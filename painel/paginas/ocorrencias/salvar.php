<?php 
$tabela = 'ocorrencias';
require_once("../../../conexao.php");
@session_start();
date_default_timezone_set('America/Sao_Paulo');

$usuario_modi = @$_SESSION['id'];

@$data_modi = date('y/m/d H:i:s');

@$funcionario = $_POST['funcionario'];
@$data_oco = $_POST['data_oco'];
@$tipo_oco = $_POST['tipo_oco'];
@$status1 = $_POST['status1'];
@$obs = $_POST['obs'];
@$id = $_POST['id'];
@$hash = '';


$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
@$res = $query->fetchAll(PDO::FETCH_ASSOC);
	@$data_oco2 = $res[0]['data_oco']; 
	@$tipo_oco2 = $res[0]['tipo_oco'];
	@$obs2 = $res[0]['obs'];



$query1 = $pdo->query("SELECT * FROM pacientes where id = '$funcionario'");
@$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
@$funcionario2 = $res1[0]['id'];

@$tipo_oco = isset($_POST['tipo_oco']) ? $_POST['tipo_oco'] : 'ValorPadrao';


if($id == ""){

    $query2 = $pdo->prepare("INSERT INTO $tabela SET funcionario = :funcionario, data_oco = :data_oco, tipo_oco = :tipo_oco, status1 = 'Pendente', obs = :obs, usuario_alt = :usuario_modi, data_alt = :data_modi");

$query2->bindValue(":funcionario", $funcionario);
$query2->bindValue(":data_oco", $data_oco);
$query2->bindValue(":tipo_oco", $tipo_oco);
$query2->bindValue(":obs", $obs);
$query2->bindValue(":usuario_modi", $usuario_modi);
$query2->bindValue(":data_modi", $data_modi);

$query2->execute();

} elseif($data_oco != $data_oco2 || $tipo_oco != $tipo_oco2 || $funcionario != $funcionario2 || $obs != $obs2){
    $query4 = $pdo->prepare("UPDATE $tabela SET funcionario = :funcionario, data_oco = :data_oco, tipo_oco = :tipo_oco, status1 = 'Pendente', obs = :obs, usuario_alt = :usuario_modi, data_alt = :data_modi WHERE id = :id");

$query4->bindValue(":funcionario", $funcionario);
$query4->bindValue(":data_oco", $data_oco);
$query4->bindValue(":tipo_oco", $tipo_oco);
$query4->bindValue(":obs", $obs);
$query4->bindValue(":id", $id);
$query4->bindValue(":usuario_modi", $usuario_modi);
$query4->bindValue(":data_modi", $data_modi);
$query4->execute();
        
}else{
    $query = $pdo->prepare("UPDATE $tabela SET funcionario = :funcionario, data_ini = :data_ini, qntd_dias = :qntd_dias, data_fim = :data_fim, status1 = :status1, usuario_alt = :usuario_modi, data_alt = :data_modi WHERE id = :id");

$query->bindValue(":funcionario", $funcionario);
$query->bindValue(":data_oco", $data_oco);
$query->bindValue(":tipo_oco", $tipo_oco);
$query->bindValue(":obs", $obs);
$query->bindValue(":status1", $status1);
$query->bindValue(":id", $id);
$query->bindValue(":usuario_modi", $usuario_modi);
$query->bindValue(":data_modi", $data_modi);
$query->execute();

}

echo 'Salvo com Sucesso';

?>
