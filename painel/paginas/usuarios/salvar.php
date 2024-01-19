<?php 
$tabela = 'usuarios';
require_once("../../../conexao.php");

$registro = $_POST['registro'];
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$nivel = $_POST['nivel'];
$filial = $_POST['filial'];
$cpf = $_POST['cpf'];
$senha = '123';
$senha_crip = md5($senha);
$id = $_POST['id'];


if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET registro = :registro, nome = :nome, filial = :filial, senha = '$senha', senha_crip = '$senha_crip', nivel = '$nivel', ativo = 'Sim', foto = 'sem-foto.jpg', telefone = :telefone, data = curDate(), cpf = :cpf ");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET registro = :registro, nome = :nome, filial = :filial, nivel = '$nivel', telefone = :telefone, cpf = :cpf where id = '$id'");
}
$query->bindValue(":registro", "$registro");
$query->bindValue(":nome", "$nome");
$query->bindValue(":filial", "$filial");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":cpf", "$cpf");

$query->execute();

echo 'Salvo com Sucesso';
 ?>