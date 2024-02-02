<?php 
$tabela = 'mensagem_entrevista';
require_once("../../../conexao.php");
session_start();

$data_entrevista = $_POST['data_entrevista'];
$data_envio = $_POST['data_envio'];
$msg_env = $_POST['msg_env'];
$id = $_POST['id'];

if(isset($_POST['checkbox_data'])) {
    $check = 'Sim';
} else {
    $check = 'Não';
}


//validar troca da foto
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET  data_envio = :data_envio, data_entrevista = :data_entrevista, mensagem = :msg_env");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET data_envio = :data_envio, data_entrevista = :data_entrevista, mensagem = :msg_env where id = '$id'");

}
$query->bindValue(":data_envio", "$data_envio");
$query->bindValue(":data_entrevista", "$data_entrevista");
$query->bindValue(":msg_env", "$msg_env");

$query->execute();


if($check == 'Sim'){

	$query2 = $pdo->prepare("SELECT * FROM candidatos WHERE data_entrevista = :data_entrevista");
	$query2->bindValue(':data_entrevista', $data_entrevista, PDO::PARAM_STR);
	$query2->execute();
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$linhas = @count($res2);
	if($linhas > 0){
		for($i=0; $i<$linhas; $i++){
			$telefone = @$res2[$i]['telefone'];
			$nome = @$res2[$i]['nome'];
			$data_entrevista2 = @$res2[$i]['data_entrevista'];
			$dataF = implode('/', array_reverse(explode('-', $data_entrevista2)));
			

			if($token != ""){

				$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
				$mensagem = "Prezado(a) ".$nome." agradecemos seu interesse no processo seletivo realizado no dia ".$dataF.". Após uma avaliação cuidadosa, decidimos não avançar com sua candidatura. Agradecemos seu tempo e desejamos sucesso em suas futuras oportunidades.\n\nAtenciosamente,\nRecursos Humanos JSL!";
				$data_agd2 = $data_envio;
				require("../../apis/agendar.php");
				
			}


		}
	}

}elseif($check == 'Não'){

	$query3 = $pdo->prepare("SELECT * FROM candidatos WHERE data_entrevista = :data_entrevista");
	$query3->bindValue(':data_entrevista', $data_entrevista, PDO::PARAM_STR);
	$query3->execute();
	$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
	$linhas = @count($res3);
	if($linhas > 0){
		for($i=0; $i<$linhas; $i++){
			$telefone = @$res3[$i]['telefone'];
			$nome = @$res3[$i]['nome'];
			$data_entrevista2 = @$res3[$i]['data_entrevista'];
			$dataF = implode('/', array_reverse(explode('-', $data_entrevista2)));
			

			if($token != ""){

				$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
				$mensagem = "Prezado(a) ".$nome." agradecemos sua participação no processo seletivo realizado no dia ".$dataF.". Após uma avaliação e entrevista, decidimos não avançar com sua candidatura. Agradecemos seu tempo e desejamos sucesso em suas futuras oportunidades.\n\nAtenciosamente,\nRecursos Humanos JSL!";
				require("../../apis/texto.php");
				
			}

			

		}
		
	}


}else{
	echo 'Verificar opções obrigatórias!!';
}

	echo 'Salvo com Sucesso';

 ?>