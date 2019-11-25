<?php
$json = file_get_contents('php://input');
$json_o = json_decode($json);
$e_name=$json_o->event_name;
$e_date=$json_o->event_date;
$e_budget=$json_o->event_budget;
$name=$json_o->event_created_by;
$email=$json_o->email;
$title=$json_o->title;
$con = mysql_connect("localhost", "ibbucc6b_swachh", "swachh@bharat")        or die('Cannot connect to the DB');mysql_select_db('ibbucc6b_swachhbharat',$con);
$e_name=trim($e_name);
$e_table=str_replace(" ", "_", $e_name);
header('Content-type: application/json');
if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$e_table."'"))==0) {

	$result=mysql_query("update description set event_name='$e_name', event_date='$e_date', event_budget='$e_budget', event_created='yes', event_created_by='$email' where title='$title'");

	if($result)
	{
		$r2=mysql_query("insert into events values('$name', '$email', '$e_name')");
		$r3=mysql_query("create table $e_table (members varchar(20), phone varchar(20), email_id varchar(50))");
		if($r3 and $r2){

			echo '['.json_encode(array("status"=>1, "message"=>"Table created")).']';
		}else
			echo '['.json_encode(array("status"=>1, "message"=>"Table not created")).']';


	}
	else{
		echo '['.json_encode(array("status"=>0)).']';

	}

}
else {

	echo "Table exist";
	echo '['.json_encode(array("status"=>0, "message"=>"Table exists")).']';

}

mysql_close($con);

  ?>
