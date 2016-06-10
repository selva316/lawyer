/**
 * Site : http:www.smarttutorials.net
 * @author muni
 */

//adds extra table rows
var i=$('.tableStatuate tr').length;
$(".addmore").on('click',function(){
	html = '<tr>';
	html += '<td><input class="case" type="checkbox"/></td>';
	html += '<td><input type="text" data-type="statuate" name="statuate[]" id="statuate_'+i+'" class="form-control autocomplete_process" autocomplete="off"></td>';
	html += '<td><input type="text" data-type="subsection" name="subsection[]" id="subsection_'+i+'" class="form-control autocomplete_process" autocomplete="off"></td>';
	html += '<td><input type="text" data-type="concept" name="concept[]" id="concept_'+i+'" class="form-control autocomplete_concept" autocomplete="off"  ondrop="return false;" onpaste="return false;"></td>';
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
	html += '<td><select  class="form-control"  data-type="courtType" id="courtType_'+j+'" name="courtType[]"><option value="CIID12345">Approved</option><option value="CIID12346">Followed</option><option value="CIID12347">Distinguished</option><option value="CIID12348">Modified</option><optionvalue="CIID12349">Overruled</option><option value="CIID12350">Appealed from</option><option value="CIID12351">Other</option></select></td>';
	html += '<td><input type="text" data-type="citationNumber" name="citationNumber[]" id="citationNumber_'+j+'" class="form-control autocomplete_citation" autocomplete="off"></td>';
	html += '<td><textarea  name="note[]" id="note_'+j+'" class="form-control"></textarea> </td>';
	html += '</tr>';
	$('.tableCitation').append(html);
	i++;
});

//adds extra table rows	Concept
var k=$('.tableNewConcept tr').length;
$(".addConceptStatuate").on('click',function(){
	html = '<tr id="rowcon_'+k+'">';
	html += '<td><input type="hidden" name="hiddenconstatuate[]" id="hiddenconceptstatuate_'+k+'" class="form-control"><input type="text" data-type="'+k+'" name="constatuate[]" id="conceptstatuate_'+k+'" class="form-control autocomplete_statuate" autocomplete="off"></td>';
	html += '<td><input type="text" name="conceptsubsection[]" id="conceptsubsection_'+k+'" class="form-control" autocomplete="off"></td>';
	html += '</tr>';
	$('.tableNewConcept').append(html);
	k++;
});

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
	
	if(citation==''){
		
		if(casenumber == '')
		{
			valid = false;
			errorstr += "Enter valid Case Number!"+ "<BR/>";
			$('#divcasenumber').addClass('has-error');
		}
		else
		{
			valid = false;
			errorstr += "Enter valid Citation Number!"+ "<BR/>";
			$('#divcitation').addClass('has-error');	
		}
		
	}
	/*
	if(casenumber==''){
		valid = false;
		errorstr += "Enter valid Case Number!"+ "<BR/>";
		$('#divcasenumber').addClass('has-error');
	}*/
	
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
	}
	
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