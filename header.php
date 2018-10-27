<?php
$q = date('s');
$url = "/css/style.css";?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>練習室用掲示板</title>
  <link rel="stylesheet" href=<?php echo $url."?".$q?>>
  <link rel="stylesheet" href="/css/reboot.css">
</head>
<body>
  <header>
    <div class="hdInner">
      <h1>練習室用掲示板</h1>
    </div>
  </header>
