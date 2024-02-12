<?php 
$tabela = 'filiais';
require_once("../../../conexao.php");

@$id = $_POST['id'];

$query = $pdo->query("SELECT * from filiais where id = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_acessos1 = @count($res);
$nome = $res[0]['nome'];


$query2 = $pdo->query("SELECT * from funcionarios where filial = '$nome' ");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_acessos = @count($res2);

if($total_acessos > 0){
	echo 'Você precisa primeiro excluir os usuários / funcionários para depois excluir as filiais relacionada!';
	
}else{

$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");

echo 'Excluído com Sucesso';

}

?>