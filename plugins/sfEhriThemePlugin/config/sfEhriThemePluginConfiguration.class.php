<?php

/*
 * This file is part of Qubit Toolkit.
 *
 * Qubit Toolkit is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * Qubit Toolkit is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Qubit Toolkit.  If not, see <http://www.gnu.org/licenses/>.
 */

class sfEhriThemePluginConfiguration extends sfPluginConfiguration
{
  public static
    $summary = 'Theme plugin.  Adaptation of Classic theme that uses drop-down menus and mixes fixed and fluid width elements.  Further adapted for EHRI colours.',
    $version = '1.0.0';

  public function contextLoadFactories(sfEvent $event)
  {
    $context = $event->getSubject();

    $context->response->addStylesheet('/plugins/sfClassicPlugin/css/main', 'last', array('media' => 'all'));
    $context->response->addStylesheet('/plugins/sfEhriThemePlugin/css/style', 'last', array('media' => 'all'));

    $context->response->addStylesheet('/plugins/sfEhriThemePlugin/css/print', 'last', array('media' => 'print'));

    $context->response->addStylesheet('/plugins/sfEhriThemePlugin/css/print-ie', 'last', array('condition' => 'IE', 'media' => 'print'));

    $context->response->addJavaScript('/plugins/sfEhriThemePlugin/js/navigation', 'last');
  }

  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    $this->dispatcher->connect('context.load_factories', array($this, 'contextLoadFactories'));
  }
}