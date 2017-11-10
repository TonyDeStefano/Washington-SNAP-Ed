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

        $('.wasnap-toggle-more').click(function(){
            var state = $(this).data('state');
            if ( state === 'closed' ) {
                $(this).data('state', 'open');
                $(this).closest('.wasnap-provider').find('.wasnap-more').show();
                $(this).find('.fa').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            } else {
                $(this).data('state', 'closed');
                $(this).closest('.wasnap-provider').find('.wasnap-more').hide();
                $(this).find('.fa').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            }
        });

        $('.wasnap-delete-post').click(function(e){
            e.preventDefault();
            var href = $(this).prop('href');
            var b = confirm('Are you sure you want to delete this item?');
            if( b ){
                window.location = href;
            }
        });

    });

})(jQuery);