( function( $ ){
    $(document).ready( function() {
        var valRating = $("#avkrating").attr('alt');
        if(valRating != null){
            $.ajaxSetup({cache: false});
            var data = {action 	: 'loadimgrating',
    				    rating : valRating};
            $("#avkshowrating").stop().animate({opacity: '0',visibility: 'hidden'},700);
            $.post(avkAjaxKP.ajurl, data , function(response){
                $("#avkshowrating").html(response);
                $("#avkshowrating").stop().animate({opacity: '1',visibility: 'visible'},700);
            });
            return false;
        }
    });
})( jQuery )