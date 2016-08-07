$(document).on('focus','.autocomplete_subsection',function(){
		
	var type = $(this).data('type');
	var statuateval = '#statuate_'+type;
	var hiddenstatuate = '#hiddenstatuate_'+type;
	if($(statuateval).val()!='')
	{
		url = 'notation/fetchUserSubSection';
		autoTypeNo=0;

		$(this).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url : url,
					dataType: "json",
					method: 'post',
					data: {
					   name_startsWith: request.term,
					   type: type,
					   statuate: $(hiddenstatuate).val()
					},
					 success: function( data ) {
						 response( $.map( data, function( item ) {
						 	var code = item.split("|");
							return {
								label: item,
								value: code[autoTypeNo],
								data : item
							}
						}));
					}
				});
			},
			autoFocus: true,	      	
			minLength: 0,
			select: function( event, ui ) {
				var names = ui.item.data.split("|");						
				id_arr = $(this).attr('id');
		  		id = id_arr.split("_");
		  		$('#subsection_'+id[1]).val(names[0]);
		  		$('#hiddensubsection_'+id[1]).val(names[1]);
				//$('#hiddensubsection_').val(names[0]);
				//$("#hiddenconceptsubsection").val(names[1]);
			}
		});	
	}
});

$(document).on('focus','.autocomplete_concept',function(){
	var type = $(this).data('type');
	var lstatuate = "#hiddenstatuate_"+type;
	var lsubsection = "#hiddensubsection_"+type;

	var vstatuate = $(lstatuate).val();
	var vsubsection = $(lsubsection).val();

	$(this).autocomplete({
		source: function( request, response ) {
			$.ajax({
				url : 'notation/conceptAjax',
				dataType: "json",
				method: 'post',
				data: {
				   name_startsWith: request.term,
				   type: type,
				   statuate: vstatuate,
				   subsection: vsubsection
				},
				 success: function( data ) {
					 response( $.map( data, function( item ) {
						return {
							label: item,
							value: item,
							data : item
						}
					}));
				}
			});
		},
		autoFocus: true,	      	
		minLength: 0		      	
	});
});


$(document).on('focus','.autocomplete_statuate',function(){
	
	var type = $(this).data('type');
	var subsectionval = '#subsection_'+type;
	
	url = 'notation/fetchUserStatuate';
	autoTypeNo=0;

	$(this).autocomplete({
		source: function( request, response ) {
			$.ajax({
				url : url,
				dataType: "json",
				method: 'post',
				data: {
				   name_startsWith: request.term,
				   type: type
				},
				 success: function( data ) {
				 		$(subsectionval).val('');
					 response( $.map( data, function( item ) {
					 	var code = item.split("|");
						return {
							label: item,
							value: code[autoTypeNo],
							data : item
						}
					}));
				}
			});
		},
		autoFocus: true,	      	
		minLength: 0,
		select: function( event, ui ) {
			var names = ui.item.data.split("|");						
			id_arr = $(this).attr('id');
	  		id = id_arr.split("_");
	  		$('#statuate_'+id[1]).val(names[0]);
	  		$('#hiddenstatuate_'+id[1]).val(names[1]);
			//$('#constatuate').val(names[0]);
			//$('#conceptsubsection').val(names[1]);
			//$('#hiddenconceptstatuate').val(names[1]);
			//$("#hiddenconceptsubsection").val(names[3]);
		}
	});
});
