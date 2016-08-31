/**
 * Site : http:www.smarttutorials.net
 * @author muni
 */

//adds extra table rows
var i=$('.tableStatuate tr').length;
$(".addmore").on('click',function(){
	html = '<tr>';
	html += '<td><input class="case" type="checkbox"/></td>';
	html += '<td><input type="text" data-type="'+i+'" name="statuate[]" id="statuate_'+i+'" class="form-control autocomplete_statuate" autocomplete="off"><input type="hidden" name="hiddenstatuate[]" id="hiddenstatuate_'+i+'" class="form-control" autocomplete="off"></td>';
	html += '<td><input type="text" data-type="'+i+'" name="subsection[]" id="subsection_'+i+'" class="form-control autocomplete_subsection" autocomplete="off"><input type="hidden" name="hiddensubsection[]" id="hiddensubsection_'+i+'" class="form-control" autocomplete="off"></td>';
	html += '<td><input type="text" data-type="'+i+'" name="concept[]" id="concept_'+i+'" class="form-control autocomplete_concept" autocomplete="off"  ondrop="return false;" onpaste="return false;"></td>';
	html += '</tr>';
	$('.tableStatuate').append(html);
	i++;
});


//adds extra table rows	Sub Section
var s=$('.tableNewSubSection tr').length;
$(".addSub").on('click',function(){
	html = '<tr id="rowss_'+s+'">';
	//html += '<td><input class="case_sub" type="checkbox"/></td>';
	html += '<td><input type="text" name="subsectionname[]" id="subsectionname_'+s+'" class="form-control" autocomplete="off"></td>';
	html += '</tr>';
	$('.tableNewSubSection').append(html);
	s++;
});

//adds extra table rows  	Type of Citation
var j=$('.tableCitation tr').length;
$(".typeAddmore").on('click',function(){
	html = '<tr>';
	html += '<td><input class="case_citation" type="checkbox"/></td>';
	html += '<td><select  class="form-control"  data-type="typeCitation" id="typeCitation_'+j+'" name="typeCitation[]"><option value="">Select</option><option value="CIID12345">Approved</option><option value="CIID12346">Followed</option><option value="CIID12347">Distinguished</option><option value="CIID12348">Modified</option><option value="CIID12349">Overruled</option><option value="CIID12350">Appealed from</option><option value="CIID12351">Other</option></select></td>';
	html += '<td><input type="text" data-type="'+j+'" name="citationNumber[]" id="citationNumber_'+j+'" class="form-control autocomplete_citation" autocomplete="off"></td>';
	html += '<td><input type="text" data-type="'+j+'" name="listCaseName[]" id="listCaseName_'+j+'" class="form-control autocomplete_casename" autocomplete="off"></td>';
	html += '<td><textarea  name="note[]" id="note_'+j+'" class="form-control"></textarea> </td>';
	html += '</tr>';
	$('.tableCitation').append(html);
	$("#numberOfCitationEntries").val(j);
	j++;
});

//adds extra table rows Word phrase and Legal Definition
var n=$('.tablePhrase tr').length;
$(".phraseAddmore").on('click',function(){
	html = '<tr>';
	html += '<td><input class="case_phrase" type="checkbox"/></td>';
	html += '<td><input type="text" data-type="phrase" name="phrase[]" id="phrase_'+j+'" class="form-control autocomplete_citation" autocomplete="off"></td>';
	html += '<td><textarea  name="legal[]" id="legal_'+j+'" class="form-control"></textarea> </td>';
	html += '</tr>';
	$('.tablePhrase').append(html);
	n++;
});

//adds extra table rows	Concept
var k=$('.tableNewConcept tr').length;
$(".addConceptStatuate").on('click',function(){
	html = '<tr id="rowcon_'+k+'">';
	html += '<td><input type="hidden" id="hiddenconceptname_'+k+'" name="hiddenconceptname[]" /><input type="text" placeholder="Concept Name" data-type="'+k+'" name="conceptName[]" id="conceptName_'+k+'" class="form-control autocomplete_cloneconcept" autocomplete="off"></td>';
	//html += '<td><input type="text" placeholder="Description" name="conceptDescription[]" id="conceptDescription_'+k+'" class="form-control" autocomplete="off"></td></td>';
	html += '</tr>';
	$('.tableNewConcept').append(html);
	k++;
});
/*var k=$('.tableNewConcept tr').length;
$(".addConceptStatuate").on('click',function(){
	html = '<tr id="rowcon_'+k+'">';
	html += '<td><input type="hidden" name="hiddenconstatuate[]" id="hiddenconceptstatuate_'+k+'" class="form-control"><input type="text" data-type="'+k+'" name="constatuate[]" id="conceptstatuate_'+k+'" class="form-control autocomplete_statuate" autocomplete="off"></td>';
	html += '<td><input type="text" name="conceptsubsection[]" id="conceptsubsection_'+k+'" class="form-control" autocomplete="off"></td>';
	html += '</tr>';
	$('.tableNewConcept').append(html);
	k++;
});*/

