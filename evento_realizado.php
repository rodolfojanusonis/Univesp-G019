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

$id_eventos = $_POST['id_eventos'] ?? '';

if (!empty($id_eventos)) {
    // Inicia a transação
    mysqli_begin_transaction($conn);

    try {
        // Busca os dados do evento e do fornecedor
        $sql_evento = "SELECT e.descricao, c.cnpj 
                       FROM eventos e 
                       JOIN contato_com c ON e.id_eventos = c.id_eventos 
                       WHERE e.id_eventos = ?";
        $stmt_evento = mysqli_prepare($conn, $sql_evento);
        mysqli_stmt_bind_param($stmt_evento, "i", $id_eventos);
        mysqli_stmt_execute($stmt_evento);
        mysqli_stmt_bind_result($stmt_evento, $descricao, $cnpj);
        mysqli_stmt_fetch($stmt_evento);
        mysqli_stmt_close($stmt_evento);

        // Insere na tabela realizado_em
        $data_realizado = date("Y-m-d H:i:s");
        $sql_realizado = "INSERT INTO realizado_em (id_eventos, cnpj, data_realizado) VALUES (?, ?, ?)";
        $stmt_realizado = mysqli_prepare($conn, $sql_realizado);
        mysqli_stmt_bind_param($stmt_realizado, "iss", $id_eventos, $cnpj, $data_realizado);
        if (!mysqli_stmt_execute($stmt_realizado)) {
            throw new Exception('Erro ao inserir na tabela realizado_em');
        }
        mysqli_stmt_close($stmt_realizado);

        // Atualiza o status do evento para 'realizado'
        $sql_update_evento = "UPDATE eventos SET status = 'realizado' WHERE id_eventos = ?";
        $stmt_update_evento = mysqli_prepare($conn, $sql_update_evento);
        mysqli_stmt_bind_param($stmt_update_evento, "i", $id_eventos);
        if (!mysqli_stmt_execute($stmt_update_evento)) {
            throw new Exception('Erro ao atualizar o status do evento');
        }
        mysqli_stmt_close($stmt_update_evento);

        // Atualiza o status do contato para 'realizado'
        $sql_update_contato = "UPDATE contato_com SET status = 'realizado' WHERE id_eventos = ?";
        $stmt_update_contato = mysqli_prepare($conn, $sql_update_contato);
        mysqli_stmt_bind_param($stmt_update_contato, "i", $id_eventos);
        if (!mysqli_stmt_execute($stmt_update_contato)) {
            throw new Exception('Erro ao atualizar o status do contato');
        }
        mysqli_stmt_close($stmt_update_contato);

        // Confirma a transação
        mysqli_commit($conn);
        mensagem("Evento e contato realizados com sucesso!", 'success');
    } catch (Exception $e) {
        // Desfaz a transação em caso de erro
        mysqli_rollback($conn);
        mensagem("Erro ao processar o evento! " . $e->getMessage(), 'danger');
    }

    // Fecha a conexão
    mysqli_close($conn);
} else {
    mensagem("ID do evento não fornecido.", 'danger');
}
?>
<hr>
<a href="eventos.php" class="btn-primary">Voltar</a>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
  </body>
</html>
