<?php 
$pag = 'funcionarios_inativos';
@session_start(); // Iniciar a sessão

if(@$funcionarios == 'ocultar'){
	echo "<script>window.location='../index.php'</script>";
    exit();
}

 ?>
<a onclick="inserir()" type="button" class="btn btn-primary"><span class="fa fa-plus"></span> Funcionário</a>
<a onclick="importar()" type="button" class="btn btn-primary"><span class="fa fa-plus"></span> Importar</a>
<a onclick="inativar()" type="button" class="btn btn-danger"><span class="fa fa-plus"></span> Inativar em Massa</a>



<li class="dropdown head-dpdn2" style="display: inline-block;">		
		<a href="#" data-toggle="dropdown"  class="btn btn-danger dropdown-toggle" id="btn-deletar" style="display:none"><span class="fa fa-trash-o"></span> Deletar</a>

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
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
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
								<label>Telefone</label>
								<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Seu Telefone" required>							
						</div>
						

						<div class="col-md-6">							
								<label>Nível</label>
								<select class="form-control" name="nivel" id="nivel" required>
								 <?php 
									$query = $pdo->query("SELECT * from cargos order by id asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$linhas = @count($res);
									if($linhas > 0){
									for($i=0; $i<$linhas; $i++){
								 ?>
								  <option value="<?php echo $res[$i]['nome'] ?>"><?php echo $res[$i]['nome'] ?></option>

								<?php } }else{ ?>
									<option value="">Cadastre um Cargo</option>
								<?php } ?>
								</select>							
						</div>


						
					</div>

					<div class="row">

						<div class="col-md-5">							
								<label>Filial</label>
								<select class="form-control" name="filial" id="filial">
									<option value="motores">Motores</option>
									<option value="cgl">CGL</option>
									<option value="filtros">Filtros</option>
								</select>								
						</div>

						<div class="col-md-7">							
								<label>CPF</label>
								<input type="text" class="form-control" id="cpf" name="cpf" placeholder="Seu CPF"  >							
						</div>
					</div>

					<div class="row">

						<div class="col-md-12">							
								<label>E-mail</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Insira seu E-mail"  >							
						</div>
					</div>

					<input type="hidden" class="form-control" id="id" name="id">					

				<br>
				<small><div id="mensagem" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
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
						<span><b>Telefone: </b></span><span id="telefone_dados"></span>
					</div>
					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>registro: </b></span><span id="registro_dados"></span>
					</div>

					
					<div class="col-md-8" style="margin-bottom: 5px">
						<span><b>Email: </b></span><span id="email_dados"></span>
					</div>


					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Nível: </b></span><span id="nivel_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Ativo: </b></span><span id="ativo_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Data Cadastro: </b></span><span id="data_dados"></span>
					</div>

					<div class="col-md-12" style="margin-bottom: 5px">
						<span><b>cpf: </b></span><span id="cpf_dados"></span>
					</div>

					<div class="col-md-12" style="margin-bottom: 5px">
						<span><b>E-mail: </b></span><span id="email_dados"></span>
					</div>

					<div class="col-md-12" style="margin-bottom: 5px">
						<div align="center"><img src="" id="foto_dados" width="200px"></div>
					</div>
				</div>
			</div>
					
		</div>
	</div>
</div>






<!-- Modal Permissoes -->
<div class="modal fade" id="modalPermissoes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="nome_permissoes"></span>

					<span style="position:absolute; right:35px">
						<input class="form-check-input" type="checkbox" id="input-todos" onchange="marcarTodos()">
						<label class="" >Marcar Todos</label>
					</span>

				</h4>
				<button id="btn-fechar-permissoes" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
				<div class="row" id="listar_permissoes">
					
				</div>

				<br>
				<input type="hidden" name="id" id="id_permissoes">
				<small><div id="mensagem_permissao" align="center" class="mt-3"></div></small>		
			</div>
					
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
								<label>Importar Dados</label>
								<input type="file" class="form-control" id="arq_inat" name="arq_inat" accept="text/csv">							
						</div>
						
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
    xhr.open('POST', 'paginas/funcionarios/importar.php', true);

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
        inativar();
		ocultar1();
});

    });

function inativar() {
    $('#mensagem2').text('');
    $('#titulo_inserir2').text('Inserir Registro');
    $('#modalForm2').modal('show');

    var form = document.getElementById('form2');
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'paginas/funcionarios/inativar.php', true);

    xhr.send(formData);

}

function ocultar1(){
	$('#modalForm2').modal('hide');
}
</script>

