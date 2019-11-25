<?php
$json = file_get_contents('php://input');
$json_o = json_decode($json);
$uname=$json_o->uname;
$password=md5(trim($json_o->password));
$con = mysql_connect("localhost", "ibbucc6b_swachh", "swachh@bharat") 
       or die('Cannot connect to the DB');
mysql_select_db('ibbucc6b_swachhbharat',$con);

$result=mysql_query("select * from swachbharath where name='$uname' and password='$password'");

header('Content-type: application/json');
if(mysql_num_rows($result)>0)
{
$rows=mysql_fetch_array($result);
	echo '['.json_encode(array("status"=>1, "name"=>$rows['name'], "email"=>$rows['email_id'], "phone"=>$rows['phone'], "counter"=>$rows['counter'])).']';
}
else{
	echo '['.json_encode(array("status"=>0)).']';

}

mysql_close($con);
  ?>
