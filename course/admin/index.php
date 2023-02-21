<?php
  require_once "../db.php";

  $stmt = $pdo->query("select * from messages");
  $messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="dist/style.css">
	<script defer src="dist/script.js"></script>
  <title>Страница Пользователя</title>
</head>
<body>
  <section class="admin container">
    <h2>Сообщения</h2>

    <table class="admin__table" border="1">
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
</body>
</html>