//to check all checkboxes
$(document).on('change','#check_all',function(){
	$('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
});

//deletes the selected table rows
$(".delete").on('click', function() {
	$('.case:checkbox:checked').parents("tr").remove();
	$('#check_all').prop("checked", false); 
});


//deletes the selected table rows
$(".typeDelete").on('click', function() {
	$('.case_citation:checkbox:checked').parents("tr").remove();
	$('#check_all').prop("checked", false); 
});

//deletes the selected table rows
$(".deleteSub").on('click', function() {
	$('.case_sub:checkbox:checked').parents("tr").remove();
	$('#check_all').prop("checked", false); 
});

//deletes the selected table rows
$(".phraseDelete").on('click', function() {
	$('.case_phrase:checkbox:checked').parents("tr").remove();
	$('#check_all').prop("checked", false); 
});

//deletes the selected table rows
$(".typeDelete").on('click', function() {
	$('.case_citation:checkbox:checked').parents("tr").remove();
	$('#check_all').prop("checked", false); 
});//It restrict the non-numbers
var specialKeys = new Array();
specialKeys.push(8,46); //Backspace
function IsNumeric(e) {
    var keyCode = e.which ? e.which : e.keyCode;
    console.log( keyCode );
    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
    return ret;
}

//datepicker
$(function () {
    $('#quotationdate').datepicker({});
});

function frmvalidation()
{
	var casename = $('#casename').val();
	var citation = $('#citation').val();
	var casenumber = $('#casenumber').val();
	var court_name = $('#court_name').val();
	var judge_name = $('#judge_name').val();
	var year = $('#year').val();
	var bench = $('#bench').val();
	var status = $('#status').val();
	var valid=true;
	
	var errorstr = '';
	
	if(casename==''){
		valid = false;
		errorstr += "Enter valid Case Name!"+ "<BR/>";
		$('#divcasename').addClass('has-error');
	}
	
	var zx = 0;
	if(citation==''){
		
		if(casenumber != '')
		{
			zx = 1;
		}
		else
		{
			valid = false;
			errorstr += "Enter valid Case Number!"+ "<BR/>";
			$('#divcasenumber').addClass('has-error');
		}
		
	}
	/*else
	{
		valid = false;
		errorstr += "Enter valid Citation Number!"+ "<BR/>";
		$('#divcitation').addClass('has-error');	
	}*/

	if(parseInt(bench)<1 && parseInt(bench)>100)
	{
		valid = false;
		errorstr += "Enter valid bench!"+ "<BR/>";
		$('#divbench').addClass('has-error');
	}

	/*
	if(casenumber==''){
		valid = false;
		errorstr += "Enter valid Case Number!"+ "<BR/>";
		$('#divcasenumber').addClass('has-error');
	}
	
	if(court_name==''){
		valid = false;
		errorstr += "Enter valid Court Name!"+ "<BR/>";
		$('#divcourt_name').addClass('has-error');
	}
	
	if(judge_name==''){
		valid = false;
		errorstr += "Enter valid Judge Name!"+ "<BR/>";
		$('#divjudge_name').addClass('has-error');
	}
	
	if(year==''){
		valid = false;
		errorstr += "Enter valid Year!"+ "<BR/>";
		$('#divyear').addClass('has-error');
	}
	
	if(bench==''){
		valid = false;
		errorstr += "Enter valid bench!"+ "<BR/>";
		$('#divbench').addClass('has-error');
	}
	
	if(status==''){
		valid = false;
		errorstr += "Enter valid status!"+ "<BR/>";
		$('#divstatus').addClass('has-error');
	}*/
	
	if(!valid)
	{
		alert(errorstr);
	}
	
	return valid;
	
}

	$(":input").keypress(function() {
		//$('div').removeClass('has-error');
		eleid = "#div"+$(this).attr('id');
		$(eleid).removeClass('has-error');
		
		inid = "#"+$(this).attr('id');
		$(inid).removeClass('clsalerttext');
	});
	
	$(":input").mousedown(function() {
		//$('div').removeClass('has-error');
		eleid = "#div"+$(this).attr('id');
		$(eleid).removeClass('has-error');
		
		inid = "#"+$(this).attr('id');
		$(inid).removeClass('clsalerttext');
	});
	
	$("select").mousedown(function() {
		//$('div').removeClass('has-error');
		eleid = "#div"+$(this).attr('id');
		$(eleid).removeClass('has-error');
	});

	$("#bench").keypress(function (e) {
		//if the letter is not digit then display error and don't type anything
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		//display error message
			//$("#errmsg").html("Digits Only").show().fadeOut("slow");
	     	return false;
		}
	});

	$("#year").keypress(function (e) {
		//if the letter is not digit then display error and don't type anything
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		//display error message
			//$("#errmsg").html("Digits Only").show().fadeOut("slow");
	     	return false;
		}
	});

	$('#frmNotation').on('keyup keypress', function(e) {
	  	var keyCode = e.keyCode || e.which;
	  	if (keyCode === 13) { 
	    	e.preventDefault();
	    return false;
	  }
	});