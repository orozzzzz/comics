<div id="buy">
	<?php
	if ($_GET['lose'] == 1) {
	?>
		<script language="JavaScript">
			alert("Авторизируйтесь для того чтобы сделать заказ")
		</script>
	<?php
	}
	include("connect.php");
	$client_ip = $_SERVER['REMOTE_ADDR']; //IP клиента
	$res_cart = mysqli_query($link, "SELECT * FROM comics b JOIN cart c ON c.id = b.id WHERE c.client = '$client_ip'");
	$count_of_rows = mysqli_num_rows($res_cart);
	if ($count_of_rows > 0) {
		$cutbook = $_GET['book'];
		$cart = [];
		$i = 0;
		while ($row = mysqli_fetch_array($res_cart)) {
			$cart[$i] =
				[
					'name' => $row['name'],
					'author' => $row['author'],
					'source' => $row['source'],
					'id' => $row['id'],
					'weight' => $row['weight'],
					'price' => $row['price'],
					'count' => $row['count']
				];
			$i++;
		}
		$vysota = 255 * $i;
	?>
		<style type="text/css">
			#buy {
				height: <?php echo $vysota; ?>px;
			}
		</style>
		<h1>Корзина:</h1>
		<a href="script1.php?"> Удалить всё </a>
		<hr>

		<form method="post" action="kek.php">
			<input hidden="" type="text" name="allcount" value="<?php echo $count_of_rows; ?>">
			<?php
			$names = [];
			$numbers = [];
			$j = 1;

			$final_weight = 0;
			$final_price = 0;
			$final_count = 0;

			foreach ($cart as $ans) :
				$final_weight += $ans['weight'] * $ans['count'];
				$final_price += $ans['price'] * $ans['count'];
				$final_count += $ans['count'];
			?>
				<input hidden="" type="text" name="<?php echo "book" . $j; ?>" value="<?php echo $ans['name']; ?>">
				<div id="cart_item">
					<img src="<?php echo $ans['source']; ?>" />
					<div class="cart_item_name">
						<?php echo $ans['name']; ?>
					</div>
					<div class="cart_item_author">
						<?php echo $ans['author']; ?>
					</div>
					<div class="cart_item_weight">
						<?php echo $ans['weight'] / 1000; ?>кг
					</div>
					<div class="cart_item_price">
						<?php echo $ans['price'] * $ans['count']; ?> &#8381;
					</div>
					<div class="wrapper">
						<div class="minus">
							<p><a class="js-minus-btn"><img src="images/minus.png" /></a></p>
						</div>
						<div class="cart_item_count">
							<input id="number-diet" class="js-number" name="<?php echo "howmuch" . $j; ?>" size="4" type="text" maxlength="2" value="<?php echo $ans['count']; ?>" align="center" />

						</div>
						<div class="plus">
							<p><a class="js-plus-btn"> <img src="images/plus.png" /></a></p>
						</div>
					</div>
					<div class="deletebutton">
						<a href="script2.php/?book=<?php echo $ans['id']; ?>" class="delete_all" type="submit" name=del><img src="images/delete.png" height="23" height="23" align="left">Удалить </a>
					</div>
				<input type="text" disabled="" hidden="" name="user" value="<? echo $_SESSION['mainuser']; ?>">
				</div>

			<?php
				$j++;
			endforeach;
			?>
			<input hidden="" type="text" name="<?php echo "allprice"; ?>" value="<?php echo $final_price; ?>">
			<div class="recalculate_button">
				<input type="submit" name="recalculate" value="Пересчитать" />
			</div>
			<div class="checkout_button">
				<input type="submit" name="checkout" value="Оформить заказ" />
			</div>
		</form>
</div>

<div class="cartfooter">

	<div class="cartresult">
		<?php
		echo "<strong>" . $final_count . "шт," . $final_weight / 1000 . "кг </strong>"; ?>
		<p>
			<?php
			echo "<strong>Общая сумма:" . $final_price . "&#8381;</strong>";
			?>
		</p>

	</div>
	<div class="cartfinal">
		<p>Итого с доставкой</p>
		<strong>
			<?php
			echo $final_price + 200 . "&#8381;";
			?>
		</strong>
	</div>
</div>

<script type="text/javascript">
	function countFunc(count) {
		var btnPlus = count.querySelector('.js-plus-btn');
		var btnMinus = count.querySelector('.js-minus-btn');
		var field = count.querySelector('.js-number');
		var fieldValue = parseFloat(field.value, 10);

		btnMinus.addEventListener('click', function() {
			if (fieldValue > 1) {
				fieldValue--;
				field.value = fieldValue;
			} else {
				return 1;
			}
		});
		btnPlus.addEventListener('click', function() {
			fieldValue++;
			field.value = fieldValue;
		});
	}
	var counts = document.querySelectorAll('.wrapper');
	counts.forEach(countFunc);
</script>
<?php
	} else {
		echo "<div class=" . 'empty' . ">
	   			<h2>Корзина пуста</h2>
			  </div>";
	}
?>