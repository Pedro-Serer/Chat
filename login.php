<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>Login to Chat</title>
    <meta charset="utf-8">

    <style>
      body{
        background: url('back4k.jpg') no-repeat;
        background-position: center;
        background-size: 100% 311%;
      }

      input[type=text]{
        border: 2px solid #F7BE81;
        border-radius: 5%;
        width: 30%;
        height: 20px;
      }

      input[type=submit]{
        background-color: #F7BE81;
        color: white;
        height: 30px;
      }

      #left{
        font-size: 17pt;
        position: relative;
        top: 75px;
        left: -10px;
      }

      #right{
        font-size: 17pt;
        position: relative;
        top: 125px;
        right: 30px;
      }

      #mostra-mensagem{
        background-color: white;
        color: black;
        position: relative;
        top: 105px;
        border: 1px solid black;
        width: 50%;
        height: 300px;
        z-index: 1;
      }

    </style>

  </head>
  <body>

    <center>
      <div id="mostra-mensagem">
        <div id="left">
          <form method="post" action="verifica.php">
            Crie um usuário: <input type='text' name="cria" placeholder="Crie um nome de usuário">
            <input type="submit" value="Criar">
          </form>
        </div>

        <div id="right">
          <form method="post" action="verifica.php">
            Entre com seu usuário: <input type='text' name="user" placeholder="Escreva o nome do seu usuário">
            <input type="submit" value="Entrar">
          </form>

        </div>
      <div>
    </center>

  </body>
</html>
