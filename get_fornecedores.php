<?php
// Conexão com o banco de dados
include "conexao.php";

// Consulta SQL para obter os fornecedores
$sql = "SELECT cnpj, nome FROM fornecedores";
$result = $conn->query($sql);

$fornecedores = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $fornecedores[] = $row;
    }
}

$conn->close();

// Retorna os fornecedores como JSON
echo json_encode($fornecedores);
?>
