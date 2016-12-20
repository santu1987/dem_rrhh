$("#btn_nuevo_usuario").click(function(){
	$("#cuerpo_principal").load("site_media/templates/usuarios.html");
});
$("#btn_imprimir").click(function(){
	$("#form_listado_us").attr("action","./controladores/reporteusController.php");
	$("#form_listado_us").submit();
});
//--Bloque de funciones
function consultar_usuario(numero){
	var datos_us = $("#tab"+numero).attr("data");
	var datos = datos_us.split("|");
	$("#cuerpo_principal").load("./site_media/templates/usuarios.html");
	if($("#btn_estatus_"+numero).hasClass("btn-danger")){
		valor_estatus="inactivo";
	}else if($("#btn_estatus_"+numero).hasClass("btn-success")){
		valor_estatus="activo";
	}		
	setTimeout(function(){
		$("#id_us").val(datos[0]);
		$("#select_tipo_usuario").val(datos[2]);
		$("#text_login").val(datos[1]);

		if(valor_estatus=='inactivo'){
			$("#btn_guardar_us").addClass("disabled");
		}else if(valor_estatus=='activo'){
			$("#btn_guardar_us").removeClass("disabled");
		}
	},1000);
}
//--
function activar_us(numero){
	var datos_us = $("#tab"+numero).attr("data");
	var datos = datos_us.split("|");
	var id_us = datos[0];
	var accion = 'activar_usuario';
	var data = {
					'id_us':id_us,
					'accion':accion};
	$.ajax({
				url:'./controladores/usuarioController.php',
				type:'POST',
				data:data,
				cache:false,
				error:function(resp){
					console.log(resp);
					mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Ocurri&oacute; un error inesperado", "alert-danger");
				},	
				success:function(resp){
					var recordset = $.parseJSON(resp);
					if(recordset[0]==1){
						if(recordset[1]=="activar"){
							$("#icono_estatus_"+numero).removeClass("fa-unlock").addClass("fa-lock");
							$("#btn_estatus_"+numero).removeClass("btn-danger").addClass("btn-success");
							$("#btn_estatus_"+numero).attr({'title':'Inactivar usuario'});
							$("#div_estatus_"+numero).text("Activo");
							mensaje_alerta("#campo_mensaje","<i class='fa fa-check'></i> Usuario activo", "alert-success");
						}else{
							$("#icono_estatus_"+numero).removeClass("fa-lock").addClass("fa-unlock");
							$("#btn_estatus_"+numero).removeClass("btn-success").addClass("btn-danger");
							$("#btn_estatus_"+numero).attr({'title':'Activar usuario'});
							$("#div_estatus_"+numero).text("Inactivo");
							mensaje_alerta("#campo_mensaje","<i class='fa fa-check'></i> Usuario inactivo", "alert-danger");
						}
					}else if(recordset[0]==0){
						mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Ocurri&oacute; un error inesperado", "alert-danger");
					}else if(recordset[0]==-1){
						mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Ocurri&oacute; un error en consulta de estatus ", "alert-danger");
					}
				}
	});				
}
//--