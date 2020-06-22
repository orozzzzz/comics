<?php
include("connect.php");
$user = $_SESSION['mainuser'];
if (isset($_POST['send'])) {
	$name = htmlentities(mysqli_real_escape_string($link,$_POST['name']));
	$email = htmlentities(mysqli_real_escape_string($link,$_POST['email']));
	$address = htmlentities(mysqli_real_escape_string($link,$_POST['address']));
	$telephone = htmlentities(mysqli_real_escape_string($link,$_POST['telephone']));
	$query1 = "UPDATE `users` SET `name` = '$name' , `email` = '$email' , `address` = '$address' , `telephone` = '$telephone' WHERE `name` = '$user'";
	$query2 = "UPDATE `orderlist` SET `name` = '$name' WHERE `name` = '$user'";
	$result1 = mysqli_query($link, $query1);
	$result2 = mysqli_query($link, $query2);
	if ($result1 && $result2) {
		$_SESSION['mainuser'] = $name;
		echo "<script>
				  alert('Данные обновлены');
				  location.href='http://comics/?page=orders';
			  </script>";
	} else {
		echo "<script>
				  alert('" . mysqli_error() . "');
			  </script>";
	}
}
if (isset($_SESSION['mainuser'])) { ?>
	<div class="mydata">
		<h2>Мои данные</h2>
		<form method="POST">
			<?
			$result = mysqli_query($link, "SELECT * FROM users WHERE name = '$user'");
			$row = mysqli_fetch_row($result);
			echo "Имя: <input type='text' value='" . $row[1] . "' readonly id='change1' name='name'><br>";
			echo "E-mail: <input type='text' value='" . $row[2] . "' readonly id='change2' name='email'><br>";
			echo "Адрес: <input type='text' value='" . $row[3] . "' readonly id='change3' name='address'><br>";
			echo "Телефон: <input type='text' value='" . $row[4] . "' readonly id='change4' name='telephone'><br>";
			?>

			<div class="buttons">
				<input class="sendbutton" type="button" name="" id="hider" value="Редактировать">
				<input class="sendbutton" type="button" value="Отменить" hidden="" id='hiddenelement1'>
				<input class="sendbutton" type="submit" name="send" value="Сохранить" hidden="" id='hiddenelement2'>
			</div>
		</form>
	</div>

	<div class="orders">
		<br>
		<h2>Мои заказы</h2>
		<?
		$result = mysqli_query($link, "SELECT * FROM orderlist WHERE name = '$user'");
		$rows = mysqli_num_rows($result);
		if ($rows == 0) {
			echo "<p class='emptyorders'>Заказов нет</p>";
		} else {
		?>
			<table border="1" align="center">
				<th>Номер</th>
				<th>Заказ</th>
				<th>Общая стоимость</th>
				<th>Дата заказа</th>
				<th>Статус</th>
				<?
				while ($row = mysqli_fetch_array($result)) {
					$ordertext = str_replace("шт.", "шт. <br>", $row[1]);
					echo "<tr>";
					echo "<td align='center'>" . $row[0] . "</td>";
					echo "<td>" . $ordertext . "</td>";
					echo "<td align='center'>" . $row[5] . "р.</td>";
					echo "<td>" . $row[6] . "</td>";
					echo "<td>" . $row[7] . "</td>";
					echo "</tr>";
				}
				?>
			</table><?
				}
					?>
	</div>
	<script type="text/javascript">
		document.getElementById('hider').onclick = function() {
			document.getElementById('hiddenelement1').hidden = false;
			document.getElementById('hiddenelement2').hidden = false;
			document.getElementById('hider').hidden = true;
			document.getElementById('change1').style.backgroundColor = 'white';
			document.getElementById('change2').style.backgroundColor = 'white';
			document.getElementById('change3').style.backgroundColor = 'white';
			document.getElementById('change4').style.backgroundColor = 'white';
			document.getElementById('change1').readOnly = false;
			document.getElementById('change2').readOnly = false;
			document.getElementById('change3').readOnly = false;
			document.getElementById('change4').readOnly = false;
		}

		document.getElementById('hiddenelement1').onclick = function() {
			document.getElementById('hiddenelement1').hidden = true;
			document.getElementById('hiddenelement2').hidden = true;
			document.getElementById('hider').hidden = false;
			document.getElementById('change1').style.backgroundColor = '#b0b0b0';
			document.getElementById('change2').style.backgroundColor = '#b0b0b0';
			document.getElementById('change3').style.backgroundColor = '#b0b0b0';
			document.getElementById('change4').style.backgroundColor = '#b0b0b0';
			document.getElementById('change1').readOnly = true;
			document.getElementById('change2').readOnly = true;
			document.getElementById('change3').readOnly = true;
			document.getElementById('change4').readOnly = true;

		}
	</script>
<?
} else {
	header('Location: http://comics/');
}

?>