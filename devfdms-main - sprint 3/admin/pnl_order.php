<?php
error_reporting(0);
include('../db.php');


if ($_GET['act'] == 'ordrdel') {

	$id = decryptIt($_GET['id']);

	$query = "DELETE FROM fds_ordr WHERE ordr_usrdt_id = '$id'";
	$result = mysqli_query($conn, $query);

	header('location: pnl_order');
	exit();
}

if ($_GET['act'] == 'ordrrdy') {

	$id = decryptIt($_GET['id']);

	$query = "UPDATE fds_ordr SET ordr_stat='ready' WHERE ordr_usrdt_id = '$id'";
	$result = mysqli_query($conn, $query);

	header('location: pnl_order');
	exit();
}


?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../favicon.ico">
	<title>Eat.lk</title>
	<link rel="stylesheet" href="../bootstrap/css/all.min.css">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<script src="../bootstrap/js/jquery-3.4.1.min.js"></script>
</head>

<body class= "body">

<style type="text/css">
        .body {
            height: 100vh;
            min-height: 500px;
            background-image: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.6)),
                url('https://images.unsplash.com/photo-1498654896293-37aacf113fd9?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
		.container {
			color: white;
		}
		.table {
			color: white;
		}
    </style>
	<div class="container">

		<div class="row p-4">
			<div class="col">
				<ul class="list-group list-group-horizontal">
					<li class="list-group-item"><a href="pnl_user">User Panel</a></li>
					<li class="list-group-item active"><a href="#" class="text-white">Order Panel</a></li>
					<li class="list-group-item "><a href="pnl_catalog">Catalog Panel</a></li>
					<li class="list-group-item"><a href="../action?act=lgout" class="text-danger">Logout</a></li>
				</ul>
			</div>
		</div>


		<div class="row p-4">
			<div class="col">
				<h2>Order List</h2>
				<table class="table">
					<tr>
						<th>No.</th>
						<th>Name & Address</th>
						<th>Meal, Shop & Quantity</th>
						<th>Status</th>
					<!--	<th>action</th> -->
					</tr>
					

				 <?php
					$count = 1;

					$query = "SELECT fds_usrdt.usrdt_nme as 'usr_nme', fds_usrdt.usrdt_adrs as 'usr_add', fds_usrdt.usrdt_id as 'usr_id', GROUP_CONCAT(ordr_ctlog_id) as ordr_list, GROUP_CONCAT(ordr_stat) as ordr_stat, GROUP_CONCAT(ordr_qty) as ordr_qty FROM fds_ordr JOIN fds_usrdt ON fds_ordr.ordr_usrdt_id = fds_usrdt.usrdt_id WHERE fds_ordr.ordr_usrdt_id = fds_usrdt.usrdt_id GROUP BY fds_ordr.ordr_usrdt_id";
					$result = mysqli_query($conn, $query);
					$order_list = array();


					if (mysqli_num_rows($result) > 0) {

						while ($row = mysqli_fetch_assoc($result)) {

							$order_list = explode(",", $row['ordr_list']);
							$order_qty = explode(",", $row['ordr_qty']);

							echo '<tr>';
							echo '<td>' . $count++ . '</td>';
							echo '<td>' . $row['usr_nme'] . '<hr>' . $row['usr_add']  .  '</td>';
							echo '<td>';
							for ($i = 0; $i < sizeof($order_list); $i++) {

								$ctlog_id = $order_list[$i];
								$query = "SELECT * FROM fds_ctlog WHERE ctlog_id = '$ctlog_id'";
								$data = mysqli_fetch_assoc(mysqli_query($conn, $query));

								echo '<p><span class="text-info">' . $data['ctlog_nme'] . '</span>; ' . $data['ctlog_shp'] . ' (' . $order_qty[$i] . ' Qty)</p>';
							}
							echo '</td>';
							if ($row['ordr_stat'] != "") {
                                echo '<td> <div class="col-2">' . $row['ordr_stat'] .'</div> </td>';
                            } else {
                                echo '<td> <div class="col-2">Preparing</div> </td>'; 
                            }
							

							/*echo '<td><a href="pnl_order?act=ordrrdy&id=' . encryptIt($row['usr_id']) . '" onclick="return confirm()">Mark ready</a><br><a href="pnl_order?act=ordrdel&id=' . encryptIt($row['usr_id']) . '" onclick="return confirm()">Delete order</a></td>';
							echo '</tr>';*/
						}
					}

					?> 
				</table>
			</div>
		</div>

	</div>
    <script src="bootstrap/js/app.js"></script>
</body>

</html>