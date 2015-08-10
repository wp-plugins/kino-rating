(function($){
    $( document ).ready(function() {
        $( "#colorpickeravk_color_font_kp" ).farbtastic( "#avk_color_font_kp" );
        $( "#colorpickeravk_color_font_imdb" ).farbtastic( "#avk_color_font_imdb" );
        $( 'input, select' ).on( 'focus', function(){
            if( ( 'avk_color_font_imdb' == $( this ).attr( 'name' ) ) || ( 'avk_color_font_kp' == $( this ).attr( 'name' ) ) ){
                $('.' + this.id).css('background-color', 'transparent');
            }
            $( '.' + this.id ).stop().css( { display: 'block', 
                                             position: 'absolute' } )
                                     .animate( { opacity: '1' }, 700 );
        }).on( 'blur', function() {
            $( '.' + this.id ).stop().animate( { opacity: '0' }, 500 ).css( { display: 'none' } );
        });
        
    });
})(jQuery)