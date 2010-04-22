<?php use_helper('Javascript') ?>

<h1><?php echo __('Import an XML file') ?></h1>

<?php echo form_tag('object/import', array('multipart' => 'true')) ?>

<table class="list">
<thead>
<tr>
  <th><?php echo __('Select a file to import'); ?></th>
  <th width="100px" />
</tr>
</thead>
<tbody>
  <tr>
    <td><?php echo input_file_tag('file', array('size' => '30px')) ?></td>
    <td width="100px">
      <div style="float: right; margin: 3px 8px 0 0">
        <?php echo submit_tag(__('Upload')) ?>
      </div>
    </td>
  </tr>
</tbody>
</table>

</form>

<br/><br/>

<h1><?php echo __('Export an XML file') ?></h1>

<?php echo form_tag('object/export') ?>

<table class="list">
<thead>
<tr>
  <th><?php echo sfConfig::get('app_ui_label_informationobject'); ?></th>
  <th><?php echo __('Format') ?></th>
  <th width="100px"/>
</tr>
</thead>
<tbody>
<tr>
  <td style="width: 200px">
    <div><?php echo object_select_tree(new QubitInformationObject, 'getId',
      array(
        'disabled' => $informationObject->getDescendants(array('index' => 'id')),
        'include_blank' => true,
        'peer_method' => 'getDescendants',
        'related_class' => QubitInformationObject::getOne(QubitInformationObject::addRootsCriteria(new Criteria)),
        'style' => 'width: 200px'
      )
    ) ?></div>

  </td>
  <td style="text-align: right;">
    <?php echo select_tag('format', options_for_select(
      array('dc' => 'Dublin Core 1.1','ead' => 'EAD 2002', 'mods' => 'MODS 3.3'),
      null, array('include_blank' => true))); ?>
  </td>
  <td width="100px">
    <div style="float: right; margin: 3px 3px 0 0;">
      <?php echo submit_tag(__('Export')) ?>
    </div>
  </td>
</tr>

</tbody>
</table>

</form>
