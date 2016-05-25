$('#estado').hide;
$('form').validate({
                
onKeyup : true,
sendForm : false,
eachValidField : function() {
	$(this).closest('div').removeClass('error').addClass('success');
			},
					eachInvalidField : function() {
				$(this).closest('div').removeClass('success').addClass('error');
			},	
			conditional : {
				confirmarUser : function() {
					return $('#id_nombre_real').val().length > 5;
				},
                confirmaNombre : function() {
					return $('#id_nombre_real').val() >= 5;
				},
                confirmaPass : function() {
                	return $('#id_pass').val() == $('#id_pass_confirm').val();
				},
				confirmaConfPass : function() {
                	return $('#id_pass').val() == $('#id_pass_confirm').val();
				}
			},		  
			description : {
					user : {
						conditional : '<div class="alert alert-error"><span class="icon-remove"></span>El nombre de usuario es muy corto</div>'
                    },
                    nombre:{
                    	conditional : '<div class="alert alert-error"><span class="icon-remove"></span>El nombre de usuario es muy corto</div>'
                    },
                    pass:{
						conditional : '<div class="alert alert-error"><span class="icon-remove"></span>Las contraseñas no coinciden</div>'
					},
					confpass:{
						conditional : '<div class="alert alert-error"><span class="icon-remove"></div>'
					}
              
                },
                valid : function(){
                    $('#estado').html('<span class="icon-ok"></span>Formulario validado!! - Sebastián Matus <br>');
                    $('#estado').show;
                }
			});
