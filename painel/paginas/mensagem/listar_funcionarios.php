<?php 
$tabela = 'msg_func';
require_once("../../../conexao.php");

$query = $pdo->query("SELECT * from $tabela");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="">
	<thead> 
	<tr>
	<th>Registro</th>		
	<th>Nome Funcionário</th>		
	<th>Excluir</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;


for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$funcionario = $res[$i]['funcionario'];

	$query2 = $pdo->query("SELECT * from funcionarios where id = '$funcionario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$funcionarios = $res2[0]['nome']; 	
$registro = $res2[0]['registro']; 	

echo <<<HTML
<tr>
<td class="">{$registro}</td>
<td class="">{$funcionarios}</td>
<td>

	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirFuncionarios('{$id}', '{$usuario}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li>



</td>
</tr>
HTML;

}


echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
HTML;

}else{
	echo '<small>Nenhum Registro Encontrado!</small>';
}
?>



<script type="text/javascript">

	function excluirFuncionarios(id, usuario){
		    	
    	$.ajax({
        url: 'paginas/' + pag + "/excluir_funcionarios.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(mensagem){
            if (mensagem.trim() == "Excluído com Sucesso") {
                listarFuncionarios(usuario);
            } 
        }
    });
	}

	


	
</script>