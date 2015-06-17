jQuery(document).ready( function() {
    var valRating = jQuery("#avkrating").attr('alt');
    if(valRating != null){
        jQuery.ajaxSetup({cache: false});
        var data = {action 	: 'loadimgrating',
				    rating : valRating};
        jQuery("#avkshowrating").stop().animate({opacity: '0',visibility: 'hidden'},700);
        jQuery.post(avkAjaxKP.ajurl, data , function(response){
            jQuery("#avkshowrating").html(response);
            jQuery("#avkshowrating").stop().animate({opacity: '1',visibility: 'visible'},700);
        });
        return false;
    }
});