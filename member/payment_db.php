<meta charset="utf-8">
<?php
//condb
include('../condb.php'); 

	$bid = $_POST["bid"];
	$o_slip_date = $_POST["o_slip_date"];
	$o_slip_total = $_POST["o_slip_total"];
	$o_id = $_POST["o_id"];

	$date1 = date("Ymd_His");
	$numrand = (mt_rand());
	$o_slip = (isset($_POST['o_slip']) ? $_POST['o_slip'] : '');
	$upload=$_FILES['o_slip']['name'];
	if($upload !='') { 
		//โฟลเดอร์ที่เก็บไฟล์
		$path="../imgslip/";
		//ตัวขื่อกับนามสกุลภาพออกจากกัน
		$type = strrchr($_FILES['o_slip']['name'],".");
		//ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
		$newname ='slip_'.$numrand.$date1.$type;
		$path_copy=$path.$newname;
		$path_link="../imgslip/".$newname;
		//คัดลอกไฟล์ไปยังโฟลเดอร์
		move_uploaded_file($_FILES['o_slip']['tmp_name'],$path_copy);  
	}else{
		$newname='';
	}

	//update data 
	$sql = "UPDATE order_head SET 
    bid='$bid',
    o_slip_date='$o_slip_date',
    o_slip_total='$o_slip_total',
    o_status=2,
    o_slip='$newname'
	WHERE o_id=$o_id";

	$result = mysqli_query($conn, $sql) or die ("Error in query: $sql " . mysqli_error());


	//ปิดการเชื่อมต่อ database
	mysqli_close($conn);
	//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('แจ้งชำระเงินสำเร็จ');";
	echo "window.location = 'payment_detail.php?o_id=$o_id'; ";
	echo "</script>";
	}else{
	echo "<script type='text/javascript'>";
	echo "alert('แจ้งชำระเงินไม่สำเร็จ');";
	echo "window.location = 'index.phpง; ";
	echo "</script>";
}
?>