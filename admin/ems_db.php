<meta charset="utf-8">
<?php
//condb
include('../condb.php'); 

	$o_ems = $_POST["o_ems"];
	$o_id = $_POST["o_id"];
    $o_ems_date = date('y/m/d h:i:s');
	//แก้ไขข้อม
	$sql = "UPDATE order_head SET 
	o_ems='$o_ems',
    o_ems_date='$o_ems_date',
    o_status=3
	WHERE o_id=$o_id
	";

	$result = mysqli_query($conn, $sql) or die ("Error in query: $sql " . mysqli_error());

 
	// echo $sql;
	// exit;
	
	//ปิดการเชื่อมต่อ database
	mysqli_close($conn);
	//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('เพิ่มเลขไปรษณีย์สำเร็จ');";
	echo "window.location = 'index.php'; ";
	echo "</script>";
	}else{
	echo "<script type='text/javascript'>";
	//echo "alert('Error!!');";
	echo "window.location = 'index.php'; ";
	echo "</script>";
}
?>