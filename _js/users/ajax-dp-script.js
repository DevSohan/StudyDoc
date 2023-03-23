jQuery(document).ready( function() {

	// Display Image Add/Change
	var croppieDemo = $('#display_dp').croppie({
		enableOrientation: true,
		viewport: {
			width: 250,
			height: 250,
			type: 'circle' // or 'square'
		},
		boundary: {
			width: 300,
			height: 300
		}
	});

	$('#dp_update').on('change', function () { 
		var reader = new FileReader();
		reader.onload = function (e) {
			croppieDemo.croppie('bind', {
				url: e.target.result
			});
		}
		reader.readAsDataURL(this.files[0]);
	});	
	
	$('#update_dp .submit_button').on('click',  function(e){
		var image_name = $('#dp_update').val().split('\\').pop();
		if ($('#dp_update')[0].files.length === 0) {
			$('#update_dp p.status').text("Please Choose an Image!");
			return false;
		}else{
			var image_origin = image_name.substr(0, image_name.lastIndexOf('.')) || image_name;
			croppieDemo.croppie('result', {
				type: 'canvas',
				size: 'viewport'
			}).then(function (image) {
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: ajax_unicrop_object.ajaxurl,
					data: {
						'action': 'ajaxunicrop',
						'image' : image,
						'name' : image_origin
					},
					success: function (data) {
						if(data.type == "success"){
							$('#update_dp p.status').removeAttr('class').addClass("status alert alert-success").text(data.message);
							setTimeout(function(){
								location.reload();
							}, 1000);
						}else{
							$('#update_dp p.status').removeAttr('class').addClass("status alert alert-danger").text(data.message);
						}

					}
				});
			});		
		}

		e.preventDefault();
	});

})