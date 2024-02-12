<?php 
$tabela = 'ocorrencias';
require_once("../../../conexao.php");
session_start();

if(isset($_POST['checkbox_oco'])) {
    $check = 'Sim';
} else {
    $check = 'Não';
}


if($check == 'Não' ){
	$query = $pdo->query("SELECT * from ocorrencias ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$linhas = @count($res);
	
	if($linhas > 0){
		for($i=0; $i<$linhas; $i++){
			$id_func = @$res[$i]['registro'];
            
            if($registro !=$id_func){
                $query5 = $pdo->query("SELECT * from funcionarios where registro = $id_func");
                $res5 = $query5->fetchAll(PDO::FETCH_ASSOC);
                $linhas2 = @count($res5);
                $telefone = @$res5[0]['telefone'];
                $nome = @$res5[0]['nome'];

                $telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
                $mensagem = "Prezado(a) ".$nome."\nSegue abaixo ocorrências de ponto pendentes para regularização, favor se atentar  e realizar ajustes atraves do portal do colaborador ou procure seu gestor imediato\n\nOcorrências\n";
                
                $query1 = $pdo->query("SELECT * from ocorrencias where registro = $id_func");
	            $res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
	            $linhas1 = @count($res1);
                foreach ($res1 as $row) {
                    $data = $row['dataF'];
                    $descricao = $row['descricao'];
                    $duracao = $row['duracao'];
                    $dataF = implode('/', array_reverse(explode('-', $data)));

                    $mensagem .= $descricao."\n".$dataF." - ".$duracao."\n";
                }

                $mensagem.="\n\nObs.: A falta de tratativa das ocorrências citadas acima acarretara em desconto na folha de pagamento.\n\nDuvidas estamos a disposição!!\n\n\nAtt,\nRecursos Humanos!!";
                require("../../apis/texto.php");
                
            }else{

                echo 'Não executar';
            }
            $registro = $id_func;
            

		}

        $pdo->query("DELETE FROM ocorrencias");
	}

}else{
	echo 'Verificar opções obrigatórias!!';
}

	echo 'Salvo com Sucesso';

 ?>