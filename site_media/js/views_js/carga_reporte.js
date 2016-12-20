//--Bloque de eventos
//--Configuracion de fecha_desde
$("#fecha_desde").datepicker({
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
  },
  onSelect: function(datevalue, inst){ 
    alert("Here");
    validaciones_fechas()   
  } 
});
//--Configuracion fecha hasta
$("#fecha_hasta").datepicker({
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
//--Imprimir reporte
$("#btn_imprimir").click(function(e){
  $("#form-imprimir-reporte").attr("action","./controladores/reporteHorasExtrasDetalleController.php");
  $("#form-imprimir-reporte").attr("target","_blank")
  $("#form-imprimir-reporte").submit();
});
//--
$("#btn_limpiar").click(function(e){
  $("#fecha_desde,#fecha_hasta,#select_dptos").val("");
});
//--------------------------------------------------------------------------------------------------------
//--Funciones a ejecutarse al cargar principal
cargar_dptos();
//--Bloque de funciones
function validaciones_fechas(){
  var fecha_desde = validar_fecha_formato($("#fecha_desde").val());
  $("#fecha_hasta").datepicker('option', 'minDate', new Date(fecha_desde));
}
function cargar_dptos(){
  var data = {
                "accion":"consultar_select_dptos"
  };
  $.ajax({
            url:"./controladores/cargahorasController.php",
            type:"POST",
            cache:false,
            data:data,
            error: function(resp){
              carga_pnoty_danger("Error","Ha ocurrido un error inesperado");
            },
            success:function(resp){
              if(resp!="error"){
                  $("#select_dptos").html(resp);
              }              
            }
  });
}