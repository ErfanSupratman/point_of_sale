<!-- Modal fullscreen -->
<div class="modal fade"
	id="modal-finalize-fullscreen" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-sm-6">
						<h4 class="modal-title" id="myModalLabel">Finalisasi</h4>
					</div>
					<div class="col-sm-6" align="right">
						<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<form id="brand_form" action="/">
							<div class="input-group date input-sm" data-provide="datepicker"   data-date-format="yyyy/mm/dd" >
							    <input type="text" placeholder="Masukkan tanggal finalisasi invoice" id="finalize_date" class="form-control">
							    <div class="input-group-addon">
							        <span class="glyphicon glyphicon-th"></span>
							    </div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" id="insert">Simpan</button>
			</div>
		</div>
	</div>
</div>