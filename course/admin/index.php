<?php
  require_once "../db.php";

	$stmt = $pdo -> query("select * from messages");
  $messages = $stmt -> fetchAll();

	$stmt = $pdo -> query("select * from admin");
  $administrator = $stmt -> fetchAll();

  $stmt = $pdo -> query("select * from employer");
  $employer = $stmt -> fetchAll();

  $stmt = $pdo -> query("select * from applicant");
  $applicant = $stmt -> fetchAll();

  session_start();
  $acc = $_COOKIE['account'];
  $mysql = mysqli_connect('localhost', 'root', '', 'workflow');
  if (!$mysql) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Получаем текущие значения полей из базы данных admin
  $admin = "SELECT * FROM `admin` WHERE email = '$acc'";
  $result = mysqli_query($mysql, $admin);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $email = $row["email"];
    $password = $row["password"];
  } else {
    echo "Error: " . $admin . "<br>" . mysqli_error($mysql);
  }

  // Обработка данных из формы редактирования admin
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $new_email = $_POST["email"];
    $new_password = $_POST["password"];

    // Запрос к базе данных для обновления данных пользователя
    $admin = "UPDATE `admin` SET
    email = '$new_email',
    password = '$new_password'
    WHERE email = '$acc'";

    if (mysqli_query($mysql, $admin)) {
      if ($email != $new_email || $password != $new_password) {
				setcookie('account', $account['email'], time() - 100000, "/course");
				header('Location: ../');
			} else {
				header('Location: #');
			}
    } else {
      echo "Error: " . $admin . "<br>" . mysqli_error($mysql);
    }

    if (empty($acc)) {
      echo "Error: Account is empty";
      exit;
    }
  }

  // Закрытие соединения с базой данных
  mysqli_close($mysql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="shortcut icon" href="../images/tools/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="../assets/css/lightgallery.css">
	<link rel="stylesheet" href="../assets/css/lg-transitions.css">
	<link rel="stylesheet" href="../dist/style.css">
	<style>
    .edit > label {
	    display: block;
    }
	</style>

	<script defer src="../dist/script.js"></script>
  <script defer src="../assets/js/lightgallery.min.js"></script>
  <title>Страница Пользователя</title>
</head>
<body>
	<!-- <div id="popup" class="overlay">
		<a class="cancel" href="#"></a>
		<div class="popup">
			<a class="close" href="#">&times;</a>

			<div class="popup__inner">
				<h2>Добавление работы</h2>
				<form action="add.php" method="post" enctype="multipart/form-data">
          <input name="name" type="text" placeholder="Название" required>
          <input name="file" type="file" required>
          <input type="submit" value="Создать">
        </form>
			</div>
		</div>
	</div> -->

	<?php
		if (($_COOKIE['account'] ?? '') === ''):
	?>

	<div id="popup" class="overlay">
		<a class="cancel" href="#"></a>
		<div class="popup">
			<a class="close" href="#">&times;</a>

			<div class="popup__inner" id="login">
				<h2>Вход</h2>
				<form action="../validation/login.php" method="post">
					<input type="email" class="form-control" name="email" id="email" placeholder="Введите почту">
					<input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль">

					<div class="popup__btns">
						<button type="submit" class="btn">Вход</button>
					</div>
				</form>
			</div>

			<div class="popup__inner" id="signup">
				<h2>Регистрация</h2>
				<form action="../validation/signup.php" method="post">
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
				display: inline-flex;
				align-items: center;
				position: absolute;
				left: 50%;
				z-index: 2;
				font-weight: 700;
				transform: translateX(-65%);
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

		<div class="account" onclick="showHide()">
			<img src="../images/tools/user.svg" alt="user">
			<?=$_COOKIE['account']?>

			<div class="account__menu hidden" id="menu">

				<?php if ($employer): ?>
					<a href="employer.php">Профиль</a>

				<?php elseif ($applicant): ?>
					<a href="applicant.php">Профиль</a>

				<?php else: ?>
					<a href="#">Профиль</a>

				<?php endif ?>

				<a href="../exit.php">Выход</a>
			</div>
		</div>
	<?php endif ?>

	<header class="header">
		<div class="header__inner container">
			<a class="logo" href="../">Work<span>Flow</span></a>

			<nav class="menu">
				<ul>
					<li><a href="../#about">О сервисе</a></li>
					<li><a href="../#feedback">Помощь</a></li>
					<li>
						<a href="../employer.php">Вакансии</a>
					</li>
					<li>
						<a href="../applicant.php">Соискатели</a>
					</li>
					<li>
						<a class="btn btn__account" href="#popup">Аккаунт
							<img src="../images/tools/account.svg" alt="account">
						</a>
					</li>
				</ul>
			</nav>
		</div>
	</header>

  <main class="container">
		<section class="form">
			<!-- <form class="edit" action="applicant.php" method="post" enctype="multipart/form-data">
				<div>
					<label for="name">Аватар: <input id="name" name="name" type="text" placeholder="Название" required></label>
					<input name="file" type="file" required>
				</div>
				<label for="email">Почта: <input id="email" name="email" type="email" placeholder="Введите почту" value="<?php echo $email?>" required></label>
				<label for="password">Пароль: <input id="password" name="password" type="password" placeholder="Введите пароль" value="<?php echo $password?>" required></label>

				<br>

				<input type="submit" id="account" name="account" value="Данные аккаунта">
			</form>

			<br> -->

			<form class="edit" action="index.php" method="post" enctype="multipart/form-data">
				<label for="email">Почта:
					<input id="email" name="email" type="email" placeholder="Введите почту" value="<?php echo $email ?>">
				</label>
				<label for="password">Пароль:
					<input id="password" name="password" type="password" placeholder="Введите пароль" value="<?php echo $password ?>">
				</label>

				<br>

				<input type="submit" id="submit" name="submit" value="Редактировать">
			</form>
		</section>

    <section class="data">
      <h2>Сообщения</h2>

      <table class="data__table" border="1">
        <tr>
          <th>#</th>
          <th>Имя</th>
          <th>Email</th>
          <th>Текст</th>
          <th>Дата и время</th>
        </tr>

        <?php foreach ($messages as $key => $message) : ?>
          <tr>
            <td><?= $key + 1 ?></td>
            <td><?= htmlspecialchars($message['name']) ?></td>
            <td><?= htmlspecialchars($message['email']) ?></td>
            <td><?= htmlspecialchars($message['text']) ?></td>
            <td><?= $message['created_at'] ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </section>

		<section class="data">
      <h2>Администраторы</h2>

      <table class="data__table" border="1">
        <tr>
          <th>#</th>
          <th>Почта</th>
          <th>Пароль</th>
        </tr>

        <?php foreach ($administrator as $key => $adm) : ?>
          <tr>
            <td><?= $key + 1 ?></td>
            <td><?= htmlspecialchars($adm['email']) ?></td>
            <td><?= htmlspecialchars($adm['password']) ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </section>

    <section class="data">
      <h2>Работодатели</h2>

      <table class="data__table" border="1">
        <tr>
          <th>#</th>
          <th>Название</th>
          <th>Описание</th>
          <th>Вакансии</th>
          <th>Регион</th>
          <th>Почта</th>
          <th>Пароль</th>
          <th>Телефон</th>
        </tr>

        <?php foreach ($employer as $key => $emp) : ?>
          <tr>
            <td><?= $key + 1 ?></td>
            <td><?= htmlspecialchars($emp['name']) ?></td>
            <td><?= htmlspecialchars($emp['description']) ?></td>
            <td><?= htmlspecialchars($emp['vacancy']) ?></td>
            <td><?= htmlspecialchars($emp['region']) ?></td>
            <td><?= htmlspecialchars($emp['email']) ?></td>
            <td><?= htmlspecialchars($emp['password']) ?></td>
            <td><?= htmlspecialchars($emp['phone_number']) ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </section>

    <section class="data">
      <h2>Соискатели</h2>

      <table class="data__table" border="1">
        <tr>
          <th>#</th>
          <th>Фамилия</th>
          <th>Имя</th>
          <th>Отчество</th>
          <th>Опыт</th>
          <th>Дата рождения</th>
          <th>Регион</th>
          <th>Почта</th>
          <th>Пароль</th>
          <th>Телефон</th>
        </tr>

        <?php foreach ($applicant as $key => $app) : ?>
          <tr>
            <td><?= $key + 1 ?></td>
            <td><?= htmlspecialchars($app['last_name']) ?></td>
            <td><?= htmlspecialchars($app['first_name']) ?></td>
            <td><?= htmlspecialchars($app['middle_name']) ?></td>
            <td><?= htmlspecialchars($app['experience']) ?></td>
            <td><?= htmlspecialchars($app['birthday']) ?></td>
            <td><?= htmlspecialchars($app['region']) ?></td>
            <td><?= htmlspecialchars($app['email']) ?></td>
            <td><?= htmlspecialchars($app['password']) ?></td>
            <td><?= htmlspecialchars($app['phone_number']) ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </section>
  </main>

  <footer>© 2023 WORKFLOW. Все права защищены. Разработан <a href="https://thelabuzov.github.io">THELABUZOV</a></footer>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/zepto/1.2.0/zepto.min.js"></script>
</body>
</html>