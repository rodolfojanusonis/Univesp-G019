<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Exclusão de cadastro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>
    <div class="container">
        <div class="row">
          <?php
              include "conexao.php";

              $id = $_POST['id'] ?? '';
              $nome = $_POST['nome'] ?? '';

              $sql = "DELETE FROM `fornecedores` WHERE cnpj = ?";
              $stmt = mysqli_prepare($conn, $sql);

              mysqli_stmt_bind_param($stmt, "s", $id);

              if (mysqli_stmt_execute($stmt)) {
                  mensagem("$nome excluído com sucesso!", 'success');
              } else {
                  mensagem("$nome NÃO foi excluído!", 'danger');
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