<?php
$json = file_get_contents('php://input');
$json_o = json_decode($json);
$e_name=$json_o->event_name;
$e_name=trim($e_name);
$e_table=str_replace(" ", "_", $e_name);
$e_by=$json_o->event_by;
$name=$json_o->name;
$phone=$json_o->phone;
$email=$json_o->email_id;
$con = mysql_connect("localhost", "ibbucc6b_swachh", "swachh@bharat") 
       or die('Cannot connect to the DB');
mysql_select_db('ibbucc6b_swachhbharat',$con);

$result=mysql_query("insert into $e_table values ('$name', '$phone', '$email')");
header('Content-type: application/json');
if($result)
{
	echo '['.json_encode(array("status"=>1, "event name"=>$e_table)).']';

}
else{
	echo '['.json_encode(array("status"=>0, "event name"=>$e_table)).']';

}
mysql_close($con);

  ?>
