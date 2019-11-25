<?php
$response=array();
$member=array();
$con = mysql_connect("localhost", "ibbucc6b_swachh", "swachh@bharat") 
       or die('Cannot connect to the DB');
mysql_select_db('ibbucc6b_swachhbharat',$con);
$result=mysql_query("select * from description where event_created='yes'");
header('Content-type: application/json');
while($rows=mysql_fetch_assoc($result))
	{
		$response['latitude']=$rows['latitude'];
        $response['longitude']=$rows['longitude'];
	    $response['description']=$rows['description'];
		$response['address']=getaddress($response['latitude'], $response['longitude']);
		$response['name']=$rows['name'];
		$response['email']=$rows['email_id'];
		$response['title']=$rows['title'];
		$response['event_created']=$rows['event_created'];
		$response['event_name']=$rows['event_name'];
		$response['event_date']=$rows['event_date'];
		$response['event_budget']=$rows['event_budget'];
		$response['event_created_by']=$rows['event_created_by'];
        $response['image']='http://swachhbharat.ibbu.in/back/uploaded/'.$rows['image_name'];
		$response['members']=array();

		if(strcmp($response['event_created'], "yes")==0){
			$e_name=trim($response['event_name']);
			$e_table=str_replace(" ", "_", $e_name);
			$result1=mysql_query("select * from ".$e_table."");

			while($rows1=mysql_fetch_assoc($result1)){
				$member['member']=$rows1['members'];
				array_push($response['members'], $member);

			}
		}

		$v1[]=$response;
	};
	$v2= json_encode($v1);
	$v3= str_replace("\\", "", "$v2");
	echo str_replace("pngt", "png", $v3);
	mysql_close($con);
	function getaddress($lat,$lng){
		$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
		$json = @file_get_contents($url);
		$data=json_decode($json);
		$status = $data->status;
		if($status=="OK")
		return $data->results[0]->formatted_address;
		else
		return false;
	}
  ?>
