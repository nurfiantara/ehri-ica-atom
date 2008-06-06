<?php

/*
 * This file is part of the Qubit Toolkit.
 * Copyright (C) 2006-2008 Peter Van Garderen <peter@artefactual.com>
 *
 * This program is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option)
 * any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License
 * for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to the Free Software Foundation, Inc., 51
 * Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

class placeActions extends sfActions
{
  public function executeList()
  {
    $this->places = QubitPlace::get();
  }

  public function executeShow()
  {
    $this->place = PlacePeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->place);

   $this->mapRelations = $this->place->getMapRelations();

    //determine if user has edit priviliges
    $this->editCredentials = false;
    if ($this->getUser()->hasCredential(array('contributor', 'editor', 'administrator'), false))
    {
    $this->editCredentials = true;
    }

  $this->nav_context_back  = $this->getUser()->getAttribute('nav_context_back');
  }

  public function executeCreate()
  {
    $this->place = new Place;

    $this->setTemplate('edit');
  }

  public function executeEdit()
  {
    $this->place = PlacePeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->place);

    $this->mapRelations = $this->place->getMapRelations();
  }

  public function executeUpdate()
  {
    if (!$this->getRequestParameter('id'))
    {
      $place = new Place;
    }
    else
    {
      $place = PlacePeer::retrieveByPk($this->getRequestParameter('id'));
      $this->forward404Unless($place);
    }

    $place->setId($this->getRequestParameter('id'));
    $place->setName($this->getRequestParameter('name'));
    $place->setDescription($this->getRequestParameter('description'));
    $place->setAddress($this->getRequestParameter('address'));
    $place->setCountryId($this->getRequestParameter('country_id') ? $this->getRequestParameter('country_id') : null);
    if (($this->getRequestParameter('longtitude') === null) or ($this->getRequestParameter('longtitude') == 0))
      {
      $place->setLongtitude(null);
      }
    else
      {
      $place->setLongtitude($this->getRequestParameter('longtitude'));
      }
    if (($this->getRequestParameter('latitude') === null) or ($this->getRequestParameter('latitude') == 0))
      {
      $place->setLatitude(null);
      }
    else
      {
      $place->setLatitude($this->getRequestParameter('latitude'));
      }

    $place->save();

    return $this->redirect('place/edit?id='.$place->getId());
  }

  public function executeDelete()
  {
    $place = PlacePeer::retrieveByPk($this->getRequestParameter('id'));

    $this->forward404Unless($place);

    $place->delete();

    return $this->redirect('place/list');
  }
}
