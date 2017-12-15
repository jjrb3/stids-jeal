var codigoMensaje = '';

function validarCorreo(email) {

	if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email)){
		
   		return true;
  	} 
  	else {
   		return false;
  	}
}

function cargar(div) {

	$("#"+div).html('<center><img src="../img/cargando.gif" width="50px"><br><br></center>');
}

function mensajeError(id,mensaje){

	codigoMensaje  = '<div class="alert alert-dismissable alert-danger">';
	codigoMensaje += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
	codigoMensaje += '<center>';
	codigoMensaje += '<i class="fa fa-exclamation-triangle fa-2x"></i> ';
	codigoMensaje += '<br>';
	codigoMensaje += mensaje;
	codigoMensaje += '</center>';
	codigoMensaje += '</div>';

	$("#"+id).html(codigoMensaje);
}

function mensajeRealizado(id,mensaje){

	codigoMensaje  = '<div class="alert alert-dismissable alert-success">';
	codigoMensaje += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
	codigoMensaje += '<center>';
	codigoMensaje += '<i class="fa fa-check-circle fa-2x"></i> ';
	codigoMensaje += '<br>';
	codigoMensaje += mensaje;
	codigoMensaje += '</center>';
	codigoMensaje += '</div>';

	$("#"+id).html(codigoMensaje);
}


function mensajeAdvertencia(id,mensaje){

	codigoMensaje  = '<div class="alert alert-dismissable alert-warning">';
	codigoMensaje += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
	codigoMensaje += '<center>';
	codigoMensaje += '<i class="fa fa-exclamation-triangle fa-2x"></i> ';
	codigoMensaje += '<br>';
	codigoMensaje += mensaje;
	codigoMensaje += '</center>';
	codigoMensaje += '</div>';

	$("#"+id).html(codigoMensaje);
}

function mensajeInformacion(id,mensaje){

	codigoMensaje  = '<div class="alert alert-dismissable alert-info">';
	codigoMensaje += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
	codigoMensaje += '<center>';
	codigoMensaje += '<i class="fa fa-info fa-2x"></i> ';
	codigoMensaje += '<br>';
	codigoMensaje += mensaje;
	codigoMensaje += '</center>';
	codigoMensaje += '</div>';

	$("#"+id).html(codigoMensaje);
}