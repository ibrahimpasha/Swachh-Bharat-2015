<?php
$response=array();
$member=array();
$json = file_get_contents('php://input');
//$json='{"latitude":"0.0", "longitude":"0.0"}';
//$json='{"latitude":"17.2550958", "longitude":"78.8955657", "phone":"9948483680"}';
$json_o = json_decode($json);
$tableName = "description";
$origLat = $json_o->latitude;
$origLon = $json_o->longitude;
$json_file_name=trim($json_o->phone).'.json';
if($origLat==0.0 and $origLon==0.0){
	$origLat = 17.2550958;
	$origLon = 78.8955657;
	$dist = 0.621371*10000;
}
else
{
	$dist = 0.621371*20;
}

$con = mysql_connect("localhost", "ibbucc6b_swachh", "swachh@bharat") 
       or die('Cannot connect to the DB');
mysql_select_db('ibbucc6b_swachhbharat',$con);
$query = "SELECT *, 3956 * 2 *
          ASIN(SQRT( POWER(SIN(($origLat - abs(latitude))*pi()/180/2),2)
          +COS($origLat*pi()/180 )*COS(abs(latitude)*pi()/180)
          *POWER(SIN(($origLon-longitude)*pi()/180/2),2)))
          as distance FROM $tableName WHERE
          longitude between ($origLon-$dist/abs(cos(radians($origLat))*69))
          and ($origLon+$dist/abs(cos(radians($origLat))*69))
          and latitude between ($origLat-($dist/69))
          and ($origLat+($dist/69))
          having distance < $dist ORDER BY distance limit 100;";
$result=mysql_query($query);
if(mysql_num_rows($result)<0){
	$result=mysql_query("select * from description");
}
header('Content-type: application/json');
while($rows=mysql_fetch_assoc($result))
	{
		$email=$rows['email_id'];
		$email=$rows['email_id'];
		$result_phone=mysql_query("select phone from swachbharath where email_id='$email'");
		if(mysql_num_rows($result_phone)>0)
		{
			$rrows=mysql_fetch_assoc($result_phone);
			$response['organizer_phone']=$rrows['phone'];
		}

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
				$member['phone']=$rows1['phone'];
				$member['email']=$rows1['email_id'];
				array_push($response['members'], $member);

			}
		}

		$v1[]=$response;
	};
	$v2= json_encode($v1);
	$v3= str_replace("\\", "", "$v2");
	//echo str_replace("pngt", "png", $v3);
	echo file_put_contents('json/'.$json_file_name, str_replace("pngt", "png", $v3));
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
