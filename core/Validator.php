<?php

namespace Core;

class Validator
{
    public $fail;

    public function __construct(bool $fail)
    {
        $this->fail = $fail;
    }

    public static function make(array $data, string|array $validations): bool
    {
        $validated = true;
        foreach ($validations as $field => $rules) {
            $rulesArray = is_string($rules) ? explode('|', $rules) : $rules;
            if (!static::validateField($data[$field] ?? null, $rulesArray, $data)) {
                $validated = false;
            }
        }
        Session::unflash();
        Session::flashError('email', "this is error 1");
        Session::flashError('password', "this is error 2");
        dd($_SESSION);
        return (new static($validated))->fail;
    }

    public static function validateField($value, array $rules, array $data): bool
    {
        foreach ($rules as $rule) {
            if (!static::applyRule($rule, $value, $data)) {
                return false;
            }
        }
        return true;
    }

    protected static function applyRule(string $rule, $value, array $data): bool
    {
        [$ruleName, $parameters] = static::parseRule($rule);
        return match ($ruleName) {
            'required'  => static::required($value),
            'email'     => static::email($value),
            'unique'    => static::unique(explode(',', $parameters)[0], explode(',', $parameters)[1], $value),
            'confirmed' => static::confirmed($value, $data['password_confirmation'] ?? null),
            default     => true,
        };
    }

    protected static function parseRule(string $rule): array
    {
        return explode(':', $rule) + [1 => ''];
    }

    public static function unique(string $table, string $column, $value): bool
    {
        $result = App::resolve(Database::class)
            ->query("SELECT * FROM {$table} WHERE {$column} = :value", ['value' => $value])
            ->fetch();

        return !$result;
    }

    public static function required($value): bool
    {
        return !empty($value);
    }

    public static function email(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function confirmed($value, $confirmation): bool
    {
        return $value === $confirmation;
    }
}
