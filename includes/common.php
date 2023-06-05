<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
define('IN_CRONLITE', true);
define('SYSTEM_ROOT', dirname(__FILE__).'/');
define('ROOT', dirname(SYSTEM_ROOT).'/');
define('SYS_KEY', 'turn');
define('VERSION', '1000');
date_default_timezone_set("PRC");
$date = date("Y-m-d H:i:s");

$adminconf = require SYSTEM_ROOT.'adminconfig.php';
$conf = require SYSTEM_ROOT.'siteconfig.php';

$dbconfig = require SYSTEM_ROOT.'config.php';
require SYSTEM_ROOT.'PdoHelper.php';

if(!$dbconfig['user']||!$dbconfig['pwd']||!$dbconfig['dbname'])//检测安装1
{
header('Content-type:text/html;charset=utf-8');
echo '你还没安装！<a href="./install/">点此安装</a>';
exit();
}

//连接数据库
$DB = new PdoHelper($dbconfig);

require SYSTEM_ROOT.'function.php';

$password_hash='!@#%!s!0';
if(isset($_COOKIE["admin_token"]))
{
	$token=authcode(daddslashes($_COOKIE['admin_token']), 'DECODE', SYS_KEY);
	list($user, $sid) = explode("\t", $token);
	$session=md5($adminconf['admin_user'].$adminconf['admin_pwd'].$password_hash);
	if($session==$sid) {
		$islogin=1;
	}
}