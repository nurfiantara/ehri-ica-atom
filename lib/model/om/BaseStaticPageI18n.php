<?php

abstract class BaseStaticPageI18n
{
  const DATABASE_NAME = 'propel';

  const TABLE_NAME = 'q_static_page_i18n';

  const TITLE = 'q_static_page_i18n.TITLE';
  const CONTENT = 'q_static_page_i18n.CONTENT';
  const ID = 'q_static_page_i18n.ID';
  const CULTURE = 'q_static_page_i18n.CULTURE';

  public static function addSelectColumns(Criteria $criteria)
  {
    $criteria->addSelectColumn(QubitStaticPageI18n::TITLE);
    $criteria->addSelectColumn(QubitStaticPageI18n::CONTENT);
    $criteria->addSelectColumn(QubitStaticPageI18n::ID);
    $criteria->addSelectColumn(QubitStaticPageI18n::CULTURE);

    return $criteria;
  }

  protected static $staticPageI18ns = array();

  public static function getFromResultSet(ResultSet $resultSet)
  {
    if (!isset(self::$staticPageI18ns[$key = serialize(array($resultSet->getInt(3), $resultSet->getString(4)))]))
    {
      $staticPageI18n = new QubitStaticPageI18n;
      $staticPageI18n->hydrate($resultSet);

      self::$staticPageI18ns[$key] = $staticPageI18n;
    }

    return self::$staticPageI18ns[$key];
  }

