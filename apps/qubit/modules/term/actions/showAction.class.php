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

class TermShowAction extends sfAction
{
  public function execute($request)
  {
    $this->term = QubitTerm::getById($this->getRequestParameter('id'));
    $this->forward404Unless($this->term);
  
    $this->scopeNotes = $this->term->getNotesByType($noteTypeId = QubitTerm::SCOPE_NOTE_ID, $exclude = null);
    $this->sourceNotes = $this->term->getNotesByType($noteTypeId = QubitTerm::SOURCE_NOTE_ID, $exclude = null);
  
    //determine if user has edit priviliges
    $this->editCredentials = false;
    if (SecurityPriviliges::editCredentials($this->getUser(), 'term'))
    {
      $this->editCredentials = true;
    }
  
  }
}
