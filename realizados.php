<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Eventos Realizados</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    
    <?php
        $pesquisa = $_POST['busca'] ?? '';

        include "conexao.php";

        $sql = "SELECT e.*, r.cnpj, r.data_realizado, f.nome 
                FROM eventos e 
                JOIN realizado_em r ON e.id_eventos = r.id_eventos 
                JOIN fornecedores f ON r.cnpj = f.cnpj
                WHERE e.descricao LIKE '%$pesquisa%' AND e.status = 'realizado'";

        $dados = mysqli_query($conn, $sql);
    ?>

    <div class="container">
        <div class="row">
            <div class="col">
                <h1 align="center">Eventos Realizados</h1>
                <div class="col">
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
                    <form class="d-flex" role="search" action="realizados.php" method="POST">
                        <input class="form-control me-2" type="search" placeholder="Descrição" aria-label="Search" name="busca" autofocus>
                        <button class="btn btn-outline-success" type="submit">Pesquisar</button>
                    </form>
                </div>
                </nav>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Frequência (dias)</th>
                            <th>Fornecedor</th>
                            <th>Data Realizada</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while($linha = mysqli_fetch_assoc($dados)){
                                $id_eventos = $linha['id_eventos'];
                                $descricao = $linha['descricao'];
                                $frequencia = $linha['frequencia_dias'];
                                $nome_fornecedor = $linha['nome'];
                                $data_realizado = $linha['data_realizado'];

                                echo "<tr>
                                        <th scope='row'>$descricao</th>
                                        <td>$frequencia</td>
                                        <td>$nome_fornecedor</td>
                                        <td>$data_realizado</td>
                                    </tr>";
                            }
                        ?>
                    </tbody>
                </table>

                <a class="btn btn-primary" href="index.html" role="button">Voltar à Home</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  </body>
</html>
