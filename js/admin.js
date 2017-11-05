(function($){

    $(function(){

        $('#approve-provider').click(function(e){
            e.preventDefault();
            var b = confirm('Are you sure you want to approve this provider?');
            if ( b ){
                window.location = 'admin.php?page=wasnap_providers&action=view&approve=true&id=' + $(this).data('id');
            }
        });

    });

})(jQuery);