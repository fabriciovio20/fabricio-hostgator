<?php 
$tabela = 'msg_func';
require_once("../../../conexao.php");

$funcionario = $_POST['funcionarios'];


$pdo->query("INSERT INTO $tabela SET funcionario = '$funcionario' ");
	
echo 'Salvo com Sucesso';
 ?>