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

class QubitPlace extends BasePlace
{
  public function __toString()
  {
    return $this->getName();
  }

  public function getMapRelations()
  {
   $mapRelations = array();

   $criteria = new Criteria;
   $criteria->add(PlaceMapRelation::PLACE_ID, $this->getId());
   $mapRelations = PlaceMapRelation::get($criteria);

   return $mapRelations;
  }
}
