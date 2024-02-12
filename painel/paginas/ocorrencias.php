<?php 
$pag = 'ocorrencias';
@session_start(); // Iniciar a sessão

if(@$ocorrencias == 'ocultar'){
	echo "<script>window.location='../index.php'</script>";
    exit();
}

 ?>
<a onclick="importar()" type="button" class="btn btn-primary"><span class="fa fa-plus"></span> Importar</a>
<a onclick="divulgar()" type="button" class="btn btn-success"><span class="fa fa-plus"></span>Divulgar Ocorrências</a>



<li class="dropdown head-dpdn2" style="display: inline-block;">		
		<a href="#" data-toggle="dropdown"  class="btn btn-danger dropdown-toggle" id="btn-deletar" style="display:none"><span class="fa-solid fa-trash-can"></span> Deletar</a>

		<ul class="dropdown-menu">
		<li>
		<div class="notification_desc2">
		<p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li>

<div class="bs-example widget-shadow" style="padding:15px" id="listar">

</div>


<input type="hidden" id="ids">


<!-- Modal Perfil -->
<div class="modal fade" id="modalForm4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir4"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form">
				<div class="modal-body">
					

						<div class="row">
							<div class="col-md-4">							
									<label>Registro</label>
									<input type="text" class="form-control" id="registro" name="registro" placeholder="Registro" required>							
							</div>
							<div class="col-md-8">							
									<label>Nome</label>
									<input type="text" class="form-control" id="nome" name="nome" placeholder="Seu Nome" required>							
							</div>
							
						</div>
						
						<div class="row">

							<div class="col-md-6">							
									<label>Descricao</label>
									<input type="text" class="form-control" id="descricao" name="descricao" placeholder="descricao" required>							
							</div>

							
						</div>

						<div class="row">

							<div class="col-md-4">							
									<label>Data</label>
									<input type="date" class="form-control" id="data" name="data" required>							
							</div>

							<div class="col-md-3">							
									<label>Duração</label>
									<input type="number" step="0.01" class="form-control" id="duracao" name="duracao" placeholder="duracao" required>							
							</div>

							
						</div>

						<div class="row">

							<div class="col-md-6" style="margin-top: 22px">							
									<button type="submit" class="btn btn-primary">Salvar</button>					
							</div>

						</div>
				
						<input type="hidden" class="form-control" id="id" name="id">					

					<br>
					<small><div id="mensagem" align="center"></div></small>
				</div>
				
			</form>
		</div>
	</div>
</div>





<!-- Modal Perfil -->
<div class="modal fade" id="modalForm1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir1"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form id="form3" method="POST"  enctype="multipart/form-data">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-12">							
								<label>Importar Dados</label>
								<input type="file" class="form-control" id="arquivo" name="arquivo" accept="text/csv">							
						</div>
						
					</div>

					<div class="row">
					<div class="col-md-6" style="margin-top: 22px">							
						<input type="submit" value="Enviar" id="btn-enviar" class="btn btn-primary">
					
						</div>
					</div>

					
			
					<input type="hidden" class="form-control" id="id1" name="id1">					

				<br>
				<small><div id="mensagem1" align="center"></div></small>
			</div>
			
			</form>
		</div>
	</div>
</div>




<!-- Modal Perfil -->
<div class="modal fade" id="modalForm2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir2"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form id="form2" method="POST"  enctype="multipart/form-data">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-12">							
							<label>Enviar pendências das ocorrências aos colaboradores ?</label>							
						</div>
						
					</div>

					<div class="col-md-4 hidden">
                        <input type="checkbox" id="checkbox_oco" name="checkbox_oco">
                    </div>

					<div class="row">
					<div class="col-md-6" style="margin-top: 22px">							
						<input type="submit" value="Enviar" id="btn-enviar1" class="btn btn-primary">
					
						</div>
					</div>

					
			
					<input type="hidden" class="form-control" id="id2" name="id2">					

				<br>
				<small><div id="mensagem2" align="center"></div></small>
			</div>
			
			</form>
		</div>
	</div>
</div>


