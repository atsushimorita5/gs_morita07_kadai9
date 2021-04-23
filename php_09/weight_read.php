<?php
//var_dump($_POST);
//exit();
session_start(); 
include('functions.php'); 

// DB接続情報
$dbn = 'mysql:dbname=gsacs_d02_07;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = '';

// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}
$sql = 'SELECT * FROM kadai_07';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status==false) {
  $error = $stmt->errorInfo();
  exit('sqlError:'.$error[2]);
} else {
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $output = "";
  foreach ($result as $record) {
    $output .= "<tr>";
    $output .= "<td>{$record["kg"]}</td>";
    $output .= "<td>{$record["mezame"]}</td>";
    $output .= "<td>{$record["time"]}</td>";
    $output .= "<td>{$record["level"]}</td>";
    $output .= "<td>{$record["conditontext"]}</td>";
    $output .= "<td><a href='weight_edit.php?id={$record["id"]}'>edit</a></td>";
    $output .= "<td><a href='weight_delete.php?id={$record["id"]}'>delete</a></td>";
    $output .= "</tr>";
} 
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>コンディショニングリスト</title>
</head>

<body>
<fieldset>
<legend>入力データリスト　こんにちは<?= $_SESSION['username']?></legend>
    <a href="weight_input.php">入力データ</a>
    <a href="todo_logout.php">ログアウト</a>
    <table>
    <thead>
    <tr>
    <th>集計データ集</th>
    </tr>
    </thead>
    <tbody>
    <?=$output?>
    </tbody>
    </table>
</fieldset>
</body>

</html>