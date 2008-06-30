﻿<div class="pageTitle"><?php echo __('view %1%', array('%1%' => sfConfig::get('app_ui_label_informationobject'))); ?></div>

<table class="detail">
<tbody>

<?php if ($informationObject->getTitle(array('sourceCulture' => true))): ?>
  <tr><td colspan="2" class="headerCell">
  <?php if ($editCredentials) echo link_to($informationObject->getLabel(), 'informationobject/edit/?id='.$informationObject->getId());
        else echo $informationObject->getLabel(); ?>
  </td></tr>
<?php endif; ?>

<?php if ($informationObject->getIdentifier()) : ?>
<tr>
<th><?php echo __('reference code'); ?></th>
<td><?php echo $informationObject->getReferenceCode(array('standard' => 'isad')) ?></td>
</tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getVersion(array('cultureFallback' => true))) > 0) : ?>
<tr>
<th><?php echo __('version'); ?></th>
<td><?php echo $value; ?></td>
</tr>
<?php endif; ?>

<?php if (count($informationObject->getDates()) > 0) : ?>
<tr><th><?php echo __('dates'); ?></th><td>
<?php foreach ($informationObject->getDates() as $date): ?>
<?php echo $date.'<br />' ?>
<?php endforeach; ?>
</td></tr>
<?php endif; ?>

<?php if ($informationObject->getLevelOfDescriptionId()) : ?>
<tr>
<th><?php echo __('level of description'); ?></th>
<td><?php echo $informationObject->getLevelOfDescription(); ?></td>
</tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getExtentAndMedium(array('cultureFallback' => true))) > 0) : ?>
<tr>
<th><?php echo __('extent and medium'); ?></th>
<td><?php echo nl2br($value); ?></td>
</tr>
<?php endif; ?>

<?php if ($digitalObject = $informationObject->getDigitalObject()): ?>
<tr><th><?php echo sfConfig::get('app_ui_label_digitalobject') ?></th>
  <td>
    <?php include_component('digitalobject', 'show', array(
      'digitalObject'=>$digitalObject,
      'usageType'=>QubitTerm::THUMBNAIL_ID,
      'link'=>'digitalobject/show?id='.$digitalObject->getId()
    )); ?>
  </td>
</tr>
<?php endif; ?>

<?php if (count($physicalObjects) && $editCredentials): ?>
  <?php include_partial('physicalobject/show', 
    array('informationObject'=>$informationObject, 'physicalObjects'=>$physicalObjects)); ?>
<?php endif; ?>

<?php  foreach ($creators as $creator): ?>
  <tr>
  <th><?php echo __('creator'); ?></th>
  <td><?php echo link_to($creator, 'actor/show?id='.$creator->getId()); ?>
    <?php if ($creator->getDatesOfExistence()) echo ' ('.$creator->getDatesOfExistence()->getDescription(array('cultureFallback' => true)).')'; ?>
  <br />
    <?php echo nl2br($creator->getHistory(array('cultureFallback' => true))); ?>
  </td>
  </tr>
<?php endforeach; ?>

<?php if ($informationObject->getRepositoryId()) : ?>
<tr>
<th><?php echo __('repository'); ?></th>
<td><?php echo link_to($informationObject->getRepository(), 'repository/show?id='.$informationObject->getRepositoryId()); ?></td>
</tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getArchivalHistory(array('cultureFallback' => true))) > 0) : ?>
<tr>
<th><?php echo __('archival history'); ?></th>
<td><?php echo nl2br($value); ?></td>
</tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getAcquisition(array('cultureFallback' => true))) > 0) : ?>
<tr>
<th><?php echo __('immediate source of acquisition'); ?></th>
<td><?php echo nl2br($value); ?></td>
</tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getScopeAndContent(array('cultureFallback' => true))) > 0) : ?>
<tr>
<th><?php echo __('scope and content'); ?></th>
<td><?php echo nl2br($value); ?></td>
</tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getAppraisal(array('cultureFallback' => true))) > 0) : ?>
<tr>
<th><?php echo __('appraisal, destruction and scheduling'); ?></th>
<td><?php echo nl2br($value); ?></td>
</tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getAccruals(array('cultureFallback' => true))) > 0) : ?>
<tr>
<th><?php echo __('accruals'); ?></th>
<td><?php echo nl2br($value); ?></td>
</tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getArrangement(array('cultureFallback' => true))) > 0) : ?>
<tr>
<th><?php echo __('system of arrangement'); ?></th>
<td><?php echo nl2br($value); ?></td>
</tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getAccessConditions(array('cultureFallback' => true))) > 0) : ?>
<tr>
<th><?php echo __('conditions governing access'); ?></th>
<td><?php echo nl2br($value); ?></td>
</tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getReproductionConditions(array('cultureFallback' => true))) > 0) : ?>
<tr>
<th><?php echo __('conditions governing reproduction'); ?></th>
<td><?php echo nl2br($value); ?></td>
</tr>
<?php endif; ?>

<?php if (count($languageCodes) > 0) : ?>
<tr>
<th><?php echo __('language of material'); ?></th>
<td>
      <?php foreach ($languageCodes as $languageCode): ?>
    <?php echo format_language($languageCode->getValue()); ?><br />
  <?php endforeach; ?>
</td></tr>
<?php endif; ?>

<?php if (count($scriptCodes) > 0) : ?>
<tr>
<th><?php echo __('script of material'); ?></th>
<td>
      <?php foreach ($scriptCodes as $scriptCode): ?>
    <?php echo format_script($scriptCode->getValue()); ?><br />
  <?php endforeach; ?>
