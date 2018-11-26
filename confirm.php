<?php
$date;
$time;
$name;
$comment;
$contact;
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
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // SQL作成
      $sql = "INSERT INTO bbs (
        date,time, name, comment, contact
      ) VALUES (
        :date, :time,:name, :comment, :contact
      )";
      // SQL実行
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':date', (string)$date);
      $stmt->bindValue(':time', (string)$time);
      $stmt->bindValue(':name', (string)$name);
      $stmt->bindValue(':comment', (string)$comment);
      $stmt->bindValue(':contact', (string)$contact);
      $stmt->execute();
      $_POST["submit"] = NULL;
    } catch(PDOException $e) {
      exit($e->getMessage());
    }
    // 接続を閉じる
    $pdo = null;
  } else {
    echo "未入力の項目があるよ";
  }
}

if(isset($_POST["delete"])){
  if($_POST["date"] && $_POST["deleteTime"] && $_POST["deleteName"] && $_POST["deleteComment"] && $_POST["deleteContact"]) {
    $sql = null;
    $stmt = null;
    $pdo = null;
    $date = $_POST["date"];
    $time = $_POST["deleteTime"];
    $name = $_POST["deleteName"];
    $comment = $_POST["deleteComment"];
    $contact = $_POST["deleteContact"];
    try {
      // DBへ接続
      $pdo = new PDO("mysql:host=127.0.0.1; dbname=bbs; charset=utf8", 'bbs', 'jvWBJ6HYixLuqwrS');
      // 静的プレースホルダを用いるようにエミュレーションを無効化(プリペアードステートメントを使うため？)
      $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // SQL作成
      $sql = "DELETE FROM bbs
      WHERE date = :date AND time = :time AND name = :name AND comment = :comment AND contact = :contact;
      ";
      // SQL実行
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':date', (string)$date);
      $stmt->bindValue(':time', (string)$time);
      $stmt->bindValue(':name', (string)$name);
      $stmt->bindValue(':comment', (string)$comment);
      $stmt->bindValue(':contact', (string)$contact);
      $stmt->execute();
      $_POST["delete"] = NULL;
    } catch(PDOException $e) {
      exit($e->getMessage());
    }
    // 接続を閉じる
    $pdo = null;
  }
}
require_once 'reserve.php';
?>
