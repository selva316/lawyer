/**
 * Site : http:www.smarttutorials.net
 * @author muni
 */

//adds extra table rows
var i=$('.tblClientEntity tr').length;
$(".addEntity").on('click',function(){
	var entityName = $("#clientname_1").val();
	var entityEmail = $("#email_1").val();
	var casenumber = $("casenumber_1").val();

	if(entityName !='' && entityEmail !='' && casenumber != '')
	{
		i++;
		html = '<tr><td>';
		html += '<div class="panel panel-info">';
			html += '<div class="panel-heading">Entities <span style="margin-left:90%; cursor:pointer;color: #ed6a43; font-size:14px;" title="Remove Entity" class="removeButton"><i class="fa fa-trash-o fa-fw"></i></span> </div>';
				html += '<div class="panel-body">';
					html += '<div class="row-fluid">';
						html += '<div class="span6"><label class="control-label">Entity Name</label><input class="form-control" type="text" id="clientname_'+i+'" name="clientname[]" value=""/></div>';
						html += '<div class="span6"><label class="control-label">Entity Email Id</label><input class="form-control" type="text" id="email_'+i+'" name="email[]" value=""/></div>';
					html += '</div>';
					html += '<div class="row-fluid">';
						html += '<div class="span6"><label class="control-label">Super note</label><textarea id="entitiessupernote_'+i+'" class="form-control myTextEditor"  placeholder="Super Notes" name="entitiessupernote[]" rows="4" cols="45"></textarea></div>';
					html += '</div>';
				html += '</div>';
		
				html += '<div class="panel panel-danger">';
					html += '<div class="panel-heading">Case Number for this Entity</div>';
						html += '<div class="panel-body">';
							html += '<div class="row-fluid">';
								html += '<div class="span6"><label class="control-label">Case Number</label><input  class="autocasenumber form-control" type="text" id="casenumber_'+i+'" name="casenumber[]" value=""/></div>';
								html += '<div class="span6"><label class="control-label">Case Super note</label><textarea id="casesupernote_'+i+'" class="form-control myTextEditor"  placeholder="Super Notes" name="casesupernote[]" rows="4" cols="45"></textarea>';
							html += '</div>';
						html += '</div>';
					html += '</div>';
				html += '</div>';
			html += '</div>';
		
		html += '</td></tr>';
		$('.tblClientEntity').append(html);
			
	}
	else
	{
		alert("Entity and Case Number should not be empty!!!");
	}
	
});


//to check all checkboxes
$(document).on('change','#check_all',function(){
	$('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
});

//deletes the selected table rows
$(document).on('click', '.removeButton', function(e) {
	$(this).parents("tr").remove();
});

//deletes the selected table rows
$(".phraseDelete").on('click', function() {
	$('.case_phrase:checkbox:checked').parents("tr").remove();
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

function frmValidation()
{
	var clientname = $('#clientname').val();
	var email = $('#email').val();
	var supernote = tinyMCE.get('supernote').getContent();
	var entityEmail = $("#email_1").val();
	var valid=true;
	
	var errorstr = '';
	
	if(clientname==''){
		valid = false;
		errorstr += "Enter valid Client Name!"+ "<BR/>";
		$('#divclientname').addClass('has-error');
	}
	
	if(email ==''){
		valid = false;
		errorstr += "Enter valid Email!"+ "<BR/>";
		$('#divemail').addClass('has-error');
	}
	
	//alert(isEmail(email));
	if(!validateEmails(email))
	{
		valid = false;
		errorstr += "Enter valid Email!"+ "<BR/>";
		$('#divemail').addClass('has-error');
	}

	if(entityEmail!='')
	{
		if(!validateEmails(entityEmail))
		{
			valid = false;
			errorstr += "Enter valid Entity Email!"+ "<BR/>";
			$('#divEntity').addClass('has-error');
		}		
	}

	if(supernote==''){
		valid = false;
		errorstr += "Enter valid supernote!"+ "<BR/>";
		$('#divsupernote').addClass('has-error');
	}
	
	if(!valid)
	{
		alert(errorstr);
	}
	
	return valid;
	
}

	function isEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}

	function validateEmails(emails){
		var res = emails.split(",");

	    for(i = 0; i < res.length; i++)
	    {
	        if(!isEmail($.trim(res[i]))) return false;
	    }
	    return true;
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