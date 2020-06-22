<?php
header("Content-type: text/xml");
include "connect.php";
print "<каталог>";
$query1 = mysqli_query($link, "SELECT id,genre FROM comics GROUP BY genre");
$genres = [];
$i = 0;
while ($row = mysqli_fetch_array($query1)) {
	$genres[$i] = [
		'id' => $i + 1,
		'genre' => $row['genre']
	];
	$i++;
}
foreach ($genres as $item) {
	print "<жанр код=\"" . $item['id'] . "\" название=\"" . $item['genre'] . "\">";
	$query2 = mysqli_query($link, "SELECT * FROM comics WHERE genre =" . "\"" . $item['genre'] . "\"");
	$values = [];
	$j = 0;
	if (mysqli_num_rows($query2) > 0) {
		while ($row = mysqli_fetch_array($query2)) {
			$values[$j] = [
				'id' => $row['id'],
				'name' => $row['name'],
				'author' => $row['author'],
				'publishing_house' => $row['publishing_house'],
				'year' => $row['year'],
				'ISBN' => $row['ISBN'],
				'pages' => $row['pages'],
				'skin_type' => $row['skin_type'],
				'weight' => $row['weight'],
				'annotation' => $row['annotation'],
				'price' => $row['price']
			];
			$j++;
		}
	}
	foreach ($values as $value) {
		print "<товар код=\"" . $value['id'] . "\" название='" . $value['name'] . "'>";
		print "<автор>" . $value['author'] . "</автор>";
		print "<издательство>" . $value['publishing_house'] . "</издательство>";
		print "<год>" . $value['year'] . "</год>";
		print "<ISBN>" . $value['ISBN'] . "</ISBN>";
		print "<количество_страниц>" . $value['pages'] . "</количество_страниц>";
		print "<тип_обложки>" . $value['skin_type'] . "</тип_обложки>";
		print "<вес>" . $value['weight'] . "</вес>";
		print "<аннотация>" . $value['annotation'] . "</аннотация>";
		print "<цена>" . $value['price'] . "</цена>";
		print "</товар>";
	}
	print "</жанр>";
}
print "</каталог>";
