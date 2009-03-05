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

class InformationObjectDeleteTermRelationAction extends sfAction
{
  public function execute($request)
  {
    $this->deleteTermRelation = QubitObjectTermRelation::getById($this->getRequestParameter('TermRelationId'));
    $this->forward404Unless($this->deleteTermRelation);

    $this->informationObject = QubitInformationObject::getById($this->deleteTermRelation->getObjectId());

    $this->deleteTermRelation->delete();

    if (strlen($template = $this->getRequestParameter('returnTemplate')) > 0)
    {
      return $this->redirect(array('module' => 'informationobject', 'action' => 'edit', 'informationobject_template' => $template, 'id' => $this->informationObject->getId()));
    }
    else
    {
      return $this->redirect(array('module' => 'informationobject', 'action' => 'edit', 'id' => $this->informationObject->getId()));
    }
  }
}
