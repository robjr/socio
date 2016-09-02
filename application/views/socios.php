<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Projeto Sócio</title>
        <meta name="description" content="###############">

        <link rel="stylesheet" type="text/css" href="<?=base_url()?>interface_components/css/semantic.min.css">
        <style>
            .hidden{
                display:none !important;
            }
            
            .novo {
                    background-color: darkseagreen !important;
                    display: block !important;
                    border: 1px black !important;
                    border-radius: 5px !important;
            }
            
            .editar {
                    background-color: #e6bb48 !important;
                    display: block !important;
                    border: 1px black !important;
                    border-radius: 5px !important;
            }
            
        </style>
    </head>
    <body>
      
        <main id="container">

           <div class="ui left fixed vertical menu" style="background-color: rgba(0,0,0,.85); padding-left: 15px; padding-right: 15px;">
               <div style="width: 100%; text-align: center; padding-top: 50px; padding-bottom: 75px;">
                   <i class="massive inverted user icon" ><p style="font-size: 25px;"><b>Sócio</b></p></i>
                   
               </div>
               
               <a href="<?=base_url('socios')?>" class="ui fluid button" style="background-color: white;">Sócios</a>
               <br>
               <a href="<?=base_url('empresas')?>" class="ui fluid button" style="background-color: white;">Empresas</a>
               <br>
               <a href="<?=base_url('index/logout')?>" class="ui fluid black inverted button">Logout</a>
            </div>
           
            
            <div id="content" style="margin-left: 210px; padding: 50px;">
                <div class="ui positive message hidden sucesso" id="sucesso-messages">
                    <i class="close icon"></i>
                    <div class="header">
                        <b>Tudo certo, vamos em frente!</b>
                    </div>
                    <ul class="list">
                    </ul>
                </div>
                <div class="ui negative message hidden erro" id="error-messages">
                    <i class="close icon"></i>
                    <div class="header">
                        <b>Erro!</b>
                    </div>
                    <ul class="list">
                    </ul>
                </div>
                <p><b style="font-size: 22px; margin-right: 15px;">Sócios</b> <button class="ui primary button" onclick="adicionar()">Adicionar novo</button> </p>
                <br>
                <div class="ui icon fluid input">
                    <input id="cpfSearch" type="text" placeholder="Digite o CPF para pesquisar por sócio...">
                    <i class="search icon"></i>
                </div>
                <br>
            
                <section id="dados" class="ui middle aligned divided selection list" id="list">
                    <a class="item hidden" style="display: block" href="#" >
                        <div style="display: table; table-layout: fixed; min-width: 100%;" data-id="">
                            <div style="display: table-row;">
                                <div class="content ui middle align" style="width: 7%; display: table-cell;">
                                    <img class="ui middle align circular tiny image" src="<?=base_url("images/perfil-photo.jpg")?>">
                                </div>
                                <div class="content ui middle align" style="display: table-cell; padding-left: 20px; width: 33%;">
                                    <div class="ui header nome"></div>
                                    <div class="description email"></div>
                                    <div class="description cpf"></div>
                                </div>
                                <div class="content ui middle align" style="display: table-cell; padding-left: 20px;width: 60%">
                                    <button class="circular ui icon button" data-id="" onclick="editar(this)">
                                      <i class="icon edit"></i>
                                    </button>
                                    <button class="circular ui icon button" data-id="" onclick="apagar(this)">
                                      <i class="white icon delete"></i>
                                    </button>
                                 </div>
                            </div>
                        </div>
                    </a>
                </section>
                <section class="center aligned">
                    <h4>Páginas</h4>
                    <div class="ui pagination menu">
                        <a class="hidden item" onclick="nextPage(this)">1</a>
                    </div>
                </section>
            </div>
        </main>
        
        
