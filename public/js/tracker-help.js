	/* help var_dump function */
	function var_dump(obj) 
	{
	    var obj_members = "";
	    var sep = "";
	    for (var key in obj) {
	        obj_members += sep + key + ":" + obj[key];
	        sep = ", ";
	    }
	    return ("[" + obj_members + "]");
	}

	/* deleteConfirmation function, expects #confirmDeleteDialog div to exists on the page */
	function confirmDelete(action, id)
	{
		$('#idToDelete').html(id);
		$('#deleteForm').attr('action', '/' + action + '/' + id);
		$('#confirmDeleteDialog').modal();
	}
