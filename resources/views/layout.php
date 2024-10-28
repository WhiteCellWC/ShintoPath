<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shinto Path</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style rel="stylesheet">
        <?php include basepath('resources/css/app.css'); ?>
    </style>
</head>

<body>
    <?php require(basepath('resources/views/Include/nav.php')); ?>
    <?php
    if (isset($sections['content'])) {
        echo $sections['content'];
    }
    ?>
</body>

</html>