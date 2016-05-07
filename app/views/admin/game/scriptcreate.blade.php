<script>
	function getFormGameOffline() {
		parentId = $('select[name=parent_id]').val();
		if (parentId != {{ GAMEHTML5 }} && parentId != {{ GAMEFLASH }}) {
			$('.blockDisabled').prop('disabled', 'disabled');
			$('.blockDisabled').hide();
			$('#checkUpload').show();
			$('#checkLinkDownload').show();
			$('.link_download').show();
			if ($('#checkUpload').is(':checked')) {
				$('#checkUpload').prop('disabled', 'disabled');
				$('#link_upload_game').prop('disabled', false);
				$('#checkLinkDownload').prop('disabled', false);
			} else {
				$('#checkUpload').prop('disabled', false);
				$('#link_upload_game').prop('disabled', 'disabled');
				$('#checkLinkDownload').prop('disabled', 'disabled');
				$('#link_download').prop('disabled', false);
				$('#link_download_ios').prop('disabled', false);
				$('#link_download_winphone').prop('disabled', false);
			}
		}
		else {
			$('.blockDisabled').prop('disabled', false);
			$('.blockDisabled').show();
			$('#checkUpload').hide();
			$('#checkLinkDownload').hide();
			$('.link_download').hide();
			$('#checkUpload').attr('checked', 'checked');
			$('#checkUpload').prop('disabled', 'disabled');
			$('#link_upload_game').prop('disabled', false);
			$('#checkLinkDownload').prop('disabled', 'disabled');
			$('#link_download').prop('disabled', 'disabled');
			$('#link_download_ios').prop('disabled', 'disabled');
			$('#link_download_winphone').prop('disabled', 'disabled');
			$('#link_upload_game').val('');
			$('#link_download').val('');
			$('#link_download_ios').val('');
			$('#link_download_winphone').val('');
		}
	}

	$(function () {
		getFormGameOffline();
		checkTag();
		
	});

	function checkTag()
	{
		var select = document.getElementById('mysel');
		select.addEventListener('mousedown', function(e){
		    var opt = e.target;
		    if (opt.selected){
		        opt.removeAttribute('selected');
		        opt.selected = false;
		    } else {
		        opt.setAttribute('selected');
		        opt.selected = true;
		    }
		    e.preventDefault();
		});
	}

	function checkUploadAction() {
		if ($('#checkUpload').is(':checked')) {
			$('#checkUpload').prop('disabled', 'disabled');
			$('#link_upload_game').prop('disabled', false);
			$('#link_download').prop('disabled', 'disabled');
			$('#link_download_ios').prop('disabled', 'disabled');
			$('#link_download_winphone').prop('disabled', 'disabled');
			$('#link_download').val('');
			$('#link_download_ios').val('');
			$('#link_download_winphone').val('');
			$('#checkLinkDownload').attr('checked', false);
			$('#checkLinkDownload').prop('disabled', false);
		} else {
			$('#checkUpload').prop('disabled', false);
			$('#link_upload_game').prop('disabled', 'disabled');
			$('#link_download').prop('disabled', false);
			$('#link_download_ios').prop('disabled', false);
			$('#link_download_winphone').prop('disabled', false);
			$('#checkLinkDownload').attr('checked', 'checked');
		}
	}

	function checkLinkDownloadAction() {
		if ($('#checkLinkDownload').is(':checked')) {
			$('#checkLinkDownload').prop('disabled', 'disabled');
			$('#link_upload_game').prop('disabled', 'disabled');
			$('#link_upload_game').val('');
			$('#link_download').prop('disabled', false);
			$('#link_download_ios').prop('disabled', false);
			$('#link_download_winphone').prop('disabled', false);
			$('#checkUpload').attr('checked', false);
			$('#checkUpload').prop('disabled', false);
		} else {
			$('#checkLinkDownload').prop('disabled', false);
			$('#link_upload_game').prop('disabled', false);
			$('#link_download').prop('disabled', 'disabled');
			$('#link_download_ios').prop('disabled', 'disabled');
			$('#link_download_winphone').prop('disabled', 'disabled');
			$('#checkUpload').attr('checked', 'checked');
		}
	}

	function disabledTypeMain() {
		$('input:radio[name^="type_main"]').click(function(){
			return false;
		})
	}

	function checkType(id) {
		if ($('#type_main_'+id).is(':checked')) {
			alert('Không thể bỏ chọn thể loại chính');
			$('#type_id_'+id).prop("checked", true);
			exit();
		}
		return;
	}

	function checkTypeMain(id) {
		if ($('#type_main_'+id).is(':checked')) {
			if($('#type_id_'+id).is(':checked')) {
				return;
			} else {
				$('#type_id_'+id).prop("checked", true);
				// alert('Thể loại chưa được chọn');
				// $('input[name=type_main]').attr('checked',false);
				exit();
			}
		}
		return;
	}





