<?php
$json = file_get_contents('php://input');
$json_o = json_decode($json);
$uname=$json_o->uname;
$password=md5($json_o->password);
$email=$json_o->email;
$phone=$json_o->phone;
$counter=$json_o->counter;
$gender=$json_o->gender;
$profile_pic=$json_o->profile_pic;
$con = mysql_connect("localhost", "ibbucc6b_swachh", "swachh@bharat") 
       or die('Cannot connect to the DB');
mysql_select_db('ibbucc6b_swachhbharat',$con);
$result=mysql_query("INSERT INTO `swachbharath`(`name`, `email_id`, `password`, `phone`, `counter`, `profile_pic`, `gender`) VALUES ('$uname','$email','$password','$phone', '$counter', '$profile_pic', '$gender')");
header('Content-type: application/json');
if($result)
{
	echo '['.json_encode(array("status"=>1)).']';
}
else
	echo '['.json_encode(array("status"=>0)).']';

mysql_close($con);
  ?>
