<script>
	$(function () {
		adSelect();
    });

    function adSelect()
    {
    	if ($('#ad-select-image').is(':checked')) {
    		$('textarea[name=adsense]').prop('disabled', 'disabled');
			$('.ad-adsense').hide();
			$('input[name=image_link]').prop('disabled', false);
			$('input[name=image_url]').prop('disabled', false);
			$('.ad-image').show();
		} else {
			$('textarea[name=adsense]').prop('disabled', false);
			$('.ad-adsense').show();
			$('input[name=image_link]').prop('disabled', 'disabled');
			$('input[name=image_url]').prop('disabled', 'disabled');
			$('.ad-image').hide();
		}
    }
</script>