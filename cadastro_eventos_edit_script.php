<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Alteração do evento</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>
    <div class="container">
        <div class="row">
        <?php
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o ID do evento foi enviado
    $id_evento = isset($_POST['id_eventos']) ? $_POST['id_eventos'] : null;

    if ($id_evento === null) {
        echo "ID do evento não foi fornecido!";
        exit;
    }

    // Recebe os dados do formulário
    $descricao = $_POST['descricao'] ?? '';
    $frequencia = $_POST['frequencia'] ?? '';
    $fornecedor = $_POST['fornecedor'] ?? '';
    $cotacao = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['cotacao'] ?? '');
    $data_inicial = $_POST['data_inicial'] ?? '';

    // Inicia uma transação
    mysqli_begin_transaction($conn);

    try {
        // Atualiza a tabela eventos
        $sql_eventos = "UPDATE `eventos` SET `descricao` = ?, `frequencia_dias` = ? WHERE `id_eventos` = ?";
        $stmt_eventos = mysqli_prepare($conn, $sql_eventos);
        mysqli_stmt_bind_param($stmt_eventos, "ssi", $descricao, $frequencia, $id_evento);

        if (mysqli_stmt_execute($stmt_eventos)) {
            // Atualiza a tabela contato_com
            $sql_contato = "UPDATE `contato_com` SET `cnpj` = ?, `valor` = ?, `data_contato` = ? WHERE `id_eventos` = ?";
            $stmt_contato = mysqli_prepare($conn, $sql_contato);
            mysqli_stmt_bind_param($stmt_contato, "sssi", $fornecedor, $cotacao, $data_inicial, $id_evento);

            if (mysqli_stmt_execute($stmt_contato)) {
                // Confirma a transação
                mysqli_commit($conn);
                echo '<div class="alert alert-success">Evento atualizado com sucesso!</div>';
            } else {
                throw new Exception('Erro ao atualizar a tabela contato_com');
            }

            mysqli_stmt_close($stmt_contato);
        } else {
            throw new Exception('Erro ao atualizar a tabela eventos');
        }

        mysqli_stmt_close($stmt_eventos);
    } catch (Exception $e) {
        // Desfaz a transação em caso de erro
        mysqli_rollback($conn);
        echo '<div class="alert alert-danger">Evento NÃO foi atualizado! ' . $e->getMessage() . '</div>';
    }

    // Fecha a conexão
    mysqli_close($conn);
}
?>

<a href="eventos.php" class="btn-primary">Voltar</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  </body>
</html>