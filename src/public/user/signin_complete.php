<?php
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

session_start();
$_SESSION['email'] = $email;

if (empty($email) || empty($password)) {
    $_SESSION['errors'] = 'パスワードとメールアドレスを入力してください';
    header('Location: ./signin.php');
    exit();
}

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=todo; charset=utf8',
    $dbUserName,
    $dbPassword
);

$sql = 'select * from users where email = :email';
$statement = $pdo->prepare($sql);
$statement->bindValue(':email', $email, PDO::PARAM_STR);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);
// var_dump(!password_verify($password, $user['password']));
// var_dump($password);
// var_dump($user);
// die();

if (empty($user)) {
    $_SESSION['errors'] = 'メールアドレスまたはパスワードが違います';
    header('Location: ./signin.php');
    exit();
}

if (!password_verify($password, $user['password'])) {
    $_SESSION['errors'] = 'メールアドレスまたはパスワードが違います';
    header('Location: ./signin.php');
    exit();
}

$_SESSION['id'] = $user['id'];
$_SESSION['userName'] = $user['name'];
header('Location: ../index.php');
exit();
