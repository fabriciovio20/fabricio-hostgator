<?php 
$tabela = 'config_sistema';
require_once("../conexao.php");

$email_rh1 = $_POST['email_rh1'];
$email_rh2 = $_POST['email_rh2'];
$email_rh3 = $_POST['email_rh3'];
$$email_ferias1 = $_POST['email_ferias1'];
$$email_ferias2 = $_POST['email_ferias2'];
$$email_ferias3 = $_POST['email_ferias3'];

$query = $pdo->prepare("UPDATE $tabela SET email_rh1 = :email_rh1, email_rh2 = :email_rh2, email_rh3 = :email_rh3, email_ferias1 = :email_ferias1, email_ferias2 = :email_ferias2, email_ferias3 = :email_ferias3 where id = 1");

$query->bindValue(":email_rh1", "$email_rh1");
$query->bindValue(":email_rh2", "$email_rh2");
$query->bindValue(":email_rh3", "$email_rh3");
$query->bindValue(":email_ferias1", "$email_ferias1");
$query->bindValue(":email_ferias2", "$email_ferias2");
$query->bindValue(":email_ferias3", "$email_ferias3");

$query->execute();

echo 'Editado com Sucesso';
 ?>