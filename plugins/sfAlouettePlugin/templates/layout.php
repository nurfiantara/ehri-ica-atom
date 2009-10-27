<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
  </head>
  <body class="yui-skin-sam">
    <div id="body-banner-top">

    <div id="header">

    <div id="header-top">
      <?php include_component_slot('header') ?>
    <div class="menu-top">
        <?php include_component_slot('ChangeLanguage') ?>

        <?php include_component('menu', 'quickLinks') ?>
    </div>
    </div> <!--close header-top -->

    <div id="header-middle">

    <div id="header-block">
    <?php include_component_slot('BrowseBox') ?>
    <div id="site-header">

    <?php if (sfConfig::get('app_toggleLogo')): ?>
    <div id="logo"><?php echo link_to(image_tag('logo', array('alt' => sfConfig::get('app_siteTitle'))),
      array('module' => 'staticpage', 'action' => 'static', 'permalink' => 'homepage')) ?></div>
    <?php endif; ?>

    <div id="site-info">
    <?php if (sfConfig::get('app_toggleTitle')): ?>
      <div id="website-name" class="transparent">
        <?php echo link_to(__(sfConfig::get('app_siteTitle')), array('module' => 'staticpage', 'action' => 'static', 'permalink' => 'homepage')) ?>
       </div>
    <?php endif; ?>

    <?php if (sfConfig::get('app_toggleDescription')): ?>
      <div id="website-description" class="transparent">
        <?php echo __(sfConfig::get('app_siteDescription')) ?>
      </div>
    <?php endif; ?>
    </div> <!-- close site-info -->
    </div> <!-- close site-header -->
    </div> <!-- close header-block -->
    </div> <!-- close header-middle -->

    <div id="header-bottom">
    <?php include_component_slot('SearchBox') ?>
    </div> <!-- close header-bottom -->

    <?php if ($sf_user->hasCredential('administrator' or 'editor' or 'contributor' or 'translator')): ?>
        <?php include_component_slot('MainMenu') ?>
    <?php endif; ?>

    </div> <!-- close header -->

    </div> <!--close body-banner-top -->

    <div id="body-page">

    <div id="main">

    <div id="content-one-column">
    </div> <!-- close content-one-column" -->


    <div id="context-column">

    <div id="sidebar">
      <?php include_component_slot('sidebar') ?>
    </div>

    </div> <!-- close context-column" -->

    <div id="content-two-column">

    <div class="content-column-box">
    <?php echo $sf_data->getRaw('sf_content') ?>
    </div>

    </div> <!-- close content-two-column -->

    </div> <!-- close main -->

    <div id="footer">
    </div>

    </div> <!-- close body-page -->
    <div id="body-banner-bottom">
      <?php include_component_slot('bottomBanner') ?>
    </div>
  </body>
</html>