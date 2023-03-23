<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


global $wpdb;
$student_table = $wpdb->prefix . 'students';
$userID = get_current_user_id();
$student = array();

$stundent_info = $wpdb->get_results ( "SELECT title, first_name, last_name, address1, country, city, zip, citizenship, gender, date_of_birth, place_of_birth, email, telephone, university, subject, present_semester, lpa, selected_university FROM $student_table where user = $userID", ARRAY_A );

$student[0] = $stundent_info[0];
$unio = explode(',', $student[0]['selected_university']);
$upload_dir   = wp_upload_dir();
$default_dp = $upload_dir['baseurl'] . '/display_image/default_dp.png';
$user_dp = (!empty(get_user_meta($userID, 'dp_link', true))) ? get_user_meta($userID, 'dp_link', true) : $default_dp;


$university_array = 'shortname,name';
$university_table = $wpdb->prefix . 'universities';
$universities = $wpdb->get_results( "SELECT $university_array FROM $university_table", ARRAY_A );
?>

<div class="container-fluid">
	<div class="row width_1600">
		<div class="col-md-3">

			<div class="wc-student-info-wrapper">
				<div class="wc-student-info-dp">
					<div class="wc-sip-image">		
						<img id="profile-stu" class="rounded mx-auto d-block" src="<?php echo $user_dp ?>" alt="<?php echo $student[0]['last_name'] . ', ' . $student[0]['first_name'] ;?>" width="150" height="150">
						
							<a href="#" id="add_dp_stu" class="change_dp" data-toggle="modal" data-target="#modalChangeDP"><?php // _e('Change', 'study-doc'); ?> <i class="fas fa-plus change_dp_icon"></i></a>
					<br>
						<h3 class="text-center section_hrading">
							<?php echo $student[0]['first_name'] . ' ' . $student[0]['last_name']; ?>
						</h3>
						<p class="text-center">
							<?php _e('ID:', 'study-doc'); ?> <?php
							global $current_user; wp_get_current_user();
							echo $current_user->user_login; 
							?>
						</p>
					</div>
				</div>
				
			</div>
			
			<div class="dashboard_section">
				<h3 class="dashboard_section_heading">
				Persönliche Infos
				</h3>
				
				<div class="wc-student-info-contents">
					
					<p class="wc-sic-email">
						<span class="dashboard_section_subheading"><?php _e('Email:', 'study-doc'); ?></span><br><?php echo $student[0]['email'];?>
					</p>
					<div class="dashboard_section_gap"></div>
					<p class="wc-sic-address">
						<span class="dashboard_section_subheading"><?php _e('Address:', 'study-doc'); ?></span><br> 
						<?php echo $student[0]['address1']; ?><br>
						<?php echo ($student[0]['address2'] != '') ? $student[0]['address2'] .'<br>' : null; ?>
						<?php echo $student[0]['city'] . ', ' . $student[0]['country']; ?>
					</p>
					
					
			</div>
			</div>
			
			
			
		</div>
		
		<div class="col-md-9">
		<div class="row">
			<div class="col-md-6 col-xs-12">
				<div class="uni-list-wrap">
					<h3 class="dashboard_section_heading">
						<?php _e('Universitäten', 'study-doc'); ?>
					</h3>
					<ul class="unilist-ul">
						<?php 
							foreach($universities as $uni){	
								$uni_name = $uni['name'];
								$uni_shortname = $uni['shortname'];
							if(in_array($uni['shortname'], $unio)){ echo '<li class="university-li" id="'.$uni_shortname.'">'.$uni_name.'</li>'; }
								
							}
	
						?>
					</ul>
				</div>
				
			</div>
			
			<div class="col-md-6 col-xs-12">
				<div class="checklists">
					<h3 class="dashboard_section_heading">
						<?php _e('Checkliste', 'study-doc'); ?>
					</h3>
					<div class="checklist" id="checkllist-null">
						<p class="null_text">
							<?php _e('Bitte wählen Sie ein Universität aus, um deren Dokumenten-Checkliste zu sehen', 'study-doc'); ?>
						</p>
					</div>
					
					<div class="checklist" id="checkllist-OSJ">
						<div class="checklist-wrap">
					
							
							<ol class="checklist-ol">
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Für die Bewerbung benötigen wir eine notariell beglaubigte Kopie Ihrer Allgemeinen Hochschulreife (z.B. Abitur).">Abiturzeugnis; notariell beglaubigt</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte senden Sie uns für Ihre Bewerbung eine Kopie Ihres gültigen Reisepasses oder eine Kopie der Vorder- und Rückseite Ihres gültigen Personalausweises zu. ">Kopie des Reisepasses/Personalausweises </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns zwei aktuelle Passfotos zukommen">2 Passfotos </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte übersenden Sie uns einen tabellarischen Lebenslauf mit Passfoto (bitte ein echtes, seriöses Passfoto, keine Ferien-/Freizeitbilder etc.).Bitte führen Sie in dem Lebenslauf neben Ihrem bisherigen Schul- und Ausbildungsablauf auch Auslandsaufenthalte, sportliches/gemeinnütziges/kirchliches Engagement sowie Praktika und berufliche Tätigkeiten (auch Nebenjobs) auf. Nachdem Sie uns den Lebenslauf mit Passfoto per E-Mail als Word-Datei übersandt haben, werden wir diese sichten und gegebenenfalls in Rücksprache mit Ihnen Änderungen vornehmen. ">Lebenslauf mit Lichtbild</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Ein zentrales Element des Bewerbungsverfahrens ist Ihre Eignung und Motivation. Bitte übersenden Sie uns daher ein Motivationsschreiben, in dem Sie darauf eingehen warum Sie sich für das Studium der Humanmedizin entschieden haben, welche Erfahrungen Sie bisher gemacht haben, die Sie in diesem Wunsch bestärken und was Sie dazu eignet an dieser Universität Medizin zu studieren. Nachdem Sie uns das Motivationsschreiben per E-Mail als Word-Datei übersandt haben, werden wir diese sichten und gegebenenfalls in Rücksprache mit Ihnen Änderungen vornehmen. ">Motivationsschreiben</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Neben den Bewerbungsunterlagen, die Sie mit unserer Unterstützung einreichen, ist Teil des Bewerbungsverfahrens das erfolgreiche Bestehen des „MediTest-EU“. Der schriftliche Teil des Tests (Multiple-Choice-Verfahren) unterteilt sich in folgende Schwerpunkte: Allgemeinwissen, Biologie, Chemie und Mathematik. Im Mittelpunkt steht das Ziel, Ihre Eignung für das Medizinstudium festzustellen; Der Anspruch der Fragen aus den Bereichen Biologie, Mathematik und Chemie bewegt sich auf Leistungskursniveau der Oberstufe. Zur Vorbereitung auf den Aufnahmetest empfehlen wir ein Handbuch, das Sie von uns mit dem Testtermin erhalten. Im unwahrscheinlichen Fall des Nichtbestehens kann der Test wiederholt werden. Über die genauen Testorte und Termine informieren wir Sie rechtzeitig. Der schriftliche Teil dauert nach der Einführung ca. 120 Minuten. Sie müssen lediglich einen Stift mitbringen, weitere Hilfsmittel benötigen Sie nicht. Die Auswertung des Tests erfolgt kurz darauf über die MediTest-Foundation. Über das Ergebnis informieren wir Sie schriftlich">MediTest-EU</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Ein weiterer Bestandteil des MediTest-EU ist die Teilnahme an einem persönlichen Interview. Dies kann persönlich zu den entsprechenden Testterminen in Hamburg oder in der Woche nach dem schriftlichen Test online durchgeführt werden. Die Dauer des Gesprächs beträgt ca. 30 Minuten. ">Persönliches Interview</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte senden Sie uns Nachweise über absolvierte Praktika, vorwissenschaftliche Arbeiten etc. – insbesondere, wenn Sie diese in Ihrem Motivationsschreiben oder Lebenslauf genannt haben. Bitte senden Sie uns falls vorhanden auch einen Nachweis über eine Ausbildung zum Rettungssanitäter oder Notfallsanitäter zu. ">Ggf. Praktikumsnachweise</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns zudem die vollständigen Namen, Geburtsdaten und aktuellen Meldeanschriften beider Elternteile zukommen. ">Daten der Eltern</li>
							</ol>
						</div>
					</div>
					
					<div class="checklist" id="checkllist-RIG">
					
						<div class="checklist-wrap">
							<ol class="checklist-ol">
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Für die Bewerbung benötigen wir eine notariell oder schulisch beglaubigte Kopie Ihrer Allgemeinen Hochschulreife (z.B. Abitur).">Abiturzeugnis; notariell oder schulisch beglaubigt</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Außerdem muss das notariell oder schulisch beglaubigte Zeugnis ins Englische übersetzt werden. Wir kümmern uns gern um die Übersetzung für Sie. Bitte senden Sie uns dafür schnellstmöglich Ihr Abiturzeugnis zu. Wenn Sie Ihr Abiturzeugnis bereits ins Englische übersetzen lassen haben, informieren Sie uns innerhalb der nächsten 7 Tage darüber. ">Abiturzeugnis; übersetzt ins Englische</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Sollten Sie Ihre Hochschulzugangsberechtigung 2021 erlangen, senden Sie uns bitte alle übrigen Dokumente und Ihr letztes Zeugnis (Halbjahreszeugnis des letzten Schuljahres) schnellstmöglich zu. Auch dieses lassen wir ins Englische übersetzen. Ihr Abiturzeugnis senden Sie uns, sobald es Ihnen vorliegt.">Hochschulzugangsberechtigung </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte senden Sie uns für Ihre Bewerbungen zwei Kopien Ihres gültigen Reisepasses oder zwei Kopien der Vorder- und Rückseite Ihres gültigen Personalausweises zu. ">Zwei Kopien des Reisepasses/Personalausweises</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns vier aktuelle Passfotos zukommen.">Vier Passfotos </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Für die Erstellung der Bewerbungsformulare ist auf der Internetseite der Universität Riga ein Onlineformular auszufüllen. Dies übernehmen wir gerne für Sie und benötigen hierzu die folgenden Informationen: Eine Notfallkontaktadresse (für Krankheitsfälle o.Ä.) 
benötigt werden hier Name, Adresse, Telefonnummer und E-Mail-Adresse ">Bewerbungsformular </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte setzen Sie für die Universität in Riga ein Motivationsschreiben in englischer Sprache auf. Das Motivationsschreiben sollte eine Begründung der Wahl des Studienfachs, der Universität und Ihre Motivation für das Studium sowie alle bisher erworbenen persönlichen, beruflichen und akademischen Qualitäten beinhalten, die für den gewählten Studiengang relevant sind. Ihr Motivationsschreiben senden Sie uns bitte ausschließlich als Word-Dokument. Die finale Version soll nach Bearbeitung in den Vordruck der Universität eingetragen werden. Diesen erhalten Sie zu gegebener Zeit.   ">Motivationsschreiben</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Die Universität in Riga fordert zwei Empfehlungsschreiben. Wir haben Ihnen zwei separate Vordrucke an dieses Schreiben angehängt. Berechtigte Personen für die Ausstellung eines Referenzschreibens sind z.B. ehemalige Lehrer, Arbeitgeber oder Betreuer von durchgeführten Praktika. Das Schreiben sollte Ihre persönlichen, beruflichen und akademischen Qualitäten und Ergebnisse, die für die Bewerbung relevant sind, hervorheben.  Bitte lassen Sie die Empfehlungsschreiben handschriftlich oder gedruckt in den dafür vorgesehenen Bereich einfügen. Die Unterschrift darf nicht maschinell erstellt werden, sie muss handschriftlich erfolgen. Die Empfehlungsschreiben müssen anschließend vom Ersteller in einen Umschlag gelegt werden. Dieser Umschlag muss verschlossen und vom Ersteller auf dem Klebestreifen unterschrieben werden.">Zwei Empfehlungsschreiben</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte überweisen Sie die anfallenden Bewerbungsgebühren in Höhe von 100,00 Euro an die Universität in Riga an folgendes Konto: Kontoinhaber: Riga Stradins University, Bank: A/S Swedbank, IBAN:  LV02 HABA 0551 0003 7605 0, SWIFT/BIC: HABALV22, Bitte geben Sie bei der Überweisung folgenden Betreff an: „Application fee for Vorname Nachname“. Wir benötigen ferner einen Nachweis über Zahlung der Bewerbungsgebühr, am besten eine Kopie der Bankbestätigung über die getätigte Überweisung.  ">Nachweis über Zahlung der Bewerbungsgebühr</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns zudem die vollständigen Namen, Geburtsdaten und aktuellen Meldeanschriften beider Elternteile zukommen.">Daten der Eltern</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Die Universität in Riga benötigt von ihren Bewerbern den Nachweis über deren Englischkenntnisse. Diese weisen Sie durch mindestens ausreichende Englischnoten in der Oberstufe oder alternativ durch ein Englisch Sprachzertifikat (TOEFL iBT, TOEFL PBT, IELTS Academic oder vergleichbar) nach. Sollten Sie bereits einen solchen Sprachtest abgelegt haben, bitten wir zunächst um Übersendung einer Kopie des Sprachzertifikats. Bitte beachten Sie, dass einige Sprachzertifikate nur zeitlich begrenzt gültig sind. ">Ggf. Nachweis der Englischkenntnisse </li>
							</ol>
						</div>
					</div>
					
					<div class="checklist" id="checkllist-RES">
						<div class="checklist-wrap">
						
							<ol class="checklist-ol">
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Für die Bewerbung benötigen wir Ihr Zeugnis der Allgemeinen Hochschulreife (z.B. Abitur) in beglaubigter Kopie">Abiturzeugnis; beglaubigt</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Außerdem muss das beglaubigte Zeugnis ins Englische übersetzt werden. Wir kümmern uns gern um die Übersetzung für Sie. Bitte senden Sie uns dafür schnellstmöglich Ihr Abiturzeugnis zu. Wenn Sie Ihr Abiturzeugnis bereits ins Englische übersetzen lassen haben, informieren Sie uns innerhalb der nächsten 7 Tage darüber. Bitte beachten Sie, dass im Falle einer Zulassung eine polnische Übersetzung Ihres Abiturzeugnisses benötigt wird. Diese können Sie in Absprache mit der Universität in Resche direkt vor Ort veranlassen">Beglaubigtes Abiturzeugnis; übersetzt ins Englische</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Sollten Sie Ihre Hochschulzugangsberechtigung 2021 erlangen, senden Sie uns bitte alle übrigen Dokumente und Ihr letztes Zeugnis (Halbjahreszeugnis des letzten Schuljahres) schnellstmöglich zu. Ihr Abiturzeugnis senden Sie uns, sobald es Ihnen vorliegt.">Hochschulzugangsberechtigung </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte senden Sie uns für Ihre Bewerbungen eine Kopie Ihres gültigen Reisepasses oder die Kopie der Vorder- und Rückseite Ihres gültigen Personalausweises zu. ">Kopie des Reisepasses/Personalausweises</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns zwei aktuelle Passfotos zukommen. Bitte beachten Sie, dass die Passfotos für die Bewerbung an der Universität in Resche biometrisch sein müssen.">Zwei Passfotos </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte füllen Sie das in der Anlage übersandte Bewerbungsformular vollständig aus und senden Sie das Original als Scan und postalisch an uns. ">Bewerbungsformular </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie das in der Anlage übersandte Attest durch Ihren Hausarzt ausfüllen und unterzeichnen und senden Sie das Original als Scan und postalisch an uns zurück. Dieses Attest darf nicht von einem verwandten Arzt ausgefüllt werden. Bitte beachten Sie, dass im Falle einer Zulassung eine polnische Übersetzung Ihres ärztlichen Attests benötigt wird. Diese können Sie in Absprache mit der Universität in Resche direkt vor Ort veranlassen.  ">Ärztliches Attest </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte unterschreiben Sie die in der Anlage übersandte Datenschutzerklärung und senden Sie das Original als Scan und postalisch an uns.">Datenschutzerklärung</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte unterschreiben Sie den in der Anlange übersandten Krankenversicherungsnachweis und senden Sie das Original als Scan und postalisch an uns.">Krankenversicherungsnachweis</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte senden Sie uns die Vollmacht ausgefüllt, unterschrieben und von einem Notar beglaubigt wieder zurück.">Power of Attorney, notariell beglaubigt</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Neben den Bewerbungsunterlagen, die Sie mit unserer Unterstützung einreichen, ist Teil des Bewerbungsverfahrens das erfolgreiche Bestehen des „MediTest-EU“. Der schriftliche Teil des Tests (Multiple-Choice-Verfahren) unterteilt sich in folgende Schwerpunkte: Allgemeinwissen, Biologie, Chemie und Mathematik. Im Mittelpunkt steht das Ziel, Ihre Eignung für das Medizinstudium festzustellen; Der Anspruch der Fragen aus den Bereichen Biologie, Mathematik, Physik und Chemie bewegt sich auf Leistungskursniveau der Oberstufe. Zur Vorbereitung auf den Aufnahmetest empfehlen wir ein Handbuch, das Sie von uns mit dem Testtermin erhalten. Im unwahrscheinlichen Fall des Nichtbestehens kann der Test wiederholt werden. Über die genauen Testorte und Termine informieren wir Sie rechtzeitig. Sie müssen lediglich einen Stift mitbringen, weitere Hilfsmittel benötigen Sie nicht. Die Auswertung des Tests erfolgt kurz darauf über die MediTest Foundation. Über das Ergebnis informieren wir Sie schriftlich. ">MediTest-EU</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Ein weiterer Bestandteil des MediTest-EU ist die Teilnahme an einem persönlichen Interview. Dies kann persönlich zu den entsprechenden Testterminen in Hamburg oder in der Woche nach dem schriftlichen Test per Skype durchgeführt werden. Die Dauer des Gesprächs beträgt ca. 30 Minuten. ">Persönliches Interview </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Die Universität in Resche erhebt im Laufe des Bewerbungsverfahrens eine Bewerbungsgebühr in Höhe von 85 PLN (ca. 23 Euro). Zahlungsinformationen erhalten Sie, sobald Ihre Unterlagen vollständig sind. Bereits jetzt weisen wir Sie darauf hin, unserer Empfehlung zu folgen und dies in polnischer Währung zu überweisen, um Nachzahlungen aufgrund von Kursabweichungen zu vermeiden. Bitte beachten Sie, dass für die Überweisung gegebenenfalls Gebühren anfallen können. Kontaktieren Sie diesbezüglich Ihre Bank. ">Nachweis über Zahlung der Bewerbungsgebühr</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns zudem die vollständigen Namen, Geburtsdaten und aktuellen Meldeanschriften beider Elternteile zukommen.">Daten der Eltern</li>
								
							</ol>
						</div>
					</div>
					
					<div class="checklist" id="checkllist-BRE">
						<div class="checklist-wrap">
						
							<ol class="checklist-ol">
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Für die Bewerbung in Breslau benötigen wir Ihr Abiturzeugnis. Dieses muss mit einer Haager Apostille versehen werden. Das Abiturzeugnis müssen Sie dazu vorbeglaubigen lassen. Über http://www.apostilleinfo.com/ erhalten Sie Informationen zu Ihrer zuständigen Behörde. Bitte setzen Sie sich vorher telefonisch mit dem Amt in Verbindung, um einen Termin zu vereinbaren und die Vorbeglaubigungen zu besprechen. Bitte senden Sie Ihre Dokumente nicht per Post dorthin, sondern vereinbaren Sie einen Termin und geben diese persönlich zur Apostillierung. ">Abiturzeugnis; apostilliert</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Außerdem müssen die entsprechenden Zeugnisse nach der Apostillierung ins Polnische übersetzt werden. Das übernehmen wir gern für Sie. Wenn Sie Ihre Zeugnisse bereits ins Polnische übersetzen lassen haben, informieren Sie uns innerhalb der nächsten 7 Tage darüber. ">Abiturzeugnis; übersetzt ins Polnische</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Sofern Sie Biologie, Chemie und Physik nicht durchgängig in der Oberstufe belegt haben, benötigen wir darüber hinaus von Ihnen auch noch apostillierte Kopien des letzten Jahrgangszeugnisses, in dem diese Fächer benotet worden sind. Wenn Sie also zum Beispiel Chemie zuletzt in der 10. Klasse belegt haben, senden Sie uns das Jahresabschlusszeugnis der 10. Klasse">Ggf. Jahresabschlusszeugnis der 10. oder 11. Klasse; apostilliert </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Auch diese Zeugnisse müssen nach der Apostillierung ins Polnische übersetzt werden. Das übernehmen wir gern für Sie. Wenn Sie Ihre Zeugnisse bereits ins Polnische übersetzen lassen haben, informieren Sie uns innerhalb der nächsten 7 Tage darüber. ">Ggf. Jahresabschlusszeugnis der 10. oder 11. Klasse; übersetzt ins Polnische</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Sollten Sie Ihre Hochschulzugangsberechtigung 2021 erlangen, senden Sie uns bitte alle übrigen Dokumente und Ihr letztes Zeugnis (Halbjahreszeugnis des letzten Schuljahres) schnellstmöglich zu. Ihr Abiturzeugnis senden Sie uns, sobald es Ihnen vorliegt.">Hochschulzugangsberechtigung </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte senden Sie uns für Ihre Bewerbungen eine Kopie Ihres gültigen Reisepasses oder die Kopie der Vorder- und Rückseite Ihres gültigen Personalausweises zu. ">Kopie des Reisepasses/Personalausweises</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns zwei aktuelle Passfotos zukommen.">Zwei Passfotos </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Das Bewerbungsformular erhalten Sie im späteren Bewerbungsverlauf nach Anmeldung an der Universität. ">Bewerbungsformular </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie das in der Anlage übersandte Attest durch Ihren Hausarzt ausfüllen und unterzeichnen und senden Sie dieses im Original an uns zurück. Dieses Attest darf nicht von einem verwandten Arzt ausgefüllt werden. ">Ärztliches Attest </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Die Hochschule in Breslau benötigt von ihren Bewerbern den Nachweis über deren Englischkenntnisse. Diese weisen Sie durch mindestens befriedigende Englischnoten in der Oberstufe oder alternativ durch ein Englisch Sprachzertifikat (TOEFL iBT, TOEFL PBT, IELTS Academic oder vergleichbar) nach. Sollten Sie bereits einen solchen Sprachtest abgelegt haben, bitten wir zunächst um Übersendung einer Kopie des Sprachzertifikats. Bitte beachten Sie, dass einige Sprachzertifikate nur zeitlich begrenzt gültig sind. ">Ggf. Sprachtest </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Die Universität in Breslau erhebt im Laufe des Bewerbungsverfahrens eine Bewerbungsgebühr in Höhe von 85 PLN (ca. 23 Euro). Zahlungsinformationen erhalten Sie, sobald Ihre Unterlagen vollständig sind. Bereits jetzt weisen wir Sie darauf hin, unserer Empfehlung zu folgen und dies in polnischer Währung zu überweisen, um Nachzahlungen aufgrund von Kursabweichungen zu vermeiden. Bitte beachten Sie, dass für die Überweisung gegebenenfalls Gebühren anfallen können. Kontaktieren Sie diesbezüglich Ihre Bank. ">Nachweis über Zahlung der Bewerbungsgebühr</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns zudem die vollständigen Namen, Geburtsdaten und aktuellen Meldeanschriften beider Elternteile zukommen.">Daten der Eltern</li>
								
							</ol>
						</div>
					</div>
					
					<div class="checklist" id="checkllist-VIL">
						<div class="checklist-wrap">
						
							<ol class="checklist-ol">
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Für die Bewerbung benötigen wir eine notariell beglaubigte Kopie Ihrer Allgemeinen Hochschulreife (z.B. Abitur).">Abiturzeugnis; notariell beglaubigt</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Außerdem muss das notariell beglaubigte Zeugnis ins Englische übersetzt werden. Wir kümmern uns gern um die Übersetzung für Sie. Bitte senden Sie uns dafür schnellstmöglich Ihr Abiturzeugnis zu. Wenn Sie Ihr Abiturzeugnis bereits ins Englische übersetzen lassen haben, informieren Sie uns innerhalb der nächsten 7 Tage darüber">Abiturzeugnis; übersetzt ins Englische</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Sollten Sie Ihre Hochschulzugangsberechtigung 2021 erlangen, senden Sie uns bitte alle übrigen Dokumente und Ihr letztes Zeugnis (Halbjahreszeugnis des letzten Schuljahres) schnellstmöglich zu. Auch dieses lassen wir ins Englische übersetzen. Ihr Abiturzeugnis senden Sie uns, sobald es Ihnen vorliegt. Informieren Sie uns vorab per Mail, wann Sie voraussichtlich Ihre Hochschulzugangsberechtigung erhalten.">Hochschulzugangsberechtigung </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Des Weiteren verlangt die Vilnius University ein Zertifikat zur Anerkennung der Zeugnisse. Dieses Zertifikat wird vom Centre for Quality Assessment in Higher Education in Lithuania (QUAHE) ausgestellt und bestätigt, dass Ihre in Deutschland erlangten Qualifikationen äquivalent zu den litauischen Qualifikationen sind. Für die Ausstellung des Zertifikats muss ein Formblatt ausgefüllt werden. Sie finden ein vorausgefülltes Muster in der Anlage. Das Zertifikat muss erst in den ersten fünf Monaten nach Zulassung zum Studium nachgereicht werden. Außer es auszufüllen müssen Sie also derzeit noch nichts unternehmen. ">Recognition Form </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte senden Sie uns für Ihre Bewerbungen eine Kopie Ihres gültigen Reisepasses oder eine Kopie der Vorder- und Rückseite Ihres gültigen Personalausweises zu. ">Kopie des Reisepasses/Personalausweises</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns zwei aktuelle Passfotos zukommen.">Zwei Passfotos </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="In der Anlage finden Sie ein Bewerbungsformular der Vilnius University, sowie ein vorausgefülltes Musterformular zur Orientierung. Bitte prüfen Sie die Daten auf dem Formular und füllen Sie anschließend die markierten Felder aus. Bitte nennen Sie uns einen Notfallkontakt und zwei Referenzpersonen, mit Namen und E-Mail-Adressen, durch die Sie ggf. für das Studium empfohlen werden.">Bewerbungsformular </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte setzen Sie für die Universität in Vilnius ein Motivationsschreiben in englischer Sprache auf. Das Motivationsschreiben sollte eine Begründung der Wahl des Studienfachs, der Universität und Ihre Motivation für das Studium sowie alle bisher erworbenen persönlichen, beruflichen und akademischen Qualitäten beinhalten, die für den gewählten Studiengang relevant sind. Ihr Motivationsschreiben senden Sie uns bitte ausschließlich als Word-Dokument. ">Motivationsschreiben</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Neben den Bewerbungsunterlagen, die Sie mit unserer Unterstützung einreichen, ist Teil des Bewerbungsverfahrens das erfolgreiche Bestehen des „MediTest-EU“. Der schriftliche Teil des Tests (Multiple-Choice-Verfahren) unterteilt sich in folgende Schwerpunkte: Allgemeinwissen, Biologie, Chemie und Mathematik. Im Mittelpunkt steht das Ziel, Ihre Eignung für das Medizinstudium festzustellen; Der Anspruch der Fragen aus den Bereichen Biologie, Mathematik und Chemie bewegt sich auf Leistungskursniveau der Oberstufe. Zur Vorbereitung auf den Aufnahmetest empfehlen wir ein Handbuch, das Sie von uns mit dem Testtermin erhalten. Im unwahrscheinlichen Fall des Nichtbestehens kann der Test wiederholt werden. Über die genauen Testorte und Termine informieren wir Sie rechtzeitig. Der schriftliche Teil dauert nach der Einführung ca. 120 Minuten. Sie müssen lediglich einen Stift mitbringen, weitere Hilfsmittel benötigen Sie nicht. Die Auswertung des Tests erfolgt kurz darauf über die MediTest Foundation. Über das Ergebnis informieren wir Sie schriftlich. ">MediTest-EU</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Ein weiterer Bestandteil des MediTest-EU ist die Teilnahme an einem persönlichen Interview. Dies kann persönlich zu den entsprechenden Testterminen in Hamburg oder in der Woche nach dem schriftlichen Test per Skype durchgeführt werden. Die Dauer des Gesprächs beträgt ca. 30 Minuten. ">Persönliches Interview</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte überweisen Sie die anfallenden Bewerbungsgebühren in Höhe von 100,00 Euro an die Universität in Vilnius an folgendes Konto: Kontoinhaber: Vilnius University, Bank: SEB bankas, IBAN:  LT 207044060006728725,  SWIFT/BIC: CBVI LT 2X , Bitte geben Sie bei der Überweisung folgenden Betreff an: „Application fee – Ihr Name“, sowie „code – 200678001“. Wir benötigen ferner einen Nachweis über Zahlung der Bewerbungsgebühr, am besten eine Kopie der Bankbestätigung über die getätigte Überweisung">Nachweis über Zahlung der Bewerbungsgebühr</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns zudem die vollständigen Namen, Geburtsdaten und aktuellen Meldeanschriften beider Elternteile zukommen.">Daten der Eltern</li>
								
							</ol>
						</div>
					</div>
					
					<div class="checklist" id="checkllist-RIJ">
						<div class="checklist-wrap">
						
							<ol class="checklist-ol">
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Für die Bewerbung benötigen wir eine notariell beglaubigte Kopie Ihrer Allgemeinen Hochschulreife (z.B. Abitur).  ">Abiturzeugnis; notariell beglaubigt</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Außerdem muss das notariell beglaubigte Zeugnis ins Englische übersetzt werden. Wir kümmern uns gern um die Übersetzung für Sie. Bitte senden Sie uns dafür schnellstmöglich Ihr Abiturzeugnis zu. Wenn Sie Ihr Abiturzeugnis bereits ins Englische übersetzen lassen haben, informieren Sie uns innerhalb der nächsten 7 Tage darüber. ">Abiturzeugnis; übersetzt ins Englische</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Sollten Sie Ihre Hochschulzugangsberechtigung 2021 erlangen, senden Sie uns bitte alle übrigen Dokumente und Ihr letztes Zeugnis (Halbjahreszeugnis des letzten Schuljahres) schnellstmöglich zu. Auch dieses lassen wir ins Englische übersetzen. Ihr Abiturzeugnis senden Sie uns, sobald es Ihnen vorliegt.">Hochschulzugangsberechtigung </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Die Universität benötigt Ihre Jahresabschlusszeugnisse der 9. und 10. Klasse. Sollten Sie Ihr Abitur nach 13 Jahren abgeschlossen haben, benötigen wir auch Ihr Jahresabschlusszeugnis der 11. Klasse. Auch diese müssen Sie beglaubigen lassen.">Jahresabschlusszeugnis 9.,10. und ggf. 11. Klasse, notariell beglaubigt</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Auch diese Zeugnisse müssen ins Englische übersetzt werden. Wir kümmern uns gern um die Übersetzung für Sie. Wenn Sie Ihre Zeugnisse bereits ins Englische übersetzen lassen haben, informieren Sie uns innerhalb der nächsten 7 Tage darüber.">Jahresabschlusszeugnis 9.,10. und ggf. 11. Klasse, übersetzt ins Englische </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte senden Sie uns für Ihre Bewerbungen eine Kopie Ihres gültigen Reisepasses oder eine Kopie der Vorder- und Rückseite Ihres gültigen Personalausweises zu. ">Kopie des Reisepasses/Personalausweises</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns vier aktuelle Passfotos zukommen.">Vier Passfotos </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte senden Sie uns die Vollmacht ausgefüllt und unterschrieben wieder zurück.  ">Power of Attorney</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="In der Anlage finden Sie ein Bewerbungsformular der Universität in Rijeka. Bitte füllen sie dieses vollständig aus und senden Sie dieses im Original an uns zurück.">Bewerbungsformular </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie dieses Formular von Ihrem/Ihren finanziellen Unterstützern ausfüllen. Dieses Dokument lassen Sie anschließend bitte von einem Notar beglaubigen.">Erklärung über finanzielle Unterstützung, notariell beglaubigt</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte übersenden Sie uns einen tabellarischen Lebenslauf. Führen Sie bitte in dem Lebenslauf neben Ihrem bisherigen Schul- und Ausbildungsablauf auch Auslandsaufenthalte, sportliches/gemeinnütziges/kirchliches Engagement sowie Praktika und berufliche Tätigkeiten (auch Nebenjobs) auf. Der Lebenslauf muss in englischer Sprache verfasst werden. Die Universität möchte dieses gerne im Format des Europass haben. Nähere Informationen finden Sie unter https://europass.cedefop.europa.eu/documents/curriculum-vitae. ">Lebenslauf</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Für die Bewerbung verlangt die Universität Rijeka ein aktuelles ärztliches Attest, in dem nachgewiesen wird, dass weder chronische noch neuropsychologische Krankheiten bestehen. Anbei finden Sie eine Vorlage. Diese ist von Ihrem Hausarzt auszufüllen. Bitte beachten Sie, dass das ärztliche Attest nicht von einem Verwandten ausgefüllt sein darf. Das ärztliche Attest darf bei Einreichung der vollständigen Unterlagen nicht älter als 4 Wochen sein.">Ärztliches Attest</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte senden Sie uns eine notariell beglaubigte Kopie Ihrer Geburtsurkunde zu. ">Geburtsurkunde, notariell beglaubigt</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte überweisen Sie die anfallenden Bewerbungsgebühren in Höhe von 250,00 Euro an die Universität in Rijeka an folgendes Konto: Empfänger: University of Rijeka, Faculty of Dental Medicine, Kresimirova 40/42, 51000 Rijeka, Croatia; Bank: Erste&Steiermarkische Bank d.d., IBAN: HR3824020061400006940, SWIFT: ESBCHR22, Betreff: reference number 710-04, Name, Vorname ">Bewerbungsgebühren</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns zudem die vollständigen Namen, Geburtsdaten und aktuellen Meldeanschriften beider Elternteile zukommen. ">Daten der Eltern</li>
								
							</ol>
						</div>
					</div>
					
					<div class="checklist" id="checkllist-BRA">
						<div class="checklist-wrap">
							
							<ol class="checklist-ol">
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Für die Bewerbung benötigen wir eine notariell beglaubigte Kopie Ihrer Allgemeinen Hochschulreife (z.B. Abitur).">Abiturzeugnis; notariell beglaubigt</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Außerdem muss das notariell beglaubigte Zeugnis in zweifacher Ausführung ins Slowakische übersetzt werden. Wir kümmern uns gern um die Übersetzung für Sie. Bitte senden Sie uns dafür schnellstmöglich Ihr Abiturzeugnis zu. Wenn Sie Ihr Abiturzeugnis bereits ins Slowakische übersetzen lassen haben, informieren Sie uns innerhalb der nächsten 7 Tage darüber. ">Abiturzeugnis;übersetzt ins Slowakische (in zweifacher Ausführung)</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Sollten Sie Ihre Hochschulzugangsberechtigung 2021 erlangen, senden Sie uns bitte alle übrigen Dokumente und Ihr letztes Zeugnis (Halbjahreszeugnis des letzten Schuljahres) schnellstmöglich zu. Ihr Abiturzeugnis senden Sie uns, sobald es Ihnen vorliegt.  ">Hochschulzugangsberechtigung </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte senden Sie uns für Ihre Bewerbungen eine Kopie Ihres gültigen Reisepasses oder die Kopie der Vorder- und Rückseite Ihres gültigen Personalausweises zu. ">Kopie des Reisepasses/Personalausweises</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitten senden Sie uns eine notariell beglaubigte Kopie Ihrer Geburtsurkunde zu. ">Geburtsurkunde, notariell beglaubigt</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Die notariell beglaubigte Kopie Ihrer Geburtsurkunde muss ebenfalls ins Slowakische übersetzt werden. Wir kümmern uns gern um die Übersetzung für Sie. Wenn Sie Ihre Geburtsurkunde bereits ins Slowakische übersetzen lassen haben, informieren Sie uns innerhalb der nächsten 7 Tage darübe">Geburtsurkunde, übersetzt ins Slowakische</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns drei aktuelle Passfotos zukommen.">Dri Passfotos </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Das Bewerbungsformular erhalten Sie im späteren Bewerbungsverlauf nach Anmeldung an der Universität.">Bewerbungsformular </li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns eine einfache Kopie Ihres Impfausweises mit einem Nachweis über eine Hepatitis B-Impfung zukommen.">Nachweis über Hepatitis B-Impfung </li>			
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Die Universität in Bratislava erhebt eine Bewerbungsgebühr in Höhe von 80 Euro. Bitte überweisen Sie die Bewerbungsgebühr an folgendes Konto: Kontoinhaber: Lekarska fakulta UK v Bratislave, Bank: State Treasury, IBAN: SK09 8180 0000 0070 0008 3004, SWIFT/BIC: SPSRSKBA Bitte geben Sie bei der Überweisung den folgenden Betreff an: EE fee - name and surname of applicant Wir benötigen ferner einen Nachweis über Zahlung der Bewerbungsgebühr, am besten eine Kopie der Bankbestätigung über die getätigte Überweisung.  ">Nachweis über Zahlung der Bewerbungsgebühr</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns zudem die vollständigen Namen, Geburtsdaten und aktuellen Meldeanschriften beider Elternteile zukommen. ">Daten der Eltern</li>
								
							</ol>
						</div>
					</div>
					
					<div class="checklist" id="checkllist-NUM">
						<div class="checklist-wrap">
							
							<ol class="checklist-ol">
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Für die Bewerbung benötigen wir zwei notariell beglaubigte Kopien Ihrer Allgemeinen Hochschulreife (z.B. Abitur).">Abiturzeugnis; notariell beglaubigt</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Außerdem müssen notariell beglaubigten Zeugnisse ins Rumänische übersetzt werden. Wir kümmern uns gern um die Übersetzung für Sie. Bitte senden Sie uns dafür schnellstmöglich Ihr Abiturzeugnis zu. Wenn Sie Ihr Abiturzeugnis bereits ins Rumänische übersetzen lassen haben, informieren Sie uns innerhalb der nächsten 7 Tage darüber.  ">Abiturzeugnis;übersetzt ins Slowakische (in zweifacher Ausführung)</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Des Weiteren benötigt die Universität jeweils zwei notariell beglaubigte Kopien Ihrer Halb- und Jahresabschlusszeugnisse der 9., 10., 11. und 12. Klasse (ggf. 13. Klasse). Bitte beachten Sie, dass jedes Zeugnis einzeln beglaubigt werden muss und dies jeweils in 2-facher Ausfertigung. Eine Stapelbeglaubigung ist nicht ausreichend. ">Halb- und Jahresabschlussabschlusszeugnis ab der 9. Klasse; notariell beglaubigt (in zweifacher Ausfertigung)</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Die oben genannten Dokumente müssen, sofern sie nicht auf Englisch ausgestellt wurden, ins Rumänische übersetzt werden. Diese müssen von einem beeidigten Übersetzer übersetzt und anschließend von einem Notar beglaubigt werden. ">Halb- und Jahresabschlussabschlusszeugnis ab der 9. Klasse; übersetzt ins Rumänische (in zweifacher Ausfertigung)</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Sollten Sie bereits andere Abschlüsse oder Ausbildungen im medizinischen oder naturwissenschaftlichen Bereich besitzen, wie zum Beispiel eine Ausbildung zum Rettungssanitäter oder einen Bachelor of Science, dann fügen Sie bitte auch davon notariell beglaubigte Kopien bei. ">Ggf. Abschlusszeugnisse bereits erworbener Ausbildungen im medizinischen oder naturwissenschaftlichen Bereich; notariell beglaubigt (in zweifacher Ausfertigung)</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Auch diese Zeugnisse müssen nach der notariellen Beglaubigung ins Rumänische übersetzt werden. Sollten Sie bereits eine Übersetzung vorliegen haben, informieren Sie uns innerhalb der nächsten 7 Tage. Ansonsten veranlassen wir auch diese Übersetzungen gerne für Sie">Ggf. Abschlusszeugnisse bereits erworbener Ausbildungen im medizinischen oder naturwissenschaftlichen Bereich, übersetzt ins Rumänische (in zweifacher Ausfertigung)</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte füllen Sie das Leerformular zwei Mal vollständig aus und senden es uns zurück">Anerkennungsformular für die Hochschulzugangsberechtigung 
(zweifache Ausfertigung)</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitten füllen Sie das Leerformular vollständig aus und senden es uns zurück. ">Bewerbungsformular der Universität</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte senden Sie uns zwei notariell beglaubigte Kopien der Vorder- und Rückseite Ihres Personalausweises oder Ihres Reisepasses (Seiten 1-4). ">Kopie des Reisepasses/Personalausweises; notariell beglaubigt (jeweils in zweifacher Ausfertigung)</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Die Universität benötigt auch eine notariell beglaubigte Kopie Ihrer Geburtsurkunde. Bitte suchen Sie hierfür einen Notar auf und legen Sie ihm Ihre Geburtsurkunde vor. ">Geburtsurkunde, notariell beglaubigt</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Auch die Kopie der Geburtsurkunde muss ins Rumänische übersetzt werden. Sollten Sie bereits eine Übersetzung ins Rumänische besitzen, informieren Sie uns innerhalb der nächsten 7 Tage. Ansonsten veranlassen wir auch diese Übersetzungen gerne für Sie. ">Geburtsurkunde; übersetzt ins Rumänische</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns vier aktuelle Passfotos (2,5 x 3,5 cm) zukommen.">Vier Passfotos </li>						
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Für die Bewerbung verlangt die Universität Neumarkt a. M. ein ärztliches Attest, in dem nachgewiesen wird, dass weder chronische noch neuropsychologische Krankheiten bestehen. Das Attest ist von Ihrem Hausarzt auszufüllen. Bitte beachten Sie, dass das ärztliche Attest nicht von einem Verwandten ausgefüllt werden darf. Bitte verwenden sie dazu den Vordruck im Anhang. ">Ärztliches Attest</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte senden Sie uns eine Kopie aller Seiten Ihres Impfpasses. ">Kopie des Impfpasses</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Für die Universität in Neumarkt a. M. werden medizinische Tests benötigt. Bitte lassen Sie sich auf HIV und VDRL testen. Die Laborergebnisse werden beim Einschreiben benötigt. ">Medizinischer Test</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte senden Sie uns eine Bescheinigung über eine Auslandskrankenversicherung. Sollten Sie gesetzlich versichert sein, genügt eine Kopie der Vorder- und Rückseite Ihrer europäischen Krankenversicherungskarte. Sollten Sie privat versichert sein, müssen Sie bei Ihrer Krankenversicherung eine Bescheinigung über Auslandskrankenversicherung, wenn möglich in englischer Sprache, anfordern. Sollte Ihre Krankenversicherung Ihnen diese Bescheinigung nur auf Deutsch ausstellen können, dann muss diese zusätzlich ins Rumänische übersetzt werden. ">Kopie der Krankenversicherung</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte übersenden Sie uns einen tabellarischen Lebenslauf. Führen Sie bitte in dem Lebenslauf neben Ihrem bisherigen Schul- und Ausbildungsablauf auch Auslandsaufenthalte, sportliches/gemeinnütziges/kirchliches Engagement sowie Praktika und berufliche Tätigkeiten (auch Nebenjobs) auf. Der Lebenslauf muss in englischer Sprache verfasst werden, Ihre Kontaktdaten enthalten und nach Korrektur durch uns von Ihnen unterschrieben werden. ">Lebenslauf – persönlich unterschrieben</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Ein zentrales Element des Bewerbungsverfahrens an der Universität Neumarkt a. M. sind Ihre Eignung und Motivation. Im Bewerbungsverfahren ist daher ein Motivationsschreiben erforderlich. Bei der Bearbeitung des Motivationsschreibens achten Sie bitte darauf, dass Sie mindestes zwei der folgenden Fragen beantworten: *Wer/was hat Ihre Entscheidung, sich für ein Medizinstudium zu bewerben, beeinflusst? *Was werden Sie unternehmen, um ein guter Student/Arzt zu werden? *Welche Pläne und Visionen haben Sie mit Blick auf Ihre ärztliche Ausbildung? *Welche Ihrer außerschulischen Tätigkeiten hat Sie am meisten beeinflusst und warum? *Welches ist Ihr Lieblingsbuch und wie hat es Sie beeinflusst? *Gibt es außergewöhnliche/ungewöhnliche Umstände in Ihrem Leben, die uns bekannt sein sollten, um Ihre Bewerbung ggf. in einem anderen Licht zu betrachten? *Beschreiben Sie das Umfeld, in dem Sie bislang gelebt haben, und sagen Sie uns, was Sie daran gerne ändern würden? *Welche Änderungen möchten Sie durch Ihre Arbeit erwirken? Das Motivationsschreiben soll auf Englisch verfasst werden und maximal 250-300 Wörter umfassen. Nachdem Sie uns das Motivationsschreiben übersandt haben, werden wir dieses im Hinblick auf die Anforderungen der Universität Neumarkt a. M. sichten und gegebenenfalls in Rücksprache mit Ihnen Änderungen vornehmen. ">Motivationsschreiben</li>	
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Wir bitten um kurze Mitteilung, ob Sie einen Sprachtest, z.B. den TOEFL-Test, für die englische Sprache abgelegt haben. Falls dies der Fall ist, bitten wir um Übersendung des Nachweises in notariell beglaubigter Kopie. ">Ggf. Sprachtest</li>	
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Die Universität berechnet für die Bearbeitung Ihrer Bewerbung eine Gebühr in Höhe von Euro 200,00. Bitte nehmen Sie die Zahlung auf die folgende Bankverbindung vor: UNIVERSITATEA DE MEDICINĂ ŞI FARMACIE (UMF) TÎRGU MUREŞ BANCA COMERCIALĂ ROMÂNĂ BUCUREŞTI, SWIFT: RNCBROBUXXX , IBAN: RO92RNCB0193015967800002 , Bitte geben Sie im Verwendungszweck Ihren vollständigen Namen an und übersenden uns eine Kopie der getätigten Überweisung per E-Mail. ">Nachweis über Zahlung der Bewerbungsgebühr</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns den vollständigen Namen und eine aktuelle Handynummer Ihres Notfallkontaktes zukommen.">Notfallkontakt</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns zudem die vollständigen Namen, Geburtsdaten und aktuellen Meldeanschriften beider Elternteile zukommen.">Daten der Eltern</li>
								<li class="cli" data-toggle="popover" tabindex="0" data-container="body" data-content="Bitte lassen Sie uns zudem Kopien Ihrer relevanten außerschulischen Aktivitäten, Praktika oder Ausbildungen zukommen. Sollten diese nicht in Englisch ausgestellt sein, müssen diese auch beglaubigt und ins Rumänische übersetzt werden.">Ggf. Kopien außerschulischer Aktivitäten / Praktika / Ausbildungen </li>
								
							</ol>
						</div>
					</div>
										
					
					
				</div>
			</div>
		</div>

		</div>
	</div>
</div>





<!-- Edit Modal HTML -->
<div id="modalChangeDP" class="modal fade">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<?php // echo do_shortcode('[elementor-template id="1885"]'); ?>
				<div class="container">


					<div class="modal-header">
						<h4 class="modal-title"><?php _e('Profilbild aktualisieren', 'study-doc'); ?></h4>

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-12" id="dp-container">
							<form id="update_dp" action="uniadd" method="post">
								<p class="status"></p>
								<div class="form-row">
									<div class="form-group">
										<label for="dp_update"></label>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="dp_update" name="dp_update" accept="image/*">
											<label class="custom-file-label" for="dp_update"><?php _e('Datei auswählen', 'study-doc'); ?></label>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group">
										<input class="submit_button btn adlo" type="submit" value="<?php _e('Hochladen', 'study-doc'); ?>" name="submit">
									</div>
								</div>
							</form>
						</div>
						<div class="col-lg-6 col-md-12 text-center">
							<div id="display_dp"></div>
						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>











		
