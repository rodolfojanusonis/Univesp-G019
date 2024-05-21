<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Alteração do Fornecedor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>

    <?php
    include "conexao.php";

    $id = $_GET['id'] ?? '';
    $sql = "SELECT * FROM fornecedores WHERE cnpj = ?";
    
    // Preparar a consulta
    $stmt = mysqli_prepare($conn, $sql);

    // Vincular parâmetros
    mysqli_stmt_bind_param($stmt, "s", $id);

    // Executar a consulta
    mysqli_stmt_execute($stmt);

    // Obter os resultados
    $result = mysqli_stmt_get_result($stmt);

    // Obter a linha de resultados
    $linha = mysqli_fetch_assoc($result);

    // Fechar a consulta
    mysqli_stmt_close($stmt);
?>


<div class="container">
        <div class="row">
            <div class="col">
                <h1 align="center">Cadastro de Fornecedores</h1>
                <hr>
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
               
               <form class="row g-3" action="cadastro_fornecedor_edit_script.php" method="POST">
                <div class="col-md-6">
                  <label for="nome" class="form-label">Nome do fornecedor</label>
                  <input type="text" class="form-control" id="nome" name="nome" placeholder="Empresa" required value="<?php echo $linha['nome']; ?>">
                </div>
                <div class="col-md-6">
                  <label for="cnpj" class="form-label">CNPJ</label>
                  <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="00.000.000/0000-00" required value="<?php echo $linha['cnpj']; ?>">
                </div>
                <div class="col-12">
                  <label for="contato" class="form-label">Contato</label>
                  <input type="text" class="form-control" id="contato" name="contato" placeholder="Nome do Contato" required value="<?php echo $linha['contato']; ?>">
                </div>
                <div class="col-md-6">
                  <label for="logradouro" class="form-label">Logradouro</label>
                  <input type="text" class="form-control" id="logradouro" name="logradouro" placeholder="Rua dos Cedros" required value="<?php echo $linha['logradouro']; ?>">
                </div>
                <div class="col-md-1">
                  <label for="numero" class="form-label">Número</label>
                  <input type="text" class="form-control" id="numero" name="numero" placeholder="nº 0 " required value="<?php echo $linha['numero_comp']; ?>">
                </div>
                <div class="col-md-5">
                  <label for="bairro" class="form-label">Bairro</label>
                  <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro Bela Vista" required value="<?php echo $linha['bairro']; ?>">
                </div>
                <div class="col-md-6">
                  <label for="cidade" class="form-label">Cidade</label>
                  <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Santos" required value="<?php echo $linha['cidade']; ?>">
                </div>
                <div class="col-md-4">
                  <label for="estado" class="form-label">Estado</label>
                  <select id="estado" class="form-select" name="estado" required value="<?php echo $linha['uf']; ?>">
                  <option value="" disabled>Selecione o estado</option>
                    <?php
                    $estados = array(
                        'AC' => 'Acre',
                        'AL' => 'Alagoas',
                        'AP' => 'Amapá',
                        'AM' => 'Amazonas',
                        'BA' => 'Bahia',
                        'CE' => 'Ceará',
                        'DF' => 'Distrito Federal',
                        'ES' => 'Espírito Santo',
                        'GO' => 'Goiás',
                        'MA' => 'Maranhão',
                        'MT' => 'Mato Grosso',
                        'MS' => 'Mato Grosso do Sul',
                        'MG' => 'Minas Gerais',
                        'PA' => 'Pará',
                        'PB' => 'Paraíba',
                        'PR' => 'Paraná',
                        'PE' => 'Pernambuco',
                        'PI' => 'Piauí',
                        'RJ' => 'Rio de Janeiro',
                        'RN' => 'Rio Grande do Norte',
                        'RS' => 'Rio Grande do Sul',
                        'RO' => 'Rondônia',
                        'RR' => 'Roraima',
                        'SC' => 'Santa Catarina',
                        'SP' => 'São Paulo',
                        'SE' => 'Sergipe',
                        'TO' => 'Tocantins',
                    );

                    foreach ($estados as $uf => $estado) {
                        $selected = ($uf == $linha['uf']) ? 'selected' : '';
                        echo "<option value=\"$uf\" $selected>$estado</option>";
                    }
                    ?>
                </select>
            </div>
                <div class="col-md-2">
                  <label for="telefone" class="form-label">Telefone</label>
                  <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(00) 00000-0000" required value="<?php echo $linha['fone']; ?>">
                </div>
                <div class="mb-3">
                     <button type="submit" class="btn btn-success" value="Salvar alterações">Salvar alterações</button>
                     <input type="hidden" name="id" value="<?php echo $linha['cnpj']; ?>">
                </div>
              </form>
              <br>
              <div class="col-12">
                <a class="btn btn-primary" href="fornecedores.php" role="button">Voltar</a>
              </div>
                    
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  </body>
</html>