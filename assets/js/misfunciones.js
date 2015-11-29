var x = $(document);
var path = "http://localhost/soporte2/";
x.ready(inicializaEventos);

function inicializaEventos() {
	
	$('#estado').live('change', modificarEstado);

	$('#btn_generar_cliente').live('click',generarListaCliente);


	generarCalendario('date-start');
	generarCalendario('fecha_ingreso');
	generarCalendario('date-end');
	
	
	$('#id_cliente').live('change', cargarProductos);
	
	//$('#btn_mostrar_form_add').live('click', mostrarFormAddCliente);
	$('#guardar_cliente').live('click',addClienteAjax);
	
	//$('#id_cliente2').live('change', cargarItemsTable);
	
	//cargarItemsTable();
	
	cargarClientesEnLista();

	//cargarClientesEnLista2();
	/*
	 * Disparar evento antes de abrir ventana agregar items
	 */
	$('#myModal2').on('show', function () {
	  // do something…
	 if ($('#id_cliente').val()=='') {
	 	alert('Seleciona a un cliente');
	 return false;	
	 }
	 
	})
	
	/*
	$('#add_clientes_ajax').validate({
                rules: {
                    nombre_contacto: {required: true}
                },
                messages: {
                    nombre_contacto: {required: "Introduzca su nombre"}
                }
            });
	*/
	
	var loader = jQuery('<div id="loader">cargando</div>')
			.css({position: "relative", top: "1em", left: "25em"})
			.appendTo("body")
			.hide();
	jQuery().ajaxStart(function() {
			loader.show();
		}).ajaxStop(function() {
			loader.hide();
		}).ajaxError(function(a, b, e) {
			throw e;
		});
		
		var v = jQuery("#add_clientes_ajax").validate({
			submitHandler: function(form) {
				
				addClienteAjax();
				
				cargarClientesEnLista();
				$('#myModal').modal('hide');
				
			}
		});
		
		
		//
		
		var loader = jQuery('<div id="loader">cargando</div>')
			.css({position: "relative", top: "1em", left: "25em"})
			.appendTo("body")
			.hide();
	jQuery().ajaxStart(function() {
			loader.show();
		}).ajaxStop(function() {
			loader.hide();
		}).ajaxError(function(a, b, e) {
			throw e;
		});
		
		var v = jQuery("#items_add_form_ajax").validate({
			submitHandler: function(form) {
				//alert('do something..');
				
				var dataString = {
					id_cliente : $('#id_cliente').val(),
					nombre_item : $('#nombre_item').val(),
					garantia : $('#garantia').val(),
					ajax : 1
				};
					
				$.ajax({
					url : path + "items/add",
					type : 'POST',
					data : dataString,
					cache : false,
					success : function(data) {
						 //alert(data);
						 $('#myModal2').modal('hide');
						 $("#result2").html(data);
						 cargarProductos();
					}
				});
				return false;	
				
			}
		});
		
}


function modificarEstado(){

	var estado = $(this).val();
	var id_tecnico_item = $('#id_tecnico_item').val();
	//var index = $('#estado').attr("selectedIndex");
	console.log('Id de estado:' + estado );
	console.log('Id de tecnico_item:' + id_tecnico_item );
	
	noty({layout : 'topCenter', theme : 'noty_theme_twitter', type : 'notification', text: 'Estas seguro de cambiar de estado ?',
    buttons: [
      {type: 'btn btn-primary', text: 'Si', click: function($noty) {
          	$noty.close();
          	//inicia la peticion ajax
          	var dataString = {
				estado : estado,
				id_tecnico_item : id_tecnico_item
			};

			$.ajax({
				url : path + "recepcion/cambiarEstado",
				type : 'POST',
				data : dataString,
				cache : false,
				success : function(data) {
					//alert(data);
					//$("#id_item").html(data);
					//$("#id_cliente").html(data);
					console.log('respuesta del servidor'+data);
					var options = ''; 
					if (estado == '0') {
						options = '<option value="0"  >Recepcionado</option>';
					}					
					if(estado == '1'){
						options ='<option value="1">Diagnostico realizado</option>'+
									'<option value="2">Reparacion Aceptada</option>'+
									'<option value="3">Reparacion Cancelada</option>';
					}
					if (estado == '2') {
						options = '	<option value="2">Reparacion Aceptada</option>'+
									'<option value="4">En reparacion</option>';
					}
					if (estado == '3') {
						options = '	<option value="3">Reparacion Cancelada</option>'+
									'<option value="6">Entregado</option>';
					}
					if(estado == '4'){
						options = '	<option value="4">En reparacion</option>'+
									'<option value="5">Listo</option>';
					}
					if (estado == '5') {
						options = '	<option value="5">Listo</option>'+
									'<option value="6">Entregado</option>';
					}
					if (estado == '6') {
						options = '<option value="6">Entregado</option>';
					}
					$('#estado').html(options);
					if (data == 1) {
						alert("Modificado con exito");
					}
					else{
						alert("Ocurrio algun error al modificar el estado, intente nuevamente");	
					}
					
					//noty({force: true,modal:true, layout : 'topCenter', theme : 'noty_theme_twitter', text: 'Estado modificado', type: 'success'});
					window.location = path+'perfil/index/'+id_tecnico_item;
					
				}
			});
			
        }
      },
      {type: 'btn btn-danger', text: 'No', click: function($noty) {
          	$noty.close();
          	$("#estado option").eq(0).attr("selected", "selected");
          	//$("#estado option[value="+estado+"]").attr("selected",true); 
          	//console.log("#estado option[value="+estado+"]");
        }
      }
    ], closable: false, timeout: false,modal:true
	  });

	}



