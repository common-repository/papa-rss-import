
	function toggleAll(checks){

		for(var i=0;i<checks.length;i++)

		{

			checks[i].checked=!checks[i].checked;

		}

	}

	function deleteRss(form){

		if(confirm("Are you sure want to delete?")){

			form.act.value="delete";

			form.submit();

		}

	}

	

	function updateStatusRss(form,status){

			form.act.value=status==1?"enable":"disable";

			form.submit();

	}

	function doFetch(form){

			if(confirm("Need Some Time to do the import from the source!")){
				form.act.value="fetch";
				form.submit();

			}

	}

	

	function addNewRss(form){

		var action=form.action;

		form.action="edit.php?page=papa-rss-import/papa-rss.php";

		form.submit();

		form.action=action;	

	}

// JavaScript Document