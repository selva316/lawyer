var interval = null;

$(document).ready(function() {

	//toastr.success('Auto Saved');
	//$("#toaster").html('');
	//$.toaster({ priority : 'success', title : '<span class="glyphicon glyphicon-ok"></span>', message : 'Command copied to clipboard' });

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

	
	if($("#statusType").val() != "dbversion")
	{
		interval = setInterval(ajaxCreateCitation, 10000);	
	}
	
	//$("#court_name")
});

$(document).on('change', '#chkPrivate', function() {
    if(this.checked)
    {
        $("#status").val('public');
    }
    else
    {
        $("#status").val('private');
    }
});

function split(val) {
	return val.split(/;\s*/);
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
	var str = $("#citation").val();
	var dub = str.replace(/[^a-zA-Z0-9]/g, "");
	$("#dubcitation").val(dub);
	if($("#casename").val() != '' && $("#citation").val() != '')
	{
		
		$.ajax({
			url : 'notation/caseame_and_citation_avilabilty',
			dataType: "text",
			method: 'post',
			data: {
			   casename: $("#casename").val(),
			   citation: $("#citation").val(),
			   ntype: $("#ntype").val()
			},
			success: function( data ) {
				if(data != ''){
					//clearInterval(interval); 
					$("#divhref").html(data);	
				}
				else
					$("#divhref").html('');	
				
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
});
*/

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



$(document).on('focus','.autocomplete_casename',function(){

		$(this).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url : 'notation/fetchcasename',
					dataType: "json",
					method: 'post',
					data: {
					   casename: request.term
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
	  		$('#hiddenstatuate_'+id[1]).val(names[1]);
			//$('#constatuate').val(names[0]);
			//$('#conceptsubsection').val(names[1]);
			//$('#hiddenconceptstatuate').val(names[1]);
			//$("#hiddenconceptsubsection").val(names[3]);
		}
	});
});

$("#court_name").blur(function(){
	$.ajax({
        type: 'post',
        dataType: "json",
        url: '../admin/listofcourt/checkCourtNameAvailable',
        data: {'courtname':$("#court_name").val()},
        success:function(data){
            $('#divcourt_name').removeClass('has-success');
            //alert(data);
            if(data=="true"){
    			$.ajax({
		            type: 'post',
		            dataType: "json",
		            url: '../admin/listofcourt/insertCourtList',
		            data: {'courtname':$("#court_name").val(),'courtType':''},
		            success:function(data){
		                $('#divcourt_name').addClass('has-success');
		            }
		        });        	
            }
        }
    });
});

$(".autocomplete_citationType").blur(function(){
	var citationType = $(this).val();
	var type = $(this).data('type');
	var idv = "typeCitation_"+type;
	if($(this).val() != '')
	{
		$.ajax({
	        type: 'post',
	        dataType: "json",
	        url: 'notation/checkCitationTypeAvailable',
	        data: {'citationType':$(this).val()},
	        success:function(data){
	            //alert(data)
	            if(data=="true"){
	    			$.ajax({
			            type: 'post',
			            dataType: "json",
			            url: 'notation/insertCitationType',
			            data: {'citationType':citationType},
			            success:function(data){
			               $(idv).css("border-color","#3c763d");
			            }
			        });        	
	            }
	        }
	    });
	}
});

/*
$(document).on('focus','.autocomplete_judge',function(){
	var type = $(this).data('type');
	$(this).autocomplete({
		source: function( request, response ) {
			$.ajax({
				url : 'notation/fetchAllJudges',
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
		minLength: 0,
		select: function( event, ui ) {
			
			$('#judge_name').val(ui.item.data);
		}		      	
	});
});
*/
$(document).on("keyup.autocomplete",".autocomplete_judge",function(e){

       var term =  $(this ).val();
       $( this ).autocomplete({
	   source : function( request, response ) {
        $.ajax({
            url: 'notation/fetchAllJudges',
            dataType: "json",
            method: 'post',
            data: {term: extractLast(term)},
            success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.judge_name,
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
		      this.value = terms.join( "; " );
		     
		      //setSubject(this.value);
		      return false;

		},
      minLength: 1

    });

});

$(document).on("keyup.autocomplete","#casenumber",function(e){

       var term =  $(this ).val();
       $( this ).autocomplete({
	   source : function( request, response ) {
        $.ajax({
            url: 'notation/fetchAllCasenumber',
            dataType: "json",
            method: 'post',
            data: {term: extractLast(term)},
            success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.casenumber,
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
		      this.value = terms.join( "; " );
		     
		      //setSubject(this.value);
		      return false;

		},
      minLength: 1

    });

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

$(document).on('change','#court_type',function(){
	$("#court_name").val('');	
});

$(document).on('keyup.autocomplete','#casename',function(){
	var casename = $(this).val();
	$(this).autocomplete({
		source: function( request, response ) {
			$.ajax({
				url : 'notation/fetchcasename',
				dataType: "json",
				method: 'post',
				data: {
				   casename: casename,
				   citation: $("#citation").val()
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


$(document).on('blur','#citation',function(){

	var citation = $(this).val();
	if($(this).val() != '')
	{
		$.ajax({
	        type: 'post',
	        dataType: "json",
	        url: 'notation/fetchCitationAvailable',
	        data: {'citation':$(this).val()},
	        success:function(data){
	        	if(data[0] == 1)
	        	{
	        		$('#availableModal').modal({backdrop: 'static', keyboard: false});
	        		$(".close").css ("display", "none");
	        		$("#availCitation").html(data[1]);
	            	/*
	            	var x = confirm("Already the citation is available, Are you want to create a edit copy?");
					if (x)
					{
						$("#availableModal").modal('show');
					}
					else{
						return false;
					}	
		            */
	        	}
	            
	        }
	    });
	}

});

$(document).on('keyup.autocomplete','.autocomplete_citationType',function(){
	var citationType = $(this).val();
	$(this).autocomplete({
		source: function( request, response ) {
			$.ajax({
				url : 'notation/fetchCitationType',
				dataType: "json",
				method: 'post',
				data: {
				   citationType: citationType
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

$(document).on("keyup.autocomplete","#citation",function(e){

       var term =  $(this ).val();
       $( this ).autocomplete({
	   source : function( request, response ) {
        $.ajax({
            url: 'notation/fetchAllCitation',
            dataType: "json",
            method: 'post',
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
		      this.value = terms.join( "; " );
		     
		      //setSubject(this.value);
		      return false;

		},
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

$(document).on('focus','.autocomplete_tag',function(){
	var topicname = $(this).val();
	$(this).autocomplete({
		source: function( request, response ) {
			$.ajax({
				url : 'research/accessResearchName',
				dataType: "json",
				method: 'post',
				data: {
				   topicname: request.term
				},
				 success: function( data ) {
					 response( $.map( data, function( item ) {
					 	var code = item.split("|");
						return {
							label: item,
							value: code[0],
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
			$('#topicname').val(names[0]);
			$('#rid').val(names[1]);
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
		var case_note = tinymce.get('case_note').getContent();
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
			   case_note:case_note,
			   status:status
			},
			success : function(data) {
				
			}
		});

	}
}