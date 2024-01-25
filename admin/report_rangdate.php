<form action="" method="GET" class="form-horizontal">
    <h4>เลือกช่วงวันที่ในการเรียกดูยอดขาย</h4>
    <div class="form-group">
        <div class="col-sm-1 control-label">
            ตั้งแต่
</div>
<div class="col-sm-3 control-label">
    <input type="date" name="ds" reguired class="form-control">
</div>
<div class="col-sm-1 control-label">
            ถึง
</div>
<div class="col-sm-3 control-label">
    <input type="date" name="de" reguired class="form-control">
</div>
<div class="col-sm-1 control-label">
    <br>
            <button type="submit" name="act" value="rangdate" class="btn btn-primary">ค้นหา</button>
</div>
</div>

</form>
<?php 
include('../condb.php');
$ds=$_GET['ds'];
$de=$_GET['de'];
            $query = "
            SELECT SUM(o_total) AS total, DATE_FORMAT(o_dttm, '%d-%M-%Y') AS o_dttm
            FROM order_head
            WHERE o_status IN (2,3)
            AND o_dttm BETWEEN '$ds 00:00:00.000000'
            AND '$de 23:59:59.000000'
            GROUP BY DATE_FORMAT(o_dttm, '%Y-%m-%d')
            ORDER BY DATE_FORMAT(o_dttm, '%Y-%m-%d') DESC
            ";
            $result = mysqli_query($conn, $query);
            $resultchart = mysqli_query($conn, $query);
            //for chart
            $o_dttm = array();
            $total = array();
            while($rs = mysqli_fetch_array($resultchart)){
            $o_dttm[] = "\"".$rs['o_dttm']."\"";
            $total[] = "\"".$rs['total']."\"";
            }
            $o_dttm = implode(",", $o_dttm);
            $total = implode(",", $total);
            
            ?>
            <h3 align="center"></h3>
            
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
            <hr>
            <p align="center">
                <!--devbanban.com-->
                <canvas id="myChart" width="800px" height="300px"></canvas>
                <script>
                var ctx = document.getElementById("myChart").getContext('2d');
                var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                labels: [<?php echo $o_dttm;?>
                
                ],
                datasets: [{
                label: 'รายงานรายได้ แยกตามวัน (บาท)',
                data: [<?php echo $total;?>
                ],
                backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
                }]
                },
                options: {
                scales: {
                yAxes: [{
                ticks: {
                beginAtZero:true
                }
                }]
                }
                }
                });
                </script>
            </p>
            <div class="col-sm-12">
                <table  class="table table-striped" border="1" cellpadding="0"  cellspacing="0" align="center">
                    <thead>
                        <tr class="table-primary">
                            <th width="20%">ว/ด/ป</th>
                            <th width="10%"><center>รายได้</center></th>
                        </tr>
                    </thead>
                    
                    
                    <?php 
					$ototal = 0;
					while($row2 = mysqli_fetch_array($result)) { 
					
					?>
                    <tr>
                        <td><?php echo $row2['o_dttm'];?></td>
                        <td align="right"><?php echo number_format($row2['total'],2);?></td>
                    </tr>
                    <?php
                    $ototal += $row2['total'];
                    }
                    ?>
                    <tr class="table-danger">
                        <td align="center">รวม</td>
                        <td align="right"><b>
                        <?php echo number_format($ototal,2);?></b></td></td>
                    </tr>
                </table>
            </div>
            <?php mysqli_close($conn);?>
        </div>
    </div>
</div>