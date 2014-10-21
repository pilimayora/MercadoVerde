</div><!-- .clearfix --> 
</div><!-- #center_column -->
</div><!-- .row -->
</div><!-- #columns -->
<div class="tiendas-destacadas">
	<span class="titulo">Tiendas destacadas</span>
	<div class="toldo"></div>
</div>

<div id="columns" class="container">
<div class="row">
{if isset($left_column_size) && isset($right_column_size)}{assign var='cols' value=(12 - $left_column_size - $right_column_size)}{else}{assign var='cols' value=12}{/if}
<div id="center_column" class="center_column col-xs-12 col-sm-{$cols|intval}">	
<div class="clearfix">