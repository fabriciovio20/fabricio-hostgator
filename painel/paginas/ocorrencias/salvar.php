<?php 
$tabela = 'ocorrencias';
require_once("../../../conexao.php");
session_start();

if(isset($_POST['checkbox_oco'])) {
    $check = 'Sim';
} else {
    $check = 'Não';
}


$registro = $_POST['registro'];
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$data = $_POST['data'];
$duracao = $_POST['duracao'];
$id = $_POST['id'];


if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET registro = :registro, nome = :nome, descricao = :descricao, dataF = :data, duracao = :duracao ");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET registro = :registro, nome = :nome, descricao = :descricao, dataF = :data, duracao = :duracao where id = '$id'");
}
$query->bindValue(":registro", "$registro");
$query->bindValue(":nome", "$nome");
$query->bindValue(":descricao", "$descricao");
$query->bindValue(":data", "$data");
$query->bindValue(":duracao", "$duracao");

$query->execute();



	echo 'Salvo com Sucesso';

 ?>