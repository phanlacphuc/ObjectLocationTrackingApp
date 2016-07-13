<?php
require_once("connection.php");
	
$format = strtolower($_GET['format']) == 'json' ? 'json' : 'xml';

$sql = "";
if(isset($_GET["getData"])){
	$ibeacon_major_number = $_GET['ibeacon_major_number'];
	$ibeacon_minor_number = $_GET['ibeacon_minor_number'];
	//$sql = "SELECT * FROM data WHERE id IN (SELECT MAX(id) FROM data WHERE ibeacon_major_number = ".$ibeacon_major_number." AND ibeacon_minor_number = ".$ibeacon_minor_number." GROUP BY ibeacon_major_number,ibeacon_minor_number,session_number)";
	$sql = "SELECT * FROM data WHERE ibeacon_major_number = ".$ibeacon_major_number." AND ibeacon_minor_number = ".$ibeacon_minor_number." AND test_number IN (SELECT MAX(test_number) FROM test) ORDER BY id DESC LIMIT 100 ";
	
	
	$success = mysqli_real_query($link, $sql);
	if (!success) {
		printf("Query failed: %s\n", mysqli_connect_error());
		exit();
	}

	$result = mysqli_use_result($link);
	$data_array = array();
	while ($row = mysqli_fetch_row($result)) {
		$data_array[] = array('id' => $row[0], 'ibeacon_major_number' => $row[1], 'ibeacon_minor_number' => $row[2], 'latitude' => $row[3], 'longitude' => $row[4], 'time_stamp' => $row[5], 'rssi' => $row[6], 'session_number' => $row[7], 'test_number' => $row[8]);
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

} else if(isset($_GET["postData"])){
	$ibeacon_major_number = $_GET['ibeacon_major_number'];
	$ibeacon_minor_number = $_GET['ibeacon_minor_number'];
	$latitude = $_GET['latitude'];
	$longitude = $_GET['longitude'];
	$rssi = $_GET['rssi'];
	$session_number = $_GET['session_number'];
	$test_number = $_GET['test_number'];
	$sql = "insert into data(ibeacon_major_number, ibeacon_minor_number, latitude, longitude, rssi, session_number, test_number) values(".$ibeacon_major_number.",".$ibeacon_minor_number.",".$latitude.",".$longitude.",".$rssi.",".$session_number.",".$test_number.")";
	
	
	$success = mysqli_real_query($link, $sql);
	if (!success) {
		printf("Query failed: %s\n", mysqli_connect_error());
		exit();
	}
	mysqli_close($link);
	
	echo $sql;
} else if(isset($_GET["registerSession"])){
	$sql = "insert into session() values()";
	
	$success = mysqli_real_query($link, $sql);
	if (!success) {
		printf("Query failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	$last_id = mysqli_insert_id($link);

	mysqli_close($link);
	
	header('Content-type: application/json');
	echo json_encode(array('session_number'=>$last_id));
} else if(isset($_GET["registerTest"])){
	$sql = "insert into test() values()";
	
	$success = mysqli_real_query($link, $sql);
	if (!success) {
		printf("Query failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	$last_id = mysqli_insert_id($link);

	mysqli_close($link);
	
	header('Content-type: application/json');
	echo json_encode(array('test_number'=>$last_id));
} else{
    echo "Invalid request!";
}

?>