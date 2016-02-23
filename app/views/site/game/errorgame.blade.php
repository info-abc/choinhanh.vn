<textarea class="form-control" name="description" rows="3" placeholder="Nội dung báo lỗi" id="description" required></textarea>
<br />
<input type="submit" class="btn btn-primary" value="Gửi" onclick="sendErrorGame()" />
<input type="reset"  class="btn btn-default" value="Nhập lại" />

<div id="modal-senderror-alert" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Thông báo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">Báo lỗi thành công!</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	function sendErrorGame()
	{
		desc = $('#description').val();
		if(!desc) {
			alert('Chưa nhập nội dung báo lỗi!');
			exit();
		}
		$.ajax({
			type:'post',
			url: '{{ url("/send-error-game") }}',
			data: {
				'id': {{ $id }},
				'description': desc
			},
			success: function(data){
				if(data == 1){
					$('#description').val('');
					$('#modal-senderror-alert').modal();
				} else {
					alert('Có lỗi xảy ra!');
				}
				return false;
			},
		});
	}
</script>