<?php
require_once dirname(__FILE__)."/dbDefine.php";

if($_POST["date"]) {
  $sql = null;
  $stmt = null;
  $pdo = null;
  $date = $_POST["date"];
  try {
    // DBへ接続
    $pdo = new PDO(DBCONF, DBUSER, DBPAS);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // SQL作成
    $sql = "SELECT * FROM bbs WHERE date = :date;";
    // SQL実行
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':date', (string)$date);
    $stmt->execute();
    $list = $stmt->fetchAll();
    echo json_encode($list);
    exit;
  } catch(PDOException $e) {
    exit ($e->getMessage());
  }
  // 接続を閉じる
  $pdo = null;
} else {
  echo "error";
}_

?>
