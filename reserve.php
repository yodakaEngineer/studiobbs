<?php require_once "header.php"; ?>
<main>
  <a href="../php/Ajax.php?date=2018-10-13">aaa</a>
  <p><a href="index.php">Topへ戻る</a></p>
  <form class="" action="index.html" method="post">
    <input type="date" name="" value="">
  </form>
  <h2 class="calendar-title"><span id="js-year"></span>年 <span id="js-month"></span>月</h2>
  <table class="calendar-table" id = "js-calendar-table">
    <thead>
      <tr>
        <th>Sun</th>
        <th>Mon</th>
        <th>Tue</th>
        <th>Wed</th>
        <th>Thu</th>
        <th>Fri</th>
        <th>Sat</th>
      </tr>
    </thead>
    <tbody id="js-calendar-body">
    </tbody>
  </table>
  <div>
    <p id="js-confirmHead" class="confirmHead"></p>
    <table class="confirmTable" id = "js-confirmTable">
    </table>
  </div>
  <h2 id="js-reserveFormHead" class="reserveFormHead"></h2>
  <form class="reserveForm" id="reserveForm" method="POST" action="reserve.php">
    <p>時間：<input id="time" type="text" name="time"></p>
    <p>名前：<input id="name" type="text" name="name"></p>
    <p>コメント：<input id="comment" type="text" name="comment"></p>
    <p>連絡先：<input id="contact" type="text" name="contact"></p>
    <p><input id="submit" type="submit" name="submit" value="送信する"></p>
  </form>
  <script src="/js/calendar.js" charset="utf-8"></script>
  <!-- <script src="/js/Ajax.js" charset="utf-8"></script> -->
</main>
<footer>
</footer>
</body>
</html>

<?php
// 変数の初期化 & 日時の取得
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
// 以下、SELECT処理
// require_once 'php/FetchTester.php';
//
// $fetch_tester = new FetchTester();
//
// // この部分のメソッドを変更して使う
// $result = $fetch_tester->fetchAll();
?>
