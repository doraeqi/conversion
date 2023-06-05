<?php
include("../includes/common.php");
$title='后台管理首页';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

$count1 = $DB->getColumn("SELECT count(*) from turn_task");
$count2 = $DB->getColumn("SELECT count(*) from turn_user");
$mysqlversion=$DB->getColumn("select VERSION()");

$scriptpath=str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$admin_path = substr($sitepath, strrpos($sitepath, '/'));
$siteurl = (is_https() ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].str_replace($admin_path,'',$sitepath).'/';

?>
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-md-8 center-block" style="float: none;">
 <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">后台管理首页</h3></div>
<table class="table table-bordered">
<tbody>
<tr height="25">
<td align="center"><font color="#808080"><b><span class="glyphicon glyphicon-tint"></span>用户数量</b></br><b><?php echo $count2?></b> 名</font></td>
<td align="center"><font color="#808080"><b><i class="glyphicon glyphicon-check"></i>任务数量</b></br></span><b><?php echo $count1?></b> 条</font></td>
</tr>
<tr height="25">
	<td align="center" colspan="2">
		<a href="./list.php" class="btn btn-info"><i class="glyphicon glyphicon-refresh"></i>&nbsp;任务列表</a>&nbsp;
		<a href="./user.php" class="btn btn-warning"><i class="glyphicon glyphicon-user"></i>&nbsp;用户列表</a>
	</td>
</tr>
</tbody>
</table>
      </div>

<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">版本更新</h3>
	</div>
	<ul class="list-group">
		<li class="list-group-item">
			<?php
			echo file_get_contents('https://turn.001api.com/Apis/h5up?v='.VERSION);
			?>
		</li>
	</ul>
</div>

<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">服务器信息</h3>
	</div>
	<ul class="list-group">
		<li class="list-group-item">
			<b>PHP 版本：</b><?php echo phpversion() ?>
			<?php if(ini_get('safe_mode')) { echo '线程安全'; } else { echo '非线程安全'; } ?>
		</li>
		<li class="list-group-item">
			<b>MySQL 版本：</b><?php echo $mysqlversion ?>
		</li>
		<li class="list-group-item">
			<b>服务器软件：</b><?php echo $_SERVER['SERVER_SOFTWARE'] ?>
		</li>
		
		<li class="list-group-item">
			<b>程序最大运行时间：</b><?php echo ini_get('max_execution_time') ?>s
		</li>
		<li class="list-group-item">
			<b>POST许可：</b><?php echo ini_get('post_max_size'); ?>
		</li>
		<li class="list-group-item">
			<b>文件上传许可：</b><?php echo ini_get('upload_max_filesize'); ?>
		</li>
		<li class="list-group-item">
			<b>框架说明：</b>本程序底层代码原自【缤纷彩虹天地】 感谢大佬开源
		</li>
	</ul>
</div>
    </div>
  </div>
<script src="//lib.baomitu.com/layer/3.1.1/layer.js"></script>
<script src="//lib.baomitu.com/clipboard.js/1.7.1/clipboard.min.js"></script>
<script>
$(document).ready(function(){
	var clipboard = new Clipboard('.copy-btn');
	clipboard.on('success', function (e) {
		layer.msg('复制成功！', {icon: 1});
	});
	clipboard.on('error', function (e) {
		layer.msg('复制失败，请长按链接后手动复制', {icon: 2});
	});
})
</script>