	/* deleteConfirmation function, expects #confirmDeleteDialog div to exists on the page */
	function confirmDelete(action, id)
	{
		$('#idToDelete').html(id);
		$('#deleteForm').attr('action', '/' + action + '/' + id);
		$('#confirmDeleteDialog').modal();
	}
