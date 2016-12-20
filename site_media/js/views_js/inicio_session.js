//-------Bloque de Eventos
$(document).ready(function(){
	//
	$("#btn_iniciar_session").click(function(){
		var usuario = $("#login_us").val();
		var password = $("#pass_us").val();
		var accion = "inicio_session";
		var data ={
					'usuario' : usuario,
					'password':password,
					'accion':accion
		};
		mensaje_preloader2("#campo_mensaje","Espere unos segundos mientras se verifican sus datos...");
		if(validar_is()==true){
		//----------------------------------------------------------------------------------------------
				$.ajax({
					url:'./controladores/inicioController.php',
					type:'POST',
					data: data,
					cache: false,
					error: function(resp){
						mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Ocurri&oacute; un error inesperado", "alert-danger");
					},
					success: function(resp){
						var recordset = $.parseJSON(resp);
						if(recordset["mensaje"]=='1'){
							setTimeout(function(){
								mensaje_preloader2("#campo_mensaje","Espere unos segundos mientras se verifican sus datos...");
								//limpiar_campos_is();
							},3000);
							document.forms.form_is.action='panel_us.html';
					        document.forms.form_is.submit();
						}else
						if(recordset["mensaje"]=='2'){
							mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Los datos del usuario no han sido encontrados ", "alert-danger");
						}
						else
						if(recordset["mensaje"]=='0'){
							mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Error en inicio de sesi&oacute;n", "alert-danger");
						}
						else
						if(recordset["mensaje"]=='3'){
							mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Error en registro de auditor&iacute;a", "alert-danger");
						}
					}
		});
		//----------------------------------------------------------------------------------------------	
		}
	});
	//
	$("#login_us,#pass_us").keypress(function(e) {
	  if(e.which==13){
	      $("#btn_iniciar_session").click();
	    }
	}); 
});
//-------Bloque de funciones
function limpiar_campos_is(){
	$("#login_us,#pass_us").val("");
}
function validar_is(){
	var usuario = $("#login_us").val();
	var password = $("#pass_us").val();
	if(usuario==""){
		mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Debe ingresar su nombre de usuario", "alert-danger");
		return false;
	}else if(password==""){
		mensaje_alerta("#campo_mensaje","<i class='fa fa-exclamation-circle'></i> Debe ingresar su password", "alert-danger");
		return false;
	}else
		return true;
}