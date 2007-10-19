<?php


abstract class BaseinformationObjectRecursiveRelationship extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $information_object_id;


	
	protected $related_information_object_id;


	
	protected $relationship_type_id;


	
	protected $relationship_description;


	
	protected $relationship_start_date;


	
	protected $relationship_end_date;


	
	protected $date_display;


	
	protected $created_at;


	
	protected $updated_at;

	
	protected $ainformationObjectRelatedByInformationObjectId;

	
	protected $ainformationObjectRelatedByRelatedInformationObjectId;

	
	protected $aTerm;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getInformationObjectId()
	{

		return $this->information_object_id;
	}

	
	public function getRelatedInformationObjectId()
	{

		return $this->related_information_object_id;
	}

	
	public function getRelationshipTypeId()
	{

		return $this->relationship_type_id;
	}

	
	public function getRelationshipDescription()
	{

		return $this->relationship_description;
	}

	
	public function getRelationshipStartDate()
	{

		return $this->relationship_start_date;
	}

	
	public function getRelationshipEndDate()
	{

		return $this->relationship_end_date;
	}

	
	public function getDateDisplay()
	{

		return $this->date_display;
	}

	
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
						$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->updated_at === null || $this->updated_at === '') {
			return null;
		} elseif (!is_int($this->updated_at)) {
						$ts = strtotime($this->updated_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [updated_at] as date/time value: " . var_export($this->updated_at, true));
			}
		} else {
			$ts = $this->updated_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = informationObjectRecursiveRelationshipPeer::ID;
		}

	} 
	
	public function setInformationObjectId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->information_object_id !== $v) {
			$this->information_object_id = $v;
			$this->modifiedColumns[] = informationObjectRecursiveRelationshipPeer::INFORMATION_OBJECT_ID;
		}

		if ($this->ainformationObjectRelatedByInformationObjectId !== null && $this->ainformationObjectRelatedByInformationObjectId->getId() !== $v) {
			$this->ainformationObjectRelatedByInformationObjectId = null;
		}

	} 
	
	public function setRelatedInformationObjectId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->related_information_object_id !== $v) {
			$this->related_information_object_id = $v;
			$this->modifiedColumns[] = informationObjectRecursiveRelationshipPeer::RELATED_INFORMATION_OBJECT_ID;
		}

		if ($this->ainformationObjectRelatedByRelatedInformationObjectId !== null && $this->ainformationObjectRelatedByRelatedInformationObjectId->getId() !== $v) {
			$this->ainformationObjectRelatedByRelatedInformationObjectId = null;
		}

	} 
	
	public function setRelationshipTypeId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->relationship_type_id !== $v) {
			$this->relationship_type_id = $v;
			$this->modifiedColumns[] = informationObjectRecursiveRelationshipPeer::RELATIONSHIP_TYPE_ID;
		}

		if ($this->aTerm !== null && $this->aTerm->getId() !== $v) {
			$this->aTerm = null;
		}

	} 
	
	public function setRelationshipDescription($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->relationship_description !== $v) {
			$this->relationship_description = $v;
			$this->modifiedColumns[] = informationObjectRecursiveRelationshipPeer::RELATIONSHIP_DESCRIPTION;
		}

	} 
	
	public function setRelationshipStartDate($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->relationship_start_date !== $v) {
			$this->relationship_start_date = $v;
			$this->modifiedColumns[] = informationObjectRecursiveRelationshipPeer::RELATIONSHIP_START_DATE;
		}

	} 
	
	public function setRelationshipEndDate($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->relationship_end_date !== $v) {
			$this->relationship_end_date = $v;
			$this->modifiedColumns[] = informationObjectRecursiveRelationshipPeer::RELATIONSHIP_END_DATE;
		}

	} 
	
	public function setDateDisplay($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->date_display !== $v) {
			$this->date_display = $v;
			$this->modifiedColumns[] = informationObjectRecursiveRelationshipPeer::DATE_DISPLAY;
		}

	} 
	
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = informationObjectRecursiveRelationshipPeer::CREATED_AT;
		}

	} 
	
	public function setUpdatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [updated_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->updated_at !== $ts) {
			$this->updated_at = $ts;
			$this->modifiedColumns[] = informationObjectRecursiveRelationshipPeer::UPDATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->information_object_id = $rs->getInt($startcol + 1);

			$this->related_information_object_id = $rs->getInt($startcol + 2);

			$this->relationship_type_id = $rs->getInt($startcol + 3);

			$this->relationship_description = $rs->getString($startcol + 4);

			$this->relationship_start_date = $rs->getString($startcol + 5);

			$this->relationship_end_date = $rs->getString($startcol + 6);

			$this->date_display = $rs->getString($startcol + 7);

			$this->created_at = $rs->getTimestamp($startcol + 8, null);

			$this->updated_at = $rs->getTimestamp($startcol + 9, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 10; 
		} catch (Exception $e) {
			throw new PropelException("Error populating informationObjectRecursiveRelationship object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseinformationObjectRecursiveRelationship:delete:pre') as $callable)
    {
      $ret = call_user_func($callable, $this, $con);
      if ($ret)
      {
        return;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(informationObjectRecursiveRelationshipPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			informationObjectRecursiveRelationshipPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseinformationObjectRecursiveRelationship:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseinformationObjectRecursiveRelationship:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(informationObjectRecursiveRelationshipPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(informationObjectRecursiveRelationshipPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(informationObjectRecursiveRelationshipPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseinformationObjectRecursiveRelationship:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


												
			if ($this->ainformationObjectRelatedByInformationObjectId !== null) {
				if ($this->ainformationObjectRelatedByInformationObjectId->isModified()) {
					$affectedRows += $this->ainformationObjectRelatedByInformationObjectId->save($con);
				}
				$this->setinformationObjectRelatedByInformationObjectId($this->ainformationObjectRelatedByInformationObjectId);
			}

			if ($this->ainformationObjectRelatedByRelatedInformationObjectId !== null) {
				if ($this->ainformationObjectRelatedByRelatedInformationObjectId->isModified()) {
					$affectedRows += $this->ainformationObjectRelatedByRelatedInformationObjectId->save($con);
				}
				$this->setinformationObjectRelatedByRelatedInformationObjectId($this->ainformationObjectRelatedByRelatedInformationObjectId);
			}

			if ($this->aTerm !== null) {
				if ($this->aTerm->isModified()) {
					$affectedRows += $this->aTerm->save($con);
				}
				$this->setTerm($this->aTerm);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = informationObjectRecursiveRelationshipPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += informationObjectRecursiveRelationshipPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


												
			if ($this->ainformationObjectRelatedByInformationObjectId !== null) {
				if (!$this->ainformationObjectRelatedByInformationObjectId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->ainformationObjectRelatedByInformationObjectId->getValidationFailures());
				}
			}

			if ($this->ainformationObjectRelatedByRelatedInformationObjectId !== null) {
				if (!$this->ainformationObjectRelatedByRelatedInformationObjectId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->ainformationObjectRelatedByRelatedInformationObjectId->getValidationFailures());
				}
			}

			if ($this->aTerm !== null) {
				if (!$this->aTerm->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aTerm->getValidationFailures());
				}
			}


			if (($retval = informationObjectRecursiveRelationshipPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = informationObjectRecursiveRelationshipPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getInformationObjectId();
				break;
			case 2:
				return $this->getRelatedInformationObjectId();
				break;
			case 3:
				return $this->getRelationshipTypeId();
				break;
			case 4:
				return $this->getRelationshipDescription();
				break;
			case 5:
				return $this->getRelationshipStartDate();
				break;
			case 6:
				return $this->getRelationshipEndDate();
				break;
			case 7:
				return $this->getDateDisplay();
				break;
			case 8:
				return $this->getCreatedAt();
				break;
			case 9:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = informationObjectRecursiveRelationshipPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getInformationObjectId(),
			$keys[2] => $this->getRelatedInformationObjectId(),
			$keys[3] => $this->getRelationshipTypeId(),
			$keys[4] => $this->getRelationshipDescription(),
			$keys[5] => $this->getRelationshipStartDate(),
			$keys[6] => $this->getRelationshipEndDate(),
			$keys[7] => $this->getDateDisplay(),
			$keys[8] => $this->getCreatedAt(),
			$keys[9] => $this->getUpdatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = informationObjectRecursiveRelationshipPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setInformationObjectId($value);
				break;
			case 2:
				$this->setRelatedInformationObjectId($value);
				break;
			case 3:
				$this->setRelationshipTypeId($value);
				break;
			case 4:
				$this->setRelationshipDescription($value);
				break;
			case 5:
				$this->setRelationshipStartDate($value);
				break;
			case 6:
				$this->setRelationshipEndDate($value);
				break;
			case 7:
				$this->setDateDisplay($value);
				break;
			case 8:
				$this->setCreatedAt($value);
				break;
			case 9:
				$this->setUpdatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = informationObjectRecursiveRelationshipPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setInformationObjectId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setRelatedInformationObjectId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setRelationshipTypeId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setRelationshipDescription($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setRelationshipStartDate($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setRelationshipEndDate($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setDateDisplay($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setCreatedAt($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setUpdatedAt($arr[$keys[9]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(informationObjectRecursiveRelationshipPeer::DATABASE_NAME);

		if ($this->isColumnModified(informationObjectRecursiveRelationshipPeer::ID)) $criteria->add(informationObjectRecursiveRelationshipPeer::ID, $this->id);
		if ($this->isColumnModified(informationObjectRecursiveRelationshipPeer::INFORMATION_OBJECT_ID)) $criteria->add(informationObjectRecursiveRelationshipPeer::INFORMATION_OBJECT_ID, $this->information_object_id);
		if ($this->isColumnModified(informationObjectRecursiveRelationshipPeer::RELATED_INFORMATION_OBJECT_ID)) $criteria->add(informationObjectRecursiveRelationshipPeer::RELATED_INFORMATION_OBJECT_ID, $this->related_information_object_id);
		if ($this->isColumnModified(informationObjectRecursiveRelationshipPeer::RELATIONSHIP_TYPE_ID)) $criteria->add(informationObjectRecursiveRelationshipPeer::RELATIONSHIP_TYPE_ID, $this->relationship_type_id);
		if ($this->isColumnModified(informationObjectRecursiveRelationshipPeer::RELATIONSHIP_DESCRIPTION)) $criteria->add(informationObjectRecursiveRelationshipPeer::RELATIONSHIP_DESCRIPTION, $this->relationship_description);
		if ($this->isColumnModified(informationObjectRecursiveRelationshipPeer::RELATIONSHIP_START_DATE)) $criteria->add(informationObjectRecursiveRelationshipPeer::RELATIONSHIP_START_DATE, $this->relationship_start_date);
		if ($this->isColumnModified(informationObjectRecursiveRelationshipPeer::RELATIONSHIP_END_DATE)) $criteria->add(informationObjectRecursiveRelationshipPeer::RELATIONSHIP_END_DATE, $this->relationship_end_date);
		if ($this->isColumnModified(informationObjectRecursiveRelationshipPeer::DATE_DISPLAY)) $criteria->add(informationObjectRecursiveRelationshipPeer::DATE_DISPLAY, $this->date_display);
		if ($this->isColumnModified(informationObjectRecursiveRelationshipPeer::CREATED_AT)) $criteria->add(informationObjectRecursiveRelationshipPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(informationObjectRecursiveRelationshipPeer::UPDATED_AT)) $criteria->add(informationObjectRecursiveRelationshipPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(informationObjectRecursiveRelationshipPeer::DATABASE_NAME);

		$criteria->add(informationObjectRecursiveRelationshipPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setInformationObjectId($this->information_object_id);

		$copyObj->setRelatedInformationObjectId($this->related_information_object_id);

		$copyObj->setRelationshipTypeId($this->relationship_type_id);

		$copyObj->setRelationshipDescription($this->relationship_description);

		$copyObj->setRelationshipStartDate($this->relationship_start_date);

		$copyObj->setRelationshipEndDate($this->relationship_end_date);

		$copyObj->setDateDisplay($this->date_display);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new informationObjectRecursiveRelationshipPeer();
		}
		return self::$peer;
	}

	
	public function setinformationObjectRelatedByInformationObjectId($v)
	{


		if ($v === null) {
			$this->setInformationObjectId(NULL);
		} else {
			$this->setInformationObjectId($v->getId());
		}


		$this->ainformationObjectRelatedByInformationObjectId = $v;
	}


	
	public function getinformationObjectRelatedByInformationObjectId($con = null)
	{
				include_once 'lib/model/om/BaseinformationObjectPeer.php';

		if ($this->ainformationObjectRelatedByInformationObjectId === null && ($this->information_object_id !== null)) {

			$this->ainformationObjectRelatedByInformationObjectId = informationObjectPeer::retrieveByPK($this->information_object_id, $con);

			
		}
		return $this->ainformationObjectRelatedByInformationObjectId;
	}

	
	public function setinformationObjectRelatedByRelatedInformationObjectId($v)
	{


		if ($v === null) {
			$this->setRelatedInformationObjectId(NULL);
		} else {
			$this->setRelatedInformationObjectId($v->getId());
		}


		$this->ainformationObjectRelatedByRelatedInformationObjectId = $v;
	}


	
	public function getinformationObjectRelatedByRelatedInformationObjectId($con = null)
	{
				include_once 'lib/model/om/BaseinformationObjectPeer.php';

		if ($this->ainformationObjectRelatedByRelatedInformationObjectId === null && ($this->related_information_object_id !== null)) {

			$this->ainformationObjectRelatedByRelatedInformationObjectId = informationObjectPeer::retrieveByPK($this->related_information_object_id, $con);

			
		}
		return $this->ainformationObjectRelatedByRelatedInformationObjectId;
	}

	
	public function setTerm($v)
	{


		if ($v === null) {
			$this->setRelationshipTypeId(NULL);
		} else {
			$this->setRelationshipTypeId($v->getId());
		}


		$this->aTerm = $v;
	}


	
	public function getTerm($con = null)
	{
				include_once 'lib/model/om/BaseTermPeer.php';

		if ($this->aTerm === null && ($this->relationship_type_id !== null)) {

			$this->aTerm = TermPeer::retrieveByPK($this->relationship_type_id, $con);

			
		}
		return $this->aTerm;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseinformationObjectRecursiveRelationship:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseinformationObjectRecursiveRelationship::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 