<div id="insercao" class="ui modal">
  <i class="close icon"></i>
  <div class="header">
    Sócio
  </div>
  <div class="image content">
    <div class="image">
      <i class="add user icon"></i>
    </div>
    <div class="description">
      <div class="ui form">
        <div class="field">
          <label>Nome</label>
          <input type="text" class="nome" size="50">
        </div>
        <div class="field">
          <label>Email</label>
          <input type="email" class="email" size="30">
        </div>
        <div class="field" size="20">
          <label>CPF</label>
          <input type="text" class="cpf">
        </div>
      </div>
    </div>
  </div>
  <div class="actions">
    <div class="two fluid ui buttons">
      <div class="ui cancel grey basic button">
        <i class="remove icon"></i>
        Cancelar
      </div>
      <div class="ui approve green button">
        <i class="checkmark icon"></i>
        Inserir
      </div>
    </div>
  </div>
</div>

<div id="edicao" class="ui modal">
  <i class="close icon"></i>
  <div class="header">
    Sócio
  </div>
  <div class="image content">
    <div class="image">
      <i class="edit icon"></i>
    </div>
    <div class="description">
      <div class="ui form">
        <div class="field">
          <label>Nome</label>
          <input type="text" class="nome" size="50">
          <input type="hidden" class="id">
        </div>
        <div class="field">
          <label>Email</label>
          <input type="email" class="email" size="30">
        </div>
        <div class="field" size="20">
          <label>CPF</label>
          <input type="text" class="cpf">
        </div>
      </div>
    </div>
  </div>
  <div class="actions">
    <div class="two fluid ui buttons">
      <div class="ui cancel grey basic button">
        <i class="remove icon"></i>
        Cancelar
      </div>
      <div class="ui approve yellow button">
        <i class="checkmark icon"></i>
        Editar
      </div>
    </div>
  </div>
</div>
        
<div id="delecao" class="ui basic modal">
  <i class="close icon"></i>
  <div class="header">
    Atenção!
  </div>
  <div class="image content">
    <div class="image">
      <i class="minus circle icon"></i>
    </div>
    <div class="description">
      <p>Tem certeza que deseja deletar este item?</p>
    </div>
  </div>
  <div class="actions">
    <div class="two fluid ui inverted buttons">
      <div class="ui cancel green basic inverted button">
        <i class="remove icon"></i>
        Não
      </div>
      <div class="ui approve red basic inverted button">
        <i class="checkmark icon"></i>
        Sim
      </div>
    </div>
  </div>
</div>
        
        <script src="<?=base_url()?>interface_components/js/jquery.min.js"></script>
        <script src="<?=base_url()?>interface_components/js/semantic.min.js"></script>
    </body>
</html>

