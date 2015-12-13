jQuery(document).ready(function() {
    //$("#filtres_submit").css("display","none");
    bindPagination();
    bindVotes();
    $("#filtres").submit(function(event){
        $.ajax({
           url: $(this).attr('href'),
           type:"POST", 
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
    var timer;
    $("#filtres input[type=text]").keyup(function(event){
        var timerCallback = function(){
            $("#filtres").submit();
        };
        clearTimeout( timer );
        timer = setTimeout( timerCallback, 300 );
        return false;
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
        var type = "GET";
        if($("#filtres").length>0){
            data = $("#filtres").serialize();
            type = "POST";
        }
        $.ajax({
           url: $(this).attr('href'),
           type: type,
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
            $("#bloc_votes_mobile").html(html);    
            bindVotes();
           }
        });
        return false;
    });
    $("#bloc_votes_mobile a").click(function(event){
        
        $.ajax({
           url: $(this).attr('href'),
           type: "GET",
           dataType: "html",
           success: function(html){
            $("#bloc_votes").html(html);  
            $("#bloc_votes_mobile").html(html);    
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

$(function() {
	if($(".tokeninput").length){
		$(".tokeninput").tokenInput("/localisation_list", {
            theme: "facebook",
            propertyToSearch: "nom",
            minChars: 3,
            tokenLimit: 10,
            preventDuplicates: true,
            prePopulate: (typeof(datas) != 'undefined')?datas:null,
        });
	}
	if($(".tokeninput_unique").length){
		$(".tokeninput_unique").tokenInput("/localisation_list", {
            theme: "facebook",
            propertyToSearch: "nom",
            minChars: 3,
            tokenLimit: 1,
            preventDuplicates: true,
            prePopulate: (typeof(datas) != 'undefined')?datas:null,
        });
	}
});