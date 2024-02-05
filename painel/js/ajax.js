    $(document).ready(function() {    
        listar();    
    } );

    function listar(p1, p2, p3, p4, p5, p6){	
        $.ajax({
            url: 'paginas/' + pag + "/listar.php",
            method: 'POST',
            data: {p1, p2, p3, p4, p5, p6},
            dataType: "html",

            success:function(result){
                $("#listar").html(result);
                $('#mensagem-excluir').text('');
            }
        });
    }      
    
    function limparCampos(){
        console.log("apareceu!");
    }

    function inserir() {
        $('#mensagem').text('');
        $('#titulo_inserir').text('Inserir Registro');
        $('#modalForm').modal('show');

    }    



    $("#form").submit(function () {

        event.preventDefault();
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


            },

            cache: false,
            contentType: false,
            processData: false,

        });

    });






    function excluir(id){	
        $('#mensagem-excluir').text('')
        showLoading_excluir();
        $.ajax({
            url: 'paginas/' + pag + "/excluir.php",
            method: 'POST',
            data: {id},
            dataType: "html",

            success:function(mensagem){
                
                if (mensagem.trim() == "Excluído com Sucesso") {  

                    listar();
                    hideLoading()
                } else {
                    $('#mensagem-excluir').addClass('text-danger')
                    $('#mensagem-excluir').text(mensagem)
                }
            }
        });
    }





    function ativar(id, acao){	
        $.ajax({
            url: 'paginas/' + pag + "/mudar-status.php",
            method: 'POST',
            data: {id, acao},
            dataType: "html",

            success:function(mensagem){
                if (mensagem.trim() == "Alterado com Sucesso") {

                    listar();
                } else {
                    $('#mensagem-excluir').addClass('text-danger')
                    $('#mensagem-excluir').text(mensagem)
                }
            }
        });
    }

    function showLoading(){
        const div = document.createElement("div");
        div.classList.add("opacity");
        const small = document.createElement("small");
        small.classList.add("loading", "centralize");
        small.textContent = "Carregando";
        small.style.color = "white";
        const updateDiv = document.createElement("div");
        updateDiv.classList.add("update");
        small.appendChild(updateDiv);
        div.appendChild(small);
        document.body.appendChild(div);

    }
    function hideLoading(){
        const loadings = document.getElementsByClassName("opacity");
        if (loadings.length){
            loadings[0].remove();
        }
    }

    function showLoading_excluir(){
        const div = document.createElement("div");
        div.classList.add("opacity");
        const small = document.createElement("small");
        small.classList.add("loading", "centralize");
        small.textContent = "Excluindo";
        small.style.color = "white";
        const updateDiv = document.createElement("div");
        updateDiv.classList.add("update");
        small.appendChild(updateDiv);
        div.appendChild(small);
        document.body.appendChild(div);

    }

