<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lohuvie
 * Date: 13-3-4
 * Time: 上午11:27
 * To change this template use File | Settings | File Templates.
 */
require_once "start-session.php";
require_once("util.php");

$joinActivity = $_GET['join'];
$activity_id = $_GET['activity'];
$user_id = $_SESSION['user_id'];

$dbc = mysqli_connect(host,user,password,database);
$query = "";
if($joinActivity == 1){
    //喜欢该活动 向数据库添加该活动
    $query = "insert into activity_join values($activity_id,$user_id)";
    $result = mysqli_query($dbc,$query) or die("already join");

}else{
    //不喜欢该活动 从数据库删除该活动
    $query = "delete from activity_join where activity_id = $activity_id and user_id = $user_id";
    $result = mysqli_query($dbc,$query) or die("already unjoin");
}

//返回喜欢人数
$query = "select * from activity_join where activity_id = $activity_id";
$result = mysqli_query($dbc,$query);
$rowCount = mysqli_num_rows($result);
//返回json数据

mysqli_close($dbc);
?>
