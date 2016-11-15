function rateError(){
    $('.current-rate').html(
        '<span class="label label-danger">Не получилось загрузить текущий курс</span>'
    );
}

$( function(){
   window.setInterval( function(){
       $.ajax('/ajax/rate')
       .done( function( data ) {
            if( data && data.success ) {
                $('.current-rate').html( data.html );
            } else {
               rateError();
            }
       })
       .fail( function() {
           rateError();
       });
   }, 10000);
});