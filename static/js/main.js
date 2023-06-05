var dropdown = layui.dropdown
,table = layui.table;

layui.use(['dropdown', 'table'], function(){
});
if($("#config_code").text() == '0'){
  $("#turn_code").hide();
}

if($("#config_adimg").text()){
  if(!$.cookie('ad')){
    $.cookie('ad', 'true', { expires: 1 });
    layer.open({
      type: 1,
      title: false,
      area: ['350px','450px'],
      shadeClose:true,
      content: '<a href="'+$("#config_adurl").text()+'" rel="nofollow" target="_blank"><img src="'+$("#config_adimg").text()+'" width="100%" height="100%"></a>'
    });
  }
}
if($.cookie('turn_pass') && !$("#turn_pass").val()){
  $("#turn_pass").val($.cookie('turn_pass'));
}
if($.cookie('token')){
    $.ajax({
        type: 'GET',
        url: '/api/auto_login.php',
        data: {token: $.cookie('token')},
        dataType: 'json',
        success: function (res){
          if(res.code > 0){
            layer.msg(res.msg, {icon: 1,time: 1000});
            $("#user_img").attr('src','static/img/'+res.login_type+'_user.png');
            $("#user_name").text('UID:'+res.uid);
            $("#user_login").removeAttr("onclick");
            $("#turn_mail").hide();
            $("#list_no").hide();
            list();
          }else{
            $.removeCookie('token');
            layer.msg(res.msg, {icon: 2});
          }
        }
    });
}else{
    login_tip = layer.tips('点我登陆可查询记录', '#user_img', {tips: [2, '#16b777'],time:666000});
}

function login() {
    login_open = layer.open({
      type: 1,
      area: '350px',
      resize: false,
      shadeClose: true,
      title: '邮箱登陆',
      content: `<div class="layui-form"lay-filter="filter-test-layer"style="margin: 16px;"><div class="demo-login-container"><div class="layui-form-item"><div class="layui-input-wrap"><div class="layui-input-prefix"><i class="layui-icon layui-icon-email"></i></div><input type="text"name="login_mail"id="login_mail"value=""lay-verify="required"placeholder="邮箱"autocomplete="off"class="layui-input"lay-affix="clear"></div></div><div class="layui-form-item"><div class="layui-row"><div class="layui-col-xs7"><div class="layui-input-wrap"><div class="layui-input-prefix"><i class="layui-icon layui-icon-vercode"></i></div><input type="text"name="login_code"id="login_code"value=""lay-verify="required"placeholder="验证码"autocomplete="off"class="layui-input"lay-affix="clear"></div></div><div class="layui-col-xs5"><div style="margin-left: 10px;"><button type="button"class="layui-btn layui-btn-normal layui-btn-fluid"onclick="get_code()"id="get_code">获取验证码</button></div></div></div></div><div class="layui-form-item"id="timeout_tip"hidden><span style="float:right;color:red;">如长时间未收到来信请到邮箱【垃圾箱】查看</span></div><div class="layui-form-item"><button class="layui-btn layui-btn-normal layui-btn-fluid"lay-submit onclick="mail_login()">登录</button></div></div></div>`
    });
}


function get_code(){
    if($("#login_mail").val()){
        var mail_check = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!mail_check.test($("#login_mail").val())){
            layer.msg('邮箱格式错误',{icon: 5});
            return false;
        }
    }else{
        layer.msg('请填写邮箱账号',{icon: 5});
        return false;
    }
    var login_mail = $("#login_mail").val();
    $.ajax({
        type: 'GET',
        url: '/api/mail_code.php',
        data: {mail: login_mail},
        dataType: 'json',
        success: function (res){
          if(res.code > 0){
            layer.msg(res.msg, {icon: 1,time: 1500});
            $("#get_code").addClass("layui-btn-disabled").attr("disabled",true);
            var time_code = 60;
            $("#get_code").text(time_code+"秒后重发");
            var time = setInterval(function(){
                time_code = time_code-1;
                $("#get_code").text(time_code+"秒后重发");
                if(time_code == 0){
                    clearInterval(time);
                    $("#get_code").removeClass("layui-btn-disabled").attr("disabled",false);
                    $("#get_code").text("获取验证码");
                }
                if(time_code < 50){
                  $("#timeout_tip").show();
                }
            },1000);
          }else{
            layer.alert(res.msg, {icon: 2});
          }
        }
    });
}

