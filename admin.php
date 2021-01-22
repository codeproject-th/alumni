<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
include_once('./config.php');
include_once('./inc.php');
// Code Start

db::open(MYSQL_HOST,MYSQL_USERNAME,MYSQL_PASSWORD,MYSQL_DATABASE); //เชื่อมต่อฐานข้อมูล
db::query('SET NAMES utf8');

$request = module::request('/administrator/login');
module::create($request[0],$request[1],$request[2]);

db::close();

?>