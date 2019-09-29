$(document).on('click', '.btn-entrar', function(){        
    var entrarModal = new Modal({
        class:'entrar-modal',
        title:'Entrar',
        body:'<form class="form-index" action="autoload/classes/Action/userAC.php" method="post">'+
        '<label class="form-index-label" for="nickname-login">Nickname:</label>'+
        '<input class="form-index-input" type="text" name="nickname-login">'+
        '<label class="form-index-label" for="senha-login">Senha:</label>'+
        '<input class="form-index-input" type="password" name="senha-login">'+
        '<a href="esqueceu-senha.php">Esqueci a senha</a>'+
        '<button class="index-btn" type="submit">Entrar</button>'+
        '</form>',
        size: 'small',
        
    });
    entrarModal.open();

});





