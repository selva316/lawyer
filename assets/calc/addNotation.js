

	/*
	$(document).on('focus','.autocomplete_statuate',function(){
		
		type = $(this).data('type');
		url = 'notation/statuateAjax';
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
		  		//hiddenconceptstatuate_
				$('#conceptstatuate_'+id[1]).val(names[0]);
				$('#conceptsubsection_'+id[1]).val(names[1]);
				$('#hiddenconceptstatuate_'+id[1]).val(names[2]);
			}
		});
	});*/
	
	
	$(document).on('focus','.autocomplete_clonesubsection',function(){
		
		if($("#constatuate").val()!='')
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
						   statuate: $("#hiddenconceptstatuate").val()
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
							 	var code = item.split("|");
								return {
									label: code[autoTypeNo],
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
			  		//$('#subsection_'+id[1]).val(names[0]);
					$('#conceptsubsection').val(names[0]);
					$("#hiddenconceptsubsection").val(names[1]);
				}
			});	
		}
	});

	$(document).on('focus','.autocomplete_clonestatuate',function(){
		
		url = 'notation/fetchUserStatuate';
		autoTypeNo=0;

		$(this).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url : url,
					dataType: "json",
					method: 'post',
					data: {
					   name_startsWith: request.term
					},
					 success: function( data ) {
						 response( $.map( data, function( item ) {
						 	var code = item.split("|");
							return {
								
								label: code[autoTypeNo],
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
				$('#constatuate').val(names[0]);
				$('#hiddenconceptstatuate').val(names[1]);
			}
		});
	});

	/*
	$(document).on("keyup.autocomplete","#citation",function(e){

	       var term =  $(this ).val();
	       $( this ).autocomplete({
    	   source : function( request, response ) {
            $.ajax({
                url: 'notation/fetchAllCitation',
                dataType: "json",
                data: {term: extractLast(term)},
                success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.citation,
                                 //email: item.email
                                };
                        }));
                    }
                });
            },
			focus : function() {
				// prevent value inserted on focus
				return true;
			},
			select : function(event, ui) {
				var terms = split( this.value );
			      // remove the current input
			      terms.pop();
			      // add the selected item
			      terms.push( ui.item.value );
			      // add placeholder to get the comma-and-space at the end
			      terms.push( "" );
			      this.value = terms.join( ", " );
			     
			      //setSubject(this.value);
			      return false;

			},
	      minLength: 2

	    });

	});
	*/

	/*
	$(document).on('blur','#citation',function(){
		if($("#citation").val() != "")
		{
			$.ajax({
				url : 'notation/citationAvailable',
				dataType: "json",
				method: 'post',
				data: {
				   citation: $("#citation").val(),
				},
				success: function( data ) {
					if(data == "false"){
						$("#citation").val('');
						$("#ntype").val('');
					}
					
				}
			});	
		}
	});
	*/
	/*
	$(document).on("keyup.autocomplete",".autocomplete_citation",function(e){

	       var term =  $(this).val();
	       $( this ).autocomplete({
    	   source : function( request, response ) {
            $.ajax({
                url: 'notation/fetchAllCitation',
                dataType: "json",
                data: {term: extractLast(term)},
                success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.citation,
                                 //email: item.email
                                };
                        }));
                    }
                });
            },
			focus : function() {
				// prevent value inserted on focus
				return false;
			},
			select : function(event, ui) {
				var terms = split( this.value );
			      // remove the current input
			      terms.pop();
			      // add the selected item
			      terms.push( ui.item.value );
			      // add placeholder to get the comma-and-space at the end
			      terms.push( "" );
			      this.value = terms.join( ", " );
			     
			      //setSubject(this.value);
			      return false;

			},
	      minLength: 2

	    });
	});
	*/

	

	
	
	/*
	$(document).on('click', '#saveConcept', function(e) {
		var errorMessage = '';

		if ( $("#conceptName").val() == ""  || $("#conceptName").val() == null) {
			errorMessage = errorMessage + 'Name cannot be empty!!\n' ;
		}

		if ( $("#conceptDescription").val() == ""  || $("#conceptDescription").val() == null) {
			errorMessage = errorMessage + 'Description cannot be empty!!\n' ;
		}


        var si = $('.tableNewConcept tr').length - 1;
        
        var temp = [];
        for(i=1;i<=si;i++)
        {
        	var conceptcontrol = "#hiddenconceptstatuate_"+i;
        	if ( $(conceptcontrol).val() == ""  || $(conceptcontrol).val() == null) {
            	continue;
        	}
        	temp.push($(conceptcontrol).val());
        }

        if(temp.length == 0)
		{
			errorMessage = errorMessage + 'Statuate should not be empty!!\n' ;
		}


		if ( errorMessage != "" ) {
			alert(errorMessage);
			return;
		}

		$.ajax({
			url : '../admin/listofconcept/insertConcept',
			type : 'POST',
			async: false,
			cache: false,
			data : {
			  	conceptname: $("#conceptName").val(),
			  	description: $("#conceptDescription").val(),
			  	statuate: temp.join(",")
			},
			success: function(dat) {
							  	
			  	$("#conceptName").val('');
			  	$("#description").val('');

			  	$("#rhiddenconceptstatuate_1").val('');
			  	$("#conceptstatuate_1").val('');
			  	$("#conceptsubsection_1").val('');

            	for(j=2;j<=si;j++)
		        {
		        	var rowtr = "#rowcon_"+j;
		        	$(rowtr).remove();
		        }

			  	$("#conceptModal").modal('hide');
			}
		});
	});
	*/
	
function ajaxCreateCitation(){
	
	var statuateRowIgnoreid = 0;
	var focusElement = ''
	$(":focus").each(function() {
	    //alert("Focused Elem_id = "+ this.id );
	    var eleval = this.id;
	    focusElement = this.id;

	    var words = eleval.split("_");
	    var ele = words[0];
	    var eleid = words[1];
	    if(ele == "statuate" || ele == "subsection" || ele == "concept")
	    	statuateRowIgnoreid = eleid;
	});

	if(focusElement != "casename" && focusElement != "citation" && focusElement != "casenumber" )
	{
		var statuateTableSize = $('.tableStatuate tr').length;
		var listOfStatuate = '';
		if(statuateTableSize > 0)
		{
			for(i=1;i<statuateTableSize;i++)
			{
				var statuate = hiddenStatuate = subsection = hiddenSubsection = concept = '';
				if(statuateRowIgnoreid	!= i)
				{
					var statuateStr = "#statuate_"+i;
					statuate = $(statuateStr).val();

					var hiddenStatuateStr = "#hiddenstatuate_"+i;
					hiddenStatuate = $(hiddenStatuateStr).val();
					
					var subsectionStr = "#subsection_"+i;
					subsection = $(subsectionStr).val();

					var hiddenSubsectionStr = "#hiddensubsection_"+i;
					hiddenSubsection = $(hiddenSubsectionStr).val();

					var conceptStr = "#concept_"+i;
					concept = $(conceptStr).val();

					//if(statuate != '' || subsection != '' || concept != '') 
						
				}
				listOfStatuate += statuate+"--$$--"+hiddenStatuate+"--$$--"+subsection+"--$$--"+hiddenSubsection+"--$$--"+concept+"--^--";		
				
			}
			listOfStatuate = listOfStatuate.substring(0,listOfStatuate.length-5);
			//alert(listOfStatuate);
		}	
	
		var citation = $("#citation").val();
		var casename = $("#casename").val();
		var casenumber = $('#casenumber').val();
		if((citation != '' || casenumber != '') && casename !='')
		{
			casename  = $("#casename").val();
			citation = $("#citation").val();
			var judge_name = $("#judge_name").val();
			var court_name = $("#court_name").val();
			var casenumber = $("#casenumber").val();
			var dubcitation = $("#dubcitation").val();
			var year = $("#year").val();

			var bench = $("#bench").val();
			var facts_of_case = tinymce.get('facts_of_case').getContent(); //$("#facts_of_case").val();
			var case_note = tinymce.get('case_note').getContent();
			var status = $("#status").val();
			var notationid = $("#ntype").val();

			$(".blockUIOverlay").show();
			$(".blockUILoading").show();

			$.ajax({
				url : 'notation/autoSave',
				dataType: "text",
				method: 'post',
				data: {
				   casename: casename, 
				   citation:citation,
				   dubcitation:dubcitation,
				   judge_name: judge_name, 
				   court_name:court_name, 
				   casenumber:casenumber, 
				   year:year, 
				   bench:bench, 
				   facts_of_case:facts_of_case, 
				   case_note:case_note,
				   status:'draft',
				   listOfStatuate:listOfStatuate, 
				   notationid:notationid
				},
				success: function( msg ) {
					//alert(msg);
					$("#ntype").val(msg);
					//clearInterval(interval);

					Command: toastr["success"]("Auto Saved");

					toastr.options = {
					  "closeButton": false,
					  "debug": false,
					  "newestOnTop": false,
					  "progressBar": false,
					  "positionClass": "toast-top-right",
					  "preventDuplicates": false,
					  "showDuration": "300",
					  "hideDuration": "1000",
					  "timeOut": "1000",
					  "extendedTimeOut": "1000",
					  "showEasing": "swing",
					  "hideEasing": "linear",
					  "showMethod": "fadeIn",
					  "hideMethod": "fadeOut"
					}
				}
			});
			$(".blockUIOverlay").hide();
			$(".blockUILoading").hide();
		}
	}
	
	
	
}