  public static function get(Criteria $criteria, array $options = array())
  {
    if (!isset($options['connection']))
    {
      $options['connection'] = Propel::getConnection(QubitStaticPageI18n::DATABASE_NAME);
    }

    self::addSelectColumns($criteria);

    return QubitQuery::createFromCriteria($criteria, 'QubitStaticPageI18n', $options);
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

  public static function getByIdAndCulture($id, $culture, array $options = array())
  {
    $criteria = new Criteria;
    $criteria->add(QubitStaticPageI18n::ID, $id);
    $criteria->add(QubitStaticPageI18n::CULTURE, $culture);

    return self::get($criteria, $options)->offsetGet(0, array('defaultValue' => null));
  }

  public static function doDelete(Criteria $criteria, $connection = null)
  {
    if (!isset($connection))
    {
      $connection = QubitTransactionFilter::getConnection(QubitStaticPageI18n::DATABASE_NAME);
    }

    $affectedRows = 0;

    $affectedRows += BasePeer::doDelete($criteria, $connection);

    return $affectedRows;
  }

  protected $title = null;

  public function getTitle()
  {
    return $this->title;
  }

  public function setTitle($title)
  {
    $this->title = $title;

    return $this;
  }

  protected $content = null;

  public function getContent()
  {
    return $this->content;
  }

  public function setContent($content)
  {
    $this->content = $content;

    return $this;
  }

  protected $id = null;

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  protected $culture = null;

  public function getCulture()
  {
    return $this->culture;
  }

  public function setCulture($culture)
  {
    $this->culture = $culture;

    return $this;
  }

  protected $new = true;

  protected $deleted = false;

  protected $columnValues = null;

  protected function isColumnModified($name)
  {
    return $this->$name != $this->columnValues[$name];
  }

  protected function resetModified()
  {
    $this->columnValues['title'] = $this->title;
    $this->columnValues['content'] = $this->content;
    $this->columnValues['id'] = $this->id;
    $this->columnValues['culture'] = $this->culture;

    return $this;
  }

  public function hydrate(ResultSet $results, $columnOffset = 1)
  {
    $this->title = $results->getString($columnOffset++);
    $this->content = $results->getString($columnOffset++);
    $this->id = $results->getInt($columnOffset++);
    $this->culture = $results->getString($columnOffset++);

    $this->new = false;
    $this->resetModified();

    return $columnOffset;
  }

  public function refresh(array $options = array())
  {
    if (!isset($options['connection']))
    {
      $options['connection'] = Propel::getConnection(QubitStaticPageI18n::DATABASE_NAME);
    }

    $criteria = new Criteria;
    $criteria->add(QubitStaticPageI18n::ID, $this->id);
    $criteria->add(QubitStaticPageI18n::CULTURE, $this->culture);

    self::addSelectColumns($criteria);

    $resultSet = BasePeer::doSelect($criteria, $options['connection']);
    $resultSet->next();

    return $this->hydrate($resultSet);
  }

  public function save($connection = null)
  {
    if ($this->deleted)
    {
      throw new PropelException('You cannot save an object that has been deleted.');
    }

    $affectedRows = 0;

    if ($this->new)
    {
      $affectedRows += $this->insert($connection);
    }
    else
    {
      $affectedRows += $this->update($connection);
    }

    $this->new = false;
    $this->resetModified();

    return $affectedRows;
  }

  protected function insert($connection = null)
  {
    $affectedRows = 0;

    $criteria = new Criteria;

    if ($this->isColumnModified('title'))
    {
      $criteria->add(QubitStaticPageI18n::TITLE, $this->title);
    }

    if ($this->isColumnModified('content'))
    {
      $criteria->add(QubitStaticPageI18n::CONTENT, $this->content);
    }

    if ($this->isColumnModified('id'))
    {
      $criteria->add(QubitStaticPageI18n::ID, $this->id);
    }

    if ($this->isColumnModified('culture'))
    {
      $criteria->add(QubitStaticPageI18n::CULTURE, $this->culture);
    }

    if (!isset($connection))
    {
      $connection = QubitTransactionFilter::getConnection(QubitStaticPageI18n::DATABASE_NAME);
    }

    BasePeer::doInsert($criteria, $connection);
    $affectedRows += 1;

    return $affectedRows;
  }

  protected function update($connection = null)
  {
    $affectedRows = 0;

    $criteria = new Criteria;

    if ($this->isColumnModified('title'))
    {
      $criteria->add(QubitStaticPageI18n::TITLE, $this->title);
    }

    if ($this->isColumnModified('content'))
    {
      $criteria->add(QubitStaticPageI18n::CONTENT, $this->content);
    }

    if ($this->isColumnModified('id'))
    {
      $criteria->add(QubitStaticPageI18n::ID, $this->id);
    }

    if ($this->isColumnModified('culture'))
    {
      $criteria->add(QubitStaticPageI18n::CULTURE, $this->culture);
    }

    if ($criteria->size() > 0)
    {
      $selectCriteria = new Criteria;
      $selectCriteria->add(QubitStaticPageI18n::ID, $this->id);
      $selectCriteria->add(QubitStaticPageI18n::CULTURE, $this->culture);

      if (!isset($connection))
      {
        $connection = QubitTransactionFilter::getConnection(QubitStaticPageI18n::DATABASE_NAME);
      }

      $affectedRows += BasePeer::doUpdate($selectCriteria, $criteria, $connection);
    }

    return $affectedRows;
  }

  public function delete($connection = null)
  {
    if ($this->deleted)
    {
      throw new PropelException('This object has already been deleted.');
    }

    $affectedRows = 0;

    $criteria = new Criteria;
    $criteria->add(QubitStaticPageI18n::ID, $this->id);
    $criteria->add(QubitStaticPageI18n::CULTURE, $this->culture);

    $affectedRows += self::doDelete($criteria, $connection);

    $this->deleted = true;

    return $affectedRows;
  }

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getId();

		$pks[1] = $this->getCulture();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setId($keys[0]);

		$this->setCulture($keys[1]);

	}

  public static function addJoinStaticPageCriteria(Criteria $criteria)
  {
    $criteria->addJoin(QubitStaticPageI18n::ID, QubitStaticPage::ID);

    return $criteria;
  }

  public function getStaticPage(array $options = array())
  {
    return $this->staticPage = QubitStaticPage::getById($this->id, $options);
  }

  public function setStaticPage(QubitStaticPage $staticPage)
  {
    $this->id = $staticPage->getId();

    return $this;
  }
}

BasePeer::getMapBuilder('lib.model.map.StaticPageI18nMapBuilder');
