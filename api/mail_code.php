<?php
//邮箱登陆获取验证码
include("../includes/common.php");

$mail_account = $_GET['mail'];

if($mail_account){
    $api_data = json_decode(get_curl('https://turn.001api.com/Apis/mail_code?mail='.$mail_account),true);
    if($api_data['code'] == '1'){
        $openid_row   = $DB->getRow("SELECT * FROM turn_user WHERE openid='{$api_data['openid']}' LIMIT 1");
        if(!$openid_row){
            $DB->exec("INSERT INTO `turn_user` (`openid`, `addtime`) VALUES ('{$api_data['openid']}', '{$date}')");
        }
        exit(json_encode(['code'=>200, 'msg'=>$api_data['msg']]));
    }else{
        //获取失败 不做数据库处理
        exit(json_encode(['code'=>-200, 'msg'=>$api_data['msg']]));
    }
}else{
    exit(json_encode(['code'=>-200, 'msg'=>'邮箱不可为空']));
}