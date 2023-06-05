<?php
//提交任务
include("../includes/common.php");

$pan_surl   = $_POST['surl'];
$pan_pass   = $_POST['pass'];
$token      = $_POST['token'];
$email      = $_POST['email'];
$turn_pass  = $_POST['turn_pass'];
$ip         = real_ip();

//密码验证
if($conf['code']){
    if($turn_pass !== $conf['code']){
        exit(json_encode(['code'=>-200, 'msg'=>'转存密码错误']));
    }
}

if($pan_surl){
    $post_data= ['url'=>$pan_surl,'pass'=>$pan_pass,'type'=>'1','token'=>$token,'mail'=>$email];
    $api_data = json_decode(get_curl('https://turn.001api.com/Apis/post',$post_data),true);
    if($api_data['code'] == '200'){
        $task_row   = $DB->getRow("SELECT * FROM turn_task WHERE task_id='{$api_data['task_id']}' LIMIT 1");
        if(!$openid_row){
            $DB->exec("INSERT INTO `turn_task` (`task_id`, `file_name`, `type`, `openid`, `ip`, `addtime`) VALUES ('{$api_data['task_id']}', '{$api_data['file_name']}', '{$api_data['turn_type']}', '{$api_data['openid']}', '{$ip}', '{$date}')");
        }
        exit(json_encode(['code'=>200, 'msg'=>$api_data['msg']]));
    }else{
        //获取失败 不做数据库处理
        exit(json_encode(['code'=>-200, 'msg'=>$api_data['msg']]));
    }
}else{
    exit(json_encode(['code'=>-200, 'msg'=>'网盘链接不可为空']));
}