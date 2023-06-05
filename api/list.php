<?php
//Token获取任务列表
include("../includes/common.php");

$token = $_GET['token'];

if($token){
    $api_data = json_decode(get_curl('https://turn.001api.com/Apis/list?token='.$token),true);
    if($api_data['code'] == '1'){
        exit(json_encode(['code'=>0, 'msg'=>$api_data['msg'], 'data'=>$api_data['list']]));
    }else{
        //登陆失败 不做数据库处理
        exit(json_encode(['code'=>-200, 'msg'=>$api_data['msg']]));
    }
}else{
    exit(json_encode(['code'=>-200, 'msg'=>'Token不可为空']));
}