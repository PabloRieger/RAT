jQuery(document).ready(function() {

	mudaSelect = function ()
		{
			jQuery('.itens_select').change(function() {
				var tipo_item = jQuery(this).find(':selected').data('tipo');
				var id_item = jQuery(this).val();
				jQuery('.itens_select').removeClass('temp_select');
				jQuery(this).addClass('temp_select');
				var temp_select = jQuery(this);
					jQuery.getJSON(le_link + "method=glpi.getObject&id="+id_item+"&itemtype="+tipo_item+"", function( data ) {
						jQuery('.temp_select').parent().next().text(data['serial']);
						if (jQuery('.temp_select').parent().next().next().hasClass('last_td')) {
							jQuery('.temp_select').parent().next().next().text(data['otherserial']);
							//alert(jQuery('.temp_select').parent().next().next('td').html());
						}
						//jQuery('.temp_select').parent().next().next().text(data['otherserial']);
					});
			});
		}

	listaItens = function ()
		{
			jQuery.getJSON(le_link + "method=datainjection.listItemtypes", function( data ) {
				// jQuery('#select_itens')
				//     .find('option')
				//     .remove()
				//     .end()

				jQuery('#select_itens')
				    .find('option')
				    .remove()
				    .end()
				;

				jQuery('#select_itens')
				    .find('optgroup')
				    .remove()
				    .end()
				;
				    //.append('<option value="whatever">text</option>')
				    //.val('whatever')
				;
				console.log(data);
				jQuery.each( data, function( key, val ) {
					switch(key){
						case "Computer":
							jQuery('#select_itens')
							   .append("<optgroup class='opt_"+key+"' label="+val+">");
							for (var i in key){
								//navego pelas chaves do array como um for
								itematSelect(key, i, ".opt_"+key);
							}
						//itemIndividual("Computer", "1");
						break;

						case "Monitor":
							jQuery('#select_itens')
							   .append("<optgroup class='opt_"+key+"' label="+val+">");
							for (var i in key){
								itematSelect(key, i, ".opt_"+key);
							}
						break;

						case "DeviceDrive":
							jQuery('#select_itens')
							   .append("<optgroup class='opt_"+key+"' label="+val+">");
							for (var i in key){
								itematSelect(key, i, ".opt_"+key);
							}
						break;

						case "DeviceMemory":
							jQuery('#select_itens')
							   .append("<optgroup class='opt_"+key+"' label="+val+">");
							for (var i in key){
								itematSelect(key, i, ".opt_"+key);
							}
						break;

						case "DeviceMotherboard":
							jQuery('#select_itens')
							   .append("<optgroup class='opt_"+key+"' label="+val+">");
							for (var i in key){
								itematSelect(key, i, ".opt_"+key);
							}
						break;

						case "Phone":
							jQuery('#select_itens')
							   .append("<optgroup class='opt_"+key+"' label="+val+">");
							for (var i in key){
								itematSelect(key, i, ".opt_"+key);
							}
						break;

						case "Printer":
							jQuery('#select_itens')
							   .append("<optgroup class='opt_"+key+"' label="+val+">");
							for (var i in key){
								itematSelect(key, i, ".opt_"+key);
							}
						break;

						case "DeviceMotherboard":
							jQuery('#select_itens')
							   .append("<optgroup class='opt_"+key+"' label="+val+">");
							for (var i in key){
								itematSelect(key, i, ".opt_"+key);
							}
						break;



					}
				});
			});
		}


	itematSelect = function (tipo, id, opt_key)
		{

				jQuery.getJSON(le_link + "method=glpi.getObject&id="+id+"&itemtype="+tipo+"", function( data ) {
					//console.log(data);
					//alert(opt_key);
					var nome = data["name"];
					if (nome !== undefined) { //id != 0 || 
						//alert(nome);
						jQuery('#select_itens')
						    .find(opt_key)
						    .append('<option data-tipo="'+tipo+'" value="'+id+'">'+data["name"]+'</option>')
						;
					}
				});

		}
	
	jQuery('a').click(function() {
		//event.preventDefault();
	});

	jQuery.getJSON(le_link + "method=glpi.getMyInfo", function( data ) {
		jQuery.each( data, function( key, val ) {
			switch(key){
				case "id":
					jQuery("#td_tecnico b input").val(data["firstname"] + " " + data["realname"]);
				break;
			}
		});
	});

	jQuery("#get_rat").click(function() {
		jQuery( ".data" ).text("");
			var id_senha = jQuery("#num_rat").val();
		jQuery.getJSON(le_link + "method=glpi.getTicket&ticket="+id_senha, function( data ) {
		  var items = [];
		  jQuery.each( data, function( key, val ) {
			//items.push( "<li id='" + key + "'>" + val + "</li>" );
			//console.log(key, val);
			//if (key == "name"){
			//	alert("test");
			//  }
			switch(key) {
				case "name":
					//alert("name");
					break;

				case "content":
					//alert(val);
					jQuery("#registro textarea").text(val);
					break;

				case "items":
					//alert(val);
					 jQuery.each( val, function( key ) {
					 	//console.log(data["items"]["0"]);
						 	var id_item = data["items"]["0"]["items_id"];
						 	var type_item = data["items"]["0"]["itemtype"];
						 	//alert(type_item);
						jQuery.getJSON(le_link + "method=glpi.getObject&id="+id_item+"&itemtype="+type_item, function( data ) {
								jQuery( "#data_maquina" ).text("");
								jQuery( "#data_maquina" ).append( ( data["name"] ) );
								jQuery( "#data_serial" ).text("");
								jQuery( "#data_serial" ).append( ( data["otherserial"] ) );
								//console.log(data);

								var id_local = data["locations_id"];
								jQuery.getJSON(le_link + "method=glpi.getObject&id="+id_local+"&itemtype=location", function( data ) {
									console.log(data["completename"]);
									jQuery( "#data_local" ).append( ( data["completename"] ) );
								});
						});
					 });
					break;

				case "date":
					var date = new Date(val);
					var le_data = (date.getDate() + 0) + '/' + (date.getMonth() + 1) + '/' +  date.getFullYear() + " " + date.getHours() + ":" + date.getMinutes();				
					jQuery( "#data_hora" ).html(le_data);
					jQuery("#td_abertura").html(le_data);
					//alert(val);
					break;

				case "solvedate":
					//alert(val);
					var date = new Date(val);
					var le_data = (date.getDate() + 0) + '/' + (date.getMonth() + 1) + '/' +  date.getFullYear() + " " + date.getHours() + ":" + date.getMinutes();
					jQuery("#td_datafim").html(le_data);
					break;

				case "locations_id":
					//alert(val);
					jQuery.getJSON(le_link + "method=glpi.getObject&id="+val+"&itemtype=location", function( data ) {
						console.log(data);
						jQuery( "#data_localidade " ).text( data['completename'] );
					});
					//jQuery("#td_datafim").html(val);
					break;

				case "users":
					//alert(val);
					  jQuery.each( val, function( key ) {
						switch(key) {
							case "assign":
								switch("users_id") {
								default:
								//alert(val);
								//console.log(val["assign"]);
								var id_user_tech = val["assign"]["0"]["users_id"];
								jQuery.getJSON(le_link + "method=glpi.getObject&id="+id_user_tech+"&itemtype=user", function( data ) {
									//console.log(data);
									jQuery( "#data_tecnico" ).text("");
									jQuery( "#data_tecnico" ).next('input').val( ( data["firstname"] + " " + data["realname"] ) );
								});
								break;
								}

								break;

							case "requester":
								switch("users_id") {
								default:
								//alert(val);
								//console.log(val["assign"]);
								var id_user_req = val["requester"]["0"]["users_id"];
								jQuery.getJSON(le_link + "method=glpi.getObject&id="+id_user_req+"&itemtype=user", function( data ) {
									console.log(data);
									jQuery( "#data_user" ).next('input').val( ( data["firstname"] + " " + data["realname"] ) );
								});
								break;
								}

								break;


							default:
								break;
						}
					  });
					break;

				case "solution":
					//alert(val);
					jQuery("#resolucao textarea").val(val);
						$('body').on( 'change keyup keydown paste cut', 'textarea', function (){
							$(this).height(0).height(this.scrollHeight);
						}).find( 'textarea' ).change();
					break;
					default:
						//alert("null");
						break;
			}
		  });
		});
	});

	jQuery("#add_material").click(function() {
		jQuery("#material_usado table tbody").append("<tr><td class='temp_query'><a href='#'>X</a></td><td></td><td class='last_td'></td></tr>");
	            jQuery('#select_itens')
	                .clone()
	                .appendTo(".temp_query");
	           jQuery(".temp_query").removeClass();
	           mudaSelect();
		jQuery("table tbody a").click(function() {
			//event.preventDefault();
			jQuery(this).parent().parent().remove();
		});
	});

	jQuery("#add_material_manual").click(function() {
		jQuery("#material_usado table tbody").append("<tr><td><a href='#'>X</a><input type='text' style='padding-left: 5px;'> </td><td><input type='text' ><br></td><td><input type='text' ><br></td></tr>");
			jQuery("table tbody a").click(function() {
				//event.preventDefault();
				jQuery(this).parent().parent().remove();
			});
	});

	jQuery("#add_material_retirado").click(function() {
		jQuery("#material_retirado table tbody").append("<tr><td class='temp_query'><a href='#'>X</a></td><td></td><td><input type='text' size='55' style='width: 100%;'></td></td></tr>");
	            jQuery('#select_itens')
	                .clone()
	                .appendTo(".temp_query");
	           jQuery(".temp_query").removeClass();
	           mudaSelect();
		jQuery("table tbody a").click(function() {
			//event.preventDefault();
			jQuery(this).parent().parent().remove();
		});
	});

	jQuery("#add_material_retirado_manual").click(function() {
		jQuery("#material_retirado table tbody").append("<tr><td style='vertical-align: middle;' class=''><a href='#'>X</a><input type='text' style='padding-left: 5px;'></td><td style='vertical-align: middle;'><input type='text' ><br></td><td><textarea type='text' size='55' style='width: 100%;'></textarea></td></tr>");
			jQuery("table tbody a").click(function() {
				//event.preventDefault();
				jQuery(this).parent().parent().remove();
			});
	});

	jQuery("#preventiva_b").click(function() {
		jQuery( "#preventiva" ).toggle();
	});

	jQuery("#resolucao button").click(function() {

	});


	listaItens();

});

$('.more').click(function(){
   $('.oculta').slideToggle(); 
});