<?php
  require_once '../../db.php';

	if (isset($_COOKIE['account'])) {
		$cookie = $_COOKIE['account'];

		$stmt = $pdo -> prepare("SELECT * FROM employers WHERE email = ?");
		$stmt -> execute([$cookie]);
		$employers = $stmt -> fetchAll();
	}

	$stmt = $pdo -> query("SELECT * FROM employers_job");
  $employers_job = $stmt -> fetchAll();
?>

<!DOCTYPE html>
<html lang='ru'>
<head>
	<meta charset='UTF-8'>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<title>WORKFLOW - страница пользователя</title>

  <link rel='shortcut icon' href='../../images/tools/favicon.ico' type='image/x-icon'>
	<link rel='stylesheet' href='../../dist/style.css'>
</head>
<body>
	<div class='loader'>
		<svg width='200' height='200' viewBox='0 0 100 100'>
			<polyline class='line' points='0,0 100,0 100,100' stroke-width='10' fill='none'></polyline>
			<polyline class='line' points='0,0 0,100 100,100' stroke-width='10' fill='none'></polyline>
			<polyline class='line line__animation' points='0,0 100,0 100,100' stroke-width='10' fill='none'></polyline>
			<polyline class='line line__animation' points='0,0 0,100 100,100' stroke-width='10' fill='none'></polyline>
		</svg>
	</div>

	<?php
		if(($_COOKIE['account'] ?? '') === ''):
	?>

	<?php else: ?>
		<style>
			.account {
				display: inline-flex;
				align-items: center;
				position: absolute;
				right: 0;
				z-index: 2;
				font-weight: 700;
				margin-right: 100px;
				padding: 17px 0;
				cursor: pointer;
			}

			.account__menu {
				background-color: var(--white);
				position: absolute;
				top: 77px;
				right: 0;
				transition: var(--transition-min);
				border-radius: 0 0 10px 10px;
			}

			.account__menu a {
				display: block;
				padding: 0 20px;
				margin: 20px 0;
			}

			li:has(.btn__account) {
				display: none;
			}
		</style>

		<div class='account__outer container'>
			<div class='account' onclick='showHide()'>
				<img src='../../images/tools/user.svg' alt='user' loading='lazy'>

				<div class='account__menu hidden' id='menu'>
					<a href='#'>Профиль</a>
					<a href='../../exit.php'>Выход</a>
				</div>
			</div>
		</div>
	<?php endif ?>

	<header class='header'>
		<div class="menu__top">
			<div class='header__inner container'>
				<a class='logo' href='../../index.php'>Work<span>Flow</span></a>

				<div class='menu__outer'>
					<a href="#" class="menu__toggle">☰</a>
					<nav class="menu__box">
						<ul>
							<li>
								<a href='../../index.php#about'>О сервисе</a>
								<a href='../../index.php#feedback'>Обратная связь</a>
							</li>
							<li>
								<a href='../../employer.php'>Работодатели</a>
								<a href='../../applicant.php'>Соискатели</a>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>

		<div class='menu'>
			<nav class='header__inner container'>
				<ul>
					<li>
						<a href='../../index.php#about'>О сервисе</a>
					</li>
					<li>
						<a href='../../index.php#feedback'>Обратная связь</a>
					</li>
					<li>
						<a href='../../employer.php'>Работодатели</a>
					</li>
					<li>
						<a href='../../applicant.php'>Соискатели</a>
					</li>
				</ul>
			</nav>
		</div>
	</header>

  <main class='data__outer container'>
		<section>
      <h2>Работодатель</h2>

      <div class='data'>
        <form action='edit.php' method='post' enctype='multipart/form-data'>
          <table class='data__table' border='1'>
            <tr>
              <th>Действие</th>
              <th>Название</th>
              <th>Регион</th>
							<th>Псевдоним</th>
              <th>Почта</th>
              <th>Пароль</th>
              <th>Телефон</th>
            </tr>

            <?php foreach($employers as $key => $employer): ?>
              <tr>
								<td class='data__btns'>
                  <input class='btn' type='submit' name='employers' value='Редактировать'>
                  <a class='btn btn--del' href='delete.php?id=<?= $employer['id'] ?>'>Удалить</a>
                </td>

                <td><input name='name' type='text' placeholder='Введите текст' value='<?php echo $employer['name'] ?>'></td>
                <td><input name='region' type='text' placeholder='Введите текст' value='<?php echo $employer['region'] ?>'></td>
                <td><input name='nickname' type='text' placeholder='Введите псевдоним *' value='<?php echo $employer['nickname'] ?>' required></td>
                <td><input name='email' type='email' placeholder='Введите почту *' value='<?php echo $employer['email'] ?>' required></td>
                <td><input name='password' type='password' placeholder='Введите пароль *' value='<?php echo $employer['password'] ?>' required></td>
                <td><input name='phone_number' type='tel' placeholder='Введите номер *' value='<?php echo $employer['phone_number'] ?>' required></td>
              </tr>
            <?php endforeach ?>

          </table>
        </form>
      </div>
    </section>

		<section>
			<h2>Создание вакансии</h2>

			<div class='data form'>
				<form action='vacancy/add.php' method='post' enctype='multipart/form-data'>
					<label for='price'>Зарплата:
						<input id='price' name='price' type='number' placeholder='Введите число *' required>
					</label>
					<label for='name'>Название:
						<input id='name' name='name' type='text' placeholder='Введите текст *' value='<?php echo $employer['name'] ?>' required>
					</label>
					<label for='experience'>Опыт:
						<input id='experience' name='experience' type='number' placeholder='Введите число *' required>
					</label>
					<label for='job'>Специальность:
						<input id='job' name='job' type='text' placeholder='Введите текст *' required>
					</label>
					<label for='region'>Регион:
						<input id='region' name='region' type='text' placeholder='Введите текст *' value='<?php echo $employer['region'] ?>' required>
					</label>
					<label for='description'>Описание:
						<textarea id='description' name='description' placeholder='Введите текст *' required></textarea>
					</label>

					<br>

					<label for='email'>Почта:
						<input id='email' name='email' type='email' placeholder='Введите почту *' value='<?php echo $employer['email'] ?>' required>
					</label>
					<label for='phone_number'>Телефон:
						<input id='phone_number' name='phone_number' type='tel' placeholder='Введите номер *' value='<?php echo $employer['phone_number'] ?>' required>
					</label>

					<br>

					<input type='submit' name='employers_job' value='Опубликовать'>
				</form>
			</div>
		</section>

		<section class='data jobs'>
			<div class='job' id='job'>

				<?php foreach($employers_job as $job): ?>
					<div class='job__item'>
						<div class='demand'><?= $job['price'] ?> руб.</div>
						<h3><?= $job['name'] ?></h3>
						<div class='demand'><?= $job['experience'] ?> год опыта</div>
						<div class='search'><?= $job['job'] ?> (<?= $job['region'] ?>)</div>
						<p><?= $job['description'] ?></p>

						<div>
							<a class='btn' href='mailto:<?= $job['email'] ?>'><?= $job['email'] ?></a>
							<a class='btn' href='tel:<?= $job['phone_number'] ?>'><?= $job['phone_number'] ?></a>
						</div>

						<a class='btn btn__job btn--del' href='vacancy/delete.php?id=<?= $job['id'] ?>'>Удалить</a>
					</div>
				<?php endforeach ?>

    	</div>
		</section>
	</main>

  <footer>© 2023 WORKFLOW. Все права защищены. Разработан <a href='https://thelabuzov.github.io'>THELABUZOV</a></footer>

	<script src='https://cdnjs.cloudflare.com/ajax/libs/zepto/1.2.0/zepto.min.js'></script>
	<script src='../../dist/script.js'></script>
</body>
</html>