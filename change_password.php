<?php  
$json = file_get_contents('php://input');
//$json='{"email":"ibrahimpasha.m.d@gmail.com", "old_password":"12345", "new_password":"54321"}';
$json_o = json_decode($json);
$email=$json_o->email;
$old_pass=md5(trim($json_o->old_password));
$new_pass=md5(trim($json_o->new_password));
$con = mysql_connect("localhost", "ibbucc6b_swachh", "swachh@bharat") 
       or die('Cannot connect to the DB');
mysql_select_db('ibbucc6b_swachhbharat',$con);
header('Content-type: application/json');
$password_result=mysql_query("SELECT `password` FROM `swachbharath` WHERE email_id='$email'");
if(mysql_num_rows($password_result)>0){
	$rows=mysql_fetch_assoc($password_result);
	if(strcmp($old_pass, $rows['password'])==0)
	{
		$update_password=mysql_query("update swachbharath set password='$new_pass' where email_id='$email'");
		if($update_password)
         {
	       echo '['.json_encode(array("status"=>1, "message"=>"Password Changed Successfully")).']';
        }
	}
	else
	 	echo '['.json_encode(array("status"=>0, "message"=>"Password Mismatch")).']';
}
else{
	echo '['.json_encode(array("status"=>0, "message"=>"No user exists")).']';

}
mysql_close($con);

  ?>	