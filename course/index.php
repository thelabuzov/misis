<?php
	require_once "db.php";

	// $messages = $stmt -> fetchAll();
	$stmt = $pdo -> query("select * from works");
	$works = $stmt -> fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="dist/style.css">
	<script defer src="dist/script.js"></script>
	<title>Workflow | Объединяя профессии</title>
</head>

<body>
	<?php
		if (($_COOKIE['account'] ?? '') === ''):
	?>

	<div id="popup" class="overlay">
		<a class="cancel" href="#"></a>
		<div class="popup">
			<a class="close" href="#">&times;</a>

			<div class="popup__inner" id="login">
				<h2>Вход</h2>
				<form action="validation/login.php" method="post">
					<input type="email" class="form-control" name="email" id="email" placeholder="Введите почту">
					<input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль">

					<div class="popup__btns">
						<button type="submit" class="btn">Вход</button>
					</div>
				</form>
			</div>

			<div class="popup__inner" id="signup">
				<h2>Регистрация</h2>
				<form action="validation/signup.php" method="post">
					<input type="email" class="form-control" name="email" id="email" placeholder="Введите почту">
					<input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль">

					<div class="popup__btns">
						<button type="submit" class="btn">Регистрация</button>
					</div>
				</form>
			</div>

		</div>
	</div>

	<?php else: ?>
		<style>
			.account {
				position: absolute;
				top: 20px;
				right: 820px;
				z-index: 5;
			}

			.account__inner {
				display: inline-flex;
				align-items: center;
				font-weight: 700;
				margin-right: 20px;
			}

			.btn__account {
				display: none;
			}
		</style>

		<a href="admin">
			<div class="account">
				<div class="account__inner">
					<?=$_COOKIE['account']?>
					<img src="images/tools/user.svg" alt="user">
				</div>

				<a href="exit.php">
					Выход
				</a>
			</div>
		</a>
	<?php endif ?>

	<header class="header">
		<div class="header__inner container">
			<a class="logo" href="index.php">Work<span>flow</span></a>

			<nav class="menu">
				<ul>
					<li><a href="#about">О сервисе</a></li>
					<li><a href="#feedback">Помощь</a></li>
					<li>
						<input type="text" placeholder="Поиск">
						<a class="btn__search" href="search.php">
							<img src="images/tools/search.svg" alt="search">
						</a>
					</li>
					<li>
						<a class="btn btn__account" href="#popup">Аккаунт
							<img src="images/tools/account.svg" alt="account">
						</a>
					</li>
				</ul>
			</nav>
		</div>
	</header>

	<section class="hero">
		<div class="container">
			<div class="hero__inner">
				<h1>Работа мечты здесь</h1>
				<p class="subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere delectus molestias ad vel
					quibusdam fugiat
					cum, voluptates esse, quasi corrupti quidem optio repellat beatae et.</p>
			</div>
		</div>
	</section>

	<section class="job container">
		<div class="job__inner">

			<a class="job__item" href="job/frontend.php">
				<h3 class="job__title">Frontend Разработчик</h3>
				<p class="job__subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus, molestias?</p>
			</a>

			<a class="job__item" href="job/frontend.php">
				<h3 class="job__title">Backend Разработчик</h3>
				<p class="job__subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus, molestias?</p>
			</a>

			<a class="job__item" href="job/frontend.php">
				<h3 class="job__title">Fullstack Разработчик</h3>
				<p class="job__subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus, molestias?</p>
			</a>

			<a class="job__item" href="job/frontend.php">
				<h3 class="job__title">UI/UX Дизайнер</h3>
				<p class="job__subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus, molestias?</p>
			</a>

			<a class="job__item" href="job/frontend.php">
				<h3 class="job__title">Системный Администратор</h3>
				<p class="job__subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus, molestias?</p>
			</a>

			<a class="job__item" href="job/frontend.php">
				<h3 class="job__title">Разработчик Видеоигр</h3>
				<p class="job__subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus, molestias?</p>
			</a>

			<a class="job__item" href="job/frontend.php">
				<h3 class="job__title">Team Lead</h3>
				<p class="job__subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus, molestias?</p>
			</a>

		</div>
	</section>

	<section class="about container" id="about">
		<div class="about__inner">
			<h2>О сервисе</h2>
			<p>
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere delectus molestias ad vel quibusdam fugiat cum,
				voluptates esse, quasi corrupti quidem optio repellat beatae et. Lorem ipsum dolor sit amet consectetur
				adipisicing elit. Facere delectus molestias ad vel quibusdam fugiat cum, voluptates esse, quasi corrupti quidem
				optio repellat beatae et.
			</p>
			<p>
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere delectus molestias ad vel quibusdam fugiat cum,
				voluptates esse, quasi corrupti quidem optio repellat beatae et. Lorem ipsum dolor sit amet consectetur
				adipisicing elit. Facere delectus molestias ad vel quibusdam fugiat cum, voluptates esse, quasi corrupti quidem
				optio repellat beatae et.
			</p>
		</div>
	</section>

	<section class="feedback" id="feedback">
		<div class="container">
			<h2>Мы поможем</h2>
		</div>
		<div class="feedback__inner">
			<div class="feedback__bg"></div>

			<form action="feedback.php" method="POST">
				<input type="text" name="name" placeholder="Имя">
				<input type="text" name="email" placeholder="Почта *" required>
				<textarea name="text" placeholder="Сообщение *" required></textarea>
				<button type="submit">Отправить</button>
			</form>
		</div>
	</section>

	<footer class="footer">
		<div class="footer__inner">
			<div class="container">
				<!-- Footer Content -->
				<div class="footer__content">
					<div class="footer__box">
						<h3>Новости и статьи</h3>
						<nav>
							<ul>
								<li>
									<a href="#">Новости рынка HR</a>
								</li>
								<li>
									<a href="#">Жизнь в компании</a>
								</li>
								<li>
									<a href="#">ИТ-проекты</a>
								</li>
								<li>
									<a href="#">Рейтинг работодателей России</a>
								</li>
							</ul>
						</nav>
					</div>

					<div class="footer__box">
						<h3>Молодым специалистам</h3>
						<nav>
							<ul>
								<li>
									<a href="#">Карьера для молодых специалистов</a>
								</li>
								<li>
									<a href="#">Школа программистов</a>
								</li>
								<li>
									<a href="#">Школа продактов</a>
								</li>
							</ul>
						</nav>
					</div>

					<div class="footer__box">
							<h3>Новости и статьи</h3>
							<nav>
								<ul>
									<li>
										<a href="#">Новости рынка HR</a>
									</li>
									<li>
										<a href="#">Жизнь в компании</a>
									</li>
									<li>
										<a href="#">ИТ-проекты</a>
									</li>
									<li>
										<a href="#">Рейтинг работодателей России</a>
									</li>
								</ul>
							</nav>
						</div>

						<div class="footer__box">
							<h3>Молодым специалистам</h3>
							<nav>
								<ul>
									<li>
										<a href="#">Карьера для молодых специалистов</a>
									</li>
									<li>
										<a href="#">Школа программистов</a>
									</li>
									<li>
										<a href="#">Школа продактов</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
					<!-- / Footer Content -->

					<!-- Footer Content -->
					<div class="footer__content">
						<div class="footer__box">
							<h3>Новости и статьи</h3>
							<nav>
								<ul>
									<li>
										<a href="#">Новости рынка HR</a>
									</li>
									<li>
										<a href="#">Жизнь в компании</a>
									</li>
									<li>
										<a href="#">ИТ-проекты</a>
									</li>
									<li>
										<a href="#">Рейтинг работодателей России</a>
									</li>
								</ul>
							</nav>
						</div>

						<div class="footer__box">
							<h3>Молодым специалистам</h3>
							<nav>
								<ul>
									<li>
										<a href="#">Карьера для молодых специалистов</a>
									</li>
									<li>
										<a href="#">Школа программистов</a>
									</li>
									<li>
										<a href="#">Школа продактов</a>
									</li>
								</ul>
							</nav>
						</div>

						<div class="footer__box">
								<h3>Новости и статьи</h3>
								<nav>
									<ul>
										<li>
											<a href="#">Новости рынка HR</a>
										</li>
										<li>
											<a href="#">Жизнь в компании</a>
										</li>
										<li>
											<a href="#">ИТ-проекты</a>
										</li>
										<li>
											<a href="#">Рейтинг работодателей России</a>
										</li>
									</ul>
								</nav>
							</div>

							<div class="footer__box">
								<h3>Молодым специалистам</h3>
								<nav>
									<ul>
										<li>
											<a href="#">Карьера для молодых специалистов</a>
										</li>
										<li>
											<a href="#">Школа программистов</a>
										</li>
										<li>
											<a href="#">Школа продактов</a>
										</li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
					<!-- / Footer Content -->

				</div>
			</div>
		</div>

		<p>© 2023 WORKFLOW. Все права защищены. Разработан THELABUZOV</p>
	</footer>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/zepto/1.2.0/zepto.min.js"></script>
</body>

</html>