</script>
<script type="text/javascript">
		// cuongnt todo
(function( $ ) {
	$.widget( "custom.combobox", {
	  _create: function() {
		this.wrapper = $( "<span>" )
		  .addClass( "custom-combobox" )
		  .insertAfter( this.element );
 
		this.element.hide();
		this._createAutocomplete();
		this._createShowAllButton();
	  },
 
	  _createAutocomplete: function() {
		var selected = this.element.children( ":selected" ),
		  value = selected.val() ? selected.text() : "";
 
		this.input = $( "<input>" )
		  .appendTo( this.wrapper )
		  .val( value )
		  .attr( "title", "" )
		  .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
		  .autocomplete({
			delay: 0,
			minLength: 0,
			source: $.proxy( this, "_source" )
		  })
		  .tooltip({
			tooltipClass: "ui-state-highlight"
		  });
 
		this._on( this.input, {
		  autocompleteselect: function( event, ui ) {
			ui.item.option.selected = true;
			this._trigger( "select", event, {
			  item: ui.item.option
			});
		  },
 
		  autocompletechange: "_removeIfInvalid"
		});
	  },
 
	  _createShowAllButton: function() {
		var input = this.input,
		  wasOpen = false;
 
		$( "<a>" )
		  .attr( "tabIndex", -1 )
		  .attr( "title", "Show All Items" )
		  .tooltip()
		  .appendTo( this.wrapper )
		  .button({
			icons: {
			  primary: "ui-icon-triangle-1-s"
			},
			text: false
		  })
		  .removeClass( "ui-corner-all" )
		  .addClass( "custom-combobox-toggle ui-corner-right" )
		  .mousedown(function() {
			wasOpen = input.autocomplete( "widget" ).is( ":visible" );
		  })
		  .click(function() {
			input.focus();
 
			// Close if already visible
			if ( wasOpen ) {
			  return;
			}
 
			// Pass empty string as value to search for, displaying all results
			input.autocomplete( "search", "" );
		  });
	  },
 
	  _source: function( request, response ) {
		var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
		response( this.element.children( "option" ).map(function() {
		  var text = $( this ).text();
		  if ( this.value && ( !request.term || matcher.test(text) ) )
			return {
			  label: text,
			  value: text,
			  option: this
			};
		}) );
	  },
 
	  _removeIfInvalid: function( event, ui ) {
 
		// Selected an item, nothing to do
		if ( ui.item ) {
		  return;
		}
 
		// Search for a match (case-insensitive)
		var value = this.input.val(),
		  valueLowerCase = value.toLowerCase(),
		  valid = false;
		this.element.children( "option" ).each(function() {
		  if ( $( this ).text().toLowerCase() === valueLowerCase ) {
			this.selected = valid = true;
			return false;
		  }
		});
 
		// Found a match, nothing to do
		if ( valid ) {
		  return;
		}
 
		// Remove invalid value
		this.input
		  .val( "" )
		  .attr( "title", value + " didn't match any item" )
		  .tooltip( "open" );
		this.element.val( "" );
		this._delay(function() {
		  this.input.tooltip( "close" ).attr( "title", "" );
		}, 2500 );
		this.input.autocomplete( "instance" ).term = "";
	  },
 
	  _destroy: function() {
		this.wrapper.remove();
		this.element.show();
	  }
	});
  })( jQuery );
 
  $(function() {
	$( "#combobox" ).combobox();
	   
  });

  $(document).ready(function(){
	$("#name_game").keyup(function(){
	  var x = document.getElementById("name_game");
	  var count = x.value.length;
	  var div = document.getElementById('divID');
	  div.innerHTML = count;
	});
});
  
 

</script>