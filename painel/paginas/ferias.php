<?php 
$pag = 'ferias';
@session_start();
if(@$ferias == 'ocultar'){
	echo "<script>window.location='../index.php'</script>";
    exit();
}

$nivel_usuario = @$_SESSION['nivel'];




 ?>
 <body>

 <link rel="stylesheet" type="text/css" href="css/style.css">

<a onclick="inserir(), limpar()" type="button" class="btn btn-primary"><span class="fa fa-plus"></span> Ferias</a>



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
			<form method="post" id="form-text">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-12">							
							<label>Registro</label>
							<select class="form-control sel2" id="funcionario" name="funcionario" style="width:100%;" required> 
								
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
								<label>Data Inicio</label>
								<input type="date" class="form-control" id="data_ini" name="data_ini" placeholder="Data Inicial" required>						
						</div>
						<div class="col-md-4">							
								<label>Qntd Dias</label>
								<input type="number" class="form-control" id="qntd_dias" name="qntd_dias" placeholder="Qntd Dias" required>						
						</div>
							<div class="<?php echo ($nivel_usuario != 'Administrador') ? 'ocultar' : ''; ?>">
								<div class="col-md-4">
										<label>Status</label>
										<select class="form-control" name="status1" id="status1">
											<option value="Pendente">Pendente</option>
											<option value="Confirmado">Confirmado</option>
											<option value="Reprovado">Reprovado</option>
										</select>						
								</div>
							</div>
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
				
				<small><div class="msajax"id="mensagem" align="center"></div></small>
			</div>
			
			</form>
		</div>
	</div>
</div>
</body>


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
    $(document).ready(function () {

        $("#form-text").submit(function () {

            $('#mensagem').text('');
            $('#btn_salvar').hide();
            event.preventDefault();

            // Adiciona a verificação da data de início aqui
            if (verificarDataInicio()) {
                var formData = new FormData(this);
				showLoading();
                $.ajax({
                    url: 'paginas/' + pag + "/salvar.php",
                    type: 'POST',
                    data: formData,

                    success: function (mensagem) {

                        $('#mensagem').text('');
                        $('#mensagem').removeClass()
                        if (mensagem.trim() == "Salvo com Sucesso") {
                            $('#btn-fechar').click();
                            listar();
                            hideLoading()
                        } else {
                            $('#mensagem').addClass('text-danger')
                            $('#mensagem').text(mensagem)
                            hideLoading()
                        }

                        $('#btn_salvar').show();

                    },

                    cache: false,
                    contentType: false,
                    processData: false,

                });
            }
        });

        // Função para verificar se a data de início é menor que a data atual
        function verificarDataInicio() {
            var dataInicio = $('#data_ini').val();
            var dataAtual = new Date().toISOString().split('T')[0];
			var novaData = new Date(dataAtual);
			novaData.setDate(novaData.getDate() + 30);
			var novaDataFormatada = novaData.toISOString().split('T')[0];

            if (dataInicio < dataAtual) {
                // Exibe mensagem de erro com estilo
				alert("Data menor que atual, favor realizar alteração!!")
                return false; // Impede o envio do formulário
            }else if (dataInicio < novaDataFormatada){

				alert("Favor procurar RH, programação férias menor que 30 dias!!");
				return false;
			}


            return true; // Permite o envio do formulário
			
        }
    });
</script>


<script>
        function limpar(){
		$('#id').val('');		
		$('#funcionario').val('').change();
		$('#status1').val('Pendente')
		$('#data_ini').val('');				
		$('#qntd_dias').val('');	
		$('#ult_modi').val('');	
            }
</script>	
