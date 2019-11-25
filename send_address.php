<?php  
$json = file_get_contents('php://input');
$json_o = json_decode($json);
$latitude=$json_o->latitude;
$longitude=$json_o->longitude;
header('Content-type: application/json');
$address=getaddress($latitude, $longitude);
if($address)
{
	echo '['.json_encode(array("address"=>$address)).']';
}
else
{
	echo '['.json_encode(array("address"=>"address not found. Please enter address")).']';
}
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
