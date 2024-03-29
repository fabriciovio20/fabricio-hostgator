<?php 
$tabela = 'msg';
require_once("../../../conexao.php");
session_start();

$data_envio = $_POST['data_envio'];
$filial = $_POST['filial'];
$msg_env = $_POST['msg_env'];
$id = $_POST['id'];

if(isset($_POST['checkbox_data'])) {
    $check = 'Sim';
} else {
    $check = 'Não';
}

if(isset($_POST['checkbox_funcionario'])) {
    $check_funcionario = 'Sim';
} else {
    $check_funcionario = 'Não';
}


//validar troca da foto
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
$foto = "";
if($total_reg > 0){
	$foto = $res[0]['foto'];
}

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../images/perfil/' .$nome_img;

$imagem_temp = @$_FILES['foto']['tmp_name']; 

if(@$_FILES['foto']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'pdf' or $ext == 'mp4' or $ext == 'avi' or $ext == 'mov' or $ext == 'mkv' or $ext == 'webm' ){ 
        $foto = '';
			//EXCLUO A FOTO ANTERIOR
			if($foto != ""){
				@unlink('images/perfil/'.$foto);
			}

			$foto = $nome_img;
		
		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}

if ($id == "" && $check == "Sim") {
    $query = $pdo->prepare("INSERT INTO $tabela SET data_envio = :data_envio, filial = :filial, mensagem = :msg_env, foto = :foto");
    $query->bindValue(":data_envio", "$data_envio");
} elseif ($id == "" && $check == "Não") {
    $query = $pdo->prepare("INSERT INTO $tabela SET data_envio = CURDATE(), filial = :filial, mensagem = :msg_env, foto = :foto");
} else {
    $query = $pdo->prepare("UPDATE $tabela SET data_envio = :data_envio, filial = :filial, mensagem = :msg_env, foto = :foto WHERE id = '$id'");
    // Se o checkbox for "Não", vincule a data atual do servidor
    if ($check == "Não") {
        $query->bindValue(":data_envio", date('Y-m-d'));
    } else {
        $query->bindValue(":data_envio", "$data_envio");
    }
}

$query->bindValue(":filial", "$filial");
$query->bindValue(":msg_env", "$msg_env");
$query->bindValue(":foto", "$foto");
$query->execute();

