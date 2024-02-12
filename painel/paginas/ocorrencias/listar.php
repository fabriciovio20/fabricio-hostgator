<?php 
$tabela = 'ocorrencias';
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
	<th>Nome</th>		
	<th class="esc">Ocorrência</th>
	<th>Data</th>		
	<th>Duração</th>		
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;


for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$registro = $res[$i]['registro'];
	$nome = $res[$i]['nome'];
	$descricao = $res[$i]['descricao'];
	$data = $res[$i]['dataF'];
	$duracao = $res[$i]['duracao'];
	$mostrar_adm = "";
	$dataF = implode('/', array_reverse(explode('-', $data)));

	

echo <<<HTML

<td>
<input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar('{$id}')">
{$nome}
</td>
<td class="esc">{$descricao}</td>
<td class="esc">{$dataF}</td>
<td class="esc">{$duracao}</td>
<td>

<big><a href="#" onclick="editar('{$id}','{$registro}','{$nome}','{$descricao}','{$data}','{$duracao}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

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

<big><a href="#" onclick="mostrar('{$registro}','{$nome}','{$descricao}','{$dataF}','{$duracao}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>


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

function editar(id, registro, nome, descricao, data, duracao){
		$('#mensagem').text('');
    	$('#titulo_inserir4').text('Editar Registro');

    	$('#id').val(id);
    	$('#registro').val(registro);
    	$('#nome').val(nome);
    	$('#descricao').val(descricao);
    	$('#data').val(data);
    	$('#duracao').val(duracao);
    	
    	$('#modalForm4').modal('show');
	}



	function mostrar(registro, nome, descricao, data, duracao){
		    	
    	$('#registro_dados').text(registro);
    	$('#titulo_dados').text(nome);
    	$('#descricao_dados').text(descricao);
    	$('#data_dados').text(data);
    	$('#duracao_dados').text(duracao);

    	$('#modalDados').modal('show');
	}

	function limparCampos(){
		$('#id').val('');
		$('#registro').val('');
    	$('#nome').val('');
    	$('#descricao').val('');
    	$('#data').val('');
    	$('#duracao').val('');
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


	function permissoes(id, nome){
		    	
    	$('#id_permissoes').val(id);
    	$('#nome_permissoes').text(nome);    	

    	$('#modalPermissoes').modal('show');
    	listarPermissoes(id);
	}

	


	
</script>