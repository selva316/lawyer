/**
 * Site : http:www.smarttutorials.net
 * @author muni
 */

//adds extra table rows
var i=$('.tableSearchBuilder tr').length;
$(".addmore").on('click',function(){
	html = '<tr>';
	html += '<td><select name="logical[]" id="logicalops_1"  class="form-control"><option value="and">AND</option><option value="or">OR</option><option value="not">NOT</option></select></td>';
	html += '<td><select name="fields[]" data-type="'+i+'" id="conditionalSearch_'+i+'" class="form-control"><option value="">All Fields</option></select></td>';
	html += '<td><input type="text" data-type="'+i+'" name="searchContent[]" id="searchcontent_'+i+'" class="form-control autocomplete_searchcontent" autocomplete="off" ondrop="return false;" onpaste="return false;"></td>';
	html += '<td><input class="searchCase" type="checkbox"/></td>'
	html += '</tr>';
	$('.tableSearchBuilder').append(html);
	i++;
});


//to check all checkboxes
$(document).on('change','#check_all',function(){
	$('input[class=searchCase]:checkbox').prop("checked", $(this).is(':checked'));
});

//deletes the selected table rows
$(".delete").on('click', function() {
	$('.searchCase:checkbox:checked').parents("tr").remove();
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