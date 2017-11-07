(function($){

    $(function(){

        var title = $('#wasnap-entry-title');

        if(title.length){
            $('h1.entry-title').text(title.text())
        }

        $('body').on('change, keyup', '#wasnap-search', function(){
            var search = $(this).val().trim().toUpperCase();
            $('.wasnap-provider').each(function(){
                $(this).hide();
            });
            $('.wasnap-search').each(function(){
                var text = $(this).text().trim().toUpperCase();
                if ( text.includes(search) ) {
                    $(this).closest('.wasnap-provider').show();
                }
            });
        });

        $('#wasnap-search-clear').click(function(e){
            e.preventDefault();
            $('#wasnap-search').val('');
            $('.wasnap-provider').each(function(){
                $(this).show();
            });
        });

    });

})(jQuery);