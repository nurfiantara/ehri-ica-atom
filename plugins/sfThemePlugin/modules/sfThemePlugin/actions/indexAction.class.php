<?php

/*
 */

class sfThemePluginIndexAction extends sfAction
{
  public function execute($request)
  {
    $this->form = new sfForm;

    $this->form->setWidgets(array(
      'toggleDescription' => new sfWidgetFormInputCheckbox,
      'toggleLogo' => new sfWidgetFormInputCheckbox,
      'toggleTitle' => new sfWidgetFormInputCheckbox));

    $criteria = new Criteria;
    $criteria->add(QubitSetting::NAME, 'toggleDescription');
    if (1 == count($toggleDescriptionQuery = QubitSetting::get($criteria)))
    {
      $toggleDescriptionSetting = $toggleDescriptionQuery[0];

      $this->form->setDefault('toggleDescription', $toggleDescriptionSetting->__get('value', array('sourceCulture' => true)));
    }

    $criteria = new Criteria;
    $criteria->add(QubitSetting::NAME, 'toggleLogo');
    if (1 == count($toggleLogoQuery = QubitSetting::get($criteria)))
    {
      $toggleLogoSetting = $toggleLogoQuery[0];

      $this->form->setDefault('toggleLogo', $toggleLogoSetting->__get('value', array('sourceCulture' => true)));
    }

    $criteria = new Criteria;
    $criteria->add(QubitSetting::NAME, 'toggleTitle');
    if (1 == count($toggleTitleQuery = QubitSetting::get($criteria)))
    {
      $toggleTitleSetting = $toggleTitleQuery[0];

      $this->form->setDefault('toggleTitle', $toggleTitleSetting->__get('value', array('sourceCulture' => true)));
    }

    if ($request->isMethod('post'))
    {
      $this->form->setValidators(array(
        'toggleDescription' => new sfValidatorBoolean,
        'toggleLogo' => new sfValidatorBoolean,
        'toggleTitle' => new sfValidatorBoolean));

      $this->form->bind($request->getPostParameters());

      if ($this->form->isValid())
      {
        if (1 != count($toggleDescriptionQuery))
        {
          $toggleDescriptionSetting = new QubitSetting;
          $toggleDescriptionSetting->name = 'toggleDescription';
        }

        $toggleDescriptionSetting->__set('value', $this->form->getValue('toggleDescription'), array('sourceCulture' => true));
        $toggleDescriptionSetting->save();

        if (1 != count($toggleLogoQuery))
        {
          $toggleLogoSetting = new QubitSetting;
          $toggleLogoSetting->name = 'toggleLogo';
        }

        $toggleLogoSetting->__set('value', $this->form->getValue('toggleLogo'), array('sourceCulture' => true));
        $toggleLogoSetting->save();

        if (1 != count($toggleTitleQuery))
        {
          $toggleTitleSetting = new QubitSetting;
          $toggleTitleSetting->name = 'toggleTitle';
        }

        $toggleTitleSetting->__set('value', $this->form->getValue('toggleTitle'), array('sourceCulture' => true));
        $toggleTitleSetting->save();

        $this->redirect(array('module' => 'sfThemePlugin'));
      }
    }
  }
}
