<?php
include("../includes/common.php");
$title='后台管理首页';
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

	$name		= trim($_POST['name']);
	$title		= trim($_POST['title']);
	$keywords	= trim($_POST['keywords']);
	$description= trim($_POST['description']);
	$code		= trim($_POST['code']);
	$codeimg	= trim($_POST['codeimg']);
	$adimg		= trim($_POST['adimg']);
	$adurl		= trim($_POST['adurl']);
	$txt		= trim($_POST['txt']);

	$conf['name'] 		= $name;
	$conf['title'] 		= $title;
	$conf['keywords']	= $keywords;
	$conf['description']= $description;
	$conf['code'] 		= $code;
	$conf['codeimg'] 	= $codeimg;
	$conf['adimg'] 		= $adimg;
	$conf['adurl'] 		= $adurl;
	$conf['txt'] 		= $txt;

	$data = '<?php'."\r\n".'return ['."\r\n";
	foreach($conf as $key=>$value){
		$data .= '"'.$key.'" => "'.$value.'",'."\r\n";
	}
	$data .= '];';
	if(file_put_contents(SYSTEM_ROOT.'siteconfig.php', $data)){
		showmsg('修改成功！',1);
	}else{
		showmsg('保存失败，请确保有本地写入权限',3);
	}
}elseif($mod=='site'){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">系统设置</h3></div>
<div class="panel-body">
  <form action="./set.php?mod=site_n" method="post" class="form-horizontal" role="form"><input type="hidden" name="do" value="1"/>
  	<div class="form-group">
	  <label class="col-sm-2 control-label">站点名称</label>
	  <div class="col-sm-10"><input type="text" name="name" value="<?php echo $conf['name']; ?>" class="form-control"></div>
	</div><br/>
  	<div class="form-group">
	  <label class="col-sm-2 control-label">站点标题</label>
	  <div class="col-sm-10"><input type="text" name="title" value="<?php echo $conf['title']; ?>" class="form-control"></div>
	</div><br/>
  	<div class="form-group">
	  <label class="col-sm-2 control-label">站点关键词</label>
	  <div class="col-sm-10"><input type="text" name="keywords" value="<?php echo $conf['keywords']; ?>" class="form-control"></div>
	</div><br/>
  	<div class="form-group">
	  <label class="col-sm-2 control-label">站点描述</label>
	  <div class="col-sm-10"><input type="text" name="description" value="<?php echo $conf['description']; ?>" class="form-control"></div>
	</div><br/>
  	<div class="form-group">
	  <label class="col-sm-2 control-label">转存验证码</label>
	  <div class="col-sm-10"><input type="text" name="code" value="<?php echo $conf['code']; ?>" class="form-control"  placeholder="留空则为无需验证码 推荐使用数字"/><code>推荐使用数字 如：123696</code></div>
	</div><br/>
  	<div class="form-group">
	  <label class="col-sm-2 control-label">验证码获取</label>
	  <div class="col-sm-10"><input type="text" name="codeimg" value="<?php echo $conf['codeimg']; ?>" class="form-control" placeholder="留空则前端不显示 请留图片链接[支持本地路径]"/><code>请留图片链接[支持本地路径] 如：static/img/default_user.png</code></div>
	</div><br/>
  	<div class="form-group">
	  <label class="col-sm-2 control-label">开屏广告图片</label>
	  <div class="col-sm-10"><input type="text" name="adimg" value="<?php echo $conf['adimg']; ?>" class="form-control" placeholder="留空则前端不显示 请留图片链接[支持本地路径]"/><code>请留图片链接[支持本地路径] 如：static/img/default_user.png</code></div>
	</div><br/>
  	<div class="form-group">
	  <label class="col-sm-2 control-label">开屏广告链接</label>
	  <div class="col-sm-10"><input type="text" name="adurl" value="<?php echo $conf['adurl']; ?>" class="form-control" placeholder="如图片存在留空本项则点击无跳转 请留链接"/><code>请留链接 如：https://www.*.com 需携带协议头</code></div>
	</div><br/>
  	<div class="form-group">
	  <label class="col-sm-2 control-label">站点公告</label>
	  <div class="col-sm-10">
	  <textarea class="form-control" name="txt" style="max-width: 100%;" rows="5" placeholder="留空则前端不显示 仅支持文字显示"><?php echo $conf['txt']; ?></textarea><code>轮播效果 仅支持文字显示</code></div>
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