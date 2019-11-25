<?php
$json = file_get_contents('php://input');
$json_o = json_decode($json);
$vol=$json_o->vol;
$funds=$json_o->funds;
$latitude=$json_o->latitude;
$longitude=$json_o->longitude;
$image_name=$json_o->image_name;
$email=$json_o->email;
$name=$json_o->name;
$title=$json_o->title;
$desc=$json_o->description;
$con = mysql_connect("localhost", "ibbucc6b_swachh", "swachh@bharat") 
       or die('Cannot connect to the DB');
mysql_select_db('ibbucc6b_swachhbharat',$con);
$result=mysql_query("INSERT INTO `description`(`description`, `vol`, `funds`, `latitude`, `longitude`, `image_name`, `name`, `email_id`, `event_created`, `event_name`, `event_date`, `event_budget`, `title`)
 VALUES ('$desc','$vol','$funds','$latitude','$longitude','$image_name', '$name', '$email', 'no', ' ', ' ', ' ', '$title')");
$counter_result=mysql_query("SELECT `counter` FROM `swachbharath` WHERE email_id='$email'");
$counter_rows=mysql_fetch_array($counter_result);
$counter=$counter_rows['counter'];
$counter=$counter+1;
header('Content-type: application/json');
if($result)
{
         $counter_result_two=mysql_query("update swachbharath set counter='$counter' where email_id='$email'");
         if($counter_result_two)
         {
	       echo '['.json_encode(array("status"=>1)).']';
        }
}
else{
	echo '['.json_encode(array("status"=>0)).']';

}
mysql_close($con);

  ?>
