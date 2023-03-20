<?php
	require_once 'db.php';

	if (isset($_COOKIE['account'])) {
		$cookie = $_COOKIE['account'];

		$stmt = $pdo -> prepare("SELECT * FROM admin WHERE email = ?");
		$stmt -> execute([$cookie]);
		$admins = $stmt -> fetch();

		$stmt = $pdo -> prepare("SELECT * FROM employers WHERE email = ?");
		$stmt -> execute([$cookie]);
		$employers = $stmt -> fetch();

		$stmt = $pdo -> prepare("SELECT * FROM applicants WHERE email = ?");
		$stmt -> execute([$cookie]);
		$applicants = $stmt -> fetch();
	}
?>

<!DOCTYPE html>
<html lang='ru'>

<head>
	<meta charset='UTF-8'>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<title>Work Flow - поиск персонала и публикация вакансий</title>

  <link rel='shortcut icon' href='images/tools/favicon.ico' type='image/x-icon'>
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css'>
	<link rel='stylesheet' href='assets/animate.min.css'>
	<link rel='stylesheet' href='dist/style.css'>
</head>

<body>
	<?php
		if(($_COOKIE['account'] ?? '') === ''):
	?>

	<div id='popup' class='overlay'>
		<a class='cancel' href='#'></a>
		<div class='popup'>
			<a class='close' href='#'>&times;</a>

			<div class='popup__inner' id='login'>
				<h2>Вход</h2>
				<form action='validation/login.php' method='post'>
					<input type='email' class='form-control' name='email' id='email' placeholder='Введите почту' required>
					<input type='password' class='form-control' name='password' id='password' placeholder='Введите пароль' required>
					<button type='submit' class='btn'>Вход</button>
				</form>
			</div>

			<div class='popup__inner' id='signup'>
				<h2>Регистрация</h2>
				<form action='validation/signup.php' method='post'>
					<input type='email' class='form-control' name='email' id='email' placeholder='Введите почту' required>
					<input type='password' class='form-control' name='password' id='password' placeholder='Введите пароль' required>
					<input type='password' class='form-control' name='cpassword' id='cpassword' placeholder='Повторите пароль' required>
          <div>
          	<label for='employer'><input type='radio' name='category' id='employer' value='1' checked>Работодатель</label>
						<label for='applicant'><input type='radio' name='category' id='applicant' value='2'>Соискатель</label>
					</div>
					<button type='submit' class='btn'>Регистрация</button>
				</form>
			</div>

		</div>
	</div>

	<?php else: ?>
		<style>
			.account {
				display: inline-flex;
				align-items: center;
				position: absolute;
				left: 50%;
				z-index: 2;
				font-weight: 700;
				transform: translateX(-50%);
				padding: 17px 0;
				cursor: pointer;
			}

			.account img {
				margin-right: 5px;
			}

			.account__menu {
				background-color: var(--white);
				position: absolute;
				top: 78px;
				left: 0;
				z-index: -1;
				transition: .3s;
				border-radius: 0 0 10px 10px;
			}

			.account__menu a {
				display: block;
				padding: 0 20px;
				margin: 20px 0;
			}

			.btn__account {
				display: none;
			}
		</style>

		<div class='account' onclick='showHide()'>
			<img src='images/tools/user.svg' alt='user'>
			<?= $_COOKIE['account'] ?>

			<div class='account__menu hidden' id='menu'>

				<?php if($employers): ?>
					<a href='account/employers/index.php'>Профиль</a>

				<?php elseif($applicants): ?>
					<a href='account/applicants/index.php'>Профиль</a>

				<?php else: ?>
					<a href='account/admin/index.php'>Профиль</a>

				<?php endif ?>

				<a href='exit.php'>Выход</a>
			</div>
		</div>
	<?php endif ?>

	<header class='header'>
		<div class='header__inner container'>
			<a class='logo' href='index.php'>Work<span>Flow</span></a>

			<nav class='menu'>
				<ul>
					<li><a href='index.php#about'>О сервисе</a></li>
					<li><a href='index.php#feedback'>Обратная связь</a></li>
					<li>
						<a href='employer.php'>Работодатели</a>
					</li>
					<li>
						<a href='applicant.php'>Соискатели</a>
					</li>
					<li>
						<a class='btn btn__account' href='index.php#popup'>Аккаунт
							<img src='images/tools/account.svg' alt='account'>
						</a>
					</li>
				</ul>
			</nav>
		</div>
	</header>

	<section class='hero'>
		<div class='container'>
			<div class='hero__inner'>
				<div>
					<h1>Работа со <span>всей</span> россии</h1>
					<p class='subtitle'>
						Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere delectus molestias ad vel quibusdam fugiat cum, voluptates esse, quasi corrupti quidem optio repellat beatae et.
					</p>
				</div>
			</div>
		</div>

		<div id='ocean'></div>
	</section>

	<section class='container'>
		<div class='job__slider'>
			<div class='swiper job'>
				<div class='swiper-wrapper'>
					<a class='swiper-slide job__item' href='https://google.com'>
						<img src="images/tools/google.svg" alt="google">
						<p>Google</p>
					</a>

					<a class='swiper-slide job__item' href='https://instagram.com'>
						<img src="images/tools/instagram.svg" alt="instagram">
						<p>Instagram</p>
					</a>

					<a class='swiper-slide job__item' href='https://facebook.com'>
						<img src="images/tools/facebook.svg" alt="facebook">
						<p>Facebook</p>
					</a>

					<a class='swiper-slide job__item' href='https://twitter.com'>
						<img src="images/tools/twitter.svg" alt="twitter">
						<p>Twitter</p>
					</a>

					<a class='swiper-slide job__item' href='https://google.com'>
						<img src="images/tools/google.svg" alt="google">
						<p>Google</p>
					</a>

					<a class='swiper-slide job__item' href='https://instagram.com'>
						<img src="images/tools/instagram.svg" alt="instagram">
						<p>Instagram</p>
					</a>

					<a class='swiper-slide job__item' href='https://facebook.com'>
						<img src="images/tools/facebook.svg" alt="facebook">
						<p>Facebook</p>
					</a>

					<a class='swiper-slide job__item' href='https://twitter.com'>
						<img src="images/tools/twitter.svg" alt="twitter">
						<p>Twitter</p>
					</a>
				</div>

				<div class='swiper-button-prev'></div>
				<div class='swiper-button-next'></div>
			</div>
		</div>
	</section>

	<section class='description container' id='about'>
		<div>
			<h2>О сервисе</h2>
			<p>
				Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatum voluptas perferendis cupiditate! At vero molestiae sint, voluptates adipisci eius fugit odit itaque aliquid deserunt illum aperiam rem debitis voluptas esse eveniet quam ut quo laudantium sit est nesciunt! Aperiam at harum ullam, modi alias dicta eius hic, itaque ut debitis quo dolorem! Architecto fuga et hic quo accusamus aperiam reprehenderit exercitationem perferendis, perspiciatis sint ad id, nulla veniam in mollitia, rerum cupiditate enim ipsa quasi nemo porro consectetur quis doloribus ut. Voluptatem eveniet obcaecati, officiis excepturi debitis velit veniam doloremque repudiandae rerum omnis quo provident fugit dolore ex molestias laborum?
			</p>
		</div>

		<div class='swiper worker wow animate__animated animate__slideInRight'>
			<div class='swiper-wrapper'>
				<div class='swiper-slide worker__item'><img src='images/content/banner-user-1.png' alt='banner-user-1'></div>
				<div class='swiper-slide worker__item'><img src='images/content/banner-user-2.png' alt='banner-user-2'></div>
				<div class='swiper-slide worker__item'><img src='images/content/banner-user-3.png' alt='banner-user-3'></div>
				<div class='swiper-slide worker__item'><img src='images/content/banner-user-4.png' alt='banner-user-4'></div>
				<div class='swiper-slide worker__item'><img src='images/content/banner-user-5.png' alt='banner-user-5'></div>
				<div class='swiper-slide worker__item'><img src='images/content/banner-user-6.png' alt='banner-user-6'></div>
				<div class='swiper-slide worker__item'><img src='images/content/banner-user-7.png' alt='banner-user-7'></div>
			</div>
		</div>
	</section>
	
	<section class="container">
		<h2>Обратная связь</h2>

		<section class='feedback' id='feedback'>
			<iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A1a16b812f78421035c4bd25ac085af5fc4b42684b9a6442c70bc9730ebfe2212&amp;source=constructor" width="1100" height="600" frameborder="0"></iframe>

			<div class="feedback__inner">
				<form action='index.php' method='post'>
					<input type='text' name='email' placeholder='Почта *' required>
					<textarea name='description' placeholder='Сообщение *' required></textarea>
					<button type='submit'>Отправить</button>
				</form>
			</div>
		</section>
	</section>

	<footer>© 2023 WORKFLOW. Все права защищены. Разработан <a href='https://thelabuzov.github.io'>THELABUZOV</a></footer>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/zepto/1.2.0/zepto.min.js'></script>
	<script src='https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js'></script>
	<script src='assets/wow.min.js'></script>
	<script src='dist/script.js'></script>
  <script>new WOW().init()</script>
	<script>
		var ocean = document.getElementById('ocean'),
    waveWidth = 10,
    waveCount = Math.floor(window.innerWidth/waveWidth),
    docFrag = document.createDocumentFragment();

		for(var i = 0; i < waveCount; i++) {
			var wave = document.createElement('div');
			wave.className += ' wave';
			docFrag.appendChild(wave);
			wave.style.left = i * waveWidth + 'px';
			wave.style.webkitAnimationDelay = (i/100) + 's';
		}

		ocean.appendChild(docFrag);
	</script>
</body>

</html>