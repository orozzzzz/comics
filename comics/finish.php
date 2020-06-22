<meta charset="utf-8">
<?php
include("connect.php");


$number_of_rows = mysqli_num_rows(mysqli_query($link, "SELECT * FROM comics b JOIN cart c ON c.id = b.id WHERE c.client = '$client_ip'"));
$fullorder = "";
?>

<?php
for ($i = 0; $i < $number_of_rows; $i++) {
	$fullorder .= $names[$i] . " в количестве " . $_POST['count' . $numbers[$i]] . "шт. \n";
}

$lol =  $_COOKIE['name'];



$stroka = "INSERT INTO orderlist (full_order, name, address, telephone, price,status) VALUES ('$fullorder', '$lol', (SELECT address FROM users WHERE name = '$lol'), (SELECT telephone FROM users WHERE name = '$lol'), $final_price,'готов')";
?>
<script language="JavaScript">
	alert("<?php echo $_POST['count1']; ?>");
</script>
<?php





if (mysqli_query($link, "INSERT INTO orderlist (full_order, name, address, telephone, price,status) VALUES ('$fullorder', '$lol', (SELECT address FROM users WHERE name = '$lol'), (SELECT telephone FROM users WHERE name = '$lol'), $final_price,'в обработке')")) {
?>
	<script language="JavaScript">
		alert("Заказ принят!");
	</script>
<?php
} else {
?>
	<script language="JavaScript">
		alert("<?php echo mysqli_error(); ?>")
	</script>
<?php
}

?>