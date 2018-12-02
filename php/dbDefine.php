<?php
$url = parse_url(getenv('CLEARDB_DATABASE_URL'));
$dbname = substr($url['path'], 1);
define("DBCONF","mysql:host={$url['host']}; dbname={$dbname}; charset=utf8");
define("DBUSER","{$url['user']}");
define("DBPAS","{$url['pass']}");
