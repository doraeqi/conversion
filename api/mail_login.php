<?php
//邮箱登陆获取Token
include("../includes/common.php");

$mail_account = $_GET['mail'];
$mail_code    = $_GET['code'];

if($mail_account && $mail_code){
    $api_data = json_decode(get_curl('https://turn.001api.com/Apis/mail_login?mail='.$mail_account.'&code='.$mail_code),true);

    if($api_data['code'] == '1'){
        $openid_row   = $DB->getRow("SELECT * FROM turn_user WHERE openid='{$api_data['openid']}' LIMIT 1");
        if($openid_row){
            $DB->exec("update turn_user set endtime='$date' where openid='{$api_data['openid']}'");
        }
        exit(json_encode(['code'=>200, 'msg'=>$api_data['msg'], 'login_type'=>'mail', 'uid'=>$openid_row['uid'], 'token'=>$api_data['token']]));
    }else{
        //获取失败 不做数据库处理
        exit(json_encode(['code'=>-200, 'msg'=>$api_data['msg']]));
    }
}else{
    exit(json_encode(['code'=>-200, 'msg'=>'邮箱或验证码不可为空']));
}