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

/**
 * Information Object - updateDc
 *
 * @package    qubit
 * @subpackage informationObject - update an information object, including any Dc specific properties
 * @author     Peter Van Garderen <peter@artefactual.com>
 * @version    SVN: $Id$
 */

class InformationObjectUpdateDcAction extends InformationObjectUpdateAction
{
  public function execute($request)
  {
    // run the core informationObject update action commands
    parent::execute($request);

    // add Dublin Core specific commands

    // update informationObject in the search index
    if (!$this->foreignKeyUpdate)
    {
      SearchIndex::updateIndexDocument($this->informationObject, $this->getUser()->getCulture());
    }
    else
    {
      SearchIndex::updateTranslatedLanguages($this->informationObject);
    }

   // return to DC edit template
   return $this->redirect(array('module' => 'informationobject', 'action' => 'edit', 'informationobject_template' => 'dc', 'id' => $this->informationObject->getId()));
  }
}