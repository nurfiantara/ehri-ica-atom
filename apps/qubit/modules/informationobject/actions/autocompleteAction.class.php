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
 * @package    qubit
 * @subpackage repository
 * @author     Peter Van Garderen <peter@artefactual.com>
 * @version    svn:$Id$
 */
class InformationObjectAutocompleteAction extends sfAction
{
  /**
   * Return all information objects (not just top-level) for Ajax request
   */
  public function execute($request)
  {
    if (!isset($request->limit))
    {
      $request->limit = sfConfig::get('app_hits_per_page');
    }

    $criteria = new Criteria;
    $criteria->addJoin(QubitInformationObject::ID, QubitInformationObjectI18n::ID, Criteria::INNER_JOIN);

    // Search for matching title or identifier
    if (isset($request->query))
    {
      $c1 = $criteria->getNewCriterion(QubitInformationObjectI18n::TITLE, $request->query.'%', Criteria::LIKE);
      $c2 = $criteria->getNewCriterion(QubitInformationObject::IDENTIFIER, $request->query.'%', Criteria::LIKE);
      $c1->addOr($c2);
      $criteria->add($c1);
    }

    // Exclude root node
    $criteria->add(QubitInformationObject::ID, QubitInformationObject::ROOT_ID, Criteria::NOT_EQUAL);

    $criteria->add(QubitInformationObjectI18n::CULTURE, $this->getUser()->getCulture(), Criteria::EQUAL);
    $criteria->addAscendingOrderByColumn(QubitInformationObject::LEVEL_OF_DESCRIPTION_ID);
    $criteria->addAscendingOrderByColumn(QubitInformationObject::IDENTIFIER);
    $criteria->addAscendingOrderByColumn(QubitInformationObjectI18n::TITLE);

    $this->pager = new QubitPager('QubitInformationObject');
    $this->pager->setCriteria($criteria);
    $this->pager->setMaxPerPage($request->limit);
    $this->pager->setPage(1);

    $this->informationObject = null;
    $this->informationObjects = $this->pager->getResults();
  }
}