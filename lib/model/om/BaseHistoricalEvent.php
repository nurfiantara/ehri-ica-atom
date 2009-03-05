<?php

abstract class BaseHistoricalEvent extends QubitTerm implements ArrayAccess
{
  const
    DATABASE_NAME = 'propel',

    TABLE_NAME = 'q_historical_event',

    ID = 'q_historical_event.ID',
    TYPE_ID = 'q_historical_event.TYPE_ID',
    START_DATE = 'q_historical_event.START_DATE',
    START_TIME = 'q_historical_event.START_TIME',
    END_DATE = 'q_historical_event.END_DATE',
    END_TIME = 'q_historical_event.END_TIME';

  public static function addSelectColumns(Criteria $criteria)
  {
    parent::addSelectColumns($criteria);

    $criteria->addJoin(QubitHistoricalEvent::ID, QubitTerm::ID);

    $criteria->addSelectColumn(QubitHistoricalEvent::ID);
    $criteria->addSelectColumn(QubitHistoricalEvent::TYPE_ID);
    $criteria->addSelectColumn(QubitHistoricalEvent::START_DATE);
    $criteria->addSelectColumn(QubitHistoricalEvent::START_TIME);
    $criteria->addSelectColumn(QubitHistoricalEvent::END_DATE);
    $criteria->addSelectColumn(QubitHistoricalEvent::END_TIME);

    return $criteria;
  }

  public static function get(Criteria $criteria, array $options = array())
  {
    if (!isset($options['connection']))
    {
      $options['connection'] = Propel::getConnection(QubitHistoricalEvent::DATABASE_NAME);
    }

    self::addSelectColumns($criteria);

    return QubitQuery::createFromCriteria($criteria, 'QubitHistoricalEvent', $options);
  }

  public static function getAll(array $options = array())
  {
    return self::get(new Criteria, $options);
  }

  public static function getOne(Criteria $criteria, array $options = array())
  {
    $criteria->setLimit(1);

    return self::get($criteria, $options)->offsetGet(0, array('defaultValue' => null));
  }

  public static function getById($id, array $options = array())
  {
    $criteria = new Criteria;
    $criteria->add(QubitHistoricalEvent::ID, $id);

    return self::get($criteria, $options)->offsetGet(0, array('defaultValue' => null));
  }

  public function __construct()
  {
    parent::__construct();

    $this->tables[] = Propel::getDatabaseMap(QubitHistoricalEvent::DATABASE_NAME)->getTable(QubitHistoricalEvent::TABLE_NAME);
  }

  public static function addJointypeCriteria(Criteria $criteria)
  {
    $criteria->addJoin(QubitHistoricalEvent::TYPE_ID, QubitTerm::ID);

    return $criteria;
  }
}
