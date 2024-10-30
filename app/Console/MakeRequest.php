<?php

$path = explode('/', $argv[2]);

if (!file_exists(__DIR__ . "/../Http/Requests")) {
    mkdir(__DIR__ . '/../Http/Requests');
}

$lastIndex = array_key_last($path);
$namespaces = ['App', 'Http', 'Requests'];
for ($i = 0; $i <= $lastIndex; $i++) {
    $filepath = implode('/', array_slice($path, 0, $i + 1));
    if ($i === $lastIndex) {
        $filepath = "{$filepath}.php";
        $file = fopen(__DIR__ . "/../Http/Requests/{$filepath}", 'w');
        $namespace = implode('\\', $namespaces);
        $content = "<?php \n\nnamespace $namespace;\n\nuse Core\Request;\n\nclass {$path[$lastIndex]} extends Request\n{\n     public function rules(): array \n     {\n          return []; \n     }\n}";
        fwrite($file, $content);
        fclose($file);
    } else {
        if (!file_exists(__DIR__ . "/../Http/Requests/{$filepath}")) {
            mkdir(__DIR__ . "/../Http/Requests/{$filepath}");
        }
        $namespaces[] = $path[$i];
    }
}
echo "{$path[$lastIndex]} created succesfully on:\n" . __DIR__ . "/../Http/Requests/$filepath";
