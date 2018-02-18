<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="js/paging.js"></script>
<script src="js/jquery.search.min.js"></script> 
 



<script type="text/javascript">
	$("#search").focus();
	var $rows = $('.table tr');
	
	var $rowsC = $('.table tr').length;
	
	
	$('#search').keyup(function() {
		
		console.log($('#search').val());
		
		if($('#search').val() == ''){
			
			location.reload();
		}		
		
		var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
		reg = RegExp(val, 'i'),
		text;
		
		$rows.show().filter(function() {
			text = $(this).text().replace(/\s+/g, ' ');
				
			return !reg.test(text); //}
			
		}).hide();		
		
	});
	
</script> 



<script type="text/javascript">
	$(document).ready(function() {
		$('#tableData').paging({limit:5});
	});
</script> 
