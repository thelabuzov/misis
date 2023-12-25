<?php
  require_once '../../db.php';

  // Удаление данных администратора
	if(isset($_GET['id'])) {
    $stmt = $pdo -> prepare('SELECT * FROM admin WHERE id = ?');
    $stmt -> execute([$_GET['id']]);
    $admin = $stmt -> fetch();

    if($admin) {
      $stmt = $pdo -> prepare('DELETE FROM admin WHERE id = ?');
      $stmt -> execute([$_GET['id']]);
    }

    setcookie('account', $account['email'], time() - 100000, '/course');
    header('Location: ../../index.php');
  }
?>