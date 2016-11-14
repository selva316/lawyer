/**
 * Site : http:www.smarttutorials.net
 * @author muni
 */

//adds extra table rows
var table;
var i=$('.tableSearchBuilder tr').length;
$(".addmore").on('click',function(){
	html = '<tr>';
	html += '<td><select name="logical[]" id="logicalops_1"  class="form-control"><option value="and">AND</option><option value="or">OR</option><option value="not">NOT</option></select></td>';
	html += '<td><select name="fields[]" data-type="'+i+'" id="conditionalSearch_'+i+'" class="form-control"><option value="">All Fields</option><option value="casename">Case Name</option><option value="citation">Citation</option><option value="judge_name">Judge Name</option><option value="court_name">Court Name</option><option value="year">Year</option><option value="statuate">Statute</option> <option value="sub_section">Sub Section</option> <option value="concept">Concept</option></select></td>';
	html += '<td><input type="text" data-type="'+i+'" name="searchContent[]" id="searchcontent_'+i+'" class="form-control autocomplete_searchcontent" autocomplete="off" ondrop="return false;" ></td>';
	html += '<td><input class="searchCase" type="checkbox"/></td>'
	html += '</tr>';
	$('.tableSearchBuilder').append(html);
	$("#numberOfSearchEntries").val(i);
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

$(document).on('click','.searchBuilder',function(){

    var errorMessage = '';
    var temp = [];
    var tempFields = [];
    var si = $("#numberOfSearchEntries").val();
    for(i=1;i<=si;i++)
    {
        var searchContent = "#searchcontent_"+i;
        var searchField = "#conditionalSearch_"+i;

        if ( $(searchContent).val() == ""  || $(searchContent).val() == null) {
            continue;
        }
        else{
            temp.push($(searchContent).val());    
        }
        
        if ( $(searchField).val() == ""  || $(searchField).val() == null) {
            continue;
        }
        else{
            tempFields.push($(searchField).val());    
        }
    }

    if(temp.length == 0)
    {
        errorMessage = errorMessage + 'Search string should not be empty!!\n' ;
    }


    if ( errorMessage != "" ) {
        alert(errorMessage);
        return;
    }

    var listOfSearchBuilder = '';
    for(i=1;i<=si;i++)
    {
        var conditionalStr = "#conditionalSearch_"+i;
        var condition = $(conditionalStr).val();

        var searchcontentStr = "#searchcontent_"+i;
        var searchcontent = $(searchcontentStr).val();

        if(i==1){
            var logicalopsStr = "#logicalops_"+i;
            var logicalops = $(logicalopsStr).val();    
        }
        
        if(searchcontent)
            listOfSearchBuilder += condition+"--$$--"+searchcontent+"--$$--"+logicalops+"--^--";
    }
    listOfSearchBuilder = listOfSearchBuilder.substring(0,listOfSearchBuilder.length-5);

    /*
    $.ajax({
        url : 'searchbuilder/searchAjax',
        dataType: "text",
        method: 'post',
        data: {
           searchString: listOfSearchBuilder
        },
        success: function( data ) {
            alert(data)    
        }
    });*/
    $("#searchResult").css("display","block");
    $('#searchBuilderTable').dataTable().fnDestroy();
	table = $('#searchBuilderTable').DataTable({
	    "ajax": 
	    {
	    	"type" : "POST",
	    	"url":"searchbuilder/searchAjax",
	    	"data" : {
	    		searchString: listOfSearchBuilder
	    	}
	    },
	    "columnDefs": [
	                { 
	                    "visible": false
	                }
	            ],
	    "columns": [
	       { "data": "casename" },  
	       { "data": "citation" },  
	       { "data": "court_name" },
	       { "data": "judge_name" }
	    ]
	});
});