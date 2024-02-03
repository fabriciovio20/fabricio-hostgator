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

<div class="bs-example widget-shadow" style="padding:15px" id="listar"></div>

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
                            <label for="checkbox_data">Programar Envio
                                <span style="margin-right: 5px;"></span>
                                <input type="checkbox" id="checkbox_data" name="checkbox_data">
 
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label for="checkbox_funcionario">Inserir Funcionário
                                <span style="margin-right: 5px;"></span>
                                <input type="checkbox" id="checkbox_funcionario" name="checkbox_funcionario">
 
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5" id="data_envio_container" style="display:none;">							
                            <label>Data Mensagem</label>
                            <input type="datetime-local" class="form-control" id="data_envio" name="data_envio">
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
                        <div class="col-md-8">							
                            <label>Foto</label>
                            <input type="file" class="form-control" id="foto_perfil1" name="foto" value="<?php echo $foto_usuario ?>" onchange="carregarImgPerfil()">							
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">							
                            <label>Mensagem a ser enviada</label>
                            <textarea style="resize: vertical;" class="form-control" id="msg_env" name="msg_env" placeholder="Digite sua mensagem aqui" rows="4"></textarea>						
                        </div>
                        <div class="row">
                        </div>
                    </div>
                
                    <input type="hidden" class="form-control" id="id" name="id">                 
                    <div class="row">
                                                
                        <div class="col-md-6" style="margin-top: 22px">							
                        <button type="submit" class="btn btn-primary">Salvar</button>					
                        </div>
                    </div>

                    <br>
                    <small><div id="mensagem" align="center"></div></small>
                    
                    </div>
                </div>

        
            </form>
        </div>
    </div>
</div>




<div class="modal fade" id="modalFuncionarios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span>					
				</h4>
                <button id="btn-fechar-funcionarios" type="button" class="close" aria-label="Close" style="margin-top: -25px">
                    <span aria-hidden="true">&times;</span>
                </button>
			</div>
			<form id="form_funcionarios">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-8">
                    <select class="sel" name="funcionarios" id="funcionarios" required style="width:100%">
                                <option value="">Selecione um funcionário</option>
                                <?php 
                                    $query = $pdo->query("SELECT * from funcionarios where ativo = 'Sim' order by id asc");
                                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                                    $linhas = @count($res);
                                    if($linhas > 0){
                                        for($i=0; $i < $linhas; $i++){
                                            foreach ($res[$i] as $key => $value){}
                                            echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['registro'].' - '.$res[$i]['nome'].'</option>';
                                        }
                                    }
                                ?>
                            </select>	
					</div>

					<div class="col-md-4">
						<button id="btn_funcionarios" type="submit" class="btn btn-primary">Inserir</button>
					</div>
				</div>

				<div class="row" id="listar_funcionarios">
					
				</div>

				<br>
				<input type="hidden" name="id" id="id_funcionarios">
				<small><div id="mensagem_funcionarios" align="center" class="mt-3"></div></small>		
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
        $('#foto_perfil1').val('');	
        $('#funcionarios').val('Selecione um funcionário');
        $('#checkbox_data').prop('checked', false); // Desmarca o checkbox de programar envio
        $('#data_envio_container').hide();
        $('#checkbox_funcionario').prop('checked', false);
        $('#listar_funcionarios').empty();
    }
</script>

<script type="text/javascript">
    function carregarImgPerfil() {
        var target = document.getElementById('target-usu');
        var file = document.querySelector("#foto_perfil1").files[0];
        
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

<script>
    document.getElementById('checkbox_data').addEventListener('change', function() {
        var dataEnvioContainer = document.getElementById('data_envio_container');
        if (this.checked) {
            // Se o checkbox estiver marcado, mostrar o contêiner
            dataEnvioContainer.style.display = 'block';
        } else {
            // Se o checkbox não estiver marcado, ocultar o contêiner
            dataEnvioContainer.style.display = 'none';
        }
    });
</script>




<script type="text/javascript">
	$(document).ready(function() {
    	$('.sel').select2({
    		dropdownParent: $('#modalFuncionarios')
    	});
	});
</script>


<script type="text/javascript">
	$(document).ready(function() {
        $('#checkbox_funcionario').change(function() {
        if ($(this).is(':checked')) {
            // Se o checkbox estiver marcado, exiba o modal
            $('#modalFuncionarios').modal('show');
        } else {
            // Se o checkbox não estiver marcado, oculte o modal
            $('#modalFuncionarios').modal('hide');
        }
    });

    });
</script>


<script type="text/javascript">
document.getElementById('btn-fechar-funcionarios').addEventListener('click', function() {
    $('#modalFuncionarios').modal('hide');
});

</script>

<script type="text/javascript">
	

$("#form_funcionarios").submit(function () {

	var usuario = $('#id_funcionarios').val();

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/inserir_funcionarios.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem_funcionarios').text('');
            $('#mensagem_funcionarios').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                limparCampos();
                $('#modalFuncionarios').modal('hide');
                $('#funcionarios').val('').trigger('change');
                //$('#btn-fechar-procedimentos').click();
                listarFuncionarios(usuario);          

            } else {

                $('#mensagem_funcionarios').addClass('text-danger')
                $('#mensagem_funcionarios').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});



function listarFuncionarios(id){
	 $.ajax({
        url: 'paginas/' + pag + "/listar_funcionarios.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){
            $("#listar_funcionarios").html(result);            
        }
    });
}
</script>
