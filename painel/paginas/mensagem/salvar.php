<?php 
$tabela = 'msg';
require_once("../../../conexao.php");
session_start();

$data_envio = $_POST['data_envio'];
$filial = $_POST['filial'];
$msg_env = $_POST['msg_env'];
$id = $_POST['id'];


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
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'pdf'){ 
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

if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET  data_envio = :data_envio, filial = :filial, mensagem = :msg_env, foto = :foto");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET data_envio = :data_envio, filial = :filial, mensagem = :msg_env, foto = :foto where id = '$id'");

}
$query->bindValue(":data_envio", "$data_envio");
$query->bindValue(":filial", "$filial");
$query->bindValue(":msg_env", "$msg_env");
$query->bindValue(":foto", "$foto");
$query->execute();

echo 'Salvo com Sucesso';


$query2 = $pdo->query("SELECT * from usuarios where filial = '$filial' AND ativo != 'não'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res2);
if($linhas > 0){
	for($i=0; $i<$linhas; $i++){
		$telefone = @$res2[$i]['telefone'];

		if($token != "" and $foto ==""){

			$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
			$mensagem = $msg_env;
			$data_agd2 = $data_envio;
			require("../../apis/agendar.php");
			
		}else{
			$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
			$mensagem = $msg_env;
			$data_agd2 = $data_envio;
			$arquivo = $foto;
			require("../../apis/envio_img.php");
		}


	}
}


 ?>