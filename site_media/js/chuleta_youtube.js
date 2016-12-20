function cargar_enlace() 
	{
		var enlace_url=$("#material_multimedia1").val();
		var material2=enlace_url.split("=");
		var material="https://www.youtube.com/v/"+material2[1];
		var enlace=ytVidId(material);
		if(enlace==false)
		{
			mensajes2("<i class='fa fa-exclamation-circle fa-2x' style='color:#bc2328'></i> Ingres&oacute; una url  no v&aacute;lida");
			$("#material_multimedia1").val("");
			$("#preview_material_multimedia").html("");
			document.getElementById("preview_material_multimedia").style.display="none";
		}
		else 
		{
			var data={
   			            enlace:material
   			          }
   			$.ajax({
   						url:'./controladores/controlador.validar_url.php',
   						data:data,
   						type:'POST',
   						cache:false,
						error: function(request,error) 
				        {
				            console.log(arguments);
				            mensajes(3);//error desconocido
				        },
				        success: function(html)
				        {
				        		//alert(html);
				        		var recordset=$.parseJSON(html);
				        		if(recordset[0]==true)
				        		{
				        			cargar_div_video(material);
				        		}else
				        		if(recordset[0]==false)
				        		{
				        			mensajes2("<i class='fa fa-exclamation-circle fa-2x' style='color:#bc2328'></i> Error:El enlace no es  v&aacute;lido");
				        			$("#material_multimedia1").val("");
									$("#preview_material_multimedia").html("");
									document.getElementById("preview_material_multimedia").style.display="none";
				        		}	
				        }
	  			});          
		}
//////////////////////////////////////////////////////////////////////////////
function cargar_div_video(material_contenido)
	{
		document.getElementById("preview_material_multimedia").style.display="block";
		var previa='<object height="100" width="200">\
					<param name="movie" value="'+material+'">\
					<param name="wmode" value="transparent">\
					<embed src="'+material_contenido+'" type="application/x-shockwave-flash" wmode="transparent" height="100" width="200">\
					</object>';
		$("#preview_material_multimedia").html(previa);
	}		
	}