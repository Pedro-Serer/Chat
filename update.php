<?php
  session_start();

  if(!isset($_SESSION['nome'])){
    session_destroy();
    unset($_SESSION['nome']);
    header("Location: http://127.0.0.1/login.php");
  }

  $conectar    = mysqli_connect("127.0.0.1", "root", "", "test");
  $novoNome    = isset($_POST['novoNome'])?$_POST['novoNome']:0;
  $xss         = array("<", ">", "\"", "'");  //filtro basicão
  $xsSqi       = str_replace($xss, "", $novoNome);
  $logado      = $_SESSION['nome'];

  $atualizar = mysqli_query($conectar, "UPDATE usuario SET nome = '$xsSqi' WHERE nome = '$logado' LIMIT 1");
  if($atualizar != false){
    echo "<script>alert('Dados atualizados com sucesso!')</script>";
    echo "<center> <a href='http://127.0.0.1/Testes_Freela/login.php'> Acesse com seu novo nome! </a> </center>";

    date_default_timezone_set("America/Sao_Paulo");
    $select_bk   = mysqli_query($conectar, "SELECT * FROM usuario");
    $backup_usr  = fopen("backup_usr.txt", "a+");
    fwrite($backup_usr, "\r\n[Data_update: ". date("d/m/Y - l  (H:i:s)")."]\r\n\r\n");

    while($bk = mysqli_fetch_array($select_bk, MYSQLI_ASSOC)){
      fwrite($backup_usr, $bk['ID']." ".$bk['nome']."\r\n");
    }

    fclose($backup_usr);
  }
  else{
    echo "<script>alert('Erro ao atualizar!')</script>";
    header("Location: http://127.0.0.1/Chat.php");
  }

?>
