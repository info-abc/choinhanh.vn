<script type="text/javascript">
    function deleteImageRelate() {
        var id = $('.image_relate').data("id");
        $.ajax(
            {
                url: '/admin/image_slider/delete/' + id,
                type: 'POST',
                dataType: "JSON",
                data: {
                    "id": id
                },
                success: function ()
                {
                    console.log("it Work");
                }
        	}
        );
        window.location.reload();
    }
</script>