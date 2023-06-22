<?php
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=todo; charset=utf8',
    $dbUserName,
    $dbPassword
);

session_start();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

$userId = $_SESSION['id'];
$name = filter_input(INPUT_POST, 'name');

$sql = 'SELECT * FROM categories WHERE user_id = :userId'; // ログインユーザーのカテゴリーのみを取得するクエリ
$statement = $pdo->prepare($sql);
$statement->bindValue(':userId', $userId, PDO::PARAM_INT);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

// $categoriesInfoList = [];
// foreach ($categoriesInfoList as $categoriesInfo) {
//     if ($_SESSION['id'] == $categoriesInfo['user_id']) {
//         $categories[] = $categoriesInfo;
//     }
// }
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>category</title><body>
</head>

<body>
  <h2>カテゴリー一覧</h2>

  <?php foreach ($errors as $error): ?>
    <p><?php echo $error; ?></p>
    <?php endforeach; ?>

    <form action="./store.php" method="POST">

      <!-- アカウント作成ボタン押下後、登録失敗時にsignup.phpを表示 → 入力していた項目をフォームに表示させる -->
      <p><input placeholder="カテゴリー追加" type=“text” name="name" value=""></p>
      <button type="submit">登録</button>
    </form>
    <div>
    <table border="1">
      <tr>
        <th>カテゴリー</th>
      </tr>

      <?php foreach ($categories as $category): ?>
        <tr>
          <td><?php echo $category['name']; ?></td>
          <td><a href="./edit.php?id=<?php echo $category[
              'id'
          ]; ?>">編集</a></td>
          <td><a href="./delete.php?id=<?php echo $category[
              'id'
          ]; ?>">削除</a></td>
        </tr>
      <?php endforeach; ?>

    </table>
  </div>

    <a href="../index.php">戻る</a>

</body>

</html>