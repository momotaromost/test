<?php
//query prd
$p_id = $_GET['p_id'];
$sql = "
SELECT *
FROM tbl_prd as p
LEFT JOIN tbl_prd_type as t ON p.ref_t_id=t.t_id
WHERE p.p_id=$p_id";
$result = mysqli_query($conn, $sql) or die ("Error in query: $sql " . mysqli_error());
$row = mysqli_fetch_array($result);
extract($row);
// echo $sql;
// echo '<pre>';
	// print_r($row);
// echo '</pre>';
//update view
	$sql2 = "UPDATE tbl_prd SET
	p_view=p_view+1
	WHERE p_id=$p_id
	";
	$result2 = mysqli_query($conn, $sql2) or die ("Error in query: $sql2 " . mysqli_error());
?>
<div class="container">
	<div class="row">
		<div class="col-md-3 col-xs-12">
			<img src="pimg/<?php echo $row['p_img'];?>" width="150%">
		</div>
		<div class="col-md-12 col-xs-12">
			<h4> <?php echo $row['p_name'];?>
			<font color="red">
			ราคา <?php echo number_format($row['p_price'],2);?> บาท
			</font>
			</h4>
			<p>
				<?php echo $row['p_detail'];?>
				<br>
				จำนวนการเข้าชม <?php echo $row['p_view'];?> ครั้ง
			</p>
		</div>
	</div>
</div>