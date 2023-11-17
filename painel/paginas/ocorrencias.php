<?php 
$pag = 'ocorrencias';
@session_start();
if(@$ferias == 'ocultar'){
	echo "<script>window.location='../index.php'</script>";
    exit();
}

$nivel_usuario = @$_SESSION['nivel'];




 ?>
<a onclick="inserir(); limpar()" type="button" class="btn btn-primary"><span class="fa fa-plus"></span> Ocorrências</a>



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
						<div class="col-md-12">							
							<label>Registro</label>
							<select class="form-control sel2" id="funcionario" name="funcionario" style="width:100%;"> 
								
								<option value="">Selecione um colaborador</option>
											
								<?php 
								$query = $pdo->query("SELECT * FROM pacientes ORDER BY id desc");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								$total_reg = @count($res);
								if($total_reg > 0){
									for($i=0; $i < $total_reg; $i++){
										foreach ($res[$i] as $key => $value){}
										echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['registro'].' - '.$res[$i]['nome'].'</option>';
									}
								}
								?>


							</select>									
						</div>
					</div>

						<div class="row">
						<div class="row">

						<div class="col-md-4">							
								<label>Data Ocorrencia</label>
								<input type="date" class="form-control" id="data_oco" name="data_oco" placeholder="Data Ocorrencia" required>						
						</div>
						<div class="col-md-5">							
							<label>Tipo Ocorrencia</label>
							<select class="form-control" name="tipo_oco" id="tipo_oco">
								<option value="ausencia_marcacao">Ausência de Marcação</option>
								<option value="falta_nao_tratada">Faltas Não Tratadas</option>
								<option value="atraso_entrada">Atraso na entrada</option>
								<option value="saida_antecipada">Saida Antecipada</option>
							</select>						
						</div>					
							<div class="<?php echo ($nivel_usuario != 'Administrador') ? 'ocultar' : ''; ?>">
								<div class="col-md-3">
										<label>Status</label>
										<select class="form-control" name="status1" id="status1">
											<option value="Pendente">Pendente</option>
											<option value="Confirmado">Confirmado</option>
											<option value="Reprovado">Reprovado</option>
										</select>						
								</div>
							</div>


						<div class="row">

						<div class="col-md-12">							
								<label>Observações</label>
								<input type="text" class="form-control" id="obs" name="obs" placeholder="Observações a serem acrescentadas">						
						</div>

						<div class="row">
						

						<div class="col-md-10">							
								<label>Ultima Modificação</label>
								<input type="text" class="form-control" id="ult_modi" name="ult_modi" disabled="disabled">					
						</div>

						


						<div class="col-md-6" style="margin-top: 22px">							
								<button type="submit" class="btn btn-primary">Salvar</button>					
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

<script type="text/javascript">
	$(document).ready(function() {
	$('.sel2').select2({
		dropdownParent: $('#modalForm')
		});
	});
</script>


<script>
        function limpar(){
		$('#id').val('');		
		$('#funcionario').val('').change();
		$('#data_oco').val('')
		$('#tipo_oco').val('ausencia_marcacao')			
		$('#status1').val('Pendente');				
		$('#obs').val('');	
		$('#ult_modi').val('');	
            }
</script>
