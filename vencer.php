<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotações</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php
$pesquisa = $_POST['busca'] ?? '';

include "conexao.php";

$sql = "SELECT c.*, e.descricao AS evento, f.nome AS fornecedor_nome, c.data_contato
        FROM contato_com c 
        JOIN eventos e ON c.id_eventos = e.id_eventos 
        JOIN fornecedores f ON c.cnpj = f.cnpj 
        WHERE e.status = 'ativo' 
        AND c.status IN ('ativo', 'inativo') 
        AND (e.descricao LIKE '%$pesquisa%' OR f.nome LIKE '%$pesquisa%')
        AND c.data_contato < DATE_SUB(NOW(), INTERVAL 30 DAY)";

$dados = mysqli_query($conn, $sql);
?>

<div class="container">
    <div class="row">
        <div class="col">
            <h1 align="center">Eventos Passados</h1>
            <div class="col">
                <div align="center">
                <div align="center">
                    <a class="btn btn-primary" href="index.html" role="button">Home</a>
                    <a class="btn btn-primary" href="eventos.php" role="button">Eventos</a>
                    <a class="btn btn-primary" href="fornecedores.php" role="button">Fornecedores</a>
                    <a class="btn btn-primary" href="cotacoes.php" role="button">Cotações</a>
                    <a class="btn btn-primary" href="realizados.php" role="button">Eventos Realizados</a>
                    <a class="btn btn-primary" href="vencer.php" role="button">Eventos a Vencer</a>
                </div>
                <br>

                <nav class="navbar bg-body-tertiary">
                    <div class="container-fluid">
                        <form class="d-flex" role="search" action="eventos.php" method="POST">
                            <input class="form-control me-2" type="search" placeholder="Descrição ou Fornecedor"
                                aria-label="Search" name="busca" autofocus>
                            <button class="btn btn-outline-success" type="submit">Pesquisar</button>
                        </form>
                    </div>
                </nav>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Evento</th>
                            <th>Fornecedor</th>
                            <th>Valor</th>
                            <th>Data de Contato</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($linha = mysqli_fetch_assoc($dados)) {
                            $evento = $linha['evento'];
                            $fornecedor_nome = $linha['fornecedor_nome'];
                            $valor = $linha['valor'];
                            $data_contato = $linha['data_contato'];

                            echo "<tr>
                                    <th scope='row'>$evento</th>
                                    <td>$fornecedor_nome</td>
                                    <td>R$ $valor</td>
                                    <td>$data_contato</td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <a class="btn btn-primary" href="index.html" role="button">Voltar à Home</a>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
                 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  </body>
</html>
