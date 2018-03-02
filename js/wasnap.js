(function($){

    $(function(){

        var title = $('#wasnap-entry-title');
        var body = $('body');

        if(title.length){
            $('h1.entry-title').text(title.text())
        }

        body.on('change, keyup', '#wasnap-search', function(){
            doProviderSearch();
        });

        body.on('change', '#wasnap-region', function(){
            doProviderSearch();
        });

        body.on('change', '#wasnap-agency', function(){
            doProviderSearch();
        });

        $('#wasnap-search-clear').click(function(e){
            e.preventDefault();
            $('#wasnap-search').val('');
            $('#wasnap-region').val('');
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

        var hidden_count = 0;

        $('.wasnap-login-hidden').each(function(){
            $(this).closest('.panel-widget-style').hide();
            hidden_count++;
        });

        if (hidden_count > 0){
            $('.wasnap-hidden').each(function(){
                $(this).hide();
            });
        }
    });

    function doProviderSearch(){

        var search = $('#wasnap-search').val().trim().toUpperCase();
        var region = $('#wasnap-region').val();
        var agency = $('#wasnap-agency').val();

        $('.wasnap-provider').each(function(){

            $(this).hide();
            var text = $(this).text().trim().toUpperCase();

            if (
                text.includes(search)
                && ( region.length === 0 || $(this).data('region') === region )
                && ( agency.length === 0 || $(this).data('agency') === agency )
            ) {
                $(this).show();
            }
        });
    }

})(jQuery);