<?php
$json = file_get_contents('php://input');
//$json='{"email_id":"ibrahimpasha.m.d@gmail.com"}';
$json_o = json_decode($json);
$email_id=$json_o->email_id;
$response=array();
$member=array();
$con = mysql_connect("localhost", "ibbucc6b_swachh", "swachh@bharat") 
       or die('Cannot connect to the DB');
mysql_select_db('ibbucc6b_swachhbharat',$con);
$result1=mysql_query("select * from events where email_id='$email_id'");
header('Content-type: application/json');
if(mysql_num_rows($result1)>0)
{
	$response['status']=1;
	while($rows=mysql_fetch_assoc($result1))
	{

		$response['event_name']=$rows['event_name'];
		$event_name=$response['event_name'];
		$event_name=trim($event_name);
		$event_name=str_replace(" ", "_", $event_name);
		$response['members']=array();
		$result2=mysql_query("select * from ".$event_name."");
		while($rows1=mysql_fetch_assoc($result2)){
				$member['member']=$rows1['members'];
				$member['phone']=$rows1['phone'];
				$member['email']=$rows1['email_id'];
				array_push($response['members'], $member);
			}

		$v1[]=$response;
	};

}
else{
	$response['status']=0;
	$v1[]=$response;
}
echo json_encode($v1);
	mysql_close($con);
  ?>
