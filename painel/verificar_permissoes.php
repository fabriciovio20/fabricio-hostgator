<?php 
require_once("../conexao.php");
@session_start();
$id_usuario = $_SESSION['id'];

$home = 'ocultar';
$configuracoes = 'ocultar';
$horarios = 'ocultar';
$configuracoes_sistema = 'ocultar';

//grupo pessoas
$usuarios = 'ocultar';
$funcionarios = 'ocultar';
$candidatos = 'ocultar';

//grupo cadastros
$acessos = 'ocultar';
$cargos = 'ocultar';
$grupo_acessos = 'ocultar';
$mensagem = 'ocultar';

//grupo Processo Seletivo
$mensagem_candidato = 'ocultar';

$query = $pdo->query("SELECT * FROM usuarios_permissoes where usuario = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	for($i=0; $i < $total_reg; $i++){
		foreach ($res[$i] as $key => $value){}
		$permissao = $res[$i]['permissao'];

		$query2 = $pdo->query("SELECT * FROM acessos where id = '$permissao'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$nome = $res2[0]['nome'];
		$chave = $res2[0]['chave'];
		$id = $res2[0]['id'];

		if($chave == 'home'){
			$home = '';
		}

		if($chave == 'configuracoes'){
			$configuracoes = '';
		}

		if($chave == 'configuracoes_sistema'){
			$configuracoes_sistema = '';
		}


		if($chave == 'usuarios'){
			$usuarios = '';
		}

		if($chave == 'funcionarios'){
			$funcionarios = '';
		}

		if($chave == 'candidatos'){
			$candidatos = '';
		}

		if($chave == 'grupo_acessos'){
			$grupo_acessos = '';
		}

		if($chave == 'acessos'){
			$acessos = '';
		}

		if($chave == 'cargos'){
			$cargos = '';
		}

		if($chave == 'mensagem'){
			$mensagem = '';
		}

		if($chave == 'mensagem_candidato'){
			$mensagem_candidato = '';
		}

	}

}



$pag_inicial = '';
if($home != 'ocultar'){
	$pag_inicial = 'home';
}else{
	$query = $pdo->query("SELECT * FROM usuarios_permissoes where usuario = '$id_usuario'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);	
	if($total_reg > 0){
		for($i=0; $i < $total_reg; $i++){	
			$permissao = $res[$i]['permissao'];		
			$query2 = $pdo->query("SELECT * FROM acessos where id = '$permissao'");
			$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
			if($res2[0]['pagina'] == 'Não'){					
				continue;
			}else{
				$pag_inicial = $res2[0]['chave'];
				break;
			}

		}	

	}else{
		echo 'Você não tem permissão para acessar nenhuma página, acione o administrador!';
		exit();
	}
}


if($pag_inicial == ''){
	echo 'Você não tem permissão para acessar nenhuma página, acione o administrador!';
		exit();
}

if($usuarios == 'ocultar' and $funcionarios == 'ocultar' and $candidatos == 'ocultar'){
	$menu_pessoas = 'ocultar';
}else{
	$menu_pessoas = '';
}


if($grupo_acessos == 'ocultar' and $acessos == 'ocultar' and $cargos == 'ocultar' and $mensagem == 'ocultar'){
	$menu_cadastros = 'ocultar';
}else{
	$menu_cadastros = '';
}

if($mensagem_candidato == 'ocultar'){
	$menu_processo_seletivo = 'ocultar';
}else{
	$menu_processo_seletivo = '';
}

?>