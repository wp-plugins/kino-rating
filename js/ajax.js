( function( $ ){
    $(document).ready( function() {
        $("#avk-form").submit(function(){
            $("#reskp,#resimdb").stop().animate({opacity: 0},500);
            $("#avk_submit").attr('disabled',true);
            data = avk_get_arr(); 
            $.ajaxSetup({cache: false});
            $.post(ajaxurl, data, function(response){
                response = JSON.parse(response);
                $('#reskp').html(response.kp);
                $('#resimdb').html(response.imdb);
                $("#reskp,#resimdb").stop().animate({opacity: 1},700);
                $("#avk_submit").attr('disabled',false);
            });
            return false;
        });
    });
} )( jQuery )