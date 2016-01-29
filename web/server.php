<?php

require_once("connection.php");
	
$format = strtolower($_GET['format']) == 'json' ? 'json' : 'xml';

$sql = "";
if(isset($_GET["getData"])){
	$sql = "SELECT * FROM data";
} else if(isset($_GET["postData"])){
	$sql = "insert into data(object_id, latitude, longitude, time_stamp, distance) values(1,1.0,1.0,0,0)";
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
	$data_array[] = array('id' => $row[0], 'object_id' => $row[1], 'latitude' => $row[2], 'longitude' => $row[3], 'time_stamp' => $row[4], 'distance' => $row[5]);
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