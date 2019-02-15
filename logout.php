<?php
  session_start();
  session_destroy();
  unset($_SESSION['nome']);
  header("Location: http://127.0.0.1/Testes_Freela/login.php");
?>
