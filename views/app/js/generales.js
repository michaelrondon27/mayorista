function __(id){
	return document.getElementById(id);
}
function DeleteItem(contenido, url){
	swal({
	  	title: contenido,
	  	type: "warning",
	  	showCancelButton: true,
	 	confirmButtonColor: "#DD6B55",
	  	confirmButtonText: "Si, Eliminar!",
	  	cancelButtonText: "No, Cancelar!",
	  	closeOnConfirm: false,
	  	closeOnCancel: false
	},
	function(isConfirm){
	  	if (isConfirm) {
	    	window.location=url;
	  	} else {
		    swal("Cancelado", "No se ha eliminado ningún dato.", "error");
	  	}
	});
}
function AnularItem(contenido, url){
	swal({
	  	title: contenido,
	  	type: "warning",
	  	showCancelButton: true,
	 	confirmButtonColor: "#DD6B55",
	  	confirmButtonText: "Si, Anular!",
	  	cancelButtonText: "No, Cancelar!",
	  	closeOnConfirm: false,
	  	closeOnCancel: false
	},
	function(isConfirm){
	  	if (isConfirm) {
	    	window.location=url;
	  	} else {
		    swal("Cancelado", "No se ha anulado la cotización.", "error");
	  	}
	});
}
function ReversarItem(contenido, url){
	swal({
	  	title: contenido,
	  	type: "warning",
	  	showCancelButton: true,
	 	confirmButtonColor: "#DD6B55",
	  	confirmButtonText: "Si, Reversar!",
	  	cancelButtonText: "No, Cancelar!",
	  	closeOnConfirm: false,
	  	closeOnCancel: false
	},
	function(isConfirm){
	  	if (isConfirm) {
	    	window.location=url;
	  	} else {
		    swal("Cancelado", "No se ha reversado la cotización.", "error");
	  	}
	});
}
function solonumeros(e){
	key=e.keyCode || e.which;
	teclado=String.fromCharCode(key);
	numeros="1234567890";
	especiales="8-9-17-37-38-46";//los numeros de esta linea son especiales y es para las flechass
	teclado_escpecial=false;
	for(var i in especiales){
	    if (key==especiales[i]) {
	        teclado_escpecial=true;
	    }
	}
	if (numeros.indexOf(teclado)==-1 && !teclado_escpecial) {
	    return false;
	}
}
function solonumeros2(e){
	key=e.keyCode || e.which;
	teclado=String.fromCharCode(key);
	numeros="1234567890-";
	especiales="8-9-17-37-38-46";//los numeros de esta linea son especiales y es para las flechas
	teclado_escpecial=false;
	for(var i in especiales){
	    if (key==especiales[i]) {
	        teclado_escpecial=true;
	    }
	}
	if (numeros.indexOf(teclado)==-1 && !teclado_escpecial) {
	    return false;
	}
}
function deshabilitarteclas(e){
    key=e.keyCode || e.which;
    teclado=String.fromCharCode(key);
    numeros="";
    especiales="9";//los numeros de esta linea son especiales y es para las flechas
    teclado_escpecial=false;
    for(var i in especiales){
        if (key==especiales[i]) {
            teclado_escpecial=true;
        }
    }
    if (numeros.indexOf(teclado)==-1 && !teclado_escpecial) {
        return false;
    }
}