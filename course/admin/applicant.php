<?php
  require_once "../db.php";

  $stmt = $pdo -> query("select * from applicant");
  $applicant = $stmt -> fetchAll();

  $stmt = $pdo -> query("select * from works");
  $works = $stmt -> fetchAll();

  session_start();
  $acc = $_COOKIE['account'];
  $mysql = mysqli_connect('localhost', 'root', '', 'workflow');
  if (!$mysql) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Получаем текущие значения полей из базы данных applicant
  $applicant = "SELECT * FROM `applicant` WHERE email = '$acc'";
  $result = mysqli_query($mysql, $applicant);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $full_name = $row["full_name"];
    $location = $row["location"];
    $experience = $row["experience"];
    $birthday = $row["birthday"];
    $email = $row["email"];
    $password = $row["password"];
    $phone_number = $row["phone_number"];
  } else {
    echo "Error: " . $applicant . "<br>" . mysqli_error($mysql);
  }

  // Обработка данных из формы редактирования applicant
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $new_full_name = $_POST["full_name"];
    $new_location = $_POST["location"];
    $new_experience = $_POST["experience"];
    $new_birthday = $_POST["birthday"];
    $new_email = $_POST["email"];
    $new_password = $_POST["password"];
    $new_phone_number = $_POST["phone_number"];

    // Запрос к базе данных для обновления данных пользователя
    $applicant = "UPDATE `applicant` SET
    full_name = '$new_full_name',
    location = '$new_location',
    experience = '$new_experience',
    birthday = '$new_birthday',
    email = '$new_email',
    password = '$new_password',
    phone_number = '$new_phone_number'
    WHERE email = '$acc'";

    if (mysqli_query($mysql, $applicant)) {
      if ($email != $new_email || $password != $new_password) {
				setcookie('account', $account['email'], time() - 100000, "/course");
				header('Location: ../');
			} else {
				header('Location: #');
			}
    } else {
      echo "Error: " . $applicant . "<br>" . mysqli_error($mysql);
    }

    if (empty($acc)) {
      echo "Error: Account is empty";
      exit;
    }
  }

	if (!empty($_POST['name'])) {
    $apppath = dirname(dirname(__FILE__));
    $filepath = 'images/content/uploads/' . time() . basename($_FILES['file']['name']);
    $uploadfile = $apppath . '/' . $filepath;

    move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);

    $stmt = $pdo->prepare("insert into works(name, file_path) values(?,?)");
    $stmt->execute([
      $_POST['name'],
      $filepath
    ]);

    header("Location: #");
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
	<title>Страница Пользователя</title>

  <link rel="shortcut icon" href="../images/tools/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="../assets/css/lightgallery.min.css">
	<link rel="stylesheet" href="../assets/css/lg-transitions.min.css">
	<link rel="stylesheet" href="../dist/style.css">
	<style>
    .edit > label {
	    display: block;
    }
	</style>
</head>

<body>
	<div id="popup" class="overlay">
		<a class="cancel" href="#"></a>
		<div class="popup">
			<a class="close" href="#">&times;</a>

			<div class="popup__inner">
				<h2>Добавление работы</h2>
				<form action="applicant.php" method="post" enctype="multipart/form-data">
          <input name="name" type="text" placeholder="Название" required>
          <input name="file" type="file" required>
          <input type="submit" value="Создать">
        </form>
			</div>
		</div>
	</div>

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

				<?php if ($applicant): ?>
					<a href="#">Профиль</a>

				<?php elseif ($employer): ?>
					<a href="employer.php">Профиль</a>

				<?php else: ?>
					<a href="index.php">Профиль</a>

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
			<form class="edit" action="applicant.php" method="post" enctype="multipart/form-data">
				<label for="email">Почта:
					<input id="email" name="email" type="email" placeholder="Введите почту" value="<?php echo $email ?>">
				</label>
				<label for="password">Пароль:
					<input id="password" name="password" type="password" placeholder="Введите пароль" value="<?php echo $password ?>">
				</label>

				<br>

				<label for="full_name">Полное имя:
					<input id="full_name" name="full_name" type="text" placeholder="Введите текст" value="<?php echo $full_name ?>">
				</label>
				<label for="location">Локация:
					<input id="location" name="location" type="text" placeholder="Введите текст" value="<?php echo $location ?>">
				</label>

				<br>

				<label for="experience">Опыт:
					<input id="experience" name="experience" type="text" placeholder="Введите число" value="<?php echo $experience ?>">
				</label>
				<label for="birthday">Дата рождения:
					<input id="birthday" name="birthday" type="date" placeholder="Введите дату" value="<?php echo $birthday ?>">
				</label>
				<label for="phone_number">Номер телефона:
					<input id="phone_number" name="phone_number" type="number" placeholder="Введите номер" value="<?php echo $phone_number ?>">
				</label>

				<br>

				<input type="submit" id="submit" name="submit" value="Редактировать">
			</form>

			<!-- <form action="applicant.php" method="post" enctype="multipart/form-data">
        <label for="name"></label>
        <input name="file" type="file">
        <input type="submit" value="Добавить">
      </form> -->
		</section>

  	<section class="data portfolio">
    	<div id="lightgallery" class="gallery">
        <?php foreach ($works as $work) : ?>
          <a class="img-wrapper" data-sub-html="<?= $work['name'] ?>" href="http://misis/course/<?= $work['file_path'] ?>">
            <img src="http://misis/course/<?= $work['file_path'] ?>" alt="<?= $work['name'] ?>">
          </a>
        <?php endforeach; ?>
    	</div>

    	<div class="portfolio__content">
      	<h2>Портфолио</h2>

      	<div>
					<a class="btn" href="#popup">Добавить</a>
        	<a class="btn" href="remove.php?id=<?= $work['id'] ?>">Удалить</a>
      	</div>
    	</div>
  	</section>
  </main>

  <footer>© 2023 WORKFLOW. Все права защищены. Разработан <a href="https://thelabuzov.github.io">THELABUZOV</a></footer>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/zepto/1.2.0/zepto.min.js"></script>
  <script src="../assets/js/lightgallery.min.js"></script>
	<script src="../dist/script.js"></script>
</body>
</html>