<script>

    var cpfSearch = "";
    
    $("#cpfSearch").keyup(function (){
         cpfSearch = this.value;
         ler('1');
    });
    
    function createPagination(total){
        
        var pagination = $(".pagination");
        var item =  $(".pagination .hidden").first();
        pagination.children("a").not(".hidden").remove();

        for(var i = 1; i <= total; i++){
            var newItem = item.clone();
            newItem.html(i).removeClass("hidden");
            newItem.appendTo(pagination);
        }
        
    }
    
    function nextPage(link){
        
        $(link).toggleClass("active");
        var page = $(link).html();
        ler(page);
        
    }
    
    function ler(page) {

        $.ajax({
            url: '<?=base_url(); ?>socios/ler/' + page + '/' + cpfSearch 
        }).done(function (obj) {
            
            if (obj.hasOwnProperty("erro")) {
                $(".erro").removeClass("hidden").addClass("visible").find('.list').html(obj.erro);
                $("html, body").animate({ scrollTop: 0 }, "slow");
            }else if(obj.hasOwnProperty("sucesso")){
                
                var section = $("#dados");
                var item = $("#dados .hidden").first();
                section.children("a").not(".hidden").remove();
                
                createPagination(obj.paginas + 1);
                
                $(obj.socios).each(function(elem){
                    var newItem = item.clone();
                    newItem.removeClass("hidden");
                    newItem.find('.nome').first().html(this.nome);
                    newItem.find('.cpf').first().html("CPF " + this.cpf);
                    newItem.find('.email').first().html(this.email);
                    newItem.find('*[data-id]').attr('data-id',this.id);
                    newItem.appendTo(section);
                });
                
            }
        });
    }
    
    function adicionar(botao){
        $('#insercao').modal({
                onApprove : function() {
                    
                    var nome = $("#insercao .nome");
                    var email =  $("#insercao .email");
                    var cpf  = $("#insercao .cpf");
                    
                    $.ajax({
                        url: '<?=base_url(); ?>socios/adicionar',
                        data: { 
                            nome : nome.val() ,
                            email : email.val(),
                            cpf : cpf.val() 
                            },
                        method: 'POST'
                    }).done(function (obj) {
                        
                        if (obj.hasOwnProperty("erro")) {
                            $(".erro").removeClass("hidden").addClass("visible").find('.list').html(obj.erro);
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                        }else if(obj.hasOwnProperty("sucesso")){

                            var section = $("#dados");
                            var item = $("#dados .hidden").first();
                            //section.children("a").not(".hidden").last().remove();

                            var newItem = item.clone();
                            newItem.removeClass("hidden");
                            newItem.addClass("novo");
                            newItem.find('.nome').first().html(nome.val());
                            newItem.find('.cpf').first().html("CPF " + cpf.val());
                            newItem.find('.email').first().html(email.val());
                            newItem.find('*[data-id]').attr('data-id',obj.id);
                            newItem.prependTo(section);
                        }
                                
                    });
                  }
                }).modal('show');
    }
    
    function editar(botao){
        
        $('#edicao').modal({
                onVisible: function(){
                    var item = $(botao).closest("a");

                    var id = $(botao).attr("data-id");
                    var nomeOriginal = $(item).find(".nome").text();
                    var emailOriginal = $(item).find(".email").text();
                    var cpfOriginal = $(item).find(".cpf").text().replace("CPF ", "");
                    
                    $("#edicao .nome").attr("data-old",nomeOriginal).val(nomeOriginal);
                    $("#edicao .cpf").attr("data-old",cpfOriginal).val(cpfOriginal);
                    $("#edicao .email").attr("data-old",emailOriginal).val(emailOriginal);
                    $("#edicao .id").val(id);
                    
                },
                onApprove : function() {
                    var campos = {};

                    var id = $("#edicao .id").val();
                    var nome = $("#edicao .nome").val();
                    var email =  $("#edicao .email").val();
                    var cpf  = $("#edicao .cpf").val();
                    
                    var emailOriginal = $("#edicao .email").attr("data-old");
                    var cpfOriginal = $("#edicao .cpf").attr("data-old");
                    
                    campos.id = id;
                    campos.nome = nome;
                    
                    if(email !== emailOriginal)
                        campos.email = email;
                    
                    if(cpf !== cpfOriginal)
                        campos.cpf = cpf;
                    
                    $.ajax({
                        url: '<?=base_url(); ?>socios/editar',
                        data: campos,
                        method: 'POST'
                    }).done(function (obj) {
                        
                        if (obj.hasOwnProperty("erro")) {
                            $(".erro").removeClass("hidden").addClass("visible").find('.list').html(obj.erro);
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                        }else if(obj.hasOwnProperty("sucesso")){
                            var item = $("#dados a div[data-id=" + id + "]").first();
                            
                            $(item).addClass("editar");
                            
                            $(item).find(".nome").html(campos.nome);
                            $(item).find(".cpf").html(campos.cpf);
                            $(item).find(".email").html(campos.email);
                            
                        }
                                
                    });
                  }
                }).modal('show');
    }
    
    function apagar(botao){
        $('#delecao').modal({
                onApprove : function() {
                    $.ajax({
                        url: '<?=base_url(); ?>socios/deletar',
                        data: { id : $(botao).attr('data-id') },
                        method: 'POST'
                    }).done(function (obj) {
                        
                        if (obj.hasOwnProperty("erro")) {
                            $(".erro").removeClass("hidden").addClass("visible").find('.list').html(obj.erro);
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                        }else if(obj.hasOwnProperty("sucesso")){
                            $(botao).closest("a").remove();
                        }
                    });
                  }
                }).modal('show');
    }
    
    $(document).ready(function(){
        
         createPagination(1);
         
        var pagChildren = $(".pagination").children("a").not(".hidden");
        pagChildren.first().click();       
        
        
        $('.message .close').on('click', function() {
            $(this).closest('.message').transition('fade');
        });
        
    });
</script>