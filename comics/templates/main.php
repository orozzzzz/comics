<?php
include("connect.php");
$result = mysqli_query($link, '
			SELECT * 
			FROM comics 
			WHERE new =' . ' "yes" ');
$new_comics = [];
$i = 0;
while ($row = mysqli_fetch_array($result)) {
	$new_comics[$i] =
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
}
?>

<h1>Из нового...</h1>
<div class="container">
	<div id="ca-container" class="ca-container">
		<div class="ca-wrapper">
			<?php foreach ($new_comics as $book) : ?>
				<div class="ca-item ca-item-1">
					<div class="ca-item-main">
						<div class="ca-icon"><img src="<?php echo $book['source']; ?>" width="150" height="230"></div>
						<h3><?php echo $book['name']; ?></h3>
						<h4>
							<span><?php echo $book['author']; ?></span>
						</h4>
						<h5>
							<?php echo $book['price']; ?>р
						</h5>
						<a href="#" class="ca-more">Больше...</a>
					</div>
					<div class="ca-content-wrapper">
						<div class="ca-content">
							<h6></h6>
							<a href="#" class="ca-close">close</a>
							<div class="ca-content-text">
								<p><?php echo $book['annotation']; ?></p>
							</div>
							<ul>
								<!-- <li><a href="#">Купить</a></li> -->
								<li><a href="?page=item&item=<?php echo $book['id']; ?>">Подробнее</a></li>
							</ul>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

</div>
<div id="second">
	<img src="images/sec.jpg" width=450 height=450">
	<h1>Comics HUB</h1>
	<p>Добро пожаловать в Comics Hub! Этот магазин создан увлечёнными любителями комиксов для облегчения поиска и покупки комиксов на русском языке жителям любого уголка России. Мы неравнодушны к своему делу, потому что сами выросли на комиксах, любим и читаем комиксы постоянно. Мы стараемся сделать так, чтобы все новинки российских издательств комиксов как можно скорее оказывались на полках нашего магазина, а цены оставались доступными. Мы хотим, чтобы как можно больше людей избавилось от стереотипов о том, что «комиксы только для детей» и «комиксы — это не серьёзно», стараясь приобщать к этому увлечению всех окружающих нас людей и раскрывая новые грани этого вида литературы и изобразительного искусства</p>
</div>


</div>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="js/jquery.contentcarousel.js"></script>
<script type="text/javascript">
	$('#ca-container').contentcarousel();
</script>