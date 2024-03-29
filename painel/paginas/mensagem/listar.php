<?php 
$tabela = 'msg';
require_once("../../../conexao.php");

$query = $pdo->query("SELECT * from $tabela order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr>
	<th>Data Envio</th>	
	<th>Filial</th>
	<th>Mensagem Enviada</th>
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;


for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$data_envio = $res[$i]['data_envio'];
	$data_envio2 = date('Y-m-d', strtotime($res[$i]['data_envio']));
	$data_envioF = implode('/', array_reverse(explode('-', $data_envio2)));
	$filial = $res[$i]['filial'];
	$msg_env = $res[$i]['mensagem'];
	$foto = $res[$i]['foto'];
	$msg_env_shortened = implode(' ', array_slice(str_word_count($msg_env, 1), 0, 20)) . ' ...';
echo <<<HTML
<tr>
<td>
<input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar('{$id}')">
{$data_envioF}
</td>
<td>{$filial}</td>
<td>{$msg_env_shortened}</td>

<td>
	<big><a href="#" onclick="editar('{$id}','{$data_envio}','{$filial}','{$msg_env}','{$foto}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa-solid fa-trash-can text-danger"></i></big></a>

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

<script type="text/javascript">
	function editar(id, data_envio, filial, msg_env, foto){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#data_envio').val(data_envio);
    	$('#filial').val(filial).change();
    	$('#msg_env').val(msg_env);
    	$('#foto').val(foto);
    
    	$('#modalForm').modal('show');
	}



	function limparCampos(){
		$('#id').val('');
    	$('#data_envio').val('');
    	$('#filial').val('todos');
    	$('#msg_env').val('');
    	$('#foto').val('');
    

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