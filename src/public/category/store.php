<?php
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=todo; charset=utf8',
    $dbUserName,
    $dbPassword
);

session_start();
$userId = $_SESSION['id'];
$name = filter_input(INPUT_POST, 'name');
// var_dump($name);
// die();
if (empty($name)) {
    $_SESSION['errors'][] = 'カテゴリ名が入力されていません';
    $_SESSION['errors'][] = '入力されていません';
    header('Location: ./index.php');
    exit();
}

$sql = 'INSERT INTO `categories`(`name`, `user_id`) VALUES(:name, :userId)';
$statement = $pdo->prepare($sql);
$statement->bindValue(':name', $name, PDO::PARAM_STR);
$statement->bindValue(':userId', $userId, PDO::PARAM_INT);
$statement->execute();

// [解説！]リダイレクト処理
header('Location: ./index.php');
// [解説！]リダイレクトしても処理が一番下まで続いてしまうので「exit」しておこう！！！
exit();
