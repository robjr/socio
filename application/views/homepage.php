<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Projeto Sócio</title>
        <meta name="description" content="###############">
        
        <link rel="stylesheet" type="text/css" href="interface_components/css/semantic.min.css">
        <link rel="stylesheet" type="text/css" href="interface_components/css/style.css">
        
    </head>
    <body>
        
        <main id="container">
            <div class="ui grid" id="content">
                        
                <div class="eight wide column" id="socio-left" style="position: relative; background-color: #2a2a2a; border-radius: 0px;">
                    <div class="middle-centered-box">
                        <i class="massive inverted users icon"></i>
                        <p style="color: white; font-size: 40px;"><b>Sócio</b></p>
                    </div>
                </div>
                
                <div class="eight wide column" id="socio-right" style="position: relative; background-color: #52B6CA; border-radius: 0px;">
                    <div class="middle-centered-box">
                        <div class="login-container" style="width: 400px; padding: 50px;">
                            <form id="#login-form" class="ui large form" method="POST" action="javascript:void();">
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                <div class="ui negative message hidden erro" id="error-messages">
                                    <i class="close icon"></i>
                                    <div class="header">
                                        <b>Erro!</b>
                                    </div>
                                    <ul class="list">
                                    </ul>
                                </div>
                                <div>
                                    <div class="field">
                                      <div class="ui left icon input">
                                        <i class="user icon"></i>
                                        <input type="text" name="username" placeholder="Nome de usuário">
                                      </div>
                                    </div>
                                    <div class="field">
                                      <div class="ui left icon input">
                                        <i class="lock icon"></i>
                                        <input type="password" name="password" placeholder="Senha">
                                      </div>
                                    </div>
                                    <button type="submit" class="ui big fluid teal submit button" onclick="sendForm('login-form', 'index/logar');">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </main>
        <script src="interface_components/js/jquery.min.js"></script>
        <script src="interface_components/js/semantic.min.js"></script>
    </body>
</html>

<script>
    
   function sendForm(formId, formUrl) {
        $("#"+formId + " .submit").addClass("loading");
        var formObj = new FormData(document.getElementById('#' + formId));
        
        $.ajax({
            url: "<?php echo base_url(); ?>" + formUrl,
            data: formObj,
            method: 'POST',
            cache:false,
            contentType: false,   
            processData:false
        }).done(function (obj) {
            if (obj.hasOwnProperty("erro")) {
                $("#"+formId + " .submit").removeClass("loading");
                $(".erro").removeClass("hidden").addClass("visible").find('.list').html(obj.erro);
            }
            else if(obj.hasOwnProperty("redirect")){
                window.location.href = obj.redirect;
            }
        });
    }
    
    $(document).ready(function(){
        
        $('.message .close').on('click', function() {
            $(this).closest('.message').transition('fade');
        });
        
    });
</script>