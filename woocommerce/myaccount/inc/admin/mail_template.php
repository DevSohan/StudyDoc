<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $wpdb;
//get_header();
?>



<div class="container admin_emails_templates">
	<div class="row">
		<div class="col-md-12 emails_templates">
			<?php

			global $wpdb;
			$template_table = $wpdb->prefix . 'mail_templates';

			$templates = $wpdb->get_results( "SELECT * FROM $template_table" );
			if(empty($templates)){ ?>
			<p class="status alert alert-danger"><?php _e('Noch keine Vorlagen festgelegt.', 'study-doc'); ?></p>
			<?php
			}else{ ?>
			<div><h2><?php _e('Vorlagen', 'study-doc'); ?></h2>
				<table class="table_vorlagen table table-striped tablemanager" id="table_vorlagen">
					<thead>
						<tr>
							<th><?php _e('Namen', 'study-doc'); ?></th>
							<th><?php _e('Thema', 'study-doc'); ?></th>
							<th style="text-align: center;" class="disableSort disableFilterBy">Aktion<?php _e('Universitäten', 'study-doc'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
				foreach ( $templates as $template ) { ?>
						<tr id="<?php echo $template->id; ?>">
							<td><?php echo $template->name; ?></td>
							<td><?php echo $template->subject; ?></td>
							<td style="text-align: center;">
								<a href="#viewTemplateModal" class="view" data-toggle="modal" 
								   data-id="<?php echo $template->id ; ?>"><i class="fas fa-file-alt"></i></a>
								<a href="#editTemplateModal" class="edit" data-toggle="modal" 
								   data-id="<?php echo $template->id; ?>"
								   ><i class="fas fa-pen"></i></a>
								<a href="#deleteTemplateModal" class="delete" data-id="<?php echo $template->id; ?>" data-toggle="modal"><i class="fas fa-trash"></i></a>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<?php
			}
			?>

		</div>
	</div>

</div>
<div class="container admin_emails_add_templates">

	<div class="row">
		<div class="col-md-12">
			<h2><?php _e('Vorlage hinzufügen', 'study-doc'); ?></h2>
			<form id="email-template" class="form">
				<div class="form-group">
					<label for="tempalte_name"><?php _e('Namen:', 'study-doc'); ?></label>
					<input type="text" class="form-control" id="tempalte_name" name="tempalte_name" placeholder="Namen" required> 
				</div>
				<div class="form-group">
					<label for="tempalte_subject"><?php _e('Thema:', 'study-doc'); ?></label>
					<input type="text" class="form-control" id="tempalte_subject" name="tempalte_subject" placeholder="Namen" required> 
				</div>
				<div class="form-group">
					<label for="template_content"><?php _e('Nachricht:', 'study-doc'); ?></label>
					<textarea type="text" class="form-control" id="template_content" name="template_content" rows="15"  required></textarea>
					<p><span class="short_code">[Anrede]</span><span class="short_code">[Vorname]</span><span class="short_code">[Nachname]</span><span class="short_code">[Strasse-und-Hausnummer]</span><span class="short_code">[Adresszusatz]</span><span class="short_code">[Bundesland]</span><span class="short_code">[Ort]</span><span class="short_code">[Land]</span><span class="short_code">[Postleitzahl]</span><span class="short_code">[Footer]</span></p>
				</div>
				<button type="submit" name="submit" class="email_button btn"><?php _e('Hinzufügen', 'study-doc'); ?><i class="fas fa-plus-circle"></i></button>

				<p class="status"></p>
			</form>

		</div>
	</div>
</div>

<!-- View STUDENT FORM  -->
<div id="viewTemplateModal" class="modal fade">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="template-body">
					<h4><?php _e('Namen:', 'study-doc'); ?> <span class="template_view_name"></span></h4>
					<h4><?php _e('Thema:', 'study-doc'); ?> <span class="template_view_thema"></span></h4>
					<h4><?php _e('Vorlage:', 'study-doc'); ?></h4>
					<div class="template_content_area">
					<div class="template_view_content shadow p-3 mb-5 bg-white rounded"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- edit STUDENT FORM  -->
<div id="editTemplateModal" class="modal fade">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
			<form id="template_update" class="form">
				<p class="status"></p>
				<div class="form-group">
					<label for="tempalte_update_name">:<?php _e('Namen', 'study-doc'); ?></label>
					<input type="text" class="form-control" id="tempalte_update_name" name="tempalte_update_name" placeholder="Namen" required> 
				</div>
				<div class="form-group">
					<label for="tempalte_update_subject">:<?php _e('Thema', 'study-doc'); ?></label>
					<input type="text" class="form-control" id="tempalte_update_subject" name="tempalte_update_subject" placeholder="Namen" required> 
				</div>
				<div class="form-group">
					<label for="template_update_content">:<?php _e('Nachricht', 'study-doc'); ?></label>
					<textarea type="text" class="form-control" id="template_update_content" name="template_update_content" rows="15"  required></textarea> 
				</div>
				<button type="submit" name="submit" class="email_button btn"><?php _e('Update', 'study-doc'); ?><i class="fas fa-plus-circle"></i></button>
			</form>
			</div>
		</div>
	</div>
</div>
