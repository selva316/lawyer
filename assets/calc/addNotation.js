var interval = null;
	$(document).ready(function() {
		$('#example').DataTable( {
			columnDefs: [ {
				targets: [ 0 ],
				orderData: [ 0, 1 ]
			}, {
				targets: [ 1 ],
				orderData: [ 1, 0 ]
			}, {
				targets: [ 3 ],
				orderData: [ 3, 0 ]
			}]
		});
		/*
		$('.form_datetime').datepicker({
		    //format: 'YYYY-MM-DD',
		    changeMonth: false,
        	changeYear: true,
		    autoclose : true
		});
		*/
		$(".form_datetime").datepicker( {
		    format: "yyyy",
		    startView: "year", 
		    minView: "year"
		});

		interval = setInterval(ajaxCreateCitation, 60000);
	
		//$("#court_name")
	});

	$(document).on('change', '#chkPrivate', function() {
        if(this.checked)
        {
            $("#status").val('private');
        }
        else
        {
            $("#status").val('public');
        }
    });

	function split(val) {
		return val.split(/,\s*/);
	}
	function extractLast(term) {
		return split(term).pop();
	}

	$(document).on('focus','.autocomplete_txt',function(){
		var type = $(this).data('type');
		$(this).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url : 'notation/ajax',
					dataType: "json",
					method: 'post',
					data: {
					   name_startsWith: request.term,
					   type: type
					},
					 success: function( data ) {
					 	/*if(!data.length) {

					 	}*/
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
			minLength: 0,
			select: function( event, ui ) {
				
				$('#court_name').val(ui.item.data);
			}		      	
		});
	});
	
	
	$(document).on('blur','#citation',function(){
		if($("#casename").val() != '' && $("#citation").val() != '')
		{
			
			$.ajax({
				url : 'notation/caseame_and_citation_avilabilty',
				dataType: "text",
				method: 'post',
				data: {
				   casename: $("#casename").val(),
				   citation: $("#citation").val()
				},
				success: function( data ) {
					if(data != ''){
						clearInterval(interval); 
						$("#divhref").html(data);	
					}
					
				}
			});
		}
	});
	
	$(document).on('blur','#casename',function(){
		if($("#casename").val() != '' && $("#citation").val() != '')
		{
			
			$.ajax({
				url : 'notation/caseame_and_citation_avilabilty',
				dataType: "text",
				method: 'post',
				data: {
				   casename: $("#casename").val(),
				   citation: $("#citation").val()
				},
				success: function( data ) {
					if(data != ''){
						clearInterval(interval); 
						$("#divhref").html(data);	
					}
				}
			});
		}
	});

	
	/*
	$(document).on('focus','.autocomplete_citation',function(){
		var type = $(this).data('citationNumber');
		
		$(this).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url : 'notation/citationTypeAjax',
					dataType: "json",
					method: 'post',
					data: {
					   name_startsWith: request.term,
					   type: type
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
	});*/


	$(document).on('focus','.autocomplete_process',function(){
		type = $(this).data('type');
		var url = '';
		if(type =='statuate' )
		{
			autoTypeNo=0;
			url = 'notation/statuateAjax'
		}
		
		if(type =='subsection' )
		{
			autoTypeNo=1; 	
			url = 'notation/subSectionAjax'
		}
		
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
				$('#statuate_'+id[1]).val(names[0]);
				$('#subsection_'+id[1]).val(names[1]);

			}		      	
		});
	
	});

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


	function saveAsDraft()
	{
		if($("#ntype").val() != '')
		{
			var casename  = $("#casename").val();
			var citation = $("#citation").val();
			var judge_name = $("#judge_name").val();
			var court_name = $("#court_name").val();
			var casenumber = $("#casenumber").val();
			var year = $("#year").val();

			var bench = $("#bench").val();
			var facts_of_case = tinymce.get('facts_of_case').getContent();
			var status = $("#status").val();

			$.ajax({
				url : 'notation/autoSaveAsDraft',
				dataType: "text",
				method: 'post',
				data: {
				   ntype: $("#ntype").val(),
				   casename: casename, 
				   citation:citation, 
				   judge_name: judge_name, 
				   court_name:court_name, 
				   casenumber:casenumber, 
				   year:year, 
				   bench:bench, 
				   facts_of_case:facts_of_case, 
				   status:status
				},
				success : function(data) {
					
				}
			});

		}
	}

	function ajaxCreateCitation(){
		

		var statuateTableSize = $('.tableStatuate tr').length;
		var listOfStatuate = '';
		for(i=1;i<statuateTableSize;i++)
		{
			var statuateStr = "#statuate_"+i;
			var statuate = $(statuateStr).val();

			var hiddenStatuateStr = "#hiddenstatuate_"+i;
			var hiddenStatuate = $(hiddenStatuateStr).val();

			var subsectionStr = "#subsection_"+i;
			var subsection = $(subsectionStr).val();

			var hiddenSubsectionStr = "#hiddensubsection_"+i;
			var hiddenSubsection = $(hiddenSubsectionStr).val();

			var conceptStr = "#concept_"+i;
			var concept = $(conceptStr).val();
			
			listOfStatuate += statuate+"--$$--"+hiddenStatuate+"--$$--"+subsection+"--$$--"+hiddenSubsection+"--$$--"+concept+"--^--";
		}
		listOfStatuate = listOfStatuate.substring(0,listOfStatuate.length-5);

		var citation = $("#citation").val();
		var casename = $("#casename").val();
		if(citation != '' && casename !='')
		{
			casename  = $("#casename").val();
			citation = $("#citation").val();
			var judge_name = $("#judge_name").val();
			var court_name = $("#court_name").val();
			var casenumber = $("#casenumber").val();
			var year = $("#year").val();

			var bench = $("#bench").val();
			var facts_of_case = tinymce.get('facts_of_case').getContent(); //$("#facts_of_case").val();
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
				   judge_name: judge_name, 
				   court_name:court_name, 
				   casenumber:casenumber, 
				   year:year, 
				   bench:bench, 
				   facts_of_case:facts_of_case, 
				   status:'draft',
				   listOfStatuate:listOfStatuate, 
				   notationid:notationid
				},
				success: function( msg ) {
					//alert(msg);
					$("#ntype").val(msg);
					//clearInterval(interval);
				}
			});
			$(".blockUIOverlay").hide();
    		$(".blockUILoading").hide();
		}
	}

	$(document).on('change','#court_type',function(){
		$("#court_name").val('');	
	});

	/*
	$(document).on('change','#casename',function(){
		if($("#casename").val() != "")
		{
			$.ajax({
				url : 'notation/caseNameAvailable',
				dataType: "json",
				method: 'post',
				data: {
				   casename: $("#casename").val(),
				},
				success: function( data ) {
					if(data == "false"){
						$("#casename").val('');
						$("#ntype").val('');
					}
				}
			});	
		}
	});
	*/	
	$(document).on('keyup.autocomplete','#casename',function(){
		var casename = $(this).val();
		$(this).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url : 'notation/fetchcasename',
					dataType: "json",
					method: 'post',
					data: {
					   casename: casename
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
			minLength: 1
		});
	});

	$(document).on('keyup.autocomplete','#year',function(){
		var year = $(this).val();
		$(this).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url : 'notation/fetchYear',
					dataType: "json",
					method: 'post',
					data: {
					   year: year
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
			minLength: 1
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

	

	$(document).on('click', '#saveStatuate', function(e) {
		var errorMessage = '';
		if ( $("#statuateName").val() == ""  || $("#statuateName").val() == null) {
			errorMessage = errorMessage + 'Name cannot be empty!!\n' ;
		}

		if ( $("#statuateDes").val() == ""  || $("#statuateDes").val() == null) {
			errorMessage = errorMessage + 'Description cannot be empty!!\n' ;
		}

		if ( errorMessage != "" ) {
			alert(errorMessage);
			return;
		}

		$.ajax({
			url : '../admin/listofstatuate/insertStatuate',
			type : 'POST',
			async: false,
			cache: false,
			data : {
			  	statuatename: $("#statuateName").val(),
			  	description: $("#statuateDes").val()
			},
			success: function(dat) {
							  	
			  	$("#statuateName").val('');
			  	$("#statuateDes").val('');
			  	$("#todoModal").modal('hide');
			  	$('#statuatename')
				    .find('option')
				    .remove()
				    .end()
				    .append('<option value="">Select</option>');

				$.ajax({
					url : '../admin/listofstatuatesubsection/fetchUserListOfStatuateSubSection',
					type : 'POST',
					async: false,
					cache: false,
					dataType: "json",
					success: function(data) {
						$.each(data, function(key, item) {
						    
						    $('#statuatename').append($('<option>', { 
						        value: item.STID,
						        text : item.DESCRIPTION 
						    }));
						});
					}
				});
			}
		});
	});
	
	/*Concept function begin*/
	$(document).on('click', '#saveConcept', function(e) {
		var errorMessage = '';

		if ( $("#constatuate").val() == ""  || $("#constatuate").val() == null) {
			errorMessage = errorMessage + 'Statuate cannot be empty!!\n' ;
		}

		/*
		if ( $("#conceptsubsection").val() == ""  || $("#conceptsubsection").val() == null) {
			errorMessage = errorMessage + 'Subsection cannot be empty!!\n' ;
		}
		*/

        var si = $('.tableNewConcept tr').length - 1;
        
        var temp = [];
        for(i=1;i<=si;i++)
        {
        	var conceptcontrol = "#conceptName_"+i;
        	if ( $(conceptcontrol).val() == ""  || $(conceptcontrol).val() == null) {
            	continue;
        	}
        	temp.push($(conceptcontrol).val());
        }

        if(temp.length == 0)
		{
			errorMessage = errorMessage + 'Concept should not be empty!!\n' ;
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
			  	statuate: $("#hiddenconceptstatuate").val(),
			  	subsection: $("#hiddenconceptsubsection").val(),
			  	concept: temp.join(",")
			},
			success: function(dat) {
							  	
			  	$("#constatuate").val('');
			  	$("#conceptsubsection").val('');

			  	$("#hiddenconceptstatuate").val('');
			  	$("#hiddenconceptsubsection").val('');
			  	$("#conceptName_1").val('');

            	for(j=2;j<=si;j++)
		        {
		        	var rowtr = "#rowcon_"+j;
		        	$(rowtr).remove();
		        }

			  	$("#conceptModal").modal('hide');
			}
		});
	});
	/*Concept function end*/
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
	$(document).on('blur','#statuateName',function(){
		if($("#statuateName").val() != '')
		{
			$.ajax({
				url : '../admin/listofstatuate/checkStatuateNameAvailable',
				dataType: "json",
				method: 'post',
				data: {
				   statuatename: $("#statuateName").val(),
				},
				success: function( data ) {
					//alert(data);
					if(data=="true"){
						$("#statuateAction").css("display","block");
					}
					else{
						$("#statuateAction").css("display","none");	
					}
				}
			});
		}
	});

	$(document).on('blur','#subsectionname',function(){
		if($("#subsectionname").val() != '')
		{
			$.ajax({
				url : '../admin/listofstatuatesubsection/checkSubsectionStatuateNameAvailable',
				dataType: "json",
				method: 'post',
				data: {
				   'statuatename':$("#statuatename").val(), 'subsectionname':$("#subsectionname").val()
				},
				success: function( data ) {
					
					if(data=="true"){
                    
                        $("#description").prop('disabled',false);
                        //$("#proceedButton").css("display","block");
                        $("#subsectionname").css("border","1px solid #ccc");
                        $("#subsectionname").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                        $("#subsectionAction").css("display","block");
                    }
                    else{
                    	$("#description").val('');
                    	$("#description").prop('disabled',true);
                        $("#subsectionname").css("border","1px solid #c7254e");
                        $("#subsectionname").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                        $("#subsectionAction").css("display","none");	
                    }
				}
			});
		}
	});

	$('#saveSubsection').click(function () {

        var errorMessage = '';
        if ( $("#statuatename").val() == ""  || $("#statuatename").val() == null) {
            errorMessage = errorMessage + 'Statuate name cannot be empty!!\n' ;
        }
        
        var si = $('.tableNewSubSection tr').length - 1;
        
        var temp = [];
        for(i=1;i<=si;i++)
        {
        	var subcontrol = "#subsectionname_"+i;
        	if ( $(subcontrol).val() == ""  || $(subcontrol).val() == null) {
            	continue;
        	}
        	temp.push($(subcontrol).val());
        }

        if(temp.length == 0)
		{
			errorMessage = errorMessage + 'Sub Section should not be empty!!\n' ;
		}

        /*if ( $("#subsectionname").val() == ""  || $("#subsectionname").val() == null) {
            errorMessage = errorMessage + 'Name cannot be empty!!\n' ;
        }
        if ( $("#description").val() == ""  || $("#description").val() == null) {
            errorMessage = errorMessage + 'Description cannot be empty!!\n' ;
        }
        */

        if ( errorMessage != "" ) {
            alert(errorMessage);
            return;
        }

        //$("#modalValidate").modal('hide');
        
        $.ajax({
            type: 'post',
            dataType: "json",
            url: '../admin/listofstatuatesubsection/insertSubSection',
            data: {'statuatename':$("#statuatename").val(),'subsectionname':temp.join(",")},
            success:function(data){
            	$("#statuatename").val('');
            	$("#rowss_1").val('');

            	for(j=2;j<=si;j++)
		        {
		        	var rowtr = "#rowss_"+j;
		        	$(rowtr).remove();
		        }
                $("#modalValidate").modal('hide');
            }
        });
    });
	
	$( "#conceptName" ).blur(function() {
        $.ajax({
            type: 'post',
            dataType: "json",
            url: '../admin/listofconcept/checkConceptNameAvailable',
            data: {'conceptname':$("#conceptName").val()},
            success:function(data){
                //alert(data);
                if(data=="true"){
                    $("#conceptDescription").prop('disabled',false);
                    //$("#proceedButton").css("display","block");
                    $("#conceptName").css("border","1px solid #ccc");
                    $("#conceptName").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                    $("#conceptAction").css("display","block");
                }
                else{
                    $("#conceptDescription").prop('disabled',true);
                    $("#conceptName").css("border","1px solid #c7254e");
                    $("#conceptName").css("box-shadow","0 1px 1px rgba(0, 0, 0, 0.075) inset");
                    $("#conceptAction").css("display","none");
                }
            }
        });
    });