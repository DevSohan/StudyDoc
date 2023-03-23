jQuery(document).ready(function($) {

	const { __, _x, _n, _nx } = wp.i18n;
	/* --------------------------------------------------------------------------
	Admin - Add Emails to Mail Reciever Field
	-------------------------------------------------------------------------- */
	$(".add_emails").click(function(){
		var email = [];
		if($('#email').val() != ""){
			email.push($('#email').val());
		}
		$.each($(".table-email .multicheck:checked"), function(){
			email.push($(this).val());
			this.checked = false;
		});

		$('#email').val(email.join(", "));
		console.log(email.join(", "));

	});
	$(".all_emails").click(function(){

		var allmail = [];
		var checkbox = $('input[name="multicheck"]');
		checkbox.each(function(){
			var display = $(this).closest( "tr" ).css("display");
			if(display != 'none'){
				allmail.push($(this).val());

			}
		});

		$('#email').val(allmail.join(", "));
		console.log(allmail.join(", "));	

	});


	/* --------------------------------------------------------------------------
	Admin - Email View Nav Pills
	-------------------------------------------------------------------------- */
	$("#viewEmailModal").on('show.bs.modal', function(){
		$('#sent-tab').addClass('active');
		$('#compose-tab').removeClass('active');
		$('#sent').addClass('active show');
		$('#compose').removeClass('active show');
	});



	if ($('#hmtChart').length){
		var hm = parseInt($("#hmtChart").attr("data-hm"));
		var zm = parseInt($("#hmtChart").attr("data-zm"));
		var tm = parseInt($("#hmtChart").attr("data-tm"));
		var subject = [];
		subject.push(hm,zm,tm);
		var ctx1 = document.getElementById('hmtChart').getContext('2d');
		var mixedChart = new Chart(ctx1, {
			type: 'doughnut',
			data: {
				labels: ['Humanmedizin: '+hm, 'Zahnmedizin: '+zm, 'Tiermedizin: '+tm],
				datasets: [{
					label: 'Data',
					data: subject,
					backgroundColor: [
						'#AF7707',
						'#588A88',
						'#84114C'
					],
					borderColor: [
						'#C6B857',
						'#A4CF7B',
						'#30613E'
					],
					borderWidth: 1
				}]
			},
			options: {
				responsive: true,
				legend: {
					position: "right",
					align: "start"
				},
				scales: {
					yAxes: [{
						display: false,
						ticks: {
							beginAtZero: true,
							max: 1000,
							stepSize: 200
						}
					}]
				}
			}
		});
	}

	/**************** PIE CHART ********************/
	if ($('#pieChart').length){
		var ctx2 = document.getElementById('pieChart').getContext('2d');
		var registered = parseInt($("#pieChart").attr("data-registered"));
		var enrolled = parseInt($("#pieChart").attr("data-enrolled"));
		var students = [];
		students.push(registered, enrolled);
		var mixedChart = new Chart(ctx2, {
			type: 'doughnut',
			data: {
				labels: ['Registriert: ' + registered, 'Eingeschrieben: ' + enrolled ],
				datasets: [{
					label: 'Data',
					data: students,
					backgroundColor: [
						'#8E0639',
						'#075E66'

					],
					borderColor: [
						'#C6B857',
						'#A4CF7B'

					],
					borderWidth: 1
				}]
			},
			options: {
				responsive: true,
				legend: {
					position: "right",
					align: "start",
				},
				scales: {
					yAxes: [{
						display: false,
						ticks: {
							beginAtZero: true,
							max: 1000,
							stepSize: 200
						}
					}]
				}
			}
		});
	}
	/******************************* MIXED CHART *******************************************/
	if ($('#mixedChart').length){
		var ctx3 = document.getElementById('mixedChart').getContext('2d');
		var male = parseInt($("#mixedChart").attr("data-male"));
		var female = parseInt($("#mixedChart").attr("data-female"));
		var gender = [];
		gender.push(male, female);
		var mixedChart = new Chart(ctx3, {
			type: 'doughnut',
			data: {
				labels: ['Männlich: '+ male, 'weiblich: ' + female],
				datasets: [{
					label: 'Data',
					data: gender,
					backgroundColor: [
						'#26157B',
						'#C78ACB'
					],
					borderColor: [
						'#D1CFDC',
						'#512556'
					],
					borderWidth: 1
				}]
			},
			options: {
				responsive: true,
				legend: {
					position: "right",
					align: "start"
				},
				scales: {
					yAxes: [{
						display: false,
						ticks: {
							beginAtZero: true,
							max: 1000,
							stepSize: 200
						}
					}]
				}
			}
		});
	}
	/******************************** Uni chartjs ******************/
	if ($('#uniChart').length){
		var ctx4 = document.getElementById('uniChart').getContext('2d');
		var ws2021 = parseInt($("#uniChart").attr("data-ws2021"));
		var ss2022 = parseInt($("#uniChart").attr("data-ss2022"));
		var ws2022 = parseInt($("#uniChart").attr("data-ws2022"));
		var semesters = [];
		semesters.push(ws2021, ss2022, ws2022 );
		var mixedChart = new Chart(ctx4, {
			type: 'doughnut',
			data: {
				labels: ['WS2021: '+ws2021, 'WS2022: '+ws2022, 'SS2022: '+ss2022],
				datasets: [{
					label: 'Data',
					data: semesters,
					backgroundColor: [
						'#AF7707',
						'#26543B',
						'#4E2124'
					],
					borderColor: [
						'#E54F2E',
						'#C8BF9E',
						'#8CB288'
					],
					borderWidth: 1
				}]
			},
			options: {
				responsive: true,
				legend: {
					position: "right",
					align: "start"
				},
				scales: {
					yAxes: [{
						display: false,
						ticks: {
							beginAtZero: true,
							max: 20,
							stepSize: 2
						}
					}]
				}
			}
		});
	}

	var filterby = objectL10n.filterby;
	var filtertext = objectL10n.filtertext;
	var filterrows = objectL10n.filterrows;

	if ($('#table-universities').length){
		$('#table-universities').tablemanager({
			firstSort: [[3,'asc']],
			disable: ["last"],
			appendFilterby: true,
			debug: true,
			vocabulary: {
				voc_filter_by: filterby,
				voc_type_here_filter: filtertext,
				voc_show_rows: filterrows
			},
			pagination: true,
			showrows: [10,20,50,100]
		});
	}
	if ($('.table-sent').length){
		$('.table-sent').tablemanager({
			disable: ["last"],
			debug: true,
			vocabulary: {
				voc_filter_by: filterby,
				voc_type_here_filter: filtertext,
				voc_show_rows: filterrows
			},
			pagination: true,
			showrows: [10,20,50,100]
		});
	}
	if ($('.table-email').length){
		$('.table-email').tablemanager({
			appendFilterby: true,
			debug: true,
			vocabulary: {
				voc_filter_by: filterby,
				voc_type_here_filter: filtertext,
				voc_show_rows: filterrows
			},
			pagination: true,
			showrows: [10,20,50,100]
		});
	}
	if ($('#table-students').length){
		$('#table-students').tablemanager({
			disable: ["last"],
			appendFilterby: true,
			debug: true,
			vocabulary: {
				voc_filter_by: filterby,
				voc_type_here_filter: filtertext,
				voc_show_rows: filterrows
			},
			pagination: true,
			showrows: [10,20,50,100]
		});
	}

	if ($('#table_vorlagen').length){
		$('#table_vorlagen').tablemanager({
			disable: ["last"],
			appendFilterby: true,
			debug: true,
			vocabulary: {
				voc_filter_by: filterby,
				voc_type_here_filter: filtertext,
				voc_show_rows: filterrows
			},
			pagination: true,
			showrows: [5,10,20,50,100]
		});
	}


	var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
	tinymce.init({
		selector: '#messagetext, #template_content, #template_update_content',
		indent: false,
		remove_linebreaks: false,
		plugins: 'print preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable help formatpainter permanentpen pageembed charmap mentions quickbars linkchecker emoticons advtable'
	});


	$('body').on('click', '#emailComp .short_code, #email-template .short_code', function(e) {
		var range = document.createRange();
		var sel = window.getSelection();
		range.setStartBefore(this.firstChild);
		range.setEndAfter(this.lastChild);
		sel.removeAllRanges();
		sel.addRange(range);
		try {  
			var successful = document.execCommand('copy');  
		} catch(err) {  
			console.error('Unable to copy'); 
		} 		
	});

	var add_text = '<p><br><br>Mit freundlichen Grüßen<br>StudyDoc<br><br><hr style="max-width:500px; margin-left:0;color:#FF6600; border-top:0px"><small style="font-size:0.8em;">StudyDoc GmbH Millerntorplatz 1, D-20354 Hamburg | <span style="color:#FF6600;">TEL</span> <a href="tel:+49(0)40237241980">+49 (0) 40 237 241 980</a> | <span style="color:#FF6600;">E-MAIL</span> <a href="mailto:info@studydoc.de">info@studydoc.de</a></small><br><small style="font-size:0.8em;"><span style="color:#FF6600;">Bankverbindung</span> Grenke Bank AG DE 42 2013 0400 0060 0152 52, BIC GREBDEH1</small><br><small style="font-size:0.8em;"><span style="color:#FF6600;">Umsatzsteuer-ID</span> DE 309348429 | <span style="color:#FF6600;">Sitz</span> Hamburg | <span style="color:#FF6600;">Handelsregister</span> Hamburg HRB 142646 | <span style="color:#FF6600;">Geschäftsführerin:</span> Karina Schwarz</small></p>';
	$('#emailComp .short_code').on('click', function(){
		if($(this).html() == '[Footer]'){
			var text = tinymce.get('messagetext').getContent();
			var new_text = text + add_text;
			tinymce.get('messagetext').setContent(new_text);
		}
	})
	$('#email-template .short_code').on('click', function(){
		if($(this).html() == '[Footer]'){
			var text = tinymce.get('template_content').getContent();
			var new_text = text + add_text;
			tinymce.get('template_content').setContent(new_text);
		}
	})

	!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');

});







