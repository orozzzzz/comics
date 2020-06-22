<?

include("connect.php");

$client_ip = $_SERVER['REMOTE_ADDR'];
@mysqli_query($link, "DELETE FROM cart WHERE client = '$client_ip'");
?>
<script>
	window.location.href = 'http://comics/?page=buy';
</script>