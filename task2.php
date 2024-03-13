<?php
session_start();
include 'DbAuthentication.php';

$connectionString = "host=localhost dbname=postgres port=5432 user=postgres password=''";

$auth = new DbAuthentication($connectionString);

if ($auth->isLogged()) {
    header('Location: task_add1.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['remember_me']);

    if ($auth->login($username, $password, $rememberMe)) {
        header('Location: task_add1.php');
        exit;
    } else {
        $error = 'Incorrect nickname and password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Authentication</title>
</head>
<body>
<h1>Authentication</h1>

<?php if (isset($error)): ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>

<form method="POST">
    <label for="username">Nickname:</label>
    <input type="text" id="username" name="username">

    <label for="password">Password:</label>
    <input type="password" id="password" name="password">

    <label for="remember_me">Remember me</label>
    <input type="checkbox" id="remember_me" name="remember_me">

    <input type="submit" value="Login">
</form>
</body>
</html>
