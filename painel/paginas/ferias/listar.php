<?php 
$tabela = 'ferias';
@session_start();
require_once("../../../conexao.php");

$nivel_usuario = @$_SESSION['nivel'];
$id_usuario = @$_SESSION['id'];

$query = $pdo->query("SELECT * from $tabela order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr>		
	<th>Registro</th>	
	<th class="esc">Nome</th>	
	<th>Data Inicio</th>	
	<th>Qntd Dias</th>	
	<th class="esc">Data Fim</th>	
	<th>Status</th>
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;


for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	@$funcionario = $res[$i]['funcionario'];
	@$usuario_alt = $res[$i]['usuario_alt'];
	@$query1 = $pdo->query("SELECT * FROM pacientes where id = $funcionario ORDER BY nome asc");
	@$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
    @$registro = $res1[0]['registro'];
    @$nome = $res1[0]['nome'];

	$data_ini = $res[$i]['data_ini'];
	$qntd_dias = $res[$i]['qntd_dias'];
	$data_fim = $res[$i]['data_fim'];
	$data_iniF = implode('/', array_reverse(explode('-', $data_ini)));
	$data_fimF = implode('/', array_reverse(explode('-', $data_fim)));
	$data_alt = new DateTime($res[$i]['data_alt']);
	$data_altF = $data_alt->format("d/m/Y H:i:s");
	$status1 = $res[$i]['status1'];
	$query2 = $pdo->query("SELECT * FROM usuarios where id = $usuario_alt ORDER BY nome asc");
	@$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    @$nome2 = $res2[0]['nome'];

	$ult_modi = $nome2.' - '.$data_altF;

	$ocultar_confirmacao = '';
	if($status1 == 'Pendente'){
		$imagem = 'text-primary';
		$imagemClasse = 'blue';
		$classe_status = 'ocultar';
		$ocultar_confirmacao = '';
	}elseif($status1 == 'Confirmado'){
		$imagem = 'verde';
		$imagemClasse = 'green';
		$classe_status = 'ocultar';
		$ocultar_confirmacao = 'ocultar';
		
	}else{
		$imagem = 'Vermelho';
		$imagemClasse = 'red';
		$classe_status = 'ocultar';
		$ocultar_confirmacao = 'ocultar';
	}


echo <<<HTML

<tr>
<td>
<input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar('{$id}')">
{$registro}
</td>
<td class="esc">{$nome}</td>
<td>{$data_iniF}</td>
<td>{$qntd_dias}</td>
<td class="esc">{$data_fimF}</td>
<td><div style="color:#FFF; background:{$imagemClasse}; padding:0px; width:75px; text-align: center; font-size: 12px; ">{$status1}</div></td>




<td>
	<big><a href="#" onclick="editar('{$id}','{$funcionario}','{$data_ini}','{$qntd_dias}','{$status1}','{$ult_modi}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
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

	function editar(id, funcionario, data_ini, qntd_dias, status1, ult_modi){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#funcionario').val(funcionario).change();
    	
    	$('#data_ini').val(data_ini).change();
    	$('#qntd_dias').val(qntd_dias);
		$('#status1').val(status1).change();
    	$('#ult_modi').val(ult_modi);
    
    	$('#modalForm').modal('show');
	}

	function limparCampos(){
		$('#id').val('');
    	$('#ids').val('');
    	$('#btn-deletar').hide();	
	}

	function selecionar(id){

		var ids = $('#ids').val();

		if($('#seletor-'+id).is(":checked") == true){
			var novo_id = ids + id + '-';
			$('#ids').val(novo_id);
		}else{
			var retirar = ids.replace(id + '-', '');
			$('#ids').val(retirar);
		}

		var ids_final = $('#ids').val();
		if(ids_final == ""){
			$('#btn-deletar').hide();
		}else{
			$('#btn-deletar').show();
		}
	}

	function deletarSel(){
		var ids = $('#ids').val();
		var id = ids.split("-");
		
		for(i=0; i<id.length-1; i++){
			excluir(id[i]);			
		}

		limparCampos();
	}

</script>

<script type="text/javascript">
	$(document).ready( function () {		
    $('#tabela').DataTable({
    	"language" : {
            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json'
        },
        "ordering": false,
		"stateSave": true
    });
} );
</script>