<?php

namespace Core;

class Validator
{
    public bool $fail;

    public function __construct(bool $fail)
    {
        $this->fail = $fail;
    }

    public static function make(array $data, string|array $validations): bool
    {
        $validated = true;

        foreach ($validations as $field => $rules) {
            $rulesArray = is_string($rules) ? explode('|', $rules) : $rules;
            if (!static::validateField($field, $data[$field] ?? null, $rulesArray, $data)) {
                $validated = false;
            }
        }
        return (new static($validated))->fail;
    }

    protected static function validateField(string $field, $value, array $rules, array $data): bool
    {
        foreach ($rules as $rule) {
            if (!static::applyRule($rule, $field, $value, $data)) {
                return false;
            }
        }
        return true;
    }

    protected static function applyRule(string $rule, string $field, $value, array $data): bool
    {
        [$ruleName, $parameters] = static::parseRule($rule);

        return match ($ruleName) {
            'required'  => static::required($field, $value),
            'email'     => static::email($field, $value),
            'unique'    => static::unique($field, $parameters, $value),
            'confirmed' => static::confirmed($field, $value, $data['password_confirmation'] ?? null),
            'min' => static::min($field, $parameters, $value),
            'max' => static::max($field, $parameters, $value),
            default     => true,
        };
    }

    protected static function parseRule(string $rule): array
    {
        return explode(':', $rule) + [1 => ''];
    }

    public static function unique(string $field, string $parameters, $value): bool
    {
        [$table, $column] = explode(',', $parameters);
        $result = App::resolve(Database::class)
            ->query("SELECT * FROM {$table} WHERE {$column} = :value", ['value' => $value])
            ->fetch();
        if ($result) Session::addError($field, "The {$field} already exists.");
        return !$result;
    }

    public static function required(string $field, $value): bool
    {
        if (empty($value)) Session::addError($field, "The {$field} field cannot be empty.");
        return !empty($value);
    }

    public static function email(string $field, string $value): bool
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            Session::addError($field, "The {$field} must be a valid email.");
        }
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function confirmed(string $field, $value, $confirmation): bool
    {
        if ($value !== $confirmation) {
            Session::addError($field, "The {$field} confirmation does not match.");
        }
        return $value === $confirmation;
    }

    public static function min(string $field, int $minLength, string $value): bool
    {
        if (strlen($value) < $minLength) {
            Session::addError($field, "The {$field} must be at least {$minLength} characters.");
            return false;
        }
        return true;
    }

    public static function max(string $field, int $maxLength, string $value): bool
    {
        if (strlen($value) > $maxLength) {
            Session::addError($field, "The {$field} must not exceed {$maxLength} characters.");
            return false;
        }
        return true;
    }
}