function generarListaCliente()
{
	id_cliente = $('#id_cliente').val();
	window.location = path+'reportes/listaCLientes/'+id_cliente;	
}


function generarCalendario(name)
{
		 $("#"+name).datepicker({
        dateFormat: 'yy-mm-dd', // formato de fecha que se usa en España
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado'], // días de la semana
        dayNamesMin: ['D', 'L', 'M', 'X', 'J', 'V', 'S'], // días de la semana (versión super-corta)
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'], // días de la semana (versión corta)
        firstDay: 1, // primer día de la semana (Lunes)
        maxDate: new Date(), // fecha máxima
        minDate: '-2y',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'], // meses
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'], // meses
        navigationAsDateFormat: true,
        });
}





function cargarClientesEnLista2()
{
	
	var dataString = {
		id_cliente : 1
	};
	$.ajax({
		url : path + "clientes/listarClientes",
		type : 'POST',
		data : dataString,
		cache : false,
		success : function(data) {
			 //alert(data);
			 //$("#id_item").html(data);
			$("#id_cliente2").html(data);
			$("#id_cliente2").trigger("liszt:updated");
			 	   
		}
	});
	return false;	

}

function cargarClientesEnLista()
{

	var dataString = {
		id_cliente : 1
	};
	$.ajax({
		url : path + "clientes/listarClientes",
		type : 'POST',
		data : dataString,
		cache : false,
		success : function(data) {
			 //alert(data);
			 //$("#id_item").html(data);
			$("#id_cliente").html(data);

			 	   
		}
	});
	return false;	

}

/*
function cargarItemsTable()
{
	//alert($('#id_cliente2').val());
	
	var dataString = {
		id_cliente : $('#id_cliente2').val()
	};
	$.ajax({
		url : path + "items/getItemsTable",
		type : 'POST',
		data : dataString,
		cache : false,
		success : function(data) {
			 //alert(data);
			 //$("#id_item").html(data);
			
			$("#items_table").html(data);

			 	   
		}
	});
	return false;
}
*/

function mostrarFormAddCliente()
{
	//$('#form_add').css("display","inline");	
}

function addClienteAjax()
{
	nombre_contacto = $('#nombre_contacto').val();
	apellido_paterno_contacto = $('#apellido_paterno_contacto').val();
	apellido_materno_contacto = $('#apellido_materno_contacto').val();
	email_contacto = $('#email_contacto').val();
	telefono_contacto = $('#telefono_contacto').val();
	movil_contacto = $('#movil_contacto').val();
	direccion_contacto = $('#direccion_contacto').val();
	
	var dataString = {
		ajax:'1',
		nombre_contacto:nombre_contacto,
		apellido_paterno_contacto:apellido_paterno_contacto,
		apellido_materno_contacto:apellido_materno_contacto,
		email_contacto:email_contacto,
		telefono_contacto:telefono_contacto,
		movil_contacto:movil_contacto,
		direccion_contacto:direccion_contacto
	};
	
	$.ajax({
		url : path + "clientes/add",
		type : 'POST',
		data : dataString,
		cache : false,
		success : function(data) {
			 //alert(data);
			 //$("#id_item").html(data);
			 $("#result").html(data);
			 //cargarProductos();
			 //$('#id_item').html("<option value=''></option>");
			 cargarClientesEnLista();
			 //$("#id_item").trigger("liszt:updated");
		}
	});
	return false;
}



function cargarProductos()
{

	name = $('option:selected', '#id_cliente').text() ;

	var id_cliente = $('#id_cliente').val();
	
	//alert(id_cliente);
	var dataString = {
		id_cliente : id_cliente
	};
/*
	usando json
	$.ajax({
		url : path + "recepcion/getItemsByCliente",
		type : 'POST',
		data : dataString,
		cache : false,
		dataType: "json",
		success : function(data) {
			 //alert(data);
			   $("#id_item").append('').show();
			  
			  $.each(data,function(index,value) {
			    alert(data[index].id_item+' '+data[index].nombre_item);
			   
			    $("#id_item").append("<option>ID: "+data[index].nombre_item+"</option>");
			   });
			   
		}
	});
	*/
	$.ajax({
		url : path + "recepcion/listaItemsPorIdCliente",
		type : 'POST',
		data : dataString,
		cache : false,
		success : function(data) {
			 //alert(data);
			 $("#id_item").html(data);
			 $('#nombre_cliente').html(name);
			 $('#id_cliente2').val(id_cliente);   
		}
	});
	return false;
	
	
}

