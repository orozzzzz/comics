<div id=item>
	<?php
	include("connect.php");
	$idbook = $_GET['item'];
	$result = mysqli_query($link,"SELECT * FROM comics 
			WHERE id= $idbook ");
	$item_book = [];
	$i = 0;
	while ($row = mysqli_fetch_array($result)) {
		$item_book[$i] =
			[
				'name' => $row['name'],
				'author' => $row['author'],
				'source' => $row['source'],
				'id' => $row['id'],
				'publishing_house' => $row['publishing_house'],
				'year' => $row['year'],
				'ISBN' => $row['ISBN'],
				'pages' => $row['pages'],
				'skin_type' => $row['skin_type'],
				'weight' => $row['weight'],
				'annotation' => $row['annotation'],
				'price' => $row['price']
			];
		$i++;
	}

	?>



	<?php foreach ($item_book as $book) :  ?>
		<div class="item_book_img">
			<img src="<?php echo $book['source']; ?>" height=300 width=250 />
		</div>
		<div class="item_book_name">
			<?php echo $book['name']; ?>
		</div>
		<div class="item_book_author">
			<?php echo $book['author']; ?>
		</div>
		<div class="fields">
			<p>Издательство
				<br>
				Год издания
				<br>
				ISBNx
				<br>
				Количество страниц
				<br>
				Тип обложки
				<br>
				Вес
			</p>
		</div>
		<div class="fvalues">
			<p>
				<?php echo $book['publishing_house']; ?>
				<br>
				<?php echo $book['year']; ?>
				<br>
				<?php echo $book['ISBN']; ?>
				<br>
				<?php echo $book['pages']; ?>
				<br>
				<?php echo $book['skin_type']; ?>
				<br>
				<?php echo $book['weight'] . " г."; ?>
			</p>
		</div>
		<div class="annot">
			Аннотация
		</div>
		<div class="item_annotation">
			<p>
				<?php echo $book['annotation']; ?>
			</p>
		</div>
		<form method="POST">
			<a>
				<button class="item_book_buy" type=submit name=btn>В корзину</button>

				<?php
				$client_ip = $_SERVER['REMOTE_ADDR']; //IP клиента

				$test_query = "SELECT * FROM cart WHERE id=$idbook AND client = '$client_ip'";

				$sql = "INSERT INTO cart (id,count,client) VALUES($idbook,1,'$client_ip')";
				// mysqli_query($link,"DELETE FROM cart WHERE car_id=$id");
				if (isset($_POST['btn'])) {
					if (mysqli_num_rows(mysqli_query($link,$test_query)) == 0) {
						mysqli_query($link,$sql);
				?>
						<script language="JavaScript">
							alert("Товар добавлен в корзину");
						</script>
					<?php

					} else {
					?>
						<script language="JavaScript">
							alert("Данная книга уже имеется в корзине");
						</script>
				<?php
					}
				}
				?>

			</a>
		</form>
		<div class="item_book_price">
			Цена: <?php echo $book['price']; ?> &#8381;
		</div>
	<?php endforeach; ?>
</div>