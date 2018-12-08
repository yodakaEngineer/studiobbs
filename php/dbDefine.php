<?php
switch (getenv('PHP_ENV')) {
  case 'heroku':
  $url = parse_url(getenv('CLEARDB_DATABASE_URL'));
  $dbname = substr($url['path'], 1);
  define("DBCONF","mysql:host={$url['host']}; dbname={$dbname}; charset=utf8");
  define("DBUSER","{$url['user']}");
  define("DBPAS","{$url['pass']}");
  break;
  default:
  define("DBCONF","mysql:host=127.0.0.1; dbname=bbs; charset=utf8");
  define("DBUSER","bbs");
  define("DBPAS","SdvO2xfoIvL5zNiy");
  break;
}
