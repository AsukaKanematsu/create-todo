<?php
$categoryId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$categoryName = filter_input(INPUT_POST, 'name');

if ($categoryId === false || $categoryName === null) {
    session_start();
    $_SESSION['errors'][] = '無効なパラメータが渡されました。';
    header('Location: ../edit.php?id=' . $categoryId);
    exit();
}

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=todo; charset=utf8',
    $dbUserName,
    $dbPassword
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($categoryName)) {
        session_start();
        $_SESSION['errors'][] = 'カテゴリー名を入力してください。';
        header('Location: ./index.php?id=' . $categoryId);
        exit();
    } else {
        $sql =
            'UPDATE categories SET name = :categoryName WHERE id = :categoryId';
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(
                ':categoryName',
                $categoryName,
                PDO::PARAM_STR
            );
            $statement->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
            $statement->execute();
            header('Location: ./index.php?id=' . $categoryId);
            exit();
        } catch (PDOException $e) {
            session_start();
            $_SESSION['errors'][] = 'カテゴリーの更新に失敗しました。';
            header('Location: ./edit.php?id=' . $categoryId);
            exit();
        }
    }
}
