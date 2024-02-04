<?php 
$pag = 'mensagem_candidato';

if(@$mensagem_candidato == 'ocultar'){
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
                        <div class="row"></div>
                        <div class="col-md-5" id="data_envio_container" style="display:none;">							
                            <label>Data Mensagem</label>
                            <input type="datetime-local" class="form-control" id="data_envio" name="data_envio">
                        </div>
                        <div class="col-md-5">							
                            <label>Data Entrevista</label>
                            <input type="date" class="form-control" id="data_entrevista" name="data_entrevista">
                        </div>
                    </div>
                    <div class="row">
                        
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
