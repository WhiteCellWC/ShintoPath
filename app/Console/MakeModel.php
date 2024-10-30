<?php

$path = explode('/', $argv[2]);

if (!file_exists(__DIR__ . "/../Models")) {
    mkdir(__DIR__ . '/../Models');
}

$lastIndex = array_key_last($path);
$namespaces = ['App', 'Models'];
for ($i = 0; $i <= $lastIndex; $i++) {
    $filepath = implode('/', array_slice($path, 0, $i + 1));
    if ($i === $lastIndex) {
        $filepath = "{$filepath}.php";
        $file = fopen(__DIR__ . "/../Models/{$filepath}", 'w');
        $namespace = implode('\\', $namespaces);
        $content = "<?php \n\nnamespace $namespace;\n\nuse App\Models\Model;\n\nclass {$path[$lastIndex]} extends Model\n{\n    protected \$fillable = [];\n}";
        fwrite($file, $content);
        fclose($file);
    } else {
        if (!file_exists(__DIR__ . "/../Models/{$filepath}")) {
            mkdir(__DIR__ . "/../Models/{$filepath}");
        }
        $namespaces[] = $path[$i];
    }
}
echo "{$path[$lastIndex]} model created succesfully on:\n" . __DIR__ . "/../Models/$filepath";
