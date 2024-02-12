<?php 

//definir fuso horário
date_default_timezone_set('America/Sao_Paulo');

//dados conexão bd local
$servidor = 'localhost';
$banco = 'hrauto46_clinica';
$usuario = 'hrauto46_fabricio';
$senha = '@2087Fabri';


try {
	$pdo = new PDO("mysql:dbname=$banco;host=$servidor;charset=utf8", "$usuario", "$senha");
} catch (Exception $e) {
	echo 'Erro ao conectar ao banco de dados!<br>';
	echo $e;
}

$url_sistema = "http://$_SERVER[HTTP_HOST]/";
$url = explode("//", $url_sistema);
if($url[1] == 'localhost/'){
	$url_sistema = "http://$_SERVER[HTTP_HOST]/clinica/";
}

//tabela config
$query = $pdo->query("SELECT * from config");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas == 0){
	$pdo->query("INSERT INTO config SET nome = '$nome_sistema', email = '$email_sistema', telefone = '$telefone_sistema', logo = 'logo.png', logo_rel = 'logo.jpg', icone = 'icone.png', marca_dagua = 'Sim', ativo = 'Sim'");
}else{
$nome_sistema = $res[0]['nome'];
$email_sistema = $res[0]['email'];
$telefone_sistema = $res[0]['telefone'];
$endereco_sistema = $res[0]['endereco'];
$logo_sistema = $res[0]['logo'];
$logo_rel = $res[0]['logo_rel'];
$icone_sistema = $res[0]['icone'];
$telefone_fixo = $res[0]['telefone_fixo'];
$token = $res[0]['token'];
$instancia = $res[0]['instancia'];
$marca_dagua = $res[0]['marca_dagua'];
$ativo_sistema = $res[0]['ativo'];


if($ativo_sistema != 'Sim' and $ativo_sistema != ""){
	echo '<div align="center"><img src="painel/images/bloqueado.jpg" width="60%"></div>';
	exit();
}

$whatsapp_sistema = '55'.preg_replace('/[ ()-]+/' , '' , $telefone_sistema);

}	


//tabela config sistemas

$query1 = $pdo->query("SELECT * from config_sistema");
$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res1);
if($linhas == 0){
	$pdo->query("INSERT INTO config_sistema SET email_rh1 = '$email_rh1', email_ferias1 = '$email_ferias1'");
}else{
$email_rh1 = $res1[0]['email_rh1'];
$email_rh2 = $res1[0]['email_rh2'];
$email_rh3 = $res1[0]['email_rh3'];
$email_ferias1 = $res1[0]['email_ferias1'];
$email_ferias2 = $res1[0]['email_ferias2'];
$email_ferias3 = $res1[0]['email_ferias3'];
};

 ?>
