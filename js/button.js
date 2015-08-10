( function( $ ){
    tinymce.PluginManager.add( 'cin_rat_button', function( editor, url ) {
        url = url.substr( 0, url.length - 2 );
        // Add a button that opens a window
        editor.addButton( 'cin_rat_button_key', {
			title : kpRatingButtonMceAvk.nameButton,
            text: false,
			image : url + 'images/kino-rating.png',
            
            onclick: function() {
                // Open window
                editor.windowManager.open( {
                    title: kpRatingButtonMceAvk.nameButton,
                    body: [
					{type: 'textbox', name: 'idcinema', label: kpRatingButtonMceAvk.idcinema}
					],
                    onsubmit: function( e ) {
                        // Insert content when the window form is submitted
                        editor.insertContent('[kpimdb]' + e.data.idcinema + '[/kpimdb]');
                    }
                } );
            }
        } );
    } );
} )( jQuery )