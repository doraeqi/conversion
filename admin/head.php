<?php
@header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title><?php echo $title ?></title>
  <link href="//lib.baomitu.com/twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="//lib.baomitu.com/jquery/2.1.4/jquery.min.js"></script>
  <script src="//lib.baomitu.com/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <!--[if lt IE 9]>
    <script src="//lib.baomitu.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//lib.baomitu.com/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
<?php if($islogin==1){?>
  <nav class="navbar navbar-fixed-top navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">导航按钮</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="./">后台管理</a>
      </div><!-- /.navbar-header -->
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="<?php echo checkIfActive('index')?>">
            <a href="./index.php"><span class="glyphicon glyphicon-home"></span> 首页</a>
          </li>
          <li class="<?php echo checkIfActive('list')?>">
            <a href="./list.php"><span class="glyphicon glyphicon-list"></span> 任务列表</a>
          </li>
          <li class="<?php echo checkIfActive('user')?>">
            <a href="./user.php"><span class="glyphicon glyphicon-user"></span> 用户列表</a>
          </li>
          <li class="<?php echo checkIfActive('set')?>">
            <a href="./set.php"><span class="glyphicon glyphicon-cog"></span> 系统设置</a>
          </li>
          <li class="<?php echo checkIfActive('admin')?>">
            <a href="./admin.php"><span class="glyphicon glyphicon-cog"></span> 管理员设置</a>
          </li>
          <li><a href="./login.php?logout"><span class="glyphicon glyphicon-log-out"></span> 退出登陆</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav><!-- /.navbar -->
<?php }?>