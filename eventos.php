<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Eventos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>
    
  <?php
    $pesquisa = $_POST['busca'] ?? '';

    include "conexao.php";

    $sql = "SELECT * FROM eventos WHERE descricao LIKE '%$pesquisa%' AND status = 'ativo'";

    $dados = mysqli_query($conn, $sql);
?>

    <div class="container">
        <div class="row">
            <div class="col">
                <h1 align="center">Eventos</h1>
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
                    <form class="d-flex" role="search" action="eventos.php" method="POST">
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
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
            while ($linha = mysqli_fetch_assoc($dados)) {
                $id_eventos = $linha['id_eventos'];
                $descricao = $linha['descricao'];
                $frequencia = $linha['frequencia_dias'];

                echo "<tr>
                        <th scope='row'>$descricao</th>
                        <td>$frequencia</td>
                        <td width='300px'>
                            <a href='cadastro_eventos_edit.php?id=$id_eventos' class='btn btn-success'>Editar</a>
                            <a href='#' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirma'
                            onclick=\"pegar_dados('$id_eventos', '$descricao')\">Excluir</a>
                            <a href='#' class='btn btn-secondary btn-sm' data-bs-toggle='modal' data-bs-target='#confirmaRealizado'
                            onclick=\"pegar_dados_realizado('$id_eventos', '$descricao')\">Evento realizado</a>
                        </td>
                    </tr>";
            }
        ?>
    </tbody>
</table>

<!-- Modal Exclusão -->
<div class="modal fade" id="confirma" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmação de exclusão</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="excluir_eventos_script.php" method="POST">
                <p>Deseja realmente excluir <b id="nome_descricao">Nome do evento</b>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                <input type="hidden" name="descricao" id="nome_descricao_1" value="">
                <input type="hidden" name="id_eventos" id="id_eventos" value="">
                <input type="submit" class="btn btn-danger" value="Sim">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal para confirmar evento realizado -->
<div class="modal fade" id="confirmaRealizado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmação de evento realizado</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="evento_realizado.php" method="POST">
                <p>Deseja realmente marcar como realizado <b id="nome_descricao_realizado">Nome do evento</b>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                <input type="hidden" name="descricao" id="nome_descricao_realizado_1" value="">
                <input type="hidden" name="id_eventos" id="id_eventos_realizado" value="">
                <input type="submit" class="btn btn-success" value="Sim">
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
   function pegar_dados_realizado(id, descricao){
        document.getElementById('nome_descricao_realizado').innerHTML = descricao;
        document.getElementById('nome_descricao_realizado_1').value = descricao;
        document.getElementById('id_eventos_realizado').value = id;
    }
</script>
<script type="text/javascript">
    function pegar_dados(id, descricao) {
        document.getElementById('nome_descricao').innerHTML = descricao;
        document.getElementById('nome_descricao_1').value = descricao;
        document.getElementById('id_eventos').value = id;
    }
</script>
<a class="btn btn-success" href="cadastro_eventos.html" role="button">Cadastrar Evento</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

  </body>
</html>