if($check_funcionario =='Sim' and $check == 'Sim' ){
	$query4 = $pdo->query("SELECT * from msg_func ");
	$res4 = $query4->fetchAll(PDO::FETCH_ASSOC);
	$linhas1 = @count($res4);
	$telefones = [];
	if($linhas1 > 0){
		for($i=0; $i<$linhas1; $i++){
			$id_func = @$res4[$i]['funcionario'];

			$query5 = $pdo->query("SELECT * from funcionarios where id = $id_func");
			$res5 = $query5->fetchAll(PDO::FETCH_ASSOC);
			$linhas2 = @count($res5);
			$telefone = @$res5[0]['telefone'];
			$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
			$telefones[] = $telefone_envio;
	
			$pdo->query("DELETE FROM msg_func WHERE funcionario = '$id_func' ");
			


		}
		$telefones_json = json_encode($telefones);

		if($token != "" and $foto ==""){

			$mensagem = $msg_env;
			$data_agd2 = $data_envio;
			require("../../apis/agendar.php");
			
		}else{
			$mensagem = $msg_env;
			$data_agd2 = $data_envio;
			$arquivo = $foto;
			require("../../apis/envio_img.php");
		}

	}elseif($filial == 'todos' and $check == 'Sim'){

		$query2 = $pdo->query("SELECT * from funcionarios where ativo != 'não'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$linhas = @count($res2);
		$telefones = [];
		if($linhas > 0){
			for($i=0; $i<$linhas; $i++){
				$telefone = @$res2[$i]['telefone'];
				$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
				$telefones[] = $telefone_envio;
	
				
	
			}

			$telefones_json = json_encode($telefones);

			if($token != "" and $foto ==""){
	
				$mensagem = $msg_env;
				$data_agd2 = $data_envio;
				require("../../apis/agendar.php");
				
			}else{
				$mensagem = $msg_env;
				$data_agd2 = $data_envio;
				$arquivo = $foto;
				require("../../apis/envio_img.php");
			}

		}
	}elseif($filial != '' and $check == 'Sim'){
	
		$query3 = $pdo->query("SELECT * from funcionarios where filial = '$filial' AND ativo != 'não'");
		$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
		$linhas = @count($res3);
		$telefones = [];
		if($linhas > 0){
			for($i=0; $i<$linhas; $i++){
				$telefone = @$res3[$i]['telefone'];
				$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
				$telefones[] = $telefone_envio;
	
	
	
	
			}

			$telefones_json = json_encode($telefones);

			if($token != "" and $foto ==""){
	
				$mensagem = $msg_env;
				$data_agd2 = $data_envio;
				require("../../apis/agendar.php");
				
			}else{
				$mensagem = $msg_env;
				$data_agd2 = $data_envio;
				$arquivo = $foto;
				require("../../apis/envio_img.php");
			}

		}
	
	}elseif($filial == 'todos' and $check == 'Não'){
	
		$query3 = $pdo->query("SELECT * from funcionarios where ativo != 'não'");
		$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
		$linhas = @count($res3);
		if($linhas > 0){
			for($i=0; $i<$linhas; $i++){
				$telefone = @$res3[$i]['telefone'];
	
				if($token != "" and $foto ==""){
	
					$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
					$mensagem = $msg_env;
					require("../../apis/texto.php");
					
				}else{
					$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
					$mensagem = $msg_env;
					$arquivo = $foto;
					require("../../apis/texto_img.php");
				}
	
	
			}
		}
	
	}elseif($filial != '' and $check == 'Não'){
	
		$query3 = $pdo->query("SELECT * from funcionarios where filial = '$filial' AND ativo != 'não'");
		$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
		$linhas = @count($res3);
		if($linhas > 0){
			for($i=0; $i<$linhas; $i++){
				$telefone = @$res3[$i]['telefone'];
				
	
				if($token != "" and $foto ==""){
	
					$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
					$mensagem = $msg_env;
					require("../../apis/texto.php");
					
				}else{
					$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
					$mensagem = $msg_env;
					$arquivo = $foto;
					require("../../apis/texto_img.php");
				}
	
	
			}
		}
	


	}



}elseif($check_funcionario =='Sim' and $check == 'Não' ){
	$query4 = $pdo->query("SELECT * from msg_func ");
	$res4 = $query4->fetchAll(PDO::FETCH_ASSOC);
	$linhas1 = @count($res4);
	
	if($linhas1 > 0){
		for($i=0; $i<$linhas1; $i++){
			$id_func = @$res4[$i]['funcionario'];

			$query5 = $pdo->query("SELECT * from funcionarios where id = $id_func");
			$res5 = $query5->fetchAll(PDO::FETCH_ASSOC);
			$linhas2 = @count($res5);
			$telefone = @$res5[0]['telefone'];
			

			if($token != "" and $foto ==""){
	
				$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
				$mensagem = $msg_env;
				require("../../apis/texto.php");
				
			}else{
				$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
				$mensagem = $msg_env;
				$arquivo = $foto;
				require("../../apis/texto_img.php");
			}

			$pdo->query("DELETE FROM msg_func WHERE funcionario = '$id_func' ");
			


		}
	}elseif($filial == 'todos' and $check == 'Sim'){

		$query2 = $pdo->query("SELECT * from funcionarios where ativo != 'não'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$linhas = @count($res2);
		$telefones = [];
		if($linhas > 0){
			for($i=0; $i<$linhas; $i++){
				$telefone = @$res2[$i]['telefone'];
				$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
				$telefones[] = $telefone_envio;
	
	
	
			}
			
			$telefones_json = json_encode($telefones);

			if($token != "" and $foto ==""){
	
				$mensagem = $msg_env;
				$data_agd2 = $data_envio;
				require("../../apis/agendar.php");
				
			}else{
				$mensagem = $msg_env;
				$data_agd2 = $data_envio;
				$arquivo = $foto;
				require("../../apis/envio_img.php");
			}

		}
	}elseif($filial != '' and $check == 'Sim'){
	
		$query3 = $pdo->query("SELECT * from funcionarios where filial = '$filial' AND ativo != 'não'");
		$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
		$linhas = @count($res3);
		$telefones = [];

		if($linhas > 0){
			for($i=0; $i<$linhas; $i++){
				$telefone = @$res3[$i]['telefone'];
				$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
				$telefones[] = $telefone_envio;
	
				
	
			}

			$telefones_json = json_encode($telefones);


			if($token != "" and $foto ==""){
	
				$mensagem = $msg_env;
				$data_agd2 = $data_envio;
				require("../../apis/agendar.php");
				
			}else{
				$mensagem = $msg_env;
				$data_agd2 = $data_envio;
				$arquivo = $foto;
				require("../../apis/envio_img.php");
			}

		}
	
	}elseif($filial == 'todos' and $check == 'Não'){
	
		$query3 = $pdo->query("SELECT * from funcionarios where ativo != 'não'");
		$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
		$linhas = @count($res3);
		if($linhas > 0){
			for($i=0; $i<$linhas; $i++){
				$telefone = @$res3[$i]['telefone'];
				
	
				if($token != "" and $foto ==""){
	
					$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
					$mensagem = $msg_env;
					require("../../apis/texto.php");
					
				}else{
					$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
					$mensagem = $msg_env;
					$arquivo = $foto;
					require("../../apis/texto_img.php");
				}
	
	
			}
		}
	
	}elseif($filial != '' and $check == 'Não'){
	
		$query3 = $pdo->query("SELECT * from funcionarios where filial = '$filial' AND ativo != 'não'");
		$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
		$linhas = @count($res3);
		if($linhas > 0){
			for($i=0; $i<$linhas; $i++){
				$telefone = @$res3[$i]['telefone'];
				
	
				if($token != "" and $foto ==""){
	
					$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
					$mensagem = $msg_env;
					require("../../apis/texto.php");
					
				}else{
					$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
					$mensagem = $msg_env;
					$arquivo = $foto;
					require("../../apis/texto_img.php");
				}
	
	
			}
		}
	


	}




}elseif($check_funcionario =='Não'){

	if($filial == 'todos' and $check == 'Sim'){

		$query2 = $pdo->query("SELECT * from funcionarios where ativo != 'não'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$linhas = @count($res2);
		$telefones = [];
		if($linhas > 0){
			for($i=0; $i<$linhas; $i++){
				$telefone = @$res2[$i]['telefone'];
				$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
				$telefones[] = $telefone_envio;
	
	
			}

			$telefones_json = json_encode($telefones);


			if($token != "" and $foto ==""){
	
				$mensagem = $msg_env;
				$data_agd2 = $data_envio;
				require("../../apis/agendar.php");
				
			}else{
				$mensagem = $msg_env;
				$data_agd2 = $data_envio;
				$arquivo = $foto;
				require("../../apis/envio_img.php");
			}

		}
	}elseif($filial != 'todos' and $check == 'Sim'){
	
		$query3 = $pdo->query("SELECT * from funcionarios where filial = '$filial' AND ativo != 'não'");
		$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
		$linhas = @count($res3);
		$telefones = [];

		if($linhas > 0){
			for($i=0; $i<$linhas; $i++){
				$telefone = @$res3[$i]['telefone'];
				$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
				$telefones[] = $telefone_envio;
	
	
			}
			
			$telefones_json = json_encode($telefones);

			if($token != "" and $foto ==""){
	
				$mensagem = $msg_env;
				$data_agd2 = $data_envio;
				require("../../apis/agendar.php");
				
			}else{
				$mensagem = $msg_env;
				$data_agd2 = $data_envio;
				$arquivo = $foto;
				require("../../apis/envio_img.php");
			}

		}
	
	}elseif($filial == 'todos' and $check == 'Não'){
	
		$query3 = $pdo->query("SELECT * from funcionarios where ativo != 'não'");
		$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
		$linhas = @count($res3);
		if($linhas > 0){
			for($i=0; $i<$linhas; $i++){
				$telefone = @$res3[$i]['telefone'];
				
	
				if($token != "" and $foto ==""){
	
					$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
					$mensagem = $msg_env;
					require("../../apis/texto.php");
					
				}else{
					$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
					$mensagem = $msg_env;
					$arquivo = $foto;
					require("../../apis/texto_img.php");
				}
	
	
			}
		}
	
	}elseif($filial != 'todos' and $check == 'Não'){
	
		$query3 = $pdo->query("SELECT * from funcionarios where filial = '$filial' AND ativo != 'não'");
		$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
		$linhas = @count($res3);
		if($linhas > 0){
			for($i=0; $i<$linhas; $i++){
				$telefone = @$res3[$i]['telefone'];
				$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
				
				if($token != "" and $foto ==""){
					$mensagem = $msg_env;
					require("../../apis/texto.php");
					
				}else{
					$mensagem = $msg_env;
					$arquivo = $foto;
					require("../../apis/texto_img.php");
				}	
			
	
			}

			
			

		}
	


	}



}else{
	echo 'Selecione pelo menos 1 opção das filiais!!';
}

echo 'Salvo com Sucesso';

 ?>