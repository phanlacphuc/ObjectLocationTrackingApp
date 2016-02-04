<?php
require_once("connection.php");
	
$format = strtolower($_GET['format']) == 'json' ? 'json' : 'xml';

$sql = "";
if(isset($_GET["getData"])){
	$ibeacon_major_number = $_GET['ibeacon_major_number'];
	$ibeacon_minor_number = $_GET['ibeacon_minor_number'];
	$sql = "SELECT * FROM data WHERE id IN (SELECT MAX(id) FROM data WHERE ibeacon_major_number = ".$ibeacon_major_number." AND ibeacon_minor_number = ".$ibeacon_minor_number." GROUP BY ibeacon_major_number,ibeacon_minor_number,device_token)";
} else if(isset($_GET["postData"])){
	$ibeacon_major_number = $_GET['ibeacon_major_number'];
	$ibeacon_minor_number = $_GET['ibeacon_minor_number'];
	$latitude = $_GET['latitude'];
	$longitude = $_GET['longitude'];
	$distance = $_GET['distance'];
	$device_token = $_GET['device_token'];
	$sql = "insert into data(ibeacon_major_number, ibeacon_minor_number, latitude, longitude, distance, device_token) values(".$ibeacon_major_number.",".$ibeacon_minor_number.",".$latitude.",".$longitude.",".$distance.",".$device_token.")";
	echo $sql;
} else{
    echo "Invalid request!";
}

//printf("%s\n", $sql);

$success = mysqli_real_query($link, $sql);
if (!success) {
    printf("Query failed: %s\n", mysqli_connect_error());
    exit();
}

$result = mysqli_use_result($link);
$data_array = array();
while ($row = mysqli_fetch_row($result)) {
	$data_array[] = array('id' => $row[0], 'ibeacon_major_number' => $row[1], 'ibeacon_minor_number' => $row[2], 'latitude' => $row[3], 'longitude' => $row[4], 'time_stamp' => $row[5], 'distance' => $row[6], 'device_token' => $row[7]);
}
mysqli_free_result($result);

mysqli_close($link);

if ($format == 'json') {
	header('Content-type: application/json');
	echo json_encode(array('data_array'=>$data_array));
} else{
	header('Content-type: text/xml');
	echo '<data_array>';
	foreach($data_array as $index => $data) {
		if(is_array($data)) {
			foreach($data as $key => $value) {
				echo '<',$key,'>';
				if(is_array($value)) {
					foreach($value as $tag => $val) {
						echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
					}
				} else {
					echo $value;
				}
				echo '</',$key,'>';
			}
		}
	}
	echo '</data_array>';
}
?>