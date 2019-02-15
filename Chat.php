<?php
  session_start();

  if(!isset($_SESSION['nome'])){
    session_destroy();
    unset($_SESSION['nome']);
    header("Location: http://127.0.0.1/login.php");
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>Simple Chat</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Black+Han+Sans|Crimson+Text|Merriweather|Pacifico" rel="stylesheet">

    <style>
      body{
        overflow: hidden;
      }

      input[type=text]{
        border: 2px solid black;
        border-radius: 5px;
        width: 55%;
        height: 25px;
      }

      input[type=submit]{
        background-color: #FF3B3F;
        color: #E6E6E6;
        height: 27px;
        border: 1px solid black;
      }

      #div-form{
        position: absolute;
        bottom: 7px;
        right: -300px;
        width: 97%;
        padding-top: 10px;
        padding-left: 100%;
        height: 37px;
        background-color: #E6E6E6;
      }

      #mostra-mensagem{
        background: url('background.jpg');
        position: absolute;
        top: 0px;
        right: 220px;
        border: 1px solid black;
        width: 59%;
        height: 580px;
        box-shadow: 2px 2px 2px black;
        overflow-y: scroll;
        overflow-x: hidden;
      }

      .msg{
        position: relative;
        border: 1px solid transparent;
        width: 30%;
        border-radius: 6px;
      }

      .msg-left{
        position: relative;
        right: 229px;
        width: 35%;
        background-color: #E6E6E6;
        color: black;
        font-family: 'Merriweather', serif;
        word-break: break-all;
      }

      .msg-right{
        position: relative;
        left: 220px;
        width: 35%;
        background-color: #FF3B3F;
        color: #E6E6E6;
        font-family: 'Merriweather', serif;
        word-break: break-all;
      }

      .msg-right::after{
        content: "";
        position: absolute;
        top: 20%;
        left: 100%;
        border-width: 5px;
        border-style: solid;
        border-color: transparent transparent transparent #FF3B3F;
      }

      .msg-left::after{
        content: "";
        position: absolute;
        top: 20%;
        right: 100%;
        border-width: 5px;
        border-style: solid;
        border-color: transparent #E6E6E6 transparent transparent;
      }

      #usuarios{
        border: 1px solid black;
        width: 20%;
        height: 500px;
        background-color: #EFEFEF;
        box-shadow: 1px 1px 1px black;
        overflow-y: scroll;
      }

      .usuarios{
        border: 1px solid black;
        height: 110px;
        font-family: 'Black Han Sans', sans-serif;
        font-size: 1.5em;
      }

      .usuarios:hover{
        background-color: #A9A9A9;
        color: white;
      }

      #botoes{
        position: absolute;
        top: 0px;
        right: -35px;
        cursor: pointer;
      }

      #voce{
        position: relative;
        left: 133px;
        font-size: 8pt;
      }

      #outro{
        position: relative;
        right: 310px;
        font-size: 8pt;
      }

      #update{
        visibility: hidden;
      }

      img:hover{
        transform: scale(1.1);
      }
    </style>

  </head>
  <body>
    <div id="div-form">
      <form method="post" action="">
        <input type='text' name="msg" placeholder="Escreva sua mensagem" autocomplete="off" required>
        <input type="submit" value="Enviar">
      </form>
    </div>

    <?php
      date_default_timezone_set("America/Sao_Paulo");
      $msg         = isset($_POST['msg'])?$_POST['msg']:0;
      $xss         = array("<", ">");  //filtro basicão
      $msgXss      = str_replace($xss, " ", $msg);

      $logado      = $_SESSION['nome'];
      $conectar    = mysqli_connect("127.0.0.1", "root", "", "test");
      $dataHora    = date("d/m/Y (H:i:s)");
      $pesquisa_id = mysqli_query($conectar, "SELECT * FROM usuario WHERE nome = '$logado'");
      $result_id   = mysqli_fetch_array($pesquisa_id, MYSQLI_ASSOC);
      $inserir     = mysqli_query($conectar, "INSERT INTO mensagem VALUES(DEFAULT, ".$result_id['ID'].", '$msgXss', '$dataHora')");
      $consulta    = mysqli_query($conectar, "SELECT * FROM mensagem");

    ?>

    <h2 style="font-family: 'Merriweather', serif;">Usuários</h2>
    <div id="usuarios">
      <?php
        $pesquisaUsr = mysqli_query($conectar, "SELECT nome FROM usuario ORDER BY nome");

        while($resultado = mysqli_fetch_array($pesquisaUsr, MYSQLI_ASSOC)){
          echo "<div class='usuarios'>"."<h2>".$resultado['nome']."</h2>"."</div>";
        }
      ?>
    </div>

    <div id="botoes">
      <p>Sair</p>
      <a href="logout.php"><img src="sair.jpg" alt="Sair" width="50" height="50"></a></br>

      <p>Modificar nome </p>
      <img id="modifica" src="modificar.png" width="50" height="50" alt="Modificar Nome"></br>

      <script>
        var modificaBotao = document.getElementById('modifica');
        var i = 0;

        modificaBotao.onclick = function(){
          i++;

          if(i % 2==0){
            var divUpdate = document.getElementById('update');
            divUpdate.style.visibility = "hidden";
          }

          else{
            var divUpdate = document.getElementById('update');
            divUpdate.style.visibility = "visible";
          }
        }
      </script>

      <div id="update">
        <p> Digite o seu novo nome: <p>
        <form method="post" action="update.php">
          <input id="novoNome" type="text" name="novoNome" required>
          <input type="submit" value="Atualizar">
        </form>
      </div>
    </div>

    <center>
      <div id="mostra-mensagem">

      <?php
        $todasMsg = mysqli_query($conectar, "SELECT u.nome, u.ID, m.Msg, m.ID_Usr, m.DataHora FROM usuario AS u JOIN mensagem AS m ON m.ID_Usr = u.ID");
        while($mensagem = mysqli_fetch_array($todasMsg, MYSQLI_ASSOC)){
          $mostrarMensagem = $mensagem['Msg'];

          if($result_id['ID'] == $mensagem['ID_Usr'] && $mensagem['Msg'] != " "){
            echo "<p class='dataHoraR'>".$mensagem['DataHora']."</p><i id='voce'> Você ($logado)</i><div class='msg-right msg'>".$mostrarMensagem."</div></br>";
          }

          if($result_id['ID'] != $mensagem['ID_Usr'] && $mensagem['Msg'] != " "){
            echo "<p class='dataHoraL'>".$mensagem['DataHora']."</p><i id='outro'>". $mensagem['nome']."</i><div class='msg-left msg'>".$mostrarMensagem."</div></br>";
          }
        }

        mysqli_close($conectar);
      ?>

      </div>
    </center>
  </body>
</html>
