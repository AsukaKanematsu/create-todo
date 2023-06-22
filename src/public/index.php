
<?php
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=todo; charset=utf8',
    $dbUserName,
    $dbPassword
);

$sql = 'SELECT * FROM tasks';
$statement = $pdo->prepare($sql);
$statement->execute();
$tasks = $statement->fetchAll(PDO::FETCH_ASSOC);

$tasks = [];

if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $sql = 'SELECT * FROM tasks WHERE title LIKE :keyword';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $statement->execute();
    $tasks = $statement->fetchAll(PDO::PARAM_STR);
} else {
    $sql = 'SELECT * FROM tasks';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $tasks = $statement->fetchAll(PDO::PARAM_STR);
}

// foreach ($tasks as $key => $value) {
//     $standard_key_array[$key] = $value['created_at'];
// }
// array_multisort($standard_key_array, SORT_DESC, $tasks);
// foreach ($tasks as $key => $page) {
//     $datetime = $page['created_at'];
//     $jp_datetime = date('Y年m月d日 H時i分s秒', strtotime($datetime));
//     $tasks[$key]['created_at'] = $jp_datetime;
// }

// $datetime = "2023-06-05 10:30:00"; // DBから取得した日時
// $jp_datetime = date("Y年m月d日 H時i分s秒", strtotime($datetime));
// echo $jp_datetime;
?>

<body>

  <div>
    <a href="./task/create.php">タスク追加</a><br>
  </div>

  <div>
<form method="GET" action="index.php">
    <input type="text" name="keyword" placeholder="キーワードを入力">
    <input type="submit" value="検索">
</form>

  </div>

  <div>
    <table border="1">
      <tr>
        <th>タイトル</th>
        <th>内容</th>
        <th>作成日時</th>
        <th>編集</th>
        <th>削除</th>
      </tr>

      <?php foreach ($tasks as $page): ?>
        <tr>
          <td><?php echo $page['title']; ?></td>
          <td><?php echo $page['content']; ?></td>
          <td><?php echo $page['created_at']; ?></td>
          <td><a href="./edit.php?id=<?php echo $page['id']; ?>">編集</a></td>
          <td><a href="./delete.php?id=<?php echo $page['id']; ?>">削除</a></td>
        </tr>
      <?php endforeach; ?>

    </table>
  </div>

</body>
