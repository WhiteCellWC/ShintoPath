<?php
ob_start();
?>

<h2>Register</h2>
<p>Please enter your credentials to login.</p>
<?php
$sections['content'] = ob_get_clean();
require basepath('resources/views/layout.php');
