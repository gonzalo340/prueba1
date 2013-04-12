var solapa='';

loadOrdenes = function (conditions, extra){
  var url= 'no_facturadas';
  $('#datagrid').html('<center><img src="images/ajax-loader.gif" /></center>');
  solapa= conditions;
  
  var param= '';
  
  if(extra){
	param= "?cliente="+extra.cliente;
  }
  
  switch(conditions){
	case 'all':
	  url= "ajax/all_ordenes.php"+param;
	  break;
	case 'facturadas':
	  url= "ajax/ordenes_facturadas.php"+param;
	  break;
	case 'no_facturadas':
	  url= "ajax/ordenes_no_facturadas.php"+param;
	  break;
	case 'sin_costo':
	  url= "ajax/ordenes_sin_costo.php"+param;
	  break;
  }
  $.get(url, function(html){
	$('#datagrid').html(html);
	$("#link-"+conditions).removeClass();
	$("#link-"+conditions).addClass("ui-btn-active ui-state-persist");
	alert($("#link-"+conditions).attr('class'));
  });
}

$(function() {
  loadOrdenes('no_facturadas', null);
  
  $("#search").keypress(function(e) {
	if (e.which == 13) {
	  loadOrdenes(solapa, {
		'cliente':$("#search").val()
	  });
	  $("#search").val('').focus();
	}
  });
});