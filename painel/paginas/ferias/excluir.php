<?php
$tabela = 'ferias';
require_once("../../../conexao.php");

$id = $_POST['id'];

// Obtém o hash da mensagem a ser cancelada (substitua 'sua_coluna_hash' pelo nome correto da coluna)
$stmt = $pdo->prepare("SELECT hash FROM $tabela WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$hash = $stmt->fetchColumn();

// Exclui a entrada na tabela ferias
$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");

// Envia uma requisição para cancelar.php com os parâmetros necessários
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://chatbot.menuia.com/api/create-message',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
    'appkey' => $instancia,
    'authkey' => $token,
    'message' => $hash,
    'cancelarAgendamento' => 'true',
    ),
  ));
  
  $response = curl_exec($curl);
  
  curl_close($curl);
  
echo 'Excluído com Sucesso';
?>