function mail_login(){
  var login_mail = $("#login_mail").val();
  var login_code = $("#login_code").val();
  //开始获取验证码
  $.ajax({
      type: 'GET',
      url: '/api/mail_login.php',
      data: {mail: login_mail,code: login_code},
      dataType: 'json',
      success: function (res){
        if(res.code > 0){
          //登陆成功
          layer.msg(res.msg, {icon: 1,time: 1500});
          $.cookie('token', res.token);
          layer.close(login_open);
          layer.close(login_tip);
          $("#user_img").attr('src','static/img/'+res.login_type+'_user.png');
          $("#user_name").text('UID:'+res.uid);
          $("#user_login").removeAttr("onclick");
          $("#turn_mail").hide();
          $("#list_no").hide();
          list();
        }else{
          layer.alert(res.msg, {icon: 2});
        }
      }
  });
}

function get_pass(){
  layer.open({
    type: 1,
    title: '获取转存验证码',
    area: ['350px','450px'],
    shadeClose:true,
    content: '<img src="'+$("#config_codeimg").text()+'" width="100%" height="100%">'
  });
}

function post(){
  var post_tip = layer.msg('提交中...', {icon: 16,shade: 0.01,time: 300000});
  var surl = $("#text").val();
  var pass = $("#pass").val();
  var turn_pass = $("#turn_pass").val();
  if($.cookie('token')){
    var post_data = {surl: surl,pass: pass,token: $.cookie('token'),turn_pass: turn_pass};
  }else{
    var email     = $("#email").val();
    var post_data = {surl: surl,pass: pass,email: email,turn_pass: turn_pass};
  }
  //开始提交转存记录
  $.ajax({
      type: 'POST',
      url: '/api/post.php',
      data: post_data,
      dataType: 'json',
      success: function (res){
        layer.close(post_tip);
        if(res.code > 0){
          if($("#turn_pass").val()){
            $.cookie('turn_pass', $("#turn_pass").val());
          }
          if($.cookie('token')){
            list();
          }
          layer.alert(res.msg, {icon: 1});
        }else{
          layer.alert(res.msg, {icon: 2});
        }
      }
  });
}

function list(){
  if(!$.cookie('token')){
    layer.msg('登录后即可查询',{icon: 5});
    login();
    return false;
  }
  var token = $.cookie('token');
  table.render({
    elem: '#list'
    ,url:'/api/list.php'
    ,method:'get'
    ,where: {token:token}
    ,id:'list'
    ,cellMinWidth: 80
    ,cols: [[
       {field:'file_name', title: '文件名', align:"center", minWidth:300}
       ,{field:'file_size', title: '文件大小', align:"center", width:120, templet: function(d){
          if(d.file_size < 0.1 * 1024) {
              return d.file_size.toFixed(2)+'B';
          } else if (d.file_size < 0.1 * 1024 * 1024) {
              return (d.file_size / 1024).toFixed(2) + "KB";
          } else if (d.file_size < 1024 * 1024 * 1024) {
              return (d.file_size / (1024 * 1024)).toFixed(2) + "MB";
          } else {
              return (d.file_size / (1024 * 1024 * 1024)).toFixed(2) + "GB";
          }
        }
      }
      ,{field:'add_time', title: '提交时间', align:"center", width:210, sort: true}
      ,{field:'status', title: '状态/操作', align:"center", width:120, templet: function(d){
        if(d.status == '1'){
          return '<button type="button" class="layui-btn layui-btn-xs layui-btn-warm">正在下载</button>';
        }else if(d.status == '0'){
          return '<button type="button" class="layui-btn layui-btn-xs layui-btn-primary">排队转存</button>';
        }else if(d.status == '2'){
          return '<button type="button" class="layui-btn layui-btn-xs layui-btn-normal">正在上传</button>';
        }else if(d.status == '3'){
          return '<button type="button" onclick="query('+d.id_md5+')" class="layui-btn layui-btn-xs">获取链接</button>';
        }else{
          return '<button type="button" class="layui-btn layui-btn-xs layui-btn-danger">转存失败</button>';
        }
      }
    }
    ]]
  });
}

function query(id){
  var query_tip = layer.msg('获取中...', {icon: 16,shade: 0.01,time: 300000});
  $.ajax({
      type: 'GET',
      url: '/api/query.php',
      data: {id: id,token: $.cookie('token')},
      dataType: 'json',
      success: function (res){
        layer.close(query_tip);
        if(res.code > 0){
          layer.alert(res.msg, {icon: 1});
        }else{
          layer.alert(res.msg, {icon: 2});
        }
      }
  });
}

//自动识别提取码函数
function getpass(){var text=$('#text').val();var pw=text.match(/提取码.? *(\w{4})/);var pw2=text.match(/pwd=(\w{4})/);if(pw!=null){$('#pass').val(pw[1])}else if(pw2!=null){$('#pass').val(pw2[1])}}