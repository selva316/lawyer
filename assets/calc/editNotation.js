	
	

	
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

	


	/*
	$(document).on('click', '#saveConcept', function(e) {
		var errorMessage = '';
		if ( $("#conceptName").val() == ""  || $("#conceptName").val() == null) {
			errorMessage = errorMessage + 'Name cannot be empty!!\n' ;
		}

		if ( $("#conceptDescription").val() == ""  || $("#conceptDescription").val() == null) {
			errorMessage = errorMessage + 'Description cannot be empty!!\n' ;
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
			  	description: $("#conceptDescription").val()
			},
			success: function(dat) {
							  	
			  	$("#conceptName").val('');
			  	$("#description").val('');
			  	$("#conceptModal").modal('hide');
			}
		});
	});
	*/

function ajaxCreateCitation(){
	

	var statuateTableSize = $('.tableStatuate tr').length;
	var listOfStatuate = '';
	if(statuateTableSize > 0)
	{
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
	
	}
	
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
			url : 'editnotation/autoEditSave',
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