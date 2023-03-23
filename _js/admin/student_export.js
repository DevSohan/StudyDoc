jQuery(document).ready(function($) {

	$("#student-exp").on("click", function (e) {  
		e.preventDefault();
		var students_exp =$(this).attr("data-export");
		console.log(typeof students_exp);
		var ids = students_exp.split(',');
		
		$.ajax({
				type: 'POST',
				dataType: 'json',
				url: student_admin_exp_obj.ajaxurl,
				data: {
					'action': 'exp_student', //wp_ajax_ex_student
					'ids': ids
				},
				success: function(data){
					if(data.type == "success"){

						$("#selectAll").prop("checked", false);
						console.log(data);
						
						var wb = XLSX.utils.book_new();
						wb.Props = {
								Title: "SheetJS Tutorial",
								Subject: "Test",
								Author: "Red Stapler",
								CreatedDate: new Date(2017,12,19)
						};

						wb.SheetNames.push("Test Sheet");
						var ws_data = [['hello' , 'world']];
						var ws = XLSX.utils.aoa_to_sheet(ws_data);
						wb.Sheets["Test Sheet"] = ws;
						var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
						
						function s2ab(s) {
							var buf = new ArrayBuffer(s.length);
							var view = new Uint8Array(buf);
							for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
							return buf;
						}
						
// 						saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), 'test.xlsx');
						
						console.log(wbout);
 					window.location.replace(data.message);

						
					}else{
						console.log(data);
// 						$('#delete-students .status').removeClass('alert-danger alert-warning').addClass("alert-danger").html(data.message);
					}
				}
			});

	});

// 		var required = $('input,textarea,select').filter('[required]:visible');
// 		var allRequired = true;
// 		required.each(function(){
// 			if($(this).val() == ''){
// 				allRequired = false;
// 			}
// 		});

// 		if(!allRequired){
// 			$('#delete-students .status').show().addClass("alert-danger").text('Please fill all fields');
// 		}else{
// 			$('#delete-students .status').show().removeClass('alert-danger').addClass("alert-warning").text(student_admin.loadingmessage);
// 			var ids = $('#delete-students input[name="input-delete-students"]').val();
// 			
// 			
// 			
// 		}


});