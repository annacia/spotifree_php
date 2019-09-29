//Feed
var btnTypeFeed = $('#type-feed');
var btnTypeCategory = $('#type-category');
var menuCategorias = $('.menu-principal-categorias.menu-item-pack');
var menuCategoriasOpt = $('.menu-principal-categorias.menu-item-pack .sub-menu-item a');
var divFeedMusics = $('#feed-musics-selecteds');

var btnTipoSelecionado = $('#type-playlist');
var tipoSelecionado = 'Album';
var btnNomeSelecionado = $('#options-selecteds');
var nomeSelecionado = btnNomeSelecionado.find('option:selected').text();
var divPlaylist = $('.playlist');

var tipo = 'Meu Feed';
var categoria = 'Categorias';

var musicClickUser = $('.music-click-user');
var albumClickUser = $('.album-click-user');
var playlistClickUser = $('.playlist-click-user');
var musicClickUserDel = '.delete-music';

var selecaoAtual = [];

var selecaoStandBy = [];

var nomeMusica = [];
var ownerMusica = [];
var albumMusica = [];
var dir_foto = [];
var pk_Musica = [];

var arrayPlaylistName = [];
var arrayPlaylistPk = [];

var sessaoNickname = '';

function deletaMusica(elemento){
    var idMusicToDel = elemento.data("index");
    $.ajax({
        url:"autoload/classes/musicadao.php",
        data:{idMusicDelete: idMusicToDel},
        type: "POST",
        dataType: "text",
        success:function(){
            setTimeout(function(){
                location.reload();
            }, 1000);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });
}

function getSessao(){
    var sessao = "true";
    $.ajax({
        url:"autoload/classes/Action/userAC.php",
        data:{sessao: sessaoNickname},
        type: "POST",
        dataType: "text",
        success: function(response){
            sessaoNickname = response;
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    })
}


function albumClickUserFunction(elemento){
    var name = elemento.text();
    $.ajax({
        url:"autoload/Helper/playlist.php",
        data:{nameAlbum : name},
        type: "POST",
        dataType: "json", 
        success: function(response){
            if(response.length > 0){
                selecaoAtual = [];
                nomeMusica = [];
                albumMusica = [];
                dir_foto = [];
                ownerMusica = [];
                for(let i=0; i<response.length; i++){
                    selecaoAtual.push(response[i].dir_music);
                    nomeMusica.push(response[i].nameMusic);
                    ownerMusica.push(response[i].nickname);
                    dir_foto.push(response[i].dir_art);
                    albumMusica.push(response[i].nameAlbum);
                    pk_Musica.push(response[i].pkMusic);
                }
                musicas = selecaoAtual;
                selecaoStandBy = musicas;
                
            }
        }, 
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });
}
function playlistClickUserFunction(elemento){
    var name = elemento.text();
    $.ajax({
        url:"autoload/Helper/playlist.php",
        data:{namePlaylist : name},
        type: "POST",
        dataType: "json", 
        success: function(response){
            if(response.length > 0){
                selecaoAtual = [];
                nomeMusica = [];
                albumMusica = [];
                dir_foto = [];
                ownerMusica = [];
                for(let i=0; i<response.length; i++){
                    selecaoAtual.push(response[i].dir_music);
                    nomeMusica.push(response[i].nameMusic);
                    ownerMusica.push(response[i].nickname);
                    albumMusica.push(response[i].nameAlbum);
                    dir_foto.push(response[i].dir_art);
                    pk_Musica.push(response[i].pkMusic);
                }
                musicas = selecaoAtual;
                selecaoStandBy = musicas;
                
            }
        }, 
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });
}

function typeFeed(){
    tipo = btnTypeFeed.find('option:selected').text();
    loadSelectMusics();
}

function typeNomeSelected(){
    nomeSelecionado = btnNomeSelecionado.find('option:selected').text();
    loadUserMusics();
}

function typeCategory(){
    categoria = btnTypeCategory.find('option:selected').text();
    loadSelectMusics();
}

function menuTypeCategory(valor){
    var numero = valor.data("value");
    btnTypeCategory.val(numero);
    typeCategory();
    loadSelectMusics();
}

function loadSelectMusics(){
    return $.ajax({
        url:"autoload/Helper/playlist.php",
        data:{tipoFeed: tipo, categoriaFeed: categoria},
        type: "POST",
        dataType: "json",
        success:function(response){
            if (typeof response == "string"){
            } else {
                if($('.feed-musica-item').length > 0){
                    $('.feed-musica-item').remove();
                }
                if(response.length > 0){
                    selecaoAtual = [];
                    nomeMusica = [];
                    albumMusica = [];
                    dir_foto = [];
                    ownerMusica = [];
                    for(let i=0; i<response.length; i++){
                        selecaoAtual.push(response[i].dir_music);
                        nomeMusica.push(response[i].nameMusic);
                        ownerMusica.push(response[i].nickname);
                        albumMusica.push(response[i].nameAlbum);
                        dir_foto.push(response[i].dir_art);
                        pk_Musica.push(response[i].pkMusic);
                        divFeedMusics.append(
                            '<div class="feed-musica-item '+ i +'">' +
                                '<a href="#" class="music-click" data-index="'+ i +'" data-value="' + response[i].pkMusic + '">' +
                                    '<div class="label-music-art-feed">'+
                                        '<i class="play-music-art far fa-play-circle"></i>'+
                                        '<img class="art-musica" src="' + response[i].dir_art + '" alt="' + response[i].nameMusic +' by '+ response[i].nickname +'">' +
                                    '</div>'+
                                    '<p class="desc-musica">' + response[i].nameMusic + '</p>' +
                                    '<p class="desc-musica">' + response[i].nickname + '</p>' +    
                                    '<p class="desc-musica">' + response[i].nameAlbum + '</p>' +
                                '</a>' +
                            '</div>'
                        );
                        if (response[i].nickname == sessaoNickname){
                            $('.feed-musica-item.'+ i).append(
                                '<a href="#" class="delete-music" data-index="'+response[i].pkMusic+'"><i class="fas fa-trash"></i> Deletar</a>'
                            );
                        }
                    }
                    musicas = selecaoAtual;
                    selecaoStandBy = musicas;
                } else {
                    divFeedMusics.prepend(
                    '<div class="feed-musica-item"> Nenhum item foi encontrado para a sua seleção</div>');
                }
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });
}

function typeUserMusic(){
    if($('#options-selecteds').length != 0){
        tipoSelecionado = btnTipoSelecionado.find('option:selected').text();
        loadUserTypes();
    }
}

function loadUserTypes(){
    return $.ajax({
        url:"autoload/Helper/types.php",
        data:{tipoSelecionadoUser: tipoSelecionado},
        type: "POST",
        dataType: "json",
        success:function(response){
            if (typeof response == "string"){
            } else {
                if($('.options-selecteds-item').length > 0){
                    $('.options-selecteds-item').remove();
                }
                if(response.length > 0){
                    for(let i=0; i<response.length; i++){
                        btnNomeSelecionado.prepend(
                            '<option class="options-selecteds-item" value="'+ response[i][0] +'">' + response[i][1] + '</option>'
                        );
                    }
                }
                loadUserMusics();
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });
}

function loadUserMusics(){
    return $.ajax({
        url:"autoload/Helper/playlist.php",
        data:{tipoSelecaoUser: tipoSelecionado, nomeSelecaoUser: nomeSelecionado},
        type: "POST",
        dataType: "json",
        success:function(response){
            if (typeof response == "string"){
            } else {
                if($('.musica').length > 0){
                    $('.musica').remove();
                }
                if(response.length > 0){
                    selecaoAtual = [];
                    nomeMusica = [];
                    albumMusica = [];
                    dir_foto = [];
                    for(let i=0; i<response.length; i++){
                        selecaoAtual.push(response[i].dir_music);
                        nomeMusica.push(response[i].nickname);
                        albumMusica.push(response[i].nameAlbum);
                        dir_foto.push(response[i].dir_art);
                        divPlaylist.prepend(
                            '<div class="musica item-'+ i +'" >' +
                                '<div class="label-img-musica">'+
                                    '<img src="'+ response[i].dir_art +'" alt="">' +
                                '</div>'+
                                '<div class="infos-playlist">' +
                                    '<span>' + response[i].nameMusic + '</span>' +
                                    '<span>' + response[i].nickname + '</span>' +
                                '</div>' +
                                '<div class="actions-musica">'+
                                    '<a class="btn-play music-click" data-index="' + i +'"><i class="fas fa-play-circle"></i></a>' +
                                '</div>'+
                            '</div>'
                        );
                        if (response[i].nickname == sessaoNickname){
                            $('.item-'+ i + ' .actions-musica').append(
                                '<a href="#" class="delete-music" data-index="'+response[i].pkMusic+'"><i class="fas fa-trash"></i></a>'
                            )
                        }
                    }
                    musicas = selecaoAtual;
                } else {
                    $('<div class="musica"> Nenhum item foi encontrado para a sua seleção</div>').insertAfter(divPlaylist);
                }
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });
}

$(document).ready(function(){

    getSessao();
    
    typeUserMusic();
    loadSelectMusics();

    
    
    musicClickUser.on("click", function(){
        // playBtn.trigger("click");
        tipo = 'Meu Feed';
        categoria = 'Categorias';
        btnTypeFeed.val(tipo);
        btnTypeCategory.val('0');
        musicaAtual = $(this).data("index");
        setTimeout(function(){
            typeFeed();
            typeCategory();
            loadSelectMusics();
            let status = musica.prop('paused');
            setTimeout(function (){
                listaString = selecaoStandBy;
                carregaMusicaDB(status);
                playBtn.trigger("click");
            }, 50);
        }, 50);
    });
    
    playlistClickUser.on("click", function(){
        playlistClickUserFunction($(this));
        let status = musica.prop('paused');
        setTimeout(function (){
            listaString = selecaoStandBy;
            carregaMusicaDB(status);
            playBtn.trigger("click");
        }, 50);
    });
    
    albumClickUser.on("click", function(){
        albumClickUserFunction($(this));
        let status = musica.prop('paused');
        setTimeout(function (){
            listaString = selecaoStandBy;
            carregaMusicaDB(status);
            playBtn.trigger("click");
        }, 50);
    });
    
    
    setTimeout(function(){
        typeNomeSelected();
        
        setTimeout(function(){
            carregaMusicaDB(true);
        }, 200);
        
        
    }, 100);
    
    $(document).on("click", musicClickUserDel, function(e){
        e.preventDefault();
        deletaMusica($(this));
    });

    btnTypeFeed.on("click", function(){
        typeFeed();
    });
    btnTypeCategory.on("click", function(){
        typeCategory();
    });
    menuCategoriasOpt.on("click", function(){
        menuTypeCategory($(this));
    });
    
    btnTipoSelecionado.on("click", function(){
        typeUserMusic();
        setTimeout(function(){
            typeNomeSelected();
        }, 100);
        
    });
    btnNomeSelecionado.on("click", function(){
        typeNomeSelected();
    });
    
    

});