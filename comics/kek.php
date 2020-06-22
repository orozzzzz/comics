<?php
if (isset($_POST['checkout'])) {
	include("connect.php");
	$totalcount = $_POST['allcount'];
	if ($totalcount > 0) {
		$fullorder = "";
		for ($i = 1; $i <= $totalcount; $i++) {
			$fullorder .= $_POST['book' . $i] . " в количестве " . $_POST['howmuch' . $i] . "шт. \n";
		}
		$final_price = $_POST['allprice'] + 200;
		$user = $_COOKIE['user'];
		date_default_timezone_set('Europe/Moscow');
		$date = date('d/m/Y H:i:s', time());
		if (isset($user)) {
			$q = "INSERT INTO orderlist (full_order, name, address, telephone, price,orderdate,status) VALUES ('$fullorder', '$user', (SELECT address FROM users WHERE name = '$user'), (SELECT telephone FROM users WHERE name = '$user'), $final_price,'$date','в обработке')";
			if (mysqli_query($link, $q)) {
?>
				<script language="JavaScript">
					alert("Заказ принят!");
					window.location.href = 'http://comics/';
				</script>
			<?php
				$client_ip = $_SERVER['REMOTE_ADDR'];
				@mysqli_query($link, "DELETE FROM cart WHERE client = '$client_ip'");
			} else {
			echo $q;
			}
			include("index.php");
		} else {
			header('Location: http://comics/?page=buy&lose=1');
		}
	}
} else {
	include("connect.php");
	$totalcount = $_POST['allcount'];
	for ($i = 1; $i <= $totalcount; $i++) {
		$one = $_POST['howmuch' . $i];
		$two = $_POST['book' . $i];
		$zapros = "UPDATE cart SET count = " . $one . " WHERE id = (SELECT id FROM comics WHERE name LIKE '%" . $two . "%')";

		if (!mysqli_query($link, $zapros)) {
			?>
			<script language="JavaScript">
				alert("<?php echo mysqli_error(); ?>")
			</script>
<?php
		}
		header('Location: http://comics/?page=buy');
	}
}
?>