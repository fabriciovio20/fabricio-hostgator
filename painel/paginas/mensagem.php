<?php 
$pag = 'mensagem';

if(@$mensagem == 'ocultar'){
	echo "<script>window.location='../index.php'</script>";
    exit();
}

 ?>
<a onclick="inserir(), limpar()" type="button" class="btn btn-primary"><span class="fa fa-plus"></span> Mensagens</a>



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
						<div class="col-md-5">							
								<label>Data Mensagem</label>
								<input type="datetime-local" class="form-control" id="data_envio" name="data_envio" required>							
						</div>
						<div class="col-md-4">							
							<label>Filial</label>
							<select class="form-control" name="filial" id="filial">
								<option value="todos">Todos</option>
								<option value="motores">Motores</option>	
								<option value="cgl">CGL</option>	
								<option value="filtros">Filtros</option>	
							</select>							
						</div>
						<div class="row">
						<div class="col-md-8">							
								<label>Foto</label>
								<input type="file" class="form-control" id="foto_perfil" name="foto" value="<?php echo $foto_usuario ?>" onchange="carregarImgPerfil()">							
						</div>
						<div class="col-md-4">								
							<img src="images/perfil/sem-foto.jpg"  width="80px" id="target-usu">								
							
						</div>
						<div class="row">
						<div class="col-md-12">							
								<label>Mensagem a ser enviada</label>
								<textarea style="resize: vertical;" class="form-control" id="msg_env" name="msg_env" placeholder="Digite sua mensagem aqui" rows="4"></textarea>						
						</div>

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





<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>


<script>
        function limpar(){
		$('#id').val('');		
		$('#data_envio').val('');
		$('#filial').val('todos');
		$('#msg_env').val('');		
		$('#target-usu').attr('src', 'images/perfil/sem-foto.jpg');			
        }
</script>


<script type="text/javascript">
	function carregarImgPerfil() {
    var target = document.getElementById('target-usu');
    var file = document.querySelector("#foto_perfil").files[0];
    
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>


