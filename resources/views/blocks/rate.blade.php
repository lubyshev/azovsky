@if ( $currentRate )
<span class="label label-primary">1 USD</span>
<span class="glyphicon glyphicon-arrow-right"></span>
<span class="label label-success">{{ number_format( $currentRate, 4) }} RUR</span>
@else
<span class="label label-default">Данные не готовы</span>
@endif