jQuery(document).ready( function() {
    jQuery("#avk-form").submit(function(){
        jQuery("#reskp,#resimdb").stop().animate({opacity: 0},500);
        jQuery("#avk_submit").attr('disabled',true);
        data = avk_get_arr(); 
        jQuery.ajaxSetup({cache: false}); 
        jQuery.post(ajaxurl, data, function(response){
            response = JSON.parse(response);
            jQuery('#reskp').html(response.kp);
            jQuery('#resimdb').html(response.imdb);
            jQuery("#reskp,#resimdb").stop().animate({opacity: 1},700);
            jQuery("#avk_submit").attr('disabled',false);
        });
        return false;
    });
});