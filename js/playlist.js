var musicaSelecionadaAdd;
var playlistSelecionadaAdd;

$(document).on("click", ".add-playlist", function(){
    musicaSelecionadaAdd = $(this).data("index");
});

$(document).on("click", ".playlist-item", function(){
    playlistSelecionadaAdd = $(this).data("index");
    addOnPlaylist();
    $(".modal-close").trigger('click');
});

$(document).on("click", ".nova-playlist-btn", function(){
    var nomeNovaPlaylist = $(".nova-playlist-nome").val();
    if(nomeNovaPlaylist.length > 0){
        novaPlaylist(nomeNovaPlaylist);
        setTimeout(function(){
            $(".modal-close").trigger('click');
            $(".add-playlist").trigger('click');
        }, 2000);
    } else {
        $('<span>Insira um valor válido</span>').insertAfter('.nova-playlist-nome');
    }
});

function novaPlaylist(nome){
    $.ajax({
        url:"autoload/Helper/playlist.php",
        data:{nomeNovaPlaylist: nome},
        type: "POST",
        dataType: "text",
        success:function(response){
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });
}

function addOnPlaylist(){
    return $.ajax({
        url:"autoload/Helper/playlist.php",
        data:{playlistSelecionadaAdd: playlistSelecionadaAdd, musicaSelecionadaAdd: musicaSelecionadaAdd},
        type: "POST",
        dataType: "text",
        success:function(response){
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });
}

function refreshModalPlaylist(){
    setTimeout(function(){
        buscaPlaylist();
        if($('.playlist-item').length > 0){
            $('.playlist-item').remove();
        }
        for(let i=0; i<arrayPlaylistPk.length; i++){
            $(".playlist.list-playlist").append(
                '<a href="#" class="playlist-item" data-index="'+ arrayPlaylistPk[i] +'">'+
                '<i class="fas fa-music"></i>'+
                '<span>' + arrayPlaylistName[i] +'</span>'+
                '</a>'
                )
        }
    }, 500);
}

function buscaPlaylist(){
        $.ajax({
            url:"autoload/Helper/types.php",
            data:{tipoSelecionadoUser: 'Playlist'},
            type: "POST",
            dataType: "json",
            success:function(response){
                arrayPlaylistName = [];
                arrayPlaylistPk = [];
                if(response.length > 0){
                    for(let i=0; i<response.length; i++){
                        arrayPlaylistName.push(response[i].namePlaylist); 
                        arrayPlaylistPk.push(response[i].pkPlaylist); 
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
}

$('.add-playlist').on('click', function(e){
    buscaPlaylist();
        var addPlaylistModal = new Modal({
            class:'addPlaylistModal',
            title:'Adicionar à Playlist',
            body:
            '<div class="playlist list-playlist">'+
            '</div>'+
            '<div class="nova-playlist">'+
            '<a href="#">'+
            '<i class="fas fa-plus-square"></i>'+
            '<span>Nova Playlist</span>'+
            '</a>'+
            '</div>'+
            '<div class="adicionar-playlist click-off">'+
            '<label for="nome-playlist">Nome da Playlist:</label>'+
            '<input type="text" class="nova-playlist-nome">'+
            '<button class="nova-playlist-btn" type="submit"><i class="fas fa-check"></i></button>'+
            '</div>',
            size: 'big'
        });
        addPlaylistModal.open();
    
    refreshModalPlaylist();


});