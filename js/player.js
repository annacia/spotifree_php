var diretorio = "music/";

var musica = $("#musica");
//var musicas = ["What You Know.mp3", "The Other Side.mp3", "Soarin.mp3", "Reminding Me.mp3", "Myself.mp3", "Ghosts.mp3", "Dreams.mp3", "A.mp3", "Good boy.mp3", "I Will Survive.mp3"];
// var musicas = musicasArray();
var musicas = [];
var musicaAtual = 0;
var musicaSource = $("#musica-source"); 

var duracao = musica.prop('duration');

var playBtn = $(".play-btn");
var leftBtn = $(".left-btn");
var rightBtn = $(".right-btn");

var playhead = $(".single-music .timeline .timeline-bar .before");
var playline = $(".single-music .timeline .timeline-bar .after");

var timeline = $(".timeline-bar");

var listaString;



/*function musicasArray(){

    return $.ajax({
        url:"autoload/Helper/playlist.php",
        data: {userName: 'Teste', albumName: 'GotSete'},
        type: "POST",
        dataType: "text",
        success: function(response){
            listaString = response.split('|');
            return response;
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });
}*/

function trocaPlaylist(element){
    listaString = selecaoAtual;
    musicaAtual = element.data("index");
    let status = musica.prop('paused');
    carregaMusicaDB(status);
}

function carregaMusicaDB(status){
    musicaSource.attr("src", listaString[musicaAtual]);
 
    musica.get(0).load();
    musica.prop('currentTime', 0);
    
    setTimeout(function(){
        if (status) {
            musica.get(0).pause();
        }else{
            musica.get(0).play();
            timelineProgress();
        }
        if($('.single-music .dados-musica p').length > 0){
            $('.single-music .dados-musica p').remove();
        }
        $('.single-music .dados-musica').append(
            '<p>Titulo: ' + nomeMusica[musicaAtual] + '</p>' +
            '<p> by ' + ownerMusica[musicaAtual] + '</p>' +
            '<p>' + albumMusica[musicaAtual] + '</p>'
        );
        $('.single-music img').attr("src", dir_foto[musicaAtual]);
        $('.single-music').addClass(ownerMusica[musicaAtual]);
        $('.add-playlist').attr("data-index", pk_Musica[musicaAtual]);
        
        $('.single-music .delete-music').remove();
        if (ownerMusica[musicaAtual] == sessaoNickname){
            $('.single-music.'+ ownerMusica[musicaAtual] + ' .left-menu .options-menu .sub-menu').append(
                '<a href="#" class="delete-music" data-index="'+pk_Musica[musicaAtual]+'"><i class="fas fa-trash"></i></a>'
            );
        }
        
    }, 1000);
    timelineProgress();


}

function getDuracao(){
    duracao = musica.prop('duration');
    return duracao;
}

/*function carregaMusica(status){
    musicaSource.attr("src", listaString[musicaAtual]);
    musica.get(0).load();
    musica.prop('currentTime', 0);
    
    setTimeout(function(){
        if (status) {
            musica.get(0).pause();
        }else{
            musica.get(0).play();
            timelineProgress();
        }
    }, 1000);
    timelineProgress();
}*/

function changeMusic(value){
    if (musicaAtual==0 && value < 0){
        musicaAtual = listaString.length - 1;
    } else if (musicaAtual==listaString.length - 1 && value > 0){
        musicaAtual = 0;
    } else {
        musicaAtual += value;
    }

    playline.css("width", "100%");
    playhead.css("left", "0%" );
    let status = musica.prop('paused');
    carregaMusicaDB(status);
}

function playMusic(){
    if (musica.prop('paused')) {
        playBtn.removeClass("paused");
		playBtn.addClass("playing");
        musica.get(0).play();
	} else {
        playBtn.removeClass("playing");
		playBtn.addClass("paused");
        musica.get(0).pause();
    }
    
}

function timelineProgress(){
    let playPercentHead = (100 * (musica.prop('currentTime') / getDuracao()));
    let playPercent = 100 - playPercentHead;

    if(playPercent > 0.8 && !musica.prop('paused')){
        setTimeout(function(){
            timelineProgress();
        }, 1000); 
    } else if (playPercent<=0.8){
        playline.css("width", "100%");
        playhead.css("left", "0%");
        changeMusic(1);
        playMusic();
    }

    playline.css("width", playPercent + "%");
    playhead.css("left", playPercentHead + "%" );
}

function btnChangeCurrentTime(value){
    let newCurrentTime = musica.prop('currentTime') + value;

    if((musica.prop('currentTime') > 1) && ((musica.prop('duration') - musica.prop('currentTime')) > 1)){
        musica.prop('currentTime', newCurrentTime);
        timelineProgress();
    }
}

function manualChangeCurrentTime(e, elemento){
    let posicao = e.pageX - elemento.position().left;
    let tamanho = timeline.width();
    let timelinePercent = posicao/tamanho;
    
    let newCurrentTime = getDuracao() * timelinePercent;
    musica.prop('currentTime', newCurrentTime);
    timelineProgress();
}

function playheadChangeCurrentTime(){
    timeline.on("click", function(e){
        manualChangeCurrentTime(e,$(this));
    });
}

function mousePlayHead(e){
    manualChangeCurrentTime(e,$(this));
}

function playheadMove(){
    timeline.mousedown(function(){
        timeline.mousemove(mousePlayHead);
    }).mouseup(function(e){
        e.stopPropagation();
        timeline.off("mousemove");
    });
}


$(document).ready(function(){

    setTimeout(function(){
        listaString = selecaoAtual;
    }, 200);

    $(document).on('click','.music-click',function(e) {
        trocaPlaylist($(this));
    });

    playBtn.on("click", function(){
        playMusic();
        timelineProgress();
    });

    leftBtn.on("click", function(){
        btnChangeCurrentTime(-10);
    });
    rightBtn.on("click", function(){
        btnChangeCurrentTime(+10);
    });

    leftBtn.on("dblclick", function(){
        changeMusic(-1);
        timelineProgress();
    });
    rightBtn.on("dblclick", function(){
        changeMusic(+1);
        timelineProgress();
    });

    

    playheadChangeCurrentTime();
    playheadMove();

   
    
});