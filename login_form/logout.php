<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
// remove all session variables
session_unset();

// destroy the session
session_destroy();

header("Location: http://".$_SERVER['HTTP_HOST'].'/login_form/login.php');
?>

</body>
</html>