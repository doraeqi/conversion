<?php
//Token自动登陆尝试
include("../includes/common.php");

$token = $_GET['token'];

if($token){
    $api_data = json_decode(get_curl('https://turn.001api.com/Apis/auto_login?token='.$token),true);
    if($api_data['code'] == '1'){
        //登陆成功
        $openid_row   = $DB->getRow("SELECT * FROM turn_user WHERE openid='{$api_data['openid']}' LIMIT 1");
        if($openid_row){
            $DB->exec("update turn_user set endtime='$date' where openid='{$api_data['openid']}'");
        }
        exit(json_encode(['code'=>200, 'msg'=>$api_data['msg'], 'login_type'=>'mail', 'uid'=>$openid_row['uid']]));
    }else{
        //登陆失败 不做数据库处理
        exit(json_encode(['code'=>-200, 'msg'=>$api_data['msg']]));
    }
}else{
    exit(json_encode(['code'=>-200, 'msg'=>'Token不可为空']));
}