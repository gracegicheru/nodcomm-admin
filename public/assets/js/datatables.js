
		$(function	()	{
			$('#dataTable').dataTable( {
				"bJQueryUI": true,
				"sPaginationType": "full_numbers"
			});
			$('#dataTable1').dataTable( {
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
				 "language": {
				"emptyTable": "Agents were not found"
				}
			});
			$('#dataTable2').dataTable( {
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
				 "language": {
				"emptyTable": "Departments were not found"
				}
			});
			$('#dataTable3').dataTable( {
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
				 "language": {
				"emptyTable": "Websites were not found"
				}
			});
			$('#dataTable4').dataTable( {
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
				 "language": {
				"emptyTable": "Agents with visitors not found"
				}
			});
			$('#dataTable5').dataTable( {
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
				 "language": {
				"emptyTable": "No registered companies"
				}
			});
			$('#dataTable6').dataTable( {
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
				 "language": {
				"emptyTable": "No messages per company"
				}
			});
			$('#dataTable7').dataTable( {
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
				 "language": {
				"emptyTable": "No message history"
				}
			});
		});
	