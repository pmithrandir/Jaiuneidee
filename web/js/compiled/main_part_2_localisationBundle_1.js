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