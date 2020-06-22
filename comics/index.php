<?php
session_start();
setrawcookie('user',$_SESSION['mainuser'],time()+3600,'/');
include("connect.php");
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<?php $title = 'Раритет'; ?>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="shortcut icon" href="images/icon2.jpg" />
	<!-- <link rel="stylesheet" type="text/css" href="css/demo.css" /> -->
	<?php $page = $_GET['page'];
	switch ($page) {
		case 'main':
			$title = 'Главная';
			break;
		case 'catalog':
			$title = 'Каталог';
			break;
		case 'about':
			$title = 'О нас';
			break;
		case 'buy':
			$title = 'Корзина';
			break;
		case 'item':
			$title = 'Подробно';
			break;
		case 'orders':
			$title = 'Личный кабинет';
			break;
		case 'reviews':
			$title = 'Отзывы';
			break;
		default:
			$title = "Главная";
			break;
	}
	?>
	<title><?php echo $title; ?> </title>
</head>

<body>
	<header>
		<div id="mainid1">
			<div class="cd-user-modal">
				<div class="cd-user-modal-container">
					<ul class="cd-switcher">
						<li><a href="#0">Вход</a></li>
						<li><a href="#0">Регистрация</a></li>
					</ul>
					<div id="cd-login">
						<form class="cd-form" method="POST">
							<p class="fieldset">
								<label class="image-replace cd-email" for="signin-email">E-mail</label>
								<input name="auth_email" class="full-width has-padding has-border" id="signin-email" type="email" placeholder="E-mail">
							</p>

							<p class="fieldset">
								<label class="image-replace cd-password" for="signin-password">Пароль</label>
								<input name="auth_pass" class="full-width has-padding has-border" id="signin-password" type="text" placeholder="Пароль">
								<a href="#0" class="hide-password">Скрыть</a>
							</p>
							<p class="fieldset">
								<input name="auth" class="full-width" type="submit" value="Войти">
							</p>
							<?php
							if (isset($_POST['auth'])) {
								$auth_email = mysqli_real_escape_string($link,$_POST['auth_email']);
								$auth_pass = mysqli_real_escape_string($link,$_POST['auth_pass']);

								$error_message = "";

								if (($auth_email != '') && ($auth_pass != '')) {
									if (mysqli_num_rows(mysqli_query($link, "SELECT * FROM users WHERE email = '$auth_email' AND password = '$auth_pass'")) > 0) {


										$auth_query = mysqli_query($link, "SELECT name FROM users WHERE email = '$auth_email' AND password = '$auth_pass'");
										$row = mysqli_fetch_row($auth_query);
										$_SESSION['mainuser'] = $row[0];
										setrawcookie('user',$row[0],time()+3600,'/');
										if ($_GET['lose'] == 1) {
											$_GET['lose'] = 0;
										}
									} else {
										echo '<script language="JavaScript">
											  	alert("Неправильный email или пароль ");
											  </script>';
									}
								}
								if ($auth_email == '' || $auth_pass == '') {
									if ($auth_email == '' && $auth_pass == '') {
										$error_message .= "Введите email и пароль";
									}
									if ($auth_email == '' && $error_message == "") {
										if ($error_message == "") {
											$error_message .= "Введите email";
										}
									}
									if ($auth_pass == "" && $error_message == "") {
										$error_message .= "Введите пароль";
									}
									echo '<script language="JavaScript">
										alert("'.$error_message.'");
									</script>';
								}
							}
							?>
						</form>
					</div>

					<div id="cd-signup">
						<form class="cd-form" method="POST">
							<p class="fieldset">
								<label class="image-replace cd-username" for="signup-username">Имя пользователя</label>
								<input name="name1" class="full-width has-padding has-border" id="signup-username" type="text" placeholder="Имя пользователя" required>
								<span class="cd-error-message">Здесь сообщение об ошибке!</span>
							</p>

							<p class="fieldset">
								<label class="image-replace cd-email" for="signup-email">E-mail</label>
								<input name="email1" class="full-width has-padding has-border" id="signup-email" type="email" placeholder="E-mail" required>
								<span class="cd-error-message">Неправильно введен email</span>
							</p>

							<p class="fieldset">
								<label class="image-replace cd-map" for="signup-address">Адрес</label>
								<input name="address1" class="full-width has-padding has-border" id="signup-address" type="text" placeholder="Адрес" required>
							</p>

							<p class="fieldset">
								<label class="image-replace cd-telephone" for="signup-telephone">Телефон</label>
								<input name="tel" class="full-width has-padding has-border" id="signup-telephone" type="text" placeholder="Телефон(89*********)" required>
							</p>

							<p class="fieldset">
								<label class="image-replace cd-password" for="signup-password">Пароль</label>
								<input name="pass1" class="full-width has-padding has-border" id="signup-password" type="text" placeholder="Пароль" required>
								<a href="#0" class="hide-password">Скрыть</a>
							</p>
							<p class="fieldset">
								<input name="reg" class="full-width has-padding" type="submit" value="Создать аккаунт">
							</p>

							<?php
							include("connect.php");
							if (isset($_POST['reg'])) {
								$_GET['lose'] = 0;
								$name1 = $_POST['name1'];
								$email1 = $_POST['email1'];
								$address1 = $_POST['address1'];
								$pass1 = $_POST['pass1'];
								$tel = $_POST['tel'];

								$error_message = "";

								if (ctype_digit($tel) && ($name1 != '') && ($email1 != '') && ($address1 != '') && ($pass1 != '')) {
									$result = mysqli_query($link, "SELECT * FROM users WHERE email = '$email1'");
									$rows = mysqli_num_rows($result);
									if ($rows > 0) {
										echo '<script language="JavaScript">
											alert("Данный email уже занят");
										</script>';
									} else {
										@mysqli_query($link, "INSERT INTO users (name, email, address, telephone,password) VALUES ('$name1', '$email1','$address1','$tel','$pass1')");
										echo '<script language="JavaScript">
											alert("Вы успешно зарегистрировались!");
										</script>';
									}
								} else {
									echo '<script language="JavaScript">
										alert("Ошибка ввода!");
									</script>';
								}
							}
							?>
						</form>
					</div>
				</div>
				<a href="#" class="cd-close-form">Закрыть</a>
			</div>
		</div>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="js/main.js"></script>

		<div id="hh1">
			<?php
			if (isset($_SESSION['mainuser'])) {
			?>
				<a href="exit.php"> выйти </a>
				<div class="welcome">
					<p>Добро пожаловать, <?php echo $_SESSION['mainuser']; ?></p>
				</div>
			<?php
			} else {
			?>
				<nav class="main-nav">
					<ul>
						<li><a class="cd-signin" href="#0">Вход</a></li>
						<li><a class="cd-signup" href="#0">Регистрация</a></li>
					</ul>
				<?php
			}
				?>
				</nav>
		</div>
		<ul id="navigation">
			<li><a href="?page=main"><img src="images/raritet1.png" width="100" height="50" align="center"></a></li>
			<li><a href="?page=catalog">Каталог</a></li>
			<li><a href="?page=about">О магазине</a></li>
			<li><a href="?page=reviews">Отзывы</a></li>
			<li><a href="?page=buy">Корзина</a></li>
			<?php
			if (isset($_SESSION['mainuser'])) {
				echo "<li><a href='?page=orders'>'Личный кабинет'</a></li>";
			}
			?>
		</ul>
	</header>
	<content>

		<?php
		if ($page == 'main' || $page == '') {
			require('templates/main.php');
			$title = 'Главная';
		}
		if ($page == 'catalog') {
			require('templates/catalog.php');
			$title = 'Каталог';
		}
		if ($page == 'about') {
			require('templates/about.php');
			$title = 'О нас';
		}
		if ($page == 'buy') {
			require('templates/buy.php');
			$title = 'Корзина';
		}
		if ($page == 'item') {
			require('templates/item.php');
			$title = 'Подробнее';
		}
		if ($page == 'orders') {
			require('templates/orders.php');
			$title = 'Личный кабинет';
		}
		if ($page == 'reviews') {
			require('templates/reviews.php');
			$title = 'Отзывы';
		}
		?>
	</content>
</body>

</html>