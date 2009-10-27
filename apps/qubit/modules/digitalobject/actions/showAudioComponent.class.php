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

/**
 * Digital Object video display component
 *
 * @package    qubit
 * @subpackage digitalObject
 * @author     Jesús García Crespo <correo@sevein.com>
 * @version    SVN: $Id
 */
class DigitalObjectShowAudioComponent extends sfComponent
{
  /**
   * Show a representation of a digital object image.
   *
   * @param sfWebRequest $request
   *
   */
  public function execute($request)
  {
    $this->getResponse()->addJavaScript('/vendor/jquery');
    $this->getResponse()->addJavaScript('/vendor/flowplayer/flashembed.min.js');
    $this->getResponse()->addStylesheet('flowPlayer');

    $this->pathToFlowPlayer = public_path('flowplayer/flowplayer.swf');
    $this->pathToFlowPlayerAudioPlugin = public_path('flowplayer/flowplayer.audio.swf');
  }
}