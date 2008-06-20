<div id="browse-sidebar">
<?php echo form_tag('browse/list', 'class=sidebarForm') ?>
<table class="sidebar">
<tr>
<td><?php echo select_tag('browseList', options_for_select(
		array('subject' => __(sfConfig::get('app_ui_label_subject')),
		      'mediatype' => __(sfConfig::get('app_ui_label_mediatype')),
					'name' => __(sfConfig::get('app_ui_label_name')),
          'informationobject' => __(sfConfig::get('app_ui_label_informationobject')),
					'place' => __(sfConfig::get('app_ui_label_place')),
					'repository' => __(sfConfig::get('app_ui_label_repository'))
		),
		$browseBy),
		'class="selectbox"'); ?>
</td>
<td><?php echo my_submit_tag(__('browse')) ?></td>
</tr>
</table>
</form>
</div>
