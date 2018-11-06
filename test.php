<?php
require_once "create.php";
$sql2 = "SELECT parking_code_id FROM parking WHERE vehicle_id = '$vehicleid' AND check_out = 0";
$parkingresult = mysqli_query($link, $sql2);
while($rows = mysqli_fetch_array($parkingresult)) {
    $park_code = $rows[0];
}
printf("Affected rows (UPDATE): %d\n", mysqli_affected_rows($link));

$sql3 = "INSERT INTO rate(slot_id,in_time,parking_code_id) VALUES('$slotid','$nowFormat','$park_code')";
mysqli_query($link,$sql3);

$sql4 = "SELECT rate_id FROM rate WHERE slot_id = '$slotid' AND time_out = '0000-00-00 00:00:00'";
$rateresult = mysqli_query($link, $sql4);
while($raterow = mysqli_fetch_array($rateresult)) {
    $rateid = $raterow[0];
}

$sql5 = "UPDATE parking SET rate_id = '$rateid' WHERE parking_code_id = '$park_code'";
mysqli_query($link,$sql5);

 ?>