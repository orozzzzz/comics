<?

include("connect.php");
$cutbook = $_GET['book'];

$client_ip = $_SERVER['REMOTE_ADDR'];

@mysqli_query($link, "DELETE FROM cart WHERE client = '$client_ip' AND id =$cutbook");

?>
<script>
	window.location.href = 'http://comics/?page=buy';
</script>