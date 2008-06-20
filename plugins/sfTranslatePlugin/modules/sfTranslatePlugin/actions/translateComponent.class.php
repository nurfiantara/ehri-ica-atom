<?php

/*
 * This file is part of the sfTranslatePlugin package.
 * (c) 2007 Jack Bates <ms419@freezone.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class sfTranslatePluginTranslateComponent extends sfComponent
{
  function execute($request)
  {
    $actionInstance = $this->getController()->getAction($this->getModuleName(), $this->getActionName());
    if ($actionInstance->isSecure())
    {
      if (!$this->getUser()->isAuthenticated())
      {
        return sfView::NONE;
      }

      $credential = $actionInstance->getCredential();
      if ($credential !== null && !$this->getUser()->hasCredential($credential))
      {
        return sfView::NONE;
      }
    }

    $this->messages = $this->getRequest()->getAttribute('messages', array());
    if (empty($this->messages))
    {
      return sfView::NONE;
    }

    ksort($this->messages);

    $this->getResponse()->addStylesheet('/sfTranslatePlugin/css/l10n_client');
    $this->getResponse()->addJavaScript('jquery');
    $this->getResponse()->addJavaScript('drupal');
    $this->getResponse()->addJavaScript('textarea');
    $this->getResponse()->addJavaScript('/sfTranslatePlugin/js/l10n_client');
  }
}
