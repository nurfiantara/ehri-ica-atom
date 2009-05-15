<?php

/*
 */

class sfDrupalWidgetFormSchemaFormatter extends sfWidgetFormSchemaFormatter
{
  // Heredocs cannot be used to initialize class members:
  // http://php.net/manual/en/language.types.string.php#language.types.string.syntax.nowdoc
  protected
    $errorListFormatInARow = "<div class=\"messages error\">\n  <ul>\n    %errors%\n  </ul>\n</div>\n",
    $helpFormat = "<div class=\"description\">\n  %help%\n</div>\n",
    $rowFormat = "<div class=\"form-item\">\n  %label%\n  %error%%field%\n  %help%%hidden_fields%\n</div>\n";

  public function formatRow($label, $field, $errors = array(), $help = '', $hiddenFields = null)
  {
    if (preg_match('/<input [^>]*type="checkbox"/', $field))
    {
      return parent::formatRow(preg_replace('/<label[^>]*>/', '\\0'.$field, $label), null, $errors, $help, $hiddenFields);
    }

    return parent::formatRow($label, $field, $errors, $help, $hiddenFields);
  }

  public function generateLabelName($name)
  {
    $label = parent::generateLabelName($name);

    $validatorSchema = $this->form->getValidatorSchema();
    if (isset($validatorSchema[$name]) && $validatorSchema[$name]->getOption('required'))
    {
      $label .= '<span class="form-required" title="This field is required.">*</span>';
    }

    return $label;
  }
}
