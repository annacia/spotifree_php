//Function Remove/Add click-off

function removeClickOff(btn, elemento){
    $(btn).on("click", function(){
        $(elemento).removeClass("click-off");
        
        if((elemento==".menu-principal-wrap")||(elemento==".menu-pessoal-wrap")){
            $(".overlay").addClass("overlaying");
            addClickOff(".overlay", elemento);
        }
    });
}


function addClickOff(btn, elemento){
    $(btn).on("click", function(){
        $(elemento).addClass("click-off");
        
        if((elemento==".menu-principal-wrap")||(elemento==".menu-pessoal-wrap")){
            $(".overlay").removeClass("overlaying");
        }
    });
}

//Function for submenu
function subItemShowOff(parent, child, holder){
    $(parent).on("click", function(){
        $(this).children(child).toggleClass("click-off");
        $(this).children(holder).toggleClass("click-off");
    });       
}

$(document).ready(function(){
   
    //Menus
    removeClickOff(".principal-menu-item.principal, .sub-menu .menu-principal", ".menu-principal-wrap");
    addClickOff(".menu-principal-wrap .btn-close, .menu-principal-wrap .menu-principal-categorias .sub-menu-item", ".menu-principal-wrap");
    
    removeClickOff(".principal-menu-item.pessoal, .sub-menu .menu-pessoal", ".menu-pessoal-wrap");
    addClickOff(".menu-pessoal-wrap .btn-close", ".menu-pessoal-wrap");
    
    subItemShowOff(".menu-item-pack .menu-item", ".sub-menu", ".holder");
    

    //Lists Playlists for Add
    // removeClickOff(".nova-playlist a", ".adicionar-playlist");

    $(document).on("click", ".nova-playlist a", function(){
        $(".adicionar-playlist").removeClass("click-off");
        
        if((".adicionar-playlist"==".menu-principal-wrap")||(".adicionar-playlist"==".menu-pessoal-wrap")){
            $(".overlay").addClass("overlaying");
            addClickOff(".overlay", ".adicionar-playlist");
        }
    });
    
    //Options Player Single Music
    subItemShowOff(".left-menu .options-menu", ".sub-menu", ".options");

    // Player Music Menu
    addClickOff(".min-music", ".single-music");
    removeClickOff(".max-music", ".single-music");


    $('.delete-account').on("click", function(e){
        e.preventDefault();
        return $.ajax({
            url:"autoload/classes/Action/userAC.php",
            data:{deleteUser: true},
            type: "POST",
            dataType: "text",
            success: function(){
                setTimeout(function(){
                    location.reload();
                }, 1000);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    });



});
