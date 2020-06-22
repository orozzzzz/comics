<?php
include("connect.php");
$user = $_SESSION['mainuser'];


if (isset($_POST['send'])){
	$text = $_POST['review'];
	$date = date('Y-m-d');
	$query = "INSERT INTO reviews(rtext,user,rdate) VALUES ('$text','$user','$date')";
    $result = mysqli_query($link,$query);
    if($result)
    {
        echo "<script>
        	  	  alert('Спасибо за Ваш отзыв')
        	  </script>";
    }
    else{
    	echo $query;
    }

}
$query = "SELECT * FROM reviews";
$result = mysqli_query($link,$query);
echo "<h3 class='rh3' align='center'>Отзывы наших пользователей</h3><br>";

while ($row = mysqli_fetch_array($result)) {
					echo "<table class='revtable' align='center'>";
					echo "<tr>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td align='right'>#".$row[0]."</td>";
					echo "<tr>";
					echo "<td class='rev' align='center' colspan='3'><i>" . $row[1] . "</i></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td align='right'>" . $row[2]. "    ". date("d.m.Y",strtotime($row[3])) . "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td></td>";
					echo "</tr>";
					echo "</table>";
				}

if(!isset($user)){
	echo "<p align='center'>Авторизируйтесь чтобы оставить отзыв</p>";
}
else{
	?>
	<form method="POST" align="center">
		<textarea name="review" placeholder="Напишите свой отзыв..." maxlength="300" cols="50" rows="4"></textarea><br>
		<input type="submit" value="Оставить" name="send" />
	</form>
	<?
}
?>