<!-- Modal Dados -->
<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_dados"></span></h4>
				<button id="btn-fechar-dados" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
				<div class="row" style="margin-top: 0px">
					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Registro: </b></span><span id="registro_dados"></span>
					</div>

					<div class="col-md-8" style="margin-bottom: 5px">
						<span><b>Ocorrência: </b></span><span id="descricao_dados"></span>
					</div>


					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Data: </b></span><span id="data_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Duração: </b></span><span id="duracao_dados"></span>
					</div>

				</div>
			</div>
					
		</div>
	</div>
</div>



<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>




<script type="text/javascript">

	function listarPermissoes(id){
		 $.ajax({
        url: 'paginas/' + pag + "/listar_permissoes.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){        	
            $("#listar_permissoes").html(result);
            $('#mensagem_permissao').text('');
        }
    });
	}

	function adicionarPermissao(id, usuario){
		 $.ajax({
        url: 'paginas/' + pag + "/add_permissao.php",
        method: 'POST',
        data: {id, usuario},
        dataType: "html",

        success:function(result){        	
           listarPermissoes(usuario);
        }
    });
	}


	function marcarTodos(){
		let checkbox = document.getElementById('input-todos');
		var usuario = $('#id_permissoes').val();
		
		if(checkbox.checked) {
		    adicionarPermissoes(usuario);		    
		} else {
		    limparPermissoes(usuario);
		}
	}


	function adicionarPermissoes(id_usuario){
		
		$.ajax({
        url: 'paginas/' + pag + "/add_permissoes.php",
        method: 'POST',
        data: {id_usuario},
        dataType: "html",

        success:function(result){        	
           listarPermissoes(id_usuario);
        }
    });
	}


	function limparPermissoes(id_usuario){
		
		$.ajax({
        url: 'paginas/' + pag + "/limpar_permissoes.php",
        method: 'POST',
        data: {id_usuario},
        dataType: "html",

        success:function(result){        	
           listarPermissoes(id_usuario);
        }
    });
	}
</script>


<script type="text/javascript">
$(document).ready(function() {
    $('#btn-enviar').on('click', function(e) {
        e.preventDefault();
        importar();
		ocultar();
});

    });

function importar() {
    $('#mensagem1').text('');
    $('#titulo_inserir1').text('Inserir Registro');
    $('#modalForm1').modal('show');

    var form = document.getElementById('form3');
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'paginas/' + pag + '/importar.php', true);

	xhr.onload = function () {
        if (xhr.status === 200) {
            // Importação bem-sucedida, agora listamos os dados
            listar();
        } else {
            console.log('Erro ao importar dados');
        }
    };


    xhr.send(formData);

}

function ocultar(){
	$('#modalForm1').modal('hide');
}
</script>




<script type="text/javascript">
$(document).ready(function() {
    $('#btn-enviar1').on('click', function(e) {
        e.preventDefault();
	
	var form = document.getElementById('form2');
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'paginas/' + pag + '/divulgar.php', true);

	xhr.onload = function () {
        if (xhr.status === 200) {
            // Importação bem-sucedida, agora listamos os dados
            listar();
        } else {
            console.log('Erro ao importar dados');
        }
    };

    xhr.send(formData);
		
		
	ocultar1();

		
	
});

    });

function divulgar() {
    $('#mensagem2').text('');
    $('#titulo_inserir2').text('Pendência Colaboradores');
    $('#modalForm2').modal('show');
}

function ocultar1(){
	$('#modalForm2').modal('hide');
}
</script>

<script type="text/javascript">

function limparCampos(){
		$('#id').val('');
		$('#data_entrevista').val('');
    	$('#nome').val('');
    	$('#telefone').val('');
    	$('#ids').val('');
    	$('#btn-deletar').hide();	
	}



</script>

<script type="text/javascript">
	function listar(){
	
	var status = $('#buscar-func').val();	

	
    $.ajax({
        url: 'paginas/' + pag + "/listar.php",
        method: 'POST',
        data: {status},
        dataType: "html",

        success:function(result){
            $("#listar").html(result);
            $('#mensagem-excluir').text('');
        }
    });
}
</script>

