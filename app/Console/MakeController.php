<?php

$path = explode('/', $argv[2]);

if (!file_exists(__DIR__ . "/../Http/Controller")) {
    mkdir(__DIR__ . '/../Http/Controller');
}

$lastIndex = array_key_last($path);
$namespaces = ['App', 'Http', 'Controller'];
for ($i = 0; $i <= $lastIndex; $i++) {
    $filepath = implode('/', array_slice($path, 0, $i + 1));
    if ($i === $lastIndex) {
        $filepath = "{$filepath}.php";
        $file = fopen(__DIR__ . "/../Http/Controller/{$filepath}", 'w');
        $namespace = implode('\\', $namespaces);
        $content = "<?php \n\nnamespace $namespace;\n\nclass {$path[$lastIndex]}\n{\n\n}";
        fwrite($file, $content);
        fclose($file);
    } else {
        if (!file_exists(__DIR__ . "/../Http/Controller/{$filepath}")) {
            mkdir(__DIR__ . "/../Http/Controller/{$filepath}");
        }
        $namespaces[] = $path[$i];
    }
}
echo "{$path[$lastIndex]} created succesfully on:\n" . __DIR__ . "/../Http/Controller/$filepath";
