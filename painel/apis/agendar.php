<?php
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
  'to' => $telefone_envio,
  'message' => $mensagem,
  'agendamento' => $data_agd2,
  ),
));

$response = curl_exec($curl);
$result = json_decode($response, true);
$messageId = $result['id']; // Usando o ID retornado pela API
curl_close($curl);

if ($messageId == 0) {
  $query = $pdo->prepare("UPDATE $tabela SET hash = :messageId WHERE id = :id");
  $query->bindValue(":messageId", $messageId);
  $query->bindValue(":id", $id); // Usando o ID do banco de dados
  $query->execute();
}else{
  require("../../apis/cancelar.php");
  $query = $pdo->prepare("UPDATE $tabela SET hash = :messageId WHERE id = :id");
  $query->bindValue(":messageId", $messageId);
  $query->bindValue(":id", $id); // Usando o ID do banco de dados
  $query->execute();

}


?>