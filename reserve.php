<?php require_once "header.php"; ?>
<main>
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
  <form class="reserveForm" id="reserveForm" method="POST" action="confirm.php">
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
