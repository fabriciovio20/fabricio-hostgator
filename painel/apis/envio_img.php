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
  'descricao' => $mensagem,
  'file' => 'https://hrautomate-tec.com/painel/images/perfil/'.$arquivo,
  'sandbox' => 'false'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

?>