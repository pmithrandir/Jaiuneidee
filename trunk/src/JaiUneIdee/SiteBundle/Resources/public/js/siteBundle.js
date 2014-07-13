jQuery(document).ready(function() {
    //$("#filtres_submit").css("display","none");
    bindPagination();
    bindVotes();
    $("#filtres").submit(function(event){
        $.ajax({
           url: $(this).attr('href'),
           type:"GET", 
           data: $(this).serialize(),
           dataType: "html",
           success: function(html){
             $("#toutes_les_idees").html(html);    
             bindPagination();
           }
        });
        return false;
    });
    //$("#filtres").submit();
    $("#filtres input[type=radio]").click(function(event){
        $("#filtres").submit();
    });
    $("#filtres select").change(function(event){
        $("#filtres").submit();
    });
    $("form.nouveau_commentaire").validate({
        rules: {
            "jaiuneidee_sitebundle_commentairetype[content]": {
                required: true,
                minlength: 20,
                maxlength: 5000,
            }
        }
    });
    if((!is_touch_device()) && ($(".theme").length)){
        try {
            $(".theme").msDropDown();
        } catch(e) {
            alert(e.message);
        }
    }
    $("form.nouvelle_idee").validate({
        rules: {
            "jaiuneidee_sitebundle_ideetype[title]": {
                required: true,
                minlength: 8,
                maxlength: 80,
            },
            "jaiuneidee_sitebundle_ideetype[description]": {
                required: true,
                minlength: 20,
                maxlength: 110,
            },
            "jaiuneidee_sitebundle_ideetype[content]": {
                required: true,
                minlength: 50,
                maxlength: 10000,
            }
        }
    }); 
    $("form.fos_user_registration_register").validate({
        rules: {
            "fos_user_registration_form[username]": {
                required: true,
                minlength: 4,
                maxlength: 80,
            },
            "fos_user_registration_form[email]": {
                required: true,
                email: true,
            },
            "fos_user_registration_form[plainPassword][first]": {
                required: true,
                minlength: 6,
                maxlength: 100,
            },
            "fos_user_registration_form[plainPassword][second]": {
                required: true,
                minlength: 6,
                maxlength: 100,
            }/*,
            "fos_user_registration_form[invitation]": {
                required: true,
                minlength: 6,
                maxlength: 6,
            }*/
        }
    }); 
    defineAnimateCCMOut();
    /*
    $("window").unload(function(event){
        return confirm('Voulez-vous<u> vraiment</u> quitter cette page ???');
    });*/
});

bindPagination = function() {
    $(".pagerfanta nav a").unbind( "click" );
    $(".pagerfanta nav a").click(function(event){
        var element = $(this);
        var data;
        if($("#filtres")){
            data = $("#filtres").serialize()
        }
        $.ajax({
           url: $(this).attr('href'),
           type: "GET",
           data: data,
           dataType: "html",
           success: function(html){
             element.parents(".pagerfanta").parent().html(html);    
             bindPagination();
           }
        });
        return false;
    });
};
bindVotes = function() {
    $("#bloc_votes a").click(function(event){
        
        $.ajax({
           url: $(this).attr('href'),
           type: "GET",
           dataType: "html",
           success: function(html){
            $("#bloc_votes").html(html);    
            bindVotes();
           }
        });
        return false;
    });
};
function is_touch_device() {
  return 'ontouchstart' in window // works on most browsers 
      || 'onmsgesturechange' in window; // works on ie10
};
function defineAnimateCCMOut(){
    $("#ccm").click(function(){
        $("#cadre_ccm1")
        .animate({width: 195}, 'slow');
        $("#cadre_ccm1 img").fadeIn("fast");
        $("#ccm").unbind( "click" );
        defineAnimateCCMIn();
        return false;
    });
}
function defineAnimateCCMIn(){
    $("#ccm").click(function(){
        $("#cadre_ccm1")
        .animate({width: 10}, 'slow');
        $("#cadre_ccm1 img").fadeOut("fast");
        $("#ccm").unbind( "click" );
        defineAnimateCCMOut();
        return false;
    });
}
