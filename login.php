<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<b>Login</b>
    <?php
    require __DIR__ . '/vendor/autoload.php';
    use \Symfony\Component\HttpFoundation\Request;
    use \Symfony\Component\HttpFoundation\RedirectResponse;
    use Symfony\Component\HttpFoundation\Session\Session;

    $session = new Session();
    $session->start();
    foreach ($session->getFlashBag()->get('invalid', array()) as $message) {
        echo "<div class='flash-notice' style='color: red;'>$message</div>";
    }
    ?>
<form method="post" action="login-process.php">
    Username: <input type="text" name="username"/>
    Password: <input type="password" name="password"/>
    <input type="submit" value="Login"/>
</form>
</body>
</html>