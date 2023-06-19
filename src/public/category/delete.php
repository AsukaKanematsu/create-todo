<?php

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=todo; charset=utf8',
    $dbUserName,
    $dbPassword
);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$deleteCategorySql = 'DELETE FROM categories WHERE id = :id';

try {
    $statement = $pdo->prepare($deleteCategorySql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    header('Location: ./index.php');
    exit();
} catch (PDOException $e) {
    $_SESSION['errors'][] = 'カテゴリの削除に失敗しました。';
    header('Location: ./index.php');
    exit();
}
