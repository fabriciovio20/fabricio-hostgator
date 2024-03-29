<?php 
$tabela = 'funcionarios';
require_once("../../../conexao.php");
$status = '%'.@$_POST['status'].'%';

$query = $pdo->query("SELECT * from $tabela where ativo LIKE '$status' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Registro</th>	
	<th>Nome</th>	
	<th class="esc">Cadastrado em</th>		
	<th class="esc">Nível / Cargo</th>	
	<th class="esc">Foto</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;


for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$registro = $res[$i]['registro'];
	$nome = $res[$i]['nome'];
	$email = $res[$i]['email'];
	$telefone = $res[$i]['telefone'];
	$cpf = $res[$i]['cpf'];
	$foto = $res[$i]['foto'];
	$nivel = $res[$i]['nivel'];
	$ativo = $res[$i]['ativo'];
	$data = $res[$i]['data'];
	$filial = $res[$i]['filial'];
	$dataF = implode('/', array_reverse(explode('-', $data)));

	if($ativo == 'Sim'){
	$icone = '<i class="fa-solid fa-square-check" style="color: #1ac125;"></i>';
	$titulo_link = 'Desativar Usuário';
	$acao = 'Não';
	$classe_ativo = '';
	}else{
		$icone = '<i class="fa-solid fa-minus" style="color: #ff1414;"></i>';
		$titulo_link = 'Ativar Usuário';
		$acao = 'Sim';
		$classe_ativo = '#c4c4c4';
	}



	$tel_pessoaF = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);


echo <<<HTML
<tr style="color:{$classe_ativo}">
<td>
<input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar('{$id}')">
{$registro}
</td>
<td>{$nome}</td>
<td class="esc">{$dataF}</td>
<td class="esc">{$nivel}</td>
<td class="esc"><img src="images/perfil/{$foto}" width="25px"></td>
<td>
	<big><a href="#" onclick="editar('{$id}','{$registro}','{$nome}','{$email}','{$telefone}','{$cpf}','{$nivel}','{$filial}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

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

<big><a href="#" onclick="mostrar('{$registro}','{$nome}','{$email}','{$telefone}','{$cpf}','{$ativo}','{$dataF}', '{$nivel}', '{$foto}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>


<big><a href="#" onclick="ativar('{$id}', '{$acao}')" title="{$titulo_link}">{$icone}</i></a></big>


<big><a class="" href="http://api.whatsapp.com/send?1=pt_BR&phone={$tel_pessoaF}" title="Whatsapp" target="_blank"><i class="fa-brands fa-whatsapp" style="color: #1c891a;"></i></a></big>

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
	function editar(id, registro, nome, email, telefone, cpf, nivel, filial){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#registro').val(registro);
    	$('#nome').val(nome);
    	$('#email').val(email);
    	$('#telefone').val(telefone);
    	$('#cpf').val(cpf);
    	$('#nivel').val(nivel).change();
    	$('#filial').val(filial).change();
    	
    	$('#modalForm').modal('show');
	}


	function mostrar(registro, nome, email, telefone, cpf, ativo, data, nivel, foto){
		    	
    	$('#registro_dados').text(registro);
    	$('#titulo_dados').text(nome);
    	$('#email_dados').text(email);
    	$('#telefone_dados').text(telefone);
    	$('#cpf_dados').text(cpf);
    	$('#ativo_dados').text(ativo);
    	$('#data_dados').text(data);
    	$('#nivel_dados').text(nivel);
    	$('#foto_dados').attr("src", "images/perfil/" + foto);
    	

    	$('#modalDados').modal('show');
	}

	function limparCampos(){
		$('#id').val('');
		$('#registro').val('');
    	$('#nome').val('');
    	$('#email').val('');
    	$('#telefone').val('');
    	$('#cpf').val('');
    	$('#email').val('');
    	$('#filial').val('todos');
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