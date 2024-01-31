<?php 
$tabela = 'candidatos';
require_once("../../../conexao.php");

$nome = $_POST['nome'];
$data_entrevista = $_POST['data_entrevista'];
$telefone = $_POST['telefone'];
$id = $_POST['id'];


if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, data_entrevista = :data_entrevista, telefone = :telefone ");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, data_entrevista = :data_entrevista, telefone = :telefone where id = '$id'");
}
$query->bindValue(":nome", "$nome");
$query->bindValue(":data_entrevista", "$data_entrevista");
$query->bindValue(":telefone", "$telefone");

$query->execute();

echo 'Salvo com Sucesso';
 ?>