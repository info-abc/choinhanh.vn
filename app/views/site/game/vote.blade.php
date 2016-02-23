<?php
    if(Session::has('voterate'.$id)) {
        //
    } else {
 ?>
<div id="rating" class="rating">
    <div class="rate-ex2-cnt stars">
        <div id="1" class="rate-btn-1 rate-btn"></div>
        <div id="2" class="rate-btn-2 rate-btn"></div>
        <div id="3" class="rate-btn-3 rate-btn"></div>
        <div id="4" class="rate-btn-4 rate-btn"></div>
        <div id="5" class="rate-btn-5 rate-btn"></div>
    </div>
</div>
<div id="modal-vote-alert" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">Thông báo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">Cảm ơn bạn đã bình chọn!</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script>
    // rating script
    $(function(){
        $('.rate-btn').hover(function() {
            $('.rate-btn').removeClass('rate-btn-hover');
            var therate = $(this).attr('id');
            for (var i = therate; i >= 0; i--) {
                $('.rate-btn-'+i).addClass('rate-btn-hover');
            };
        });

        $('.rate-btn').click(function() {
            var therate = $(this).attr('id');
            var dataRate = 'id=<?php echo $id; ?>&rate='+therate; //
            $('.rate-btn').removeClass('rate-btn-active');
            for (var i = therate; i >= 0; i--) {
                $('.rate-btn-'+i).addClass('rate-btn-active');
            };
            $.ajax({
                type : "POST",
                url : "{{ route('vote-game') }}",
                data: dataRate,
                success:function(data){
                    // window.location.reload();
                    $('#modal-vote-alert').modal();
                    $('#rating').html(data);
                }
            });

        });
    });

</script>
<?php } ?>