<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Alteração de cadastro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>
    <div class="container">
        <div class="row">
           <?php

               include "conexao.php";

               $id = $_POST['id'] ?? '';
               $nome = $_POST['nome'] ?? '';
               $contato = $_POST['contato'] ?? '';
               $telefone = $_POST['telefone'] ?? '';
               $logradouro = $_POST['logradouro'] ?? '';
               $numero = $_POST['numero'] ?? '';
               $bairro = $_POST['bairro'] ?? '';
               $cidade = $_POST['cidade'] ?? '';
               $estado = $_POST['estado'] ?? '';
               
               $sql = "UPDATE `fornecedores` SET `nome` = ?, `fone` = ?, `logradouro` = ?, `numero_comp` = ?, `bairro` = ?,
                   `cidade` = ?, `uf` = ? WHERE cnpj = ?";
                   
               $stmt = mysqli_prepare($conn, $sql);
               mysqli_stmt_bind_param($stmt, "ssssssss", $nome, $telefone, $logradouro, $numero, $bairro, $cidade, $estado, $id);
                   
               if (mysqli_stmt_execute($stmt)) {
                   mensagem("$nome alterado com sucesso!", 'success');
               } else {
                   mensagem("$nome NÃO foi alterado!", 'danger');
               }
               
               mysqli_stmt_close($stmt);               
          
           ?>
           <hr>
           <a href="fornecedores.php" class="btn-primary">Voltar</a>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  </body>
</html>