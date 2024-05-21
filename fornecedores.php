<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Fornecedores</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>
    
    <?php

        $pesquisa = $_POST['busca'] ?? '';

        include "conexao.php";

        $sql = "SELECT * FROM fornecedores where nome LIKE '%$pesquisa%' ";

        $dados = mysqli_query($conn, $sql);

    ?>

    <div class="container">
        <div class="row">
            <div class="col">
                <h1 alin align="center">Fornecedores</h1>
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
                    <form class="d-flex" role="search" action="fornecedores.php" method="POST">
                        <input class="form-control me-2" type="search" placeholder="Nome" aria-label="Search" name="busca" autofocus>
                        <button class="btn btn-outline-success" type="submit">pesquisar</button>
                    </form>
                </div>
                </nav>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CNPJ</th>
                            <th>Contato</th>
                            <th>Rua</th>
                            <th>Número</th>
                            <th>Bairro</th>
                            <th>Cidade</th>
                            <th>Estado</th>
                            <th>Telefone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while($linha = mysqli_fetch_assoc($dados) ){
                                $cnpj = $linha ['cnpj'];
                                $nome = $linha ['nome'];
                                $contato = $linha ['contato'];
                                $telefone = $linha ['fone'];
                                $logradouro = $linha ['logradouro'];
                                $numero = $linha ['numero_comp'];
                                $bairro = $linha ['bairro'];
                                $cidade = $linha ['cidade'];
                                $estado = $linha ['uf'];

                                echo "<tr>
                                        <th scope='row'>$nome</th>
                                        <td>$cnpj</td>
                                        <td>$contato</td>
                                        <td>$logradouro</td>
                                        <td>$numero</td>
                                        <td>$bairro</td>
                                        <td>$cidade</td>
                                        <td>$estado</td>
                                        <td>$telefone</td>
                                        <td with=150px>
                                            <a href='cadastro_fornecedor_edit.php?id=$cnpj' class='btn btn-success'>Editar</a>
                                            <a href='#' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirma'
                                            onclick=" .'"' ."pegar_dados('$cnpj', '$nome')" .'"' .">Excluir</a>
                                        </td>
                                    </tr>";
                            }
                        ?>
                    </tbody>
                </table>

                <a class="btn btn-success" href="cadastro_fornecedores.html" role="button">Cadastrar Fornecedor</a>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirma" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmação de exclusão</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="excluir_fornecedor_script.php" method="POST">
                    <p>Deseja realmente excluir <b id="nome_pessoa">Nome da pessoa</b>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                    <input type="hidden" name="nome" id="nome_pessoa_1" value="">
                    <input type="hidden" name="id" id="cnpj" value="">
                    <input type="submit" class="btn btn-danger" value="Sim">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function pegar_dados(id, nome){
            document.getElementById('nome_pessoa').innerHTML = nome;
            document.getElementById('nome_pessoa_1').value = nome;
            document.getElementById('cnpj').value = id;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  </body>
</html>
