//--Bloque de eventos
$(document).ready(function(){

	//--Al hacer click al btn +
	$("#agregar_fecha").click(function(e){
		cargar_filas();
	});
	//--Al hacer click al btn -
	$("#quitar_fecha").click(function(e){
		eliminar_filas();
		sumar_totales();
	});
	//--
	$("#cedula_trabajador").keypress(function(e) {
	  if(e.which==13){
	      consultar_trabajador();
	    }
	});
	//--
	$("#buscar_trabajador").click(function(){
		consultar_trabajador();
	});
	//--
	$("#btn_guardar_horas_extras").click(function(e){
		if($("#estatus_trabajador").val()=="5"){
		//---
			carga_pnoty_info("Informaci&oacute;n","No puede modificar un registro aprobado !");
		//---	
		}
		else{	
			if( validar_campos()==true){
			//--	
				e.preventDefault();
				vector = new Array( new Array(), new Array(), new Array(), new Array());
				var accion = "guardar_horas_extras";
				var id_trabajador = $("#id_trabajador").val();
				var mes = $("#select_mes_he").val();
				var horas_totales = $("#horas_totales").text();
				var id_he = $("#id_horas_extras").val();
				var estatus=1;
				var tipo_hora=3;
				//Valores dinamicos de tabla de he...
				//--
				var cantidad = $(".fila_he").size();
				for(i=0;i<cantidad;i++){
					x = i+1;
					vector[i][0] = $("#fecha_he"+x).val();
					vector[i][1] = $("#hora_ini"+x).val();
					vector[i][2] = $("#hora_fin"+x).val();
					vector[i][3] = $("#cantidad_he"+x).val();
					vector[i][4] = $("#motivo"+x).val();
				}
				//--
				var data = {
								'accion':accion,
								'id_trabajador':id_trabajador,
								'mes':mes,
								'horas_totales':horas_totales,
								'estatus':estatus,
								'tipo_hora':tipo_hora,
								'vector':vector,
								'id_he':id_he
				};
				$.ajax({
								url:'./controladores/cargahorasController.php',
								cache:'false',
								type:'POST',
								data:data,
								error:function(resp){
									carga_pnoty_danger("Error","Ha ocurrido un error inesperado");	
								},
								success:function(resp){
									var recordset = $.parseJSON(resp);
									//alert(recordset);
									if(recordset[0]==4){
										carga_pnoty_danger("Error","Ya ha sido registrado el d&iacute;a adicional trabajado por este empleado, correspondiente al mes ");
									}else
									if(recordset[0]==1){
										carga_pnoty_success("Informaci&oacute;:",'Registro exitoso!');
										eliminar_grupo_filas();
										limpiar_grupo_campos();
										$("#tbody_lista_nosotros").html("");
										carga_tabla_he();
									}else
									if(recordset[0]==5){
										carga_pnoty_danger("Error","Ocurri&oacute; un error al actualizar datos");
									}else
									if(recordset[0]==6){
										carga_pnoty_success("Informaci&oacute;n","Actualizaci&oacute;n exitosa !");
										eliminar_grupo_filas();
										limpiar_grupo_campos();
										$("#tbody_lista_nosotros").html("");
										carga_tabla_he();
									}
								}
				});
			//--
			}
		}		
	});
	//--
	$("#btn_limpiar").click(function(){
		eliminar_grupo_filas();
		limpiar_grupo_campos();	
	});
	//--
	$("#select_mes_he").change(function(){
		//validar_fechas();
		eliminar_grupo_filas_todas();
		limpiar_grupo_campos2();
		cargar_filas();
	});
	//--
	$("#modal_reporte_aceptar").click(function(e){
		var id = $("#id_modal").val();
		var mes = $("#mes_modal").val();
		var accion = "anular_registro";
		var numero = $("#numero_modal").val();
		var data ={
						'id':id,
						'mes':mes,
						'accion':accion
		};
		$.ajax({
					url:'./controladores/cargahorasController.php',
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
							eliminar_grupo_filas();
							limpiar_grupo_campos();
							$("#tbody_lista_nosotros").html("");
							carga_tabla_he();
						}else if(recordset[0]==4){
							carga_pnoty_info("Informaci&oacute;n","Ya existe un registro activo para este mes");
						}else if(recordset[0]==6){
							carga_pnoty_info("Informaci&oacute;n","Ya existe un registro aprobado para este mes");
						}
						else{
							carga_pnoty_danger("Error","Ocurri&oacute; un error durante el proceso de anulaci&oacute;n");
						}
					}
		});
	});
	//--
	cargar_filas();
	cargar_mes();
	carga_tabla_he();
});
//--Bloque de funciones
//--Carga de filas
function cargar_filas(){
	var valore = $('.fila_he').length+1;
	var accion = "listar_filas_he";
	var data = {
					"valore":valore,
					"accion":accion
	}
	$.ajax({
				url:"./controladores/cargahorasController.php",
				cache:'false',
				type:"POST",
				data:data,
				error:function(resp){
					carga_pnoty_danger("Error","Ha ocurrido un error inesperado");
				},
				success:function(resp){
					$(resp).hide().appendTo("#tbody_he").fadeIn(500);
					//--Para datapicker de fila
					if(valore==1){
						dia_inicio= primer_dia($("#select_mes_he").val());
					}else{
						valore2 = valore-1;
						dia =$("#fecha_he"+valore2).val();
						dia = dia.split("/");
						dias = parseInt(dia[0])+1;
						dia_inicio = dia[2]+","+dia[1]+","+dias;
					}
					$("#fecha_he"+valore).datepicker({
					  minDate: new Date(dia_inicio),
				      maxDate: new Date(ultimo_dia($("#select_mes_he").val())),
				      prevText: '<i class="fa fa-chevron-left"></i>',
				      nextText: '<i class="fa fa-chevron-right"></i>',
				      showButtonPanel: false,
				      showOn: 'both',
				      buttonText: '<i class="fa fa-calendar-o"></i>',
				      dateFormat:'dd/mm/yy',
				      beforeShow: function(input, inst) {
				        var newclass = 'admin-form';
				        var themeClass = $(this).parents('.admin-form').attr('class');
				        var smartpikr = inst.dpDiv.parent();
				        if (!smartpikr.hasClass(themeClass)) {
				          inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
				        }
				      }
				    });
				    //--Para timepicker de hora inicio
				    $('#hora_ini'+valore).timepicker({
				    	showMeridian	: false
				    });
				    $('#hora_fin'+valore).timepicker({
				    	minTime: $("#hora_ini"+valore).val(),
				    	showMeridian	: false
				    });
				    /*$('#hora_ini'+valore).timepicker({
				    	  showButtonPanel: false,
				    	  showOn: 'both',
				    	  buttonText: '<i class="fa fa-hourglass-start" aria-hidden="true"></i>',
					      beforeShow: function(input, inst) {
					        var newclass = 'admin-form';
					        var themeClass = $(this).parents('.admin-form').attr('class');
					        var smartpikr = inst.dpDiv.parent();
					        if (!smartpikr.hasClass(themeClass)) {
					          inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
					        }
					      }
				    });
				    //--
				    //--Para timepicker de hora fin
				    $('#hora_fin'+valore).timepicker({
				    	  showButtonPanel: false,
				    	  showOn: 'both',
				    	  buttonText: '<i class="fa fa-hourglass-end" aria-hidden="true"></i>',
					      beforeShow: function(input, inst) {
					        var newclass = 'admin-form';
					        var themeClass = $(this).parents('.admin-form').attr('class');
					        var smartpikr = inst.dpDiv.parent();
					        if (!smartpikr.hasClass(themeClass)) {
					          inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
					        }
					      },
					      hourMin:'00',minuteMin:'00'
				    });*/
				    //--
				}
	});
}
//--Eliminar filas
function eliminar_filas(){
	//--
	var valore = $('.fila_he').size();
	if (valore>1){
		//$("#cuerpo_horas_extras"+valore).remove();
		$("#cuerpo_horas_extras"+valore).fadeOut(100, function() { $(this).remove(); });
	}
	//--
}
//--Eliminar grupos de filas
function eliminar_grupo_filas(){
	var valore = $('.fila_he').size();
	for(i=valore;i>1;i--){
		$("#cuerpo_horas_extras"+i).remove();
	}
}
//--Limpiar grupos campos
function limpiar_grupo_campos(){
	$("#cedula_trabajador,#nombre_trabajador,#cargo_trabajador,#id_horas_extras,#estatus_trabajador").val("");
	$("#fecha_he1,#hora_ini1,#hora_fin1,#cantidad_he1,#motivo1").val("");
	$("#horas_totales").text("00:00");
}
//--Limpiar grupos campos
function limpiar_grupo_campos2(){
	$("#fecha_he1,#hora_ini1,#hora_fin1,#cantidad_he1,#motivo1").val("");
	$("#horas_totales").text("00:00");
}
//--Carga los meses al select
function cargar_mes(){
	$("#select_mes_he").html(cargar_select_mes());
	var fecha = new Date();
    var var_mes = fecha.getMonth()+1;//Obtengo el mes actual
    $('#select_mes_he > option[value="'+var_mes+'"]').attr('selected','selected');
}
//--Carga de datapicker
function activar_fecha(valore){
	//-- En el change del mes
	//--Para datapicker de fila
	valore2 = valore-1;
	if($("#fecha_he"+valore2).length>0){
	//--
		dia =$("#fecha_he"+valore2).val();
		dia = dia.split("/");
		dias = parseInt(dia[0])+1;
		dia_inicio = dia[2]+","+dia[1]+","+dias;
		if(valore==1){
			dia_inicio= primer_dia($("#select_mes_he").val());
		}else{
			valore2 = valore-1;
			dia =$("#fecha_he"+valore2).val();
			dia = dia.split("/");
			dias = parseInt(dia[0])+1;
			dia_inicio = dia[2]+","+dia[1]+","+dias;
		}
		$("#fecha_he"+valore).datepicker('option', 'minDate', new Date(dia_inicio));
		$("#fecha_he"+valore).datepicker('option', 'maxDate', new Date(ultimo_dia($("#select_mes_he").val())));
	//--	
	}
}
//--Carga ultimo dia de mes 
function cargar_ultimo_dia(mes){
	var ultimo_dia = 0;
	if(mes!="0"){
		if(mes=='01' || mes=='03' || mes=='05' || mes=='07' || mes=='08' || mes=='10' || mes=='12'){
			ultimo_dia = "31";
		}else if(mes=='02' || mes=='04' || mes=='06' || mes=='09' || mes=='11'){
			ultimo_dia = "30";
		}
	}
	return ultimo_dia;
}
//--Devuelve la fecha del primer dia
function primer_dia(mes){
	var fecha = new Date();
	var anio = fecha. getFullYear();
	fecha_armada = anio+","+mes+",01"
	return fecha_armada;
}
//--Devuelve la fecha del ultimo dia
function ultimo_dia(mes){
	var fecha = new Date();
	var anio = fecha.getFullYear();
	mes = mes;
	fecha_armada = anio+","+mes+","+cargar_ultimo_dia(mes);
	return fecha_armada;
}
//--Devuelve la duracion de el tiempo transcurrido
function tiempo_transcurrido(valore){
	var hora_ini = $("#hora_ini"+valore).val();
	var hora_fin = $("#hora_fin"+valore).val();
	var duracion  = calcular_duracion(hora_ini, hora_fin,'diferencia');
	if(duracion<"00:00"){
		$("#hora_fin"+valore).val($("#hora_ini"+valore).val());
		hora_ini = $("#hora_ini"+valore).val();
		hora_fin = $("#hora_fin"+valore).val();
		duracion  = calcular_duracion(hora_ini, hora_fin,'diferencia');
	}
	$("#cantidad_he"+valore).val(duracion);
	sumar_totales();
}
//--Suma los totales de los tiempos transcurridos
function sumar_totales(){
	$("#horas_totales").text("00:00");
	valor = $("#horas_totales").text();
	$(".cantidad_horas").each(function(){
		valor = calcular_duracion(valor,$(this).val(),'suma');	
	});
	$("#horas_totales").text(valor);
}
//Devuelve la hora 
function hora_inicio_captura(valore){
	hora_min = $("#hora_ini"+valore).val();
	hora = hora_min.split(":");
	return hora[0]; 
}
//Devuelve los minutos
function minuto_inicio_captura(valore){
	hora_min = $("#hora_fin"+valore).val();
	minuto = hora_min.split(":");
	return minuto[1]; 
}
//--
function cambio_hora(valore){
	//$("#hora_fin"+valore).timepicker({'hourMin': '01'});
	//$("#hora_fin"+valore).timepicker("option", "hourMin", hora_inicio_captura(valore));
	//$("#hora_fin"+valore).timepicker("option", "stepMinute", minuto_inicio_captura(valore));
	//--
	$("#hora_fin"+valore).timepicker({
		minTime: $("#hora_ini"+valore).val(),
		showMeridian: false
    });
}
//Carga los datos de un trabajador consultado por numero de cedula
function consultar_trabajador(){
	var accion = "consultar_trabajador";
	var cedula = $("#cedula_trabajador").val();
	var data = {
					"accion":accion,
					"cedula":cedula
	};
	$.ajax({
				url :"./controladores/cargahorasController.php",
				data:data,
				type:"POST",
				cache:false,
				error:function(resp){
					carga_pnoty_danger("Error","Ha ocurrido un error inesperado");
				},
				success:function(resp){
					var recordset = $.parseJSON(resp);
					if(recordset!="error"){
						$("#nombre_trabajador").val(recordset[0][0]+" "+recordset[0][1]);
						$("#cargo_trabajador").val(recordset[0][2]);
						$("#id_trabajador").val(recordset[0][3]);	
						
					}else{
						carga_pnoty_info("Informaci&oacute;n:","Trabajador no encontrado");
					}					
				}

	});
}
//--Valida si los campos se ecnuetran llenos
function validar_campos(){
	var horas_totales = $("#horas_totales").text();
	horas_totales = horas_totales.split(":");
	if($("#cedula_trabajador").val()==""){
		carga_pnoty_info("Informaci&oacute;n:","Debe incluir la cédula del trabajador");
		$("#cedula_trabajador").focus();
		return false;
	}else if($("#nombre_trabajador").val()==""){
		carga_pnoty_info("Informaci&oacute;n:","Debe incluir nombres del trabajador");
		$("#nombre_trabajador").focus();
		return false;
	}else if($("#cargo_trabajador").val()==""){
		carga_pnoty_info("Informaci&oacute;n:","Debe incluir cargo del trabajador");
		$("#cargo_trabajador").focus();
		return false;
	}
	else if($("#select_mes_he").val()=="0"){
		carga_pnoty_info("Informaci&oacute;n:","Debe seleccionar un mes");
		$("#select_mes_he").focus();
		return false;
	}
	else
		if (validar_filas() == false){
			return false;
		}
	else if($("#horas_totales").text()=="00:00"){
		carga_pnoty_info("Informaci&oacute;n","Las horas totales no pueden ser 0");
		return false;
	}else if(horas_totales[0]< 4){
		carga_pnoty_info("Informaci&oacute;n","Las horas totales no pueden ser  menores a 04:00 hrs");
		return false;
	}	
	else{
		return true;
	}
}
//--
//Valida cada fila de la tabla
function validar_filas(){
	var cantidad = $(".fila_he").size();
	for(i=0;i<=cantidad;i++){
		x = i+1;
		if($("#fecha_he"+x).val()==""){
			$("#fecha_he"+x).focus();
			carga_pnoty_info("Informaci&oacute;n","Debe señalar la fecha de la hora extra de la fila #"+x);
			return false;
		}else
		if($("#hora_ini"+x).val()==""){
			$("#hora_ini"+x).focus();
			carga_pnoty_info("Informaci&oacute;n","Debe señalar la hora de inicio de la fila #"+x);
			return false;
		}else
		if($("#hora_fin"+x).val()==""){
			$("#hora_fin"+x).focus();
			carga_pnoty_info("Informaci&oacute;n","Debe señalar la hora final de la fila #"+x);
			return false;
		}else
		if($("#cantidad_ini"+x).val()==""){
			carga_pnoty_info("Informaci&oacute;n","Debe señalar la cantidad de horas extras de la fila #"+x);
			return false;
		}
		else
		if($("#motivo"+x).val()==""){
			carga_pnoty_info("Informaci&oacute;n","Debe señalar el motivo de la fila #"+x);
			return false;
		}
	}
}
//--
function validar_fechas(){
	dia_inicio= primer_dia($("#select_mes_he").val());
	//alert(dia_inicio);
	var cantidad = $(".fila_he").size();
	for(i=0;i<=cantidad;i++){
		x = i+1;
		$("#fecha_he"+x).datepicker('option', 'minDate', new Date(dia_inicio));
		$("#fecha_he"+x).datepicker('option', 'maxDate', new Date(ultimo_dia($("#select_mes_he").val())));
	}	
}	
//--
function carga_tabla_he(){
	var accion = "consultar_dias_extras_trabajadores";
	var unidad = $("#unidad_administrativa").val();
	var data = {
					'accion':accion,
					'unidad':unidad
	};
	$.ajax({
				url:"./controladores/cargahorasController.php",
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

function btn_seleccionar_registro(caja){
	var datos = $(caja).attr("dat");
	var arreglo_datos = datos.split("|");
	if(arreglo_datos[8]==1 || arreglo_datos[8]==5){
		$("#id_horas_extras").val(arreglo_datos[0]);
		$("#cedula_trabajador").val(arreglo_datos[3]);
		$("#nombre_trabajador").val(arreglo_datos[2]);
		$("#cargo_trabajador").val(arreglo_datos[4]);
		if(arreglo_datos[5]<10){
			mes = "0"+arreglo_datos[5];
		}else{
			mes = arreglo_datos[5];
		}
		$("#select_mes_he > option[value='"+mes+"']").attr('selected','selected');
		$("#id_trabajador").val(arreglo_datos[1]);
		$("#estatus_trabajador").val(arreglo_datos[8]);
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
	}
}
//--
function generar_detalle_horas_extras(){
	var id = $("#id_horas_extras").val();
	var accion = "consulta_detalle_horas_extras";
	var data = {
					"id":id,
					"accion":accion
	}
	$.ajax({
				url:"./controladores/cargahorasController.php",
				data:data,
				cache:false,
				type:"POST",
				error:function(resp){
					carga_pnoty_danger("Error","Ha ocurrido un error inesperado");
				},
				success:function(resp){
					//alert(resp);
					if(resp!="error"){
						$("#tbody_he").html(resp);
						sumar_totales();
						activar_controles_fechas();
					}
				}
	});
}
//--
function activar_controles_fechas(){
	valore = 1;
	$(".cantidad_horas").each(function(){
	//----------------------------------
		if(valore==1){
			dia_inicio= primer_dia($("#select_mes_he").val());
		}else{
			valore2 = valore-1;
			dia =$("#fecha_he"+valore2).val();
			dia = dia.split("/");
			dias = parseInt(dia[0])+1;
			dia_inicio = dia[2]+","+dia[1]+","+dias;
		}
		$("#fecha_he"+valore).datepicker({
		  minDate: new Date(dia_inicio),
	      maxDate: new Date(ultimo_dia($("#select_mes_he").val())),
	      prevText: '<i class="fa fa-chevron-left"></i>',
	      nextText: '<i class="fa fa-chevron-right"></i>',
	      showButtonPanel: false,
	      showOn: 'both',
	      buttonText: '<i class="fa fa-calendar-o"></i>',
	      dateFormat:'dd/mm/yy',
	      beforeShow: function(input, inst) {
	        var newclass = 'admin-form';
	        var themeClass = $(this).parents('.admin-form').attr('class');
	        var smartpikr = inst.dpDiv.parent();
	        if (!smartpikr.hasClass(themeClass)) {
	          inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
	        }
	      }
	    });
	    //--Para timepicker de hora inicio
	    $('#hora_ini'+valore).timepicker({
	    	showMeridian	: false
	    });
	    $('#hora_fin'+valore).timepicker({
	    	minTime: $("#hora_ini"+valore).val(),
	    	showMeridian	: false
	    });
	//----------------------------------
	valore = valore +1;
	});
}
//--------------------------------------------------------------
function activar_reg(id, numero){
	var dat = $("#fila"+numero).attr("data");
	var vector = dat.split("|");
	if(vector[8]==5){
		carga_pnoty_info("Informaci&oacute;n","No puede modificar el estatus de un registro aprobado");
	}else
	if(vector[8]==4){
		carga_pnoty_info("Informaci&oacute;n","No puede modificar el estatus de un registro desaprobado por RRHH");
	}
	else if (vector[8]==1){
		mensajes("Desea anular de estatus al registro #"+numero+"?");	
	}else{
		mensajes("Desea activar de estatus al registro #"+numero+"?");
	}
	$("#id_modal").val(id); 
	$("#numero_modal").val(numero);
	$("#mes_modal").val(vector[5]);
}
//--------------------------------------------------------------