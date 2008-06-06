﻿<div class="pageTitle"><?php echo __('add/edit term'); ?></div>

<?php echo form_tag('term/update') ?>

<?php echo object_input_hidden_tag($term, 'getId') ?>

<table class="detail">
<tbody>

<tr><td colspan="2" class="headerCell">
<?php if (!$term->getName()): ?>
  <?php echo $term->getName(array('sourceCulture' => true)) ?>
<?php else: ?>
  <?php echo $term->getName(); ?>
<?php endif; ?>
</td></tr>

<tr>
  <th><?php echo __('term name'); ?></th>
  <td><?php echo object_input_tag($term, 'getName', array ('size' => 80)) ?></td>
</tr>

<tr>
  <th><?php echo __('taxonomy'); ?></th>
  <td><?php echo object_select_tag($term, 'getTaxonomyId', array ('related_class' => 'QubitTaxonomy', 'peer_method' => 'getEditableTaxonomies', 'include_blank' => true)) ?></td>
</tr>

<tr>
  <th><?php echo __('scope note'); ?></th>
  <td><?php echo object_textarea_tag($term, 'getScopeNote', array ('size' => '30x3')) ?></td>
</tr>
<tr>
  <th><?php echo __('code alpha'); ?></th>
  <td><?php echo object_input_tag($term, 'getCodeAlpha', array ('size' => 20)) ?></td>
</tr>
<tr>
  <th><?php echo __('code alpha'); ?>2</th>
  <td><?php echo object_input_tag($term, 'getCodeAlpha2', array ('size' => 20)) ?></td>
</tr>
<tr>
  <th><?php echo __('code numeric'); ?></th>
  <td><?php echo object_input_tag($term, 'getCodeNumeric', array ('size' => 7)) ?></td>
</tr>
<tr>
  <th><?php echo __('source'); ?></th>
  <td><?php echo object_input_tag($term, 'getSource', array ('size' => 80)) ?></td>
</tr>
</tbody>
</table>

<div class="menu-action">
<?php if ($term->getId()): ?>
  &nbsp;<?php echo link_to(__('delete'), 'term/delete?id='.$term->getId(), 'post=true&confirm='.__('are you sure?')) ?>
  &nbsp;<?php echo link_to(__('cancel'), 'term/list') ?>
<?php else: ?>
  &nbsp;<?php echo link_to(__('cancel'), 'term/list') ?>
<?php endif; ?>
    <?php if ($term->getId()): ?>
      <?php echo my_submit_tag(__('save'), array('style' => 'width: auto;')) ?>
    <?php else: ?>
      <?php echo my_submit_tag(__('create'), array('style' => 'width: auto;')) ?>
    <?php endif; ?>
</div>

<?php if ($term->getId()): ?>
  <?php if ($taxonomyName): ?>
    <div class="menu-extra"><?php echo link_to(__('add new %1%', array('%1%' =>$taxonomyName)), 'term/create?taxonomyId='.$taxonomyId) ?></div>
  <?php else: ?>
    <div class="menu-extra"><?php echo link_to( __('add new term'), 'term/create') ?></div>
  <?php endif; ?>
<?php endif; ?>

<div class="menu-extra">
<?php echo link_to(__('list all taxonomies'), 'term/list?taxonomyId=0') ?>
<?php if ($term->getTaxonomyId()): ?>
  <?php echo link_to(__('list only %1%', array('%1%' =>$term->getTaxonomy())), 'term/list?taxonomyId='.$term->getTaxonomyId()) ?>
<?php endif; ?>
</div>

</form>
