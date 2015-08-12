( function( $ ){
    $( document ).ready( function() {
        $( "[id ^= avkkprating]" ).each( function( indx, element ){
            var valRating = $( element ).find( '.avkrating' ).attr( 'alt' );
            if( valRating != null ){
                $.ajaxSetup( { cache: false } );
                var data = { action: 'loadimgrating',
        				     rating: valRating };
                $( element ).stop().animate( { opacity: '0', visibility: 'hidden' }, 700 );
                $.post( avkAjaxKP.ajurl, data , function( response ){
                    $( element ).html(response);
                    $( element ).stop().animate( { opacity: '1', visibility: 'visible' }, 700 );
                });
            }
        });
    });
} )( jQuery )