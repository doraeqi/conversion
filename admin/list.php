<?php
include("../includes/common.php");
$title='任务列表';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 center-block" style="float: none;">
<?php

$my=isset($_GET['my'])?$_GET['my']:null;


if($my=='search') {
	$sql=" `{$_GET['column']}`='{$_GET['value']}'";
	$numrows=$DB->getColumn("SELECT count(*) from turn_task WHERE{$sql}");
	$con='包含 '.$_GET['value'].' 的共有 <b>'.$numrows.'</b> 条任务';
	$link='&my=search&column='.$_GET['column'].'&value='.$_GET['value'];
}else{
	$numrows=$DB->getColumn("SELECT count(*) from turn_task WHERE 1");
	$sql=" 1";
	$con='系统共有 <b>'.$numrows.'</b> 条任务';
}

echo '<form action="task.php" method="GET" class="form-inline"><input type="hidden" name="my" value="search">
  <div class="form-group">
    <label>搜索</label>
	  <select name="column" class="form-control">
      <option value="openid">OPENID</option>
      <option value="task_id">任务ID</option>
    </select>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" name="value" placeholder="搜索内容">
  </div>
  <button type="submit" class="btn btn-primary">搜索</button>
</form>';
echo $con;
?>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>任务ID</th><th>文件名</th><th>转存方式</th><th>OPENID</th><th>提交时间</th></tr></thead>
          <tbody>
<?php
$pagesize=30;
$pages=ceil($numrows/$pagesize);
$page=isset($_GET['page'])?intval($_GET['page']):1;
$offset=$pagesize*($page - 1);

$rs=$DB->query("SELECT * FROM turn_task WHERE{$sql} order by id desc limit $offset,$pagesize");
while($res = $rs->fetch())
{
echo '<tr><td><b>'.$res['task_id'].'</b></td><td style="max-width:150px"><b>'.$res['file_name'].'</b></td><td>'.($res['type']=='kk'?'<font color="blue">百度转夸克</font>':'<font color="red">未知</font>').'</td><td>'.$res['openid'].'</td><td>'.$res['addtime'].'</td><td>'.$res['endtime'].'</td></tr>';
}
?>
          </tbody>
        </table>
      </div>
<?php
echo'<ul class="pagination">';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo '<li><a href="list.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="list.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
$start=$page-10>1?$page-10:1;
$end=$page+10<$pages?$page+10:$pages;
for ($i=$start;$i<$page;$i++)
echo '<li><a href="list.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$end;$i++)
echo '<li><a href="list.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li><a href="list.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="list.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
?>
    </div>
  </div>