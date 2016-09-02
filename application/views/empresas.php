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
                <p><b style="font-size: 22px; margin-right: 15px;">Empresas</b> <button class="ui primary button" onclick="adicionar()">Adicionar nova</button> </p>
                <br>
                <div class="ui icon fluid input">
                    <input id="cnpjSearch" type="text" placeholder="Digite o CNPJ para pesquisar por empresa...">
                    <i class="search icon"></i>
                </div>
                <br>
            
                <section id="dados" class="ui middle aligned divided selection list" id="list">
                    <a class="item hidden" style="display: block" href="#" >
                        <div style="display: table; table-layout: fixed; min-width: 100%;" data-id="">
                            <div style="display: table-row;">
                                <div class="content ui middle align" style="width: 7%; display: table-cell;">
                                    <img class="ui middle align circular tiny image" src="<?=base_url("images/company.png")?>">
                                </div>
                                <div class="content ui middle align" style="display: table-cell; padding-left: 20px; width: 33%;">
                                    <div class="description cnpj"></div>
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
    Empresa
  </div>
  <div class="image content">
    <div class="image">
      <i class="add user icon"></i>
    </div>
    <div class="description">
      <div class="ui form">
        <div class="field" size="20">
          <label>CNPJ</label>
          <input type="text" class="cnpj">
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
    Empresa
  </div>
  <div class="image content">
    <div class="image">
      <i class="edit icon"></i>
    </div>
    <div class="description">
      <div class="ui form">
        <div class="field" size="20">
          <label>CNPJ</label>
          <input type="text" class="cnpj">
          <input type="hidden" class="id">
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

    var cnpjSearch = "";
    
    $("#cnpjSearch").keyup(function (){
         cnpjSearch = this.value;
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
            url: '<?=base_url(); ?>empresas/ler/' + page + '/' + cnpjSearch 
        }).done(function (obj) {
            
            if (obj.hasOwnProperty("erro")) {
                $(".erro").removeClass("hidden").addClass("visible").find('.list').html(obj.erro);
                $("html, body").animate({ scrollTop: 0 }, "slow");
            }else if(obj.hasOwnProperty("sucesso")){
                
                var section = $("#dados");
                var item = $("#dados .hidden").first();
                section.children("a").not(".hidden").remove();
                
                createPagination(obj.paginas + 1);
                
                $(obj.empresas).each(function(elem){
                    var newItem = item.clone();
                    newItem.removeClass("hidden");
                    newItem.find('.cnpj').first().html("CNPJ " + this.cnpj);
                    newItem.find('*[data-id]').attr('data-id',this.id);
                    newItem.appendTo(section);
                });
                
            }
        });
    }
    
    function adicionar(botao){
        $('#insercao').modal({
                onApprove : function() {
                    
                    var cnpj  = $("#insercao .cnpj");
                    
                    $.ajax({
                        url: '<?=base_url(); ?>empresas/adicionar',
                        data: { 
                            cnpj : cnpj.val() 
                            },
                        method: 'POST'
                    }).done(function (obj) {
                        
                        if (obj.hasOwnProperty("erro")) {
                            $(".erro").removeClass("hidden").addClass("visible").find('.list').html(obj.erro);
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                        }else if(obj.hasOwnProperty("sucesso")){

                            var section = $("#dados");
                            var item = $("#dados .hidden").first();

                            var newItem = item.clone();
                            newItem.removeClass("hidden");
                            newItem.addClass("novo");
                            newItem.find('.cnpj').first().html("CNPJ " + cnpj.val());
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
                    var cnpjOriginal = $(item).find(".cnpj").text().replace("CNPJ ", "");
                    
                    $("#edicao .cnpj").attr("data-old",cnpjOriginal).val(cnpjOriginal);
                    $("#edicao .id").val(id);
                    
                },
                onApprove : function() {
                    var campos = {};

                    var id = $("#edicao .id").val();
                    var cnpj  = $("#edicao .cnpj").val();
                    
                    var cnpjOriginal = $("#edicao .cnpj").attr("data-old");
                    
                    campos.id = id;

                    if(cnpj !== cnpjOriginal)
                        campos.cnpj = cnpj;
                    
                    $.ajax({
                        url: '<?=base_url(); ?>empresas/editar',
                        data: campos,
                        method: 'POST'
                    }).done(function (obj) {
                        
                        if (obj.hasOwnProperty("erro")) {
                            $(".erro").removeClass("hidden").addClass("visible").find('.list').html(obj.erro);
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                        }else if(obj.hasOwnProperty("sucesso")){
                            var item = $("#dados a div[data-id=" + id + "]").first();
                            
                            $(item).addClass("editar");
                            
                            $(item).find(".cnpj").html(campos.cnpj);
                            
                        }
                                
                    });
                  }
                }).modal('show');
    }
    
    function apagar(botao){
        $('#delecao').modal({
                onApprove : function() {
                    $.ajax({
                        url: '<?=base_url(); ?>empresas/deletar',
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