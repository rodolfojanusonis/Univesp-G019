<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Exclusão do Evento</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
        <div class="row">
          <?php
              include "conexao.php";

              if (!function_exists('mensagem')) {
                  function mensagem($texto, $tipo) {
                      echo "<div class='alert alert-$tipo' role='alert'>
                              $texto
                            </div>";
                  }
              }

              $id = $_POST['id_eventos'] ?? '';

              if (!empty($id)) {
                  // Inicia a transação
                  mysqli_begin_transaction($conn);

                  try {
                      // Exclui da tabela contato_com
                      $sql_contato = "DELETE FROM `contato_com` WHERE id_eventos = ?";
                      $stmt_contato = mysqli_prepare($conn, $sql_contato);
                      mysqli_stmt_bind_param($stmt_contato, "i", $id);
                      if (!mysqli_stmt_execute($stmt_contato)) {
                          throw new Exception('Erro ao excluir da tabela contato_com');
                      }
                      mysqli_stmt_close($stmt_contato);

                      // Exclui da tabela eventos
                      $sql_eventos = "DELETE FROM `eventos` WHERE id_eventos = ?";
                      $stmt_eventos = mysqli_prepare($conn, $sql_eventos);
                      mysqli_stmt_bind_param($stmt_eventos, "i", $id);
                      if (!mysqli_stmt_execute($stmt_eventos)) {
                          throw new Exception('Erro ao excluir da tabela eventos');
                      }
                      mysqli_stmt_close($stmt_eventos);

                      // Confirma a transação
                      mysqli_commit($conn);
                      mensagem("Evento excluído com sucesso!", 'success');
                  } catch (Exception $e) {
                      // Desfaz a transação em caso de erro
                      mysqli_rollback($conn);
                      mensagem("Evento NÃO foi excluído! " . $e->getMessage(), 'danger');
                  }

                  // Fecha a conexão
                  mysqli_close($conn);
              } else {
                  mensagem("ID do evento não fornecido.", 'danger');
              }
          ?>
           <hr>
           <a href="eventos.php" class="btn-primary">Voltar</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
  </body>
</html>
