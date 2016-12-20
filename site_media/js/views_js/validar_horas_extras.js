//--Bloque de eventos
$(document).ready(function(){
	//--
	$("#modal_reporte_aceptar").click(function(e){
		var id = $("#id_modal").val();
		var mes = $("#mes_modal").val();
		var unidad = $("#unidad_modal").val();
		var accion = "aprobar_registro";
		var numero = $("#numero_modal").val();
		var data ={
						'id':id,
						'mes':mes,
						'unidad':unidad,
						'accion':accion
		};
		$.ajax({
					url:'./controladores/validarhorasController.php',
					type:'POST',
					data: data,
					cache:false,
					error: function(e){
						carga_pnoty_danger("Error","Ha ocurrido un error inesperado");
					},
					success: function(resp){
						var recordset = $.parseJSON(resp);
						if(recordset[0]==1){
							carga_pnoty_success("Informaci&oacute;n","Proceso ejecutado de manera exitosa !");
							$("#tbody_lista_nosotros").html("");
							$("#btn_seleccionar_registro"+id).prop("disabled", false);
							carga_tabla_he();
						}else if(recordset[0]==4){
							carga_pnoty_info("Informaci&oacute;n","Ya existe un registro aprobado para este mes");
						}else if(recordset[0]==5){
							carga_pnoty_info("Informaci&oacute", "El registro no se encuentra activo por lo que no se puede aprobar");
						}
						else{
							carga_pnoty_danger("Error","Ocurri&oacute; un error durante el proceso de anulaci&oacute;n");
						}
					}
		});
	});
	//--
	carga_tabla_he();
});
//--Bloque de funciones
//--
function carga_tabla_he(){
	var accion = "consultar_horas_extras_trabajadores";
	var data = {
					'accion':accion
	};
	$.ajax({
				url:"./controladores/validarhorasController.php",
				data:data,
				type:"POST",
				cache:false,
				error:function(resp){
					carga_pnoty_danger("Error","Ha ocurrido un error inesperado");
				},
				success:function(resp){
					$("#cuerpo_tabla").html("");
					$("#cuerpo_tabla").html(resp);
					$("#tbody_lista_nosotros").fadeIn();
					iniciar_datatable();
				}
	});
}
//--
//-----------------------------------------------------------
function btn_seleccionar_registro_validar(caja){
	var datos = $(caja).attr("dat");
	var arreglo_datos = datos.split("|");
	cargar_modal_form_he(arreglo_datos[0]);
	/*if(arreglo_datos[8]==1){
		$("#id_horas_extras").val(arreglo_datos[0]);
		$("#cedula_trabajador").val(arreglo_datos[2]);
		$("#nombre_trabajador").val(arreglo_datos[3]);
		$("#cargo_trabajador").val(arreglo_datos[4]);
		$("select_mes_he > option[value='"+arreglo_datos[5]+"']").attr('selected','selected');
		$("#motivo_he").val(arreglo_datos[6]);
		$("#id_trabajador").val(arreglo_datos[1]);
		//-Activo
		if(arreglo_datos[9]==1){
			$("#sol").click();
		}
		//-Inactivo
		else if(arreglo_datos[9]==2){
			$("#luna").click();
		}
		subir_top();	
		generar_detalle_horas_extras();
	}else{
		carga_pnoty_info("Informaci&oacute;n","No puede consultar datos de un registro anulado");
	}*/
}
//--------------------------------------------------------------
function cargar_modal_form_he(id){
	$("#modal_mensaje_validacion").modal("show");
	var accion = "consultar_detalle_he";
	var data = {
					'accion':accion,
					'id':id
	}
	$.ajax({
				url:"./controladores/validarhorasController.php",
				data:data,
				type:"POST",
				cache:false,
				error:function(resp){
					carga_pnoty_danger("Error","Ha ocurrido un error inesperado");	
				},
				success: function(resp){
					$("#cuerpo_mensaje_val").html(resp);
				}
	});
}
//--------------------------------------------------------------
function aprobar_reg(id, numero, unidad){
	var dat = $("#fila"+numero).attr("data");
	var vector = dat.split("|");
	if (vector[8]!=5){
		mensajes("Desea aprobar el registro #"+numero+"?");	
	}else{
		mensajes("Desea desaprobar el registro #"+numero+"?");
	}
	$("#id_modal").val(id); 
	$("#numero_modal").val(numero);
	$("#mes_modal").val(vector[5]);
	$("#unidad_modal").val(unidad);
}
//---------------------------------------------------------------
function btn_imprimir_registro(id){
	$("#form-validar-listado-he").attr("action","./controladores/reportehorasextrasController.php?id="+id);
	$("#form-validar-listado-he").attr("target","_blank")
	$("#form-validar-listado-he").submit();
}
//--------------------------------------------------------------
function btn_imprimir_planilla_dia_extra(id){
	$("#form-validar-listado-he").attr("action","./controladores/reportehorasextrasdiasController.php?id="+id);
	$("#form-validar-listado-he").attr("target","_blank")
	$("#form-validar-listado-he").submit();
}
//--------------------------------------------------------------