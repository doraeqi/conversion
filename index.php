<?php
include("includes/common.php");
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title><?php echo $conf['title']?></title>
  <meta name="keywords" content="<?php echo $conf['keywords']?>">
  <meta name="description" content="<?php echo $conf['description']?>">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="shortcut icon" href="favicon.ico">
  <link href="static/layui/css/layui.css" rel="stylesheet">
  <link href="static/css/index.css" rel="stylesheet">
</head>
<body class="site-home" style="background-color: #eee;">
<div class="header header-index">
  <div class="layui-container">
    <a>
        <p class="logo"><?php echo $conf['name']?></p>
    </a>
  </div>
</div>
 
<div class="container">  
  <div class="layui-row t10">
    <div class="layui-col-md12 p10">
        <div class="layui-panel border center" id="user">
            <div id="user_login" onclick="login()">
              <img width="55px" id="user_img" class="layui-circle" src="static/img/default_user.png">
              <div class="user_name" id="user_name">
                  临时用户
                  <span style="font-size:8px;">(无法查询记录)</span>
              </div>
            </div>
        </div>
    </div>
    <?php
      if($conf['txt']){
        echo '<div class="layui-col-md12 p10"><div class="border"><blockquote style="padding: 10px;background-color:#ffffff;font-size:20px;"><marquee>'.$conf['txt'].'</marquee></blockquote></div></div>';
      }
    ?>
    <div class="layui-col-md12 p10">
        <div class="layui-panel border">
        <form class="layui-form layui-form-pane" action="">
            <div class="layui-form-item">
              <label class="layui-form-label">网盘链接</label>
              <div class="layui-input-block">
                <input type="text" name="text" id="text" autocomplete="off" placeholder="请输入百度网盘链接" lay-verify="required" oninput="getpass()" class="layui-input">
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">网盘密码</label>
              <div class="layui-input-block">
                <input type="text" name="pass" id="pass" autocomplete="off" placeholder="网盘提取码 无密码可留空" lay-verify="required" class="layui-input">
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">转存方式</label>
              <div class="layui-input-block">
                <select name="interest" lay-filter="aihao">
                  <option value=""></option>
                  <option value="0" selected>百度网盘转夸克网盘</option>
                </select>
              </div>
            </div>
            <div class="layui-form-item" id="turn_mail">
              <label class="layui-form-label">接收邮箱</label>
              <div class="layui-input-block">
                <input type="text" name="mail" id="email" autocomplete="off" placeholder="临时使用需填写完成后接收邮箱" lay-verify="required" class="layui-input" lay-verify="email">
              </div>
            </div>
            <div class="layui-form-item" id="turn_code">
              <div class="layui-row">
                <div class="layui-col-xs9 layui-col-sm8">
                  <div class="layui-input-wrap">
                    <label class="layui-form-label">转存密码</label>
                    <div class="layui-input-block">
                      <input type="text" name="turn_pass" id="turn_pass" autocomplete="off" placeholder="点击右侧按钮查看" lay-verify="required" class="layui-input">
                    </div>
                  </div>
                </div>
                <div class="layui-col-xs3 layui-col-sm4">
                  <div style="margin-left: 3px;">
                      <button type="button" class="layui-btn layui-btn-primary layui-border-blue layui-btn-fluid" onclick="get_pass()">获取</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="layui-form-item">
                <button type="button" class="layui-btn layui-btn-fluid layui-btn-normal" onclick="post()">
                  <i class="layui-icon layui-icon-file"></i>  提交
                </button>
            </div>
        </form>
        </div>
    </div>

    <div class="layui-col-md12 p10">
        <div class="layui-card border">
        <div class="layui-card-header">
          任务列表
          <button type="button" class="layui-btn layui-btn-primary layui-btn-xs qr-btn" onclick="list()">刷新列表</button></label>
        </div>
            <div style="text-align:center;padding:10px;" id="list_no">
              <i class="layui-icon layui-icon-question" style="font-size:5rem;"></i>
              <br>
              <span style="font-size:1.6rem;">暂未登陆 无法查询记录</span>
            </div>
            <div class="layui-card-body">
                <table class="layui-hide" id="list"></table>
            </div>
      </div>

    </div>

    <!-- 输出设置数值 -->
    <span id="config_code" hidden><?php echo $conf['code']?'1':'0' ?></span>
    <span id="config_codeimg" hidden><?php echo $conf['codeimg'] ?></span>
    <span id="config_adimg" hidden><?php echo $conf['adimg'] ?></span>
    <span id="config_adurl" hidden><?php echo $conf['adurl'] ?></span>
</div>
</div>
<script src="static/js/jquery-3.5.1.min.js"></script>
<script src="static/js/jquery.cookie.js"></script>
<script src="static/layui/layui.js"></script>
<script src="static/js/main.js"></script>
</body>
</html>