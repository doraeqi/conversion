<?php
//获取任务链接
include("../includes/common.php");

$taskid = $_GET['id'];
$token  = $_GET['token'];

if($taskid || $token){
    $api_data = json_decode(get_curl('https://turn.001api.com/Apis/query?token='.$token.'&id='.$taskid),true);
    if($api_data['code'] == '1'){
        exit(json_encode(['code'=>200, 'msg'=>$api_data['msg']]));
    }else{
        //登陆失败 不做数据库处理
        exit(json_encode(['code'=>-200, 'msg'=>$api_data['msg']]));
    }
}else{
    exit(json_encode(['code'=>-200, 'msg'=>'数据异常 请刷新页面']));
}