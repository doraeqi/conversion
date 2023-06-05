<?php
include("../includes/common.php");
$title='管理员设置';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-md-10 col-lg-8 center-block" style="float: none;">
<?php
$scriptpath=str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$admin_path = substr($sitepath, strrpos($sitepath, '/'));
$siteurl = (is_https() ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].str_replace($admin_path,'',$sitepath).'/';

$mod=isset($_GET['mod'])?$_GET['mod']:'site';
if($mod=='site_n' && $_POST['do']){
	$admin_user=trim($_POST['admin_user']);
	$admin_pwd=trim($_POST['admin_pwd']);
	if(!$admin_user)showmsg('管理员用户名不能为空',3);
	if(!empty($admin_pwd))$adminconf['admin_pwd'] = $admin_pwd;
	$adminconf['admin_user'] = $admin_user;

	$data = '<?php'."\r\n".'return ['."\r\n";
	foreach($adminconf as $key=>$value){
		$data .= '"'.$key.'" => "'.$value.'",'."\r\n";
	}
	$data .= '];';
	if(file_put_contents(SYSTEM_ROOT.'adminconfig.php', $data)){
		showmsg('修改成功！',1);
	}else{
		showmsg('保存失败，请确保有本地写入权限',3);
	}
}elseif($mod=='site'){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">管理员设置</h3></div>
<div class="panel-body">
  <form action="./admin.php?mod=site_n" method="post" class="form-horizontal" role="form"><input type="hidden" name="do" value="1"/>
  	<div class="form-group">
	  <label class="col-sm-3 control-label">管理员用户名</label>
	  <div class="col-sm-9"><input type="text" name="admin_user" value="<?php echo $adminconf['admin_user']; ?>" class="form-control" required/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-3 control-label">重置密码</label>
	  <div class="col-sm-9"><input type="text" name="admin_pwd" value="" class="form-control" placeholder="不重置管理员密码请留空"/></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-12"><input type="submit" name="submit" value="保存" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
</div>
<?php
}
?>
    </div>
  </div>