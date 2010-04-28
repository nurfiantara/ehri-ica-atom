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
 * Display ACL permission tabs
 *
 * @package    qubit
 * @subpackage aclGroup 
 * @version    svn: $Id$
 * @author     David Juhasz <david@artefactual.com>
 */
class aclGroupTabsComponent extends sfComponent
{
  public function execute($request)
  {
    // Get parent menu
    $criteria = new Criteria;
    $criteria->add(QubitMenu::NAME, 'groups');

    $this->groupsMenu = QubitMenu::getOne($criteria);
  }
}