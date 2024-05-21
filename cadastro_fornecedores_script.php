<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cadastro de Fornecedores</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

  </head>
  <body>
    <div class="container">
        <div class="row">
        <div class="row">
           <?php
                include"conexao.php";

                $nome = $_POST['nome'];
                $cnpj = $_POST['cnpj'];
                $contato = $_POST['contato'];
                $logradouro = $_POST['logradouro'];
                $numero = $_POST['numero'];
                $bairro = $_POST['bairro'];
                $cidade = $_POST['cidade'];
                $uf = $_POST['estado'];
                $telefone = $_POST['telefone'];

                $sql = "INSERT INTO `fornecedores`(`cnpj`, `nome`, `logradouro`, `numero_comp`, `bairro`, `cidade`, `uf`, `fone`, `contato`) VALUES 
                                                  ('$cnpj','$nome','$logradouro','$numero','$bairro','$cidade','$uf','$telefone','$contato')";
                                             
                if(mysqli_query($conn, $sql)) {
                   mensagem("$nome cadastrado com sucesso!", 'success'); 
                } else
                   mensagem("$nome NÃO foi cadastrado!", 'danger'); 
            
           ?>
           <hr>
           <a href="cadastro_fornecedores.html" class="btn-primary">Voltar</a>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  </body>
</html>
