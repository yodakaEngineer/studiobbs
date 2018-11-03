<?php
if(isset($_POST["submit"])){
  if($_POST["date"] && $_POST["time"] && $_POST["name"] && $_POST["comment"] && $_POST["contact"]) {
    $sql = null;
    $stmt = null;
    $pdo = null;
    $date = $_POST["date"];
    $time = $_POST["time"];
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $contact = $_POST["contact"];
    try {
      // DBへ接続
      $pdo = new PDO("mysql:host=127.0.0.1; dbname=bbs; charset=utf8", 'bbs', 'jvWBJ6HYixLuqwrS');
      // 静的プレースホルダを用いるようにエミュレーションを無効化(プリペアードステートメントを使うため？)
      $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      // SQL作成
      $sql = "INSERT INTO bbs (
        date,time, name, comment, contact
      ) VALUES (
        :date, :time,:name, :comment, :contact
      )";
      // SQL実行
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':date', $date, PDO::PARAM_STR);
      $stmt->bindParam(':time', $time, PDO::PARAM_STR);
      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
      $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
      $stmt->bindParam(':contact', $contact, PDO::PARAM_STR);
      $stmt->execute();
      $_POST["submit"] = NULL;
    } catch(PDOException $e) {
      echo $e->getMessage();
      die();
    }
    // 接続を閉じる
    $pdo = null;
  } else {
    echo "未入力の項目があるよ";
  }
}
require_once 'reserve.php';
?>
