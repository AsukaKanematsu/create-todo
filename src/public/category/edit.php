<?php
session_start();
$userId = $_SESSION['id'];
$name = filter_input(INPUT_POST, 'name');

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=todo; charset=utf8',
    $dbUserName,
    $dbPassword
);

$sql = 'SELECT * FROM categories';
$statement = $pdo->prepare($sql);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

$registed = $_SESSION['registed'] ?? '';
$_SESSION['registed'] = '';

$errors = []; // エラーメッセージを格納するための配列

$name = $_SESSION['name'] ?? '';
unset($_SESSION['name']);

if (!isset($_SESSION['id'])) {
    header('Location: ./index.php');
    exit();
}

$categoriesId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (empty($categoriesId)) {
    header('Location: ./index.php');
    exit();
}

$sqlUserId = 'SELECT user_id FROM categories WHERE id = :id';
$statement = $pdo->prepare($sqlUserId);
$statement->bindValue(':id', $categoriesId, PDO::PARAM_INT);
$statement->execute();
$userId = $statement->fetch(PDO::FETCH_COLUMN);

if ($userId != $_SESSION['id']) {
    header('Location: ./index.php');
    exit();
}

$sql = 'SELECT * FROM categories WHERE id = :id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $categoriesId, PDO::PARAM_INT);
$statement->execute();
$category = $statement->fetch(PDO::FETCH_ASSOC);
?>

<body>
    <?php foreach ($errors as $error): ?>
    <p><?php echo $error; ?></p>
    <?php endforeach; ?>

    <!-- <h3><?php echo $registed; ?></h3>
    <p><?php echo $error; ?></p> -->

    <form action="./update.php" method="POST">
        <!-- 更新時にデータを渡すため、hiddenフィールドでカテゴリIDを送信 -->
        <input type="hidden" name="id" value="<?php echo $categoriesId; ?>">

        <p><input type="text" name="name" value="<?php echo $category[
            'name'
        ]; ?>"></p>
        <button type="submit">更新</button>
        <a href="./index.php?id=">戻る</a>
    </form>
</body>