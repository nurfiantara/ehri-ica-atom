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

class RepositoryContextMenuComponent extends sfComponent
{
  public function execute($request)
  {
    $this->repository = QubitRepository::getById($this->getRequestParameter('id'));
    if ($this->repository)
    {
      // Set current page
      $this->holdingsPage = $this->getRequestParameter('holdingsPage', 1);
      $options['page'] = $this->holdingsPage;

      // Paginate holdings list
      $this->pager = $this->repository->getHoldingsPager($options);
      $this->pager->setMaxLinkCount(5);
      $this->pager->init();

      $this->holdings = $this->pager->getResults();
      $this->currentAction = sfContext::getInstance()->getActionName();
    }
    else
    {
      return sfView::NONE;
    }
  }
}