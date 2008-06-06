<div class="pageTitle"><?php echo __('list places'); ?></div>

<table class="list">
<thead>
<tr>
  <th><?php echo __('id'); ?></th>
  <th><?php echo __('place name'); ?> <span class="th-link"><?php echo link_to(__('add new'), 'place/create') ?></span></th>
  <th><?php echo __('address'); ?></th>
  <th><?php echo __('country'); ?></th>
</tr>
</thead>
<tbody>
<?php foreach ($places as $place): ?>
<tr>
      <td><?php echo $place->getId() ?></td>
      <td><?php echo link_to($place->getName(), 'place/edit?id='.$place->getId()) ?></td>
      <td><?php echo $place->getAddress() ?></td>
      <td><?php echo $place->getCountry() ?></td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>

<div class="menu-action">
<?php echo link_to (__('add new place'), 'place/create') ?>
</div>
