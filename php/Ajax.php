<?php
//Ajax以外からのアクセスを遮断
// $request = isset($_SERVER['HTTP_X_REQUESTED_WITH'])
// ? strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) : '';
// if($request !== 'xmlhttprequest') exit;

if($_POST["date"]) {
  date_default_timezone_set('Asia/Tokyo');
  $sql = null;
  $stmt = null;
  $pdo = null;
  $date = $_POST["date"];
  try {
    // DBへ接続
    $pdo = new PDO("mysql:host=127.0.0.1; dbname=bbs; charset=utf8", 'bbs', 'jvWBJ6HYixLuqwrS');
    // 静的プレースホルダを用いるようにエミュレーションを無効化(プリペアードステートメントを使うため？)
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // SQL作成
    $sql = "SELECT * FROM bbs WHERE date = :date;";
    // SQL実行
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->execute();
    $list = $stmt->fetchAll();
    echo json_encode($list);
    exit;
  } catch(PDOException $e) {
    echo $e->getMessage();
    die();
  }
  // 接続を閉じる
  $pdo = null;
}else {
  $eM = "error";
}


?>
