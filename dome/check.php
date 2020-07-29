<?php
require_once  __DIR__."/Bootstarp.php";

//访问连接
$token=isset($_GET['token'])?$_GET['token']:'';
$tokenlink=new LSYS\TokenLink();
$token_item=$tokenlink->find($token);
if (!$token_item)die('link timeout');
var_dump($token_item);
$user=$token_item->get("user_id","dd");
var_dump($user);

//完成时清除此连接访问

$tokenlink->clear($token);