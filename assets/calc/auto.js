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


//adds extra table rows  	Type of Citation
var j=$('.tableCitation tr').length;
$(".typeAddmore").on('click',function(){
	html = '<tr>';
	html += '<td><input class="case_citation" type="checkbox"/></td>';
	html += '<td><select  class="form-control"  data-type="courtType" id="courtType_'+j+'" name="courtType[]"></select></td>';
	html += '<td><input type="text" data-type="citationNumber" name="citationNumber[]" id="citationNumber_'+j+'" class="form-control autocomplete_citation" autocomplete="off"></td>';
	html += '</tr>';
	$('.tableCitation').append(html);
	i++;
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





//It restrict the non-numbers
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
		valid = false;
		errorstr += "Enter valid Citation Number!"+ "<BR/>";
		$('#divcitation').addClass('has-error');
	}
	
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

