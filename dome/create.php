<?php

require_once  __DIR__."/Bootstarp.php";

//验证等...

$token_item=(new LSYS\TokenLink())->create(array(
	'user_id'=>'111',
	'code'=>'1212'
));

$url='check.php?token='.strval($token_item);

//把URL发送到指定邮件,连接连接进入[如修改密码操作]
//debug output
echo $url;