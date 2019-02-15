<?php
  session_start();
  $cria     = isset($_POST["cria"])?$_POST["cria"]:0;
  $user     = isset($_POST["user"])?$_POST["user"]:0;
  $conectar = mysqli_connect("127.0.0.1", "root", "", "test");

  if(!$conectar){
    echo "Erro na conexão com banco de dados ".mysqli_connect_error();
  }

  if($cria != " " && $cria != 0){
    $inserir = mysqli_query($conectar, "INSERT INTO usuario VALUES(DEFAULT, '$cria')");

    date_default_timezone_set("America/Sao_Paulo");
    $select_bk   = mysqli_query($conectar, "SELECT * FROM usuario");
    $backup_usr  = fopen("backup_usr.txt", "a+");
    fwrite($backup_usr, "\r\n[Data_insert: ". date("d/m/Y - l  (H:i:s)")."]\r\n\r\n");

    while($bk = mysqli_fetch_array($select_bk, MYSQLI_ASSOC)){
      fwrite($backup_usr, $bk['ID']." ".$bk['nome']."\r\n");
    }

    fclose($backup_usr);
  }


  $pesquisar = mysqli_query($conectar, "SELECT * FROM usuario WHERE nome = '$user'");

  $retorno   = mysqli_fetch_array($pesquisar, MYSQLI_ASSOC);

  if($retorno['nome'] == $user && $user != NULL){
     header("Location: http://127.0.0.1/Chat.php");
     $_SESSION['nome'] = $user;
  }
  else{
    header("Location: http://127.0.0.1/login.php");
    unset($_SESSION['nome']);
  }

  mysqli_close($conectar);
?>
