<?php
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("Cache-Control: private",false);
header("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
/*
session_cache_limiter('private');
$cache_limiter = session_cache_limiter();
session_cache_expire(30);
$cache_expire = session_cache_expire();
*/
session_start();
//session_cache_limiter('private');
//$cache_limiter = session_cache_limiter();


/* set the cache expire to 30 minutes */
session_cache_expire(30);
$cache_expire = session_cache_expire();
error_reporting(E_ALL ^ E_NOTICE);
// Include Config
include_once('./config.php');
include_once('./inc.php');
// Code Start

db::open(MYSQL_HOST,MYSQL_USERNAME,MYSQL_PASSWORD,MYSQL_DATABASE); //เชื่อมต่อฐานข้อมูล
db::query('SET NAMES utf8');

$request = module::request();
module::create($request[0],$request[1],$request[2]);

db::close();
?>