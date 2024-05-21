<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  </head>
  <body>
    <div class="container">
        <div class="row">
        <div class="row">
        <input type="hidden" name="id_evento" value="<?php echo $id_evento; ?>">

        <?php
            include "conexao.php";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Recebe os dados do formulário
                $descricao = $_POST['descricao'] ?? '';
                $frequencia = $_POST['frequencia'] ?? '';
                $fornecedor = $_POST['fornecedor'] ?? '';
                $cotacao = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['cotacao'] ?? '');
                $data_inicial = $_POST['data_inicial'] ?? '';

                // Inicia uma transação
                mysqli_begin_transaction($conn);

                try {
                    // Insere na tabela eventos
                    $sql_eventos = "INSERT INTO `eventos`(`descricao`, `frequencia_dias`) VALUES (?, ?)";
                    $stmt_eventos = mysqli_prepare($conn, $sql_eventos);
                    mysqli_stmt_bind_param($stmt_eventos, "ss", $descricao, $frequencia);

                    if (mysqli_stmt_execute($stmt_eventos)) {
                        // Obtém o id do evento inserido
                        $id_eventos = mysqli_insert_id($conn);

                        // Insere na tabela contato_com
                        $sql_contato = "INSERT INTO `contato_com`(`id_eventos`, `cnpj`, `valor`, `data_contato`) VALUES (?, ?, ?, ?)";
                        $stmt_contato = mysqli_prepare($conn, $sql_contato);
                        mysqli_stmt_bind_param($stmt_contato, "isss", $id_eventos, $fornecedor, $cotacao, $data_inicial);

                        if (mysqli_stmt_execute($stmt_contato)) {
                            // Confirma a transação
                            mysqli_commit($conn);
                            echo '<div class="alert alert-success">Evento cadastrado com sucesso!</div>';
                        } else {
                            throw new Exception('Erro ao cadastrar na tabela contato_com');
                        }

                        mysqli_stmt_close($stmt_contato);
                    } else {
                        throw new Exception('Erro ao cadastrar na tabela eventos');
                    }

                    mysqli_stmt_close($stmt_eventos);
                } catch (Exception $e) {
                    // Desfaz a transação em caso de erro
                    mysqli_rollback($conn);
                    echo '<div class="alert alert-danger">Evento NÃO foi cadastrado! ' . $e->getMessage() . '</div>';
                }

                // Fecha a conexão
                mysqli_close($conn);
            }
        ?>
           <hr>
           <a href="eventos.php" class="btn-primary">Voltar</a>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  </body>
</html>
