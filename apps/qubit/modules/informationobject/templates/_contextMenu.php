<?php use_helper('Javascript') ?>

<?php $sf_response->addJavaScript('/vendor/yui/yahoo-dom-event/yahoo-dom-event') ?>
<?php $sf_response->addJavaScript('/vendor/yui/container/container-min') ?>
<?php $sf_response->addStylesheet('/vendor/yui/container/assets/skins/sam/container') ?>

<div class="context-column-box">
  <div class="contextMenu">
    <?php if (isset($repository)): ?>
      <?php echo javascript_tag(<<<EOF
var repositoryTooltip = new YAHOO.widget.Tooltip('repositoryTooltip', {
  context: 'repositoryLink'});
EOF
) ?>
      <div class="label">
        <?php echo sfConfig::get('app_ui_label_repository') ?>
      </div>
      <?php echo link_to(render_title($repository), 'repository/show?id='.$repository->getId(), $sf_data->getRaw('repositoryOptions')) ?>
    <?php endif; ?>

    <?php if (count($creators) > 0): ?>
      <?php echo javascript_tag(<<<EOF
var repositoryTooltip = new YAHOO.widget.Tooltip('creatorsTooltip', {
  context: 'creatorsLink'});
EOF
) ?>
      <div class="label">
        <?php echo sfConfig::get('app_ui_label_creator') ?>
      </div>
      <ul>
        <?php foreach ($creators as $creator): ?>
          <li><?php echo link_to(render_title($creator), 'actor/show?id='.$creator->getId(), $sf_data->getRaw('creatorOptions')) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <?php if (count($thumbnails) > 1): ?>
      <?php include_component('digitalobject', 'imageflow', array('thumbnails' => $thumbnails)) ?>
    <?php endif; ?>

    <?php if (count($informationObjects) > 1): ?>
      <div class="label">
        <?php if (null === $levelOfDescription = $informationObject->getCollectionRoot()->getLevelOfDescription()) $levelOfDescription = sfConfig::get('app_ui_label_collection'); echo $levelOfDescription ?>
      </div>
      <?php include_component('informationobject', 'treeView', array('informationObjects' => $informationObjects)) ?>
    <?php endif; ?>
    
    <?php if (count($physicalObjects)): ?>
      <?php include_component('physicalobject', 'contextMenu', array('physicalObjects' => $physicalObjects, 'informationObject' => $informationObject)) ?>
    <?php endif; ?>
  </div>
</div>