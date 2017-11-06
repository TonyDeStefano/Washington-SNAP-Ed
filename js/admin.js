(function($){

    $(function(){

        $('#approve-provider').click(function(e){
            e.preventDefault();
            var b = confirm('Are you sure you want to approve this provider?');
            if ( b ){
                window.location = 'admin.php?page=wasnap_providers&action=view&approve=true&id=' + $(this).data('id');
            }
        });

        $('#send-approval-email').click(function(e){
            e.preventDefault();
            var b = confirm('Are you sure you want to send an approval email to this provider?');
            if ( b ){
                window.location = 'admin.php?page=wasnap_providers&action=view&send=true&id=' + $(this).data('id');
            }
        });

        $('#role').change(function(){
            if( $('#role').val() === 'provider' ) {
                $('#provider-information').show();
            } else {
                $('#provider-information').hide();
            }
        });

    });

})(jQuery);