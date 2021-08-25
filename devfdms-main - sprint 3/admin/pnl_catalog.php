<?php
session_start();
include ('../db.php');

if(!isset($_SESSION["sess_id"])) {
	header ('location: ../index');
} else {
	if ($_SESSION["sess_status"] != 'admin') {
		header ('location: ../index');
	} 
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
<body class="body">
<style type="text/css">
        .body {
            height: 100vh;
            min-height: 500px;
            background-image: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.6)),
                url('https://images.unsplash.com/photo-1494597564530-871f2b93ac55?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1001&q=80');
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
					<li class="list-group-item"><a href="pnl_order">Order Panel</a></li>
					<li class="list-group-item active"><a href="pnl_catalog" class="text-white">Catalog Panel</a></li>
					<li class="list-group-item"><a href="../action?act=lgout" class="text-danger">Logout</a></li>
				</ul>
			</div>
		</div>

		<div class="row p-4">
			<div class="col">
				<h2>All Catalog List</h2>
				<table class="table">
					<tr>
						<th>No.</th>
						<th>Picture</th>
						<th>Name</th>
						<th>Price</th>
						<th>Description</th>
						<th>Shop Name</th>
					</tr>

					<?php
					$query = "SELECT * from fds_ctlog";
					$result = mysqli_query($conn, $query);
					$count = 1;

					if (mysqli_num_rows($result) > 0) {
						while($row = mysqli_fetch_assoc($result)){

							echo '<tr>';
							echo '<td>' . $count++ . '</td>';
							echo '<td><img class="img-fluid" width="150" src="../img/menu/'. $row['ctlog_img'] .'" alt="no image"></td>';
							echo '<td>' . $row['ctlog_nme'] . '</td>';
							echo '<td>' . $row['ctlog_prc'] . '</td>';
							echo '<td>' . $row['ctlog_desc'] . '</td>';
							echo '<td>' . $row['ctlog_shp'] . '</td>';
						}
					}

					?>
				</table>
			</div>
		</div>

	</div>

</body>
</html>