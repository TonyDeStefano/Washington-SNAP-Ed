(function($){

    $(function(){

        var title = $('#wasnap-entry-title');

        if(title.length){
            $('h1.entry-title').text(title.text())
        }

    });

})(jQuery);