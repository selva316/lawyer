
	

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
					
				}
				listOfStatuate += statuate+"--$$--"+hiddenStatuate+"--$$--"+subsection+"--$$--"+hiddenSubsection+"--$$--"+concept+"--^--";
			}
			listOfStatuate = listOfStatuate.substring(0,listOfStatuate.length-5);
		
		}
		
		var citation = $("#citation").val();
		var casename = $("#casename").val();
		var casenumber = $('#casenumber').val();
		if((citation != '' || casenumber != '') && casename !='')
		{
			casename  = $("#casename").val();
			citation = $("#citation").val();
			var dubcitation = $("#dubcitation").val();
			var judge_name = $("#judge_name").val();
			var court_name = $("#court_name").val();
			var casenumber = $("#casenumber").val();
			var year = $("#year").val();

			var bench = $("#bench").val();
			var facts_of_case = tinymce.get('facts_of_case').getContent(); //$("#facts_of_case").val();
			var case_note = tinymce.get('case_note').getContent();
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