function confirmarEliminarTecnico(id) {
  	
  	noty({layout : 'topCenter', theme : 'noty_theme_twitter', type : 'notification', text: 'Estas seguro de eliminar este Tecnico ?',
    buttons: [
      {type: 'btn btn-primary', text: 'Si', click: function($noty) {
          	$noty.close();
          //noty({force: true, layout : 'topCenter', theme : 'noty_theme_twitter', text: 'You clicked "Ok" button', type: 'success'});
       	//alert(path+'clientes/delete/'+id);
       		window.location = path+'tecnicos/delete/'+id;
        }
      },
      {type: 'btn btn-danger', text: 'No', click: function($noty) {
          $noty.close();
          //noty({force: true, layout : 'topCenter', theme : 'noty_theme_twitter', text: 'You clicked "Cancel" button', type: 'error'});
        }
      }
    ], closable: false, timeout: false,modal:true
  });
  
}


function confirmarEliminarCliente(id) {
  	
  	noty({layout : 'topCenter', theme : 'noty_theme_twitter', type : 'notification', text: 'Estas seguro de eliminar este cliente ?',
    buttons: [
      {type: 'btn btn-primary', text: 'Si', click: function($noty) {
          	$noty.close();
          //noty({force: true, layout : 'topCenter', theme : 'noty_theme_twitter', text: 'You clicked "Ok" button', type: 'success'});
       	//alert(path+'clientes/delete/'+id);
       		window.location = path+'clientes/delete/'+id;
        }
      },
      {type: 'btn btn-danger', text: 'No', click: function($noty) {
          $noty.close();
          //noty({force: true, layout : 'topCenter', theme : 'noty_theme_twitter', text: 'You clicked "Cancel" button', type: 'error'});
        }
      }
    ], closable: false, timeout: false,modal:true
  });
  
}


function confirmarEliminarItem(id) {
  	
  	noty({layout : 'topCenter', theme : 'noty_theme_twitter', type : 'notification', text: 'Estas seguro de eliminar este Producto ?',
    buttons: [
      {type: 'btn btn-primary', text: 'Si', click: function($noty) {
          	$noty.close();
          //noty({force: true, layout : 'topCenter', theme : 'noty_theme_twitter', text: 'You clicked "Ok" button', type: 'success'});
       	//alert(path+'clientes/delete/'+id);
       		window.location = path+'items/delete/'+id;
        }
      },
      {type: 'btn btn-danger', text: 'No', click: function($noty) {
          $noty.close();
          //noty({force: true, layout : 'topCenter', theme : 'noty_theme_twitter', text: 'You clicked "Cancel" button', type: 'error'});
        }
      }
    ], closable: false, timeout: false,modal:true
  });
  
}



function confirmarEliminarDetalleItem(id_item,id_detalle_item) {
  	
  	noty({layout : 'topCenter', theme : 'noty_theme_twitter', type : 'notification', text: 'Estas seguro de eliminar este detalle ?',
    buttons: [
      {type: 'btn btn-primary', text: 'Si', click: function($noty) {
          	$noty.close();
          //noty({force: true, layout : 'topCenter', theme : 'noty_theme_twitter', text: 'You clicked "Ok" button', type: 'success'});
       	//alert(path+'clientes/delete/'+id);
       		window.location = path+'detalles_item/delete/'+id_item+'/'+id_detalle_item;
        }
      },
      {type: 'btn btn-danger', text: 'No', click: function($noty) {
          $noty.close();
          //noty({force: true, layout : 'topCenter', theme : 'noty_theme_twitter', text: 'You clicked "Cancel" button', type: 'error'});
        }
      }
    ], closable: false, timeout: false,modal:true
  });
  
}

function confirmarEliminarRecepcion(id) {
  	
  	noty({layout : 'topCenter', theme : 'noty_theme_twitter', type : 'notification', text: 'Estas seguro de eliminar esta recepción ?',
    buttons: [
      {type: 'btn btn-primary', text: 'Si', click: function($noty) {
          	$noty.close();
          //noty({force: true, layout : 'topCenter', theme : 'noty_theme_twitter', text: 'You clicked "Ok" button', type: 'success'});
       	//alert(path+'clientes/delete/'+id);
       		window.location = path+'recepcion/delete/'+id;
        }
      },
      {type: 'btn btn-danger', text: 'No', click: function($noty) {
          $noty.close();
          //noty({force: true, layout : 'topCenter', theme : 'noty_theme_twitter', text: 'You clicked "Cancel" button', type: 'error'});
        }
      }
    ], closable: false, timeout: false,modal:true
  });
  
}




