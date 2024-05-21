<?php
// Conexão com o banco de dados
include('conexao.php');

// Obtendo o ID do evento a ser editado
$id_evento = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_evento) {
    echo "ID do evento não foi fornecido!";
    exit;
}

// Consultando os dados do evento
$query = "
    SELECT 
        e.descricao, 
        e.frequencia_dias, 
        c.valor as cotacao, 
        c.data_contato as data_inicial, 
        f.nome as fornecedor,
        f.cnpj as fornecedor_cnpj
    FROM 
        eventos e
    INNER JOIN 
        contato_com c ON e.id_eventos = c.id_eventos
    INNER JOIN 
        fornecedores f ON c.cnpj = f.cnpj
    WHERE 
        e.id_eventos = '$id_evento'
";

$result = mysqli_query($conn, $query);
$evento = mysqli_fetch_assoc($result);

if (!$evento) {
    echo "Evento não encontrado!";
    exit;
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alteração do Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 align="center">Alteração do Evento</h1>
            <hr>
            <div align="center">
                <a class="btn btn-primary" href="index.html" role="button">Home</a>
                <a class="btn btn-primary" href="eventos.php" role="button">Eventos</a>
                <a class="btn btn-primary" href="fornecedores.php" role="button">Fornecedores</a>
                <a class="btn btn-primary" href="cotacoes.php" role="button">Cotações</a>
                <a class="btn btn-primary" href="realizados.php" role="button">Eventos Realizados</a>
                <a class="btn btn-primary" href="vencer.php" role="button">Eventos a Vencer</a>
            </div>
            <br>
            <form id="formulario" class="row g-3" action="cadastro_eventos_edit_script.php" method="POST">
                <input type="hidden" name="id_eventos" value="<?php echo $id_evento; ?>">
                <div class="col-md-6">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo $evento['descricao']; ?>" placeholder="Descrição do evento">
                </div>
                <div class="col-md-6">
                    <label for="fornecedor" class="form-label">Fornecedor</label>
                    <select class="form-select" id="fornecedor" name="fornecedor">
                        <option selected value="<?php echo $evento['fornecedor_cnpj']; ?>"><?php echo $evento['fornecedor']; ?></option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="frequencia" class="form-label">Frequência (dias)</label>
                    <input type="text" class="form-control" id="frequencia" name="frequencia" value="<?php echo $evento['frequencia_dias']; ?>" placeholder="30 dias">
                </div>
                <div class="col-md-2">
                    <label for="cotacao" class="form-label">Cotação</label>
                    <input type="text" class="form-control" id="cotacao" name="cotacao" value="<?php echo 'R$ ' . number_format($evento['cotacao'], 2, ',', '.'); ?>" placeholder="R$ 0,00">
                </div>
                <div class="col-md-2">
                    <label for="data_inicial" class="form-label">Data inicial</label>
                    <input type="date" class="form-control" id="data_inicial" name="data_inicial" value="<?php echo $evento['data_inicial']; ?>">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Atualizar</button>
                </div>
            </form>
            <br>
            <div class="col-12">
                <a class="btn btn-primary" href="eventos.php" role="button">Voltar</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-mask-plugin@1.14.16/dist/jquery.mask.min.js"></script>
<script>
$(document).ready(function(){
    $('#frequencia').mask('000');
    $('#cotacao').on('input', function() {
        let valor = $(this).val().replace(/\D/g, '');
        valor = (parseInt(valor) / 100).toFixed(2).replace(".", ",").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        $(this).val("R$ " + valor);
    });

    let fornecedorCadastrado = "<?php echo $evento['fornecedor_cnpj']; ?>";

    if (fornecedorCadastrado) {
        $.ajax({
            url: 'get_fornecedor.php',
            type: 'GET',
            data: { cnpj: fornecedorCadastrado },
            dataType: 'json',
            success: function(fornecedor) {
                $('#fornecedor').append('<option value="' + fornecedor.cnpj + '" selected>' + fornecedor.nome + '</option>');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Erro ao carregar o fornecedor cadastrado:");
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown);
            }
        });
    }

    $.ajax({
        url: 'get_fornecedores.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data);
            $.each(data, function(index, fornecedor) {
                if (fornecedor.cnpj !== fornecedorCadastrado) {
                    $('#fornecedor').append('<option value="' + fornecedor.cnpj + '">' + fornecedor.nome + '</option>');
                }
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("Erro ao carregar os fornecedores:");
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
        }
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
