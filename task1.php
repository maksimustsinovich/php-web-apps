<?php
session_start();

include_once 'DbAuthentication.php';
include_once 'FileManager.php';

$connectionString = "host=localhost dbname=postgres port=5432 user=postgres password=''";

$auth = new DbAuthentication($connectionString);

if (!$auth->isLogged()) {
    header('Location: task2.php');
    exit;
}

$fileManager = new FileManager('C:\Users\Maksim Ustsinovich\IdeaProjects\web-apps\\');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        $fileManager->uploadFile($_FILES['file']);
    } elseif (isset($_POST['delete'])) {
        $fileManager->deleteFile($_POST['delete']);
    } elseif (isset($_POST['open'])) {
        $fileManager->changeDirectory($_POST['open']);
    } elseif (isset($_POST['logout'])) {
        $auth->logout();
        header('Location: task2.php');
        exit;
    }
}

$files = $fileManager->listFiles();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>File manager</title>
</head>
<body>
<h1>File manager</h1>

<form method="POST">
    <input type="hidden" name="logout">
    <input type="submit" value="Log out">
</form>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit" value="Upload">
</form>

<h2>File list</h2>
<ul>
    <?php foreach ($files as $file): ?>
        <li>
            <a href="<?php echo $fileManager->getDirectory().$file; ?>"><?php echo $file; ?></a>
            <form method="POST">
                <input type="hidden" name="delete" value="<?php echo $file; ?>">
                <input type="submit" value="Delete">
            </form>
            <?php if (is_dir($fileManager->getDirectory().$file)): ?>
                <form method="POST">
                    <input type="hidden" name="open" value="<?php echo $file; ?>">
                    <input type="submit" value="Open">
                </form>
            <?php endif; ?>
            <?php if (is_file($fileManager->getDirectory().$file)): ?>
                <button><a href="/<?php echo $file; ?>" download>Download</a></button>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>
