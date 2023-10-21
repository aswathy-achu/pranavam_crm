<script type="text/javascript">
function showAjaxModal(url) {
	
	// SHOWING AJAX PRELOADER IMAGE
	jQuery( '#modal_ajax .modal-body' ).html('<label>loading.....<label>'); 
	// LOADING THE AJAX MODAL
	jQuery( '#modal_ajax' ).modal( 'show', {
		backdrop: 'true'
	} );
	// SHOW AJAX RESPONSE ON REQUEST SUCCESS
	$.ajax( {
		url: url,
		success: function ( response ) {
			$('.modal-body').html(response);
		}
	} );
}
</script>

<div class="modal fade" id="modal_ajax" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Isoba</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">	<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										
									</div>
									<!-- <div class="modal-footer">
										<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-light">Save changes</button>
									</div> -->
								</div>
							</div>
						</div>

