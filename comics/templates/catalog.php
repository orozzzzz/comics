<div id="catalog">
	<div id="spisok">
		<p>Категории</p>
		<ul>
			<?php
			include("connect.php");
			$genre = $_GET['genre'];
			if ($genre == '')
				echo "<li><p id=" . '"sel"' . ">" . "Все категории" . "</p>";
			else {
				echo
					"<li><a href=" . '"?page=catalog"' . ">Все категории</a></li>";
			}
			?>

			<?php

			$res = mysqli_query($link, 'SELECT genre FROM comics GROUP BY CHAR_LENGTH(genre) DESC');
			$genres = [];
			$g = 0;
			while ($row = mysqli_fetch_array($res)) {
				$genres[$g] = $row['genre'];
				$g++;
			}
			foreach ($genres as $ans) :
				if (stristr($ans, $genre) == TRUE) {
					echo "<li>
						<p id=" . '"sel"' . "> $ans </p>";
				} else {
					echo "<li>
						<a href=?page=catalog&genre=$ans> 
						$ans </a></li>";
				}

			endforeach;

			?>
		</ul>
	</div>

	<?php
	include("connect.php");

	if (empty($genre) == true) {
		$result = mysqli_query($link, 'SELECT * FROM comics ');
	}
	if (empty($genre) == false) {
		$kek = "SELECT * FROM comics WHERE genre 
			LIKE '%" . $genre . "%'";
		$result = mysqli_query($link, $kek);
	}

	// if (empty($genre)==false){
	// 	$kek = "SELECT * FROM comics WHERE genre 
	// 	LIKE '%".$genre."%'";
	// 	$result=mysqli_query($link,$kek);
	// }

	$comics = [];
	$i = 0;
	$h = 1;
	while ($row = mysqli_fetch_array($result)) {
		$comics[$i] =
			[
				'name' => $row['name'],
				'author' => $row['author'],
				'source' => $row['source'],
				'id' => $row['id'],
				'publishing_house' => $row['publishing_house'],
				'year' => $row['year'],
				'ISBN' => $row['ISBN'],
				'pages' => $row['pages'],
				'skin_type' => $row['tagline'],
				'weight' => $row['weight'],
				'annotation' => $row['annotation'],
				'price' => $row['price']
			];
		$i++;
		$h++;
	}
	$vysota = 280 * $h;
	?>
	<style type="text/css">
		#catalog {
			height: <?php echo $vysota; ?>px;
		}
	</style>




	<?php foreach ($comics as $book) : ?>
		<form method="POST">
			<div class="shopUnit">
				<img src="<?php echo $book['source']; ?>" />

				<div class="shopUnitName">
					<?php echo $book['name']; ?>
				</div>
				<div class="cope_text line-clamp">
					<p><?php echo $book['annotation']; ?></p>
				</div>
				<div class="shopUnitAuthor">
					<?php echo $book['author']; ?>
				</div>
				<div class="ph">
					Издательство
					<p> <?php echo $book['publishing_house']; ?></p>
				</div>
				<div class="yop">
					Год издания <p><?php echo $book['year']; ?></p>
				</div>
				<div class="shopUnitPrice">
					<?php echo $book['price']; ?> &#8381;
				</div>
				<a href="?page=item&item=<?php echo $book['id']; ?>" class="shopUnitMore">
					Подробнее
				</a>
			</div>
		</form>
	<?php endforeach; ?>


</div>