</td></tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getPhysicalCharacteristics(array('cultureFallback' => true))) > 0) : ?>
<tr>
<th><?php echo __('physical characteristics'); ?></th>
<td><?php echo nl2br($value); ?></td>
</tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getFindingAids(array('cultureFallback' => true))) > 0) : ?>
<tr>
<th><?php echo __('finding aids'); ?></th>
<td><?php echo nl2br($value); ?></td>
</tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getLocationOfOriginals(array('cultureFallback' => true))) > 0) : ?>
<tr>
<th><?php echo __('location of originals'); ?></th>
<td><?php echo nl2br($value); ?></td>
</tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getLocationOfCopies(array('cultureFallback' => true))) > 0) : ?>
<tr>
<th><?php echo __('location of copies'); ?></th>
<td><?php echo nl2br($value); ?></td>
</tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getRelatedUnitsOfDescription(array('cultureFallback' => true))) > 0) : ?>
<tr>
<th><?php echo __('related units of description'); ?></th>
<td><?php echo nl2br($value); ?></td>
</tr>
<?php endif; ?>

<?php if (count($subjectAccessPoints) > 0) : ?>
<tr>
<th><?php echo __('subject access points'); ?></th>
<td>
  <?php foreach ($subjectAccessPoints as $subject): ?>
    <?php echo link_to($subject->getTerm(), 'term/browse?termId='.$subject->getTermId()); ?><br />
  <?php endforeach; ?>
</td></tr>
<?php endif; ?>

<?php if (count($placeAccessPoints) > 0) : ?>
<tr>
<th><?php echo __('place access points'); ?></th>
<td>
  <?php foreach ($placeAccessPoints as $place): ?>
    <?php echo link_to($place->getTerm(), 'term/browse?termId='.$place->getTermId()); ?><br />
  <?php endforeach; ?>
</td></tr>
<?php endif; ?>

<?php if (count($nameAccessPoints) > 0 ) : ?>
<tr>
<th><?php echo __('name access points'); ?></th>
<td>
  <?php foreach ($nameAccessPoints as $name): ?>
    <?php echo link_to($name->getActor(), 'actor/show?id='.$name->getActorId()) ?>
    <?php echo ' ('.$name->getActorRole().')' ?>
    <br />
  <?php endforeach; ?>
</td></tr>
<?php endif; ?>

<?php if (count($notes) > 0) : ?>
<tr>
<th><?php echo __('notes'); ?></th>
<td>
  <?php foreach ($notes as $note): ?>
    <?php echo $note->getType().': '.nl2br($note->getContent(array('cultureFallback' => true))); ?><br />
  <?php endforeach; ?>
</td>
</tr>
<?php endif; ?>

<?php if ($informationObject->getDescriptionIdentifier()): ?>
  <tr><th><?php echo __('description identifier')?></th>
  <td><?php echo $informationObject->getDescriptionIdentifier() ?></td></tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getInstitutionResponsibleIdentifier(array('cultureFallback' => true))) > 0) : ?>
  <tr><th><?php echo __('institution identifier')?></th>
  <td><?php echo $value ?></td></tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getRules(array('cultureFallback' => true))) > 0) : ?>
  <tr><th><?php echo __('rules')?></th>
  <td><?php echo nl2br($value) ?></td></tr>
<?php endif; ?>

<?php if ($informationObject->getDescriptionStatusId()): ?>
  <tr><th><?php echo __('status')?></th><td>
  <?php echo $informationObject->getDescriptionStatus()->getName(array('sourceCulture' => true)) ?>
  </td></tr>
<?php endif; ?>

<?php if ($informationObject->getDescriptionDetailId()): ?>
  <tr><th><?php echo __('detail')?></th><td>
  <?php echo $informationObject->getDescriptionDetail()->getName(array('sourceCulture' => true)) ?>
  </td></tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getRevisionHistory(array('cultureFallback' => true))) > 0) : ?>
  <tr><th><?php echo __('dates of creation revision deletion')?></th><td>
  <?php echo nl2br($value) ?>
  </td></tr>
<?php endif; ?>

<?php if (count($descriptionLanguageCodes) > 0): ?>
  <tr><th><?php echo __('language of description')?>:
  </th><td>
  <?php foreach ($descriptionLanguageCodes as $languageCode): ?>
    <?php echo format_language($languageCode->getValue()) ?><br />
  <?php endforeach; ?>
  </td></tr>
<?php endif; ?>

<?php if (count($descriptionScriptCodes) > 0): ?>
  <tr><th><?php echo __('script of description')?>:
  </th><td>
  <?php foreach ($descriptionScriptCodes as $scriptCode): ?>
    <?php echo format_script($scriptCode->getValue()) ?><br />
  <?php endforeach; ?>
  </td></tr>
<?php endif; ?>

<?php if (strlen($value = $informationObject->getSources(array('cultureFallback' => true))) > 0) : ?>
  <tr><th><?php echo __('sources')?></th>
  <td><?php echo nl2br($value) ?></td></tr>
<?php endif; ?>

</tbody>
</table>

<?php if ($editCredentials): ?>
<div class="menu-action">
  <?php echo link_to (__('edit %1%', array('%1%' => sfConfig::get('app_ui_label_informationobject'))), 'informationobject/edit?id='.$informationObject->getId()) ?>
</div>
<?php endif; ?>

<div class="menu-extra">
<?php if ($editCredentials): ?>
  <?php echo link_to(__('add new %1%', array('%1%' => sfConfig::get('app_ui_label_informationobject'))), 'informationobject/create'); ?>
<?php endif; ?>
  <?php echo link_to(__('list all %1%', array('%1%' => sfConfig::get('app_ui_label_informationobject'))), 'informationobject/list'); ?>
</div>
