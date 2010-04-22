<?php


/**
 * This class defines the structure of the 'q_rights_term_relation' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class RightsTermRelationTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.RightsTermRelationTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('q_rights_term_relation');
		$this->setPhpName('rightsTermRelation');
		$this->setClassname('QubitRightsTermRelation');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addForeignKey('RIGHTS_ID', 'rightsId', 'INTEGER', 'q_rights', 'ID', true, null, null);
		$this->addForeignKey('TERM_ID', 'termId', 'INTEGER', 'q_term', 'ID', true, null, null);
		$this->addForeignKey('TYPE_ID', 'typeId', 'INTEGER', 'q_term', 'ID', false, null, null);
		$this->addColumn('DESCRIPTION', 'description', 'LONGVARCHAR', false, null, null);
		$this->addColumn('CREATED_AT', 'createdAt', 'TIMESTAMP', true, null, null);
		$this->addColumn('UPDATED_AT', 'updatedAt', 'TIMESTAMP', true, null, null);
		$this->addPrimaryKey('ID', 'id', 'INTEGER', true, null, null);
		$this->addColumn('SERIAL_NUMBER', 'serialNumber', 'INTEGER', true, null, 0);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('rights', 'rights', RelationMap::MANY_TO_ONE, array('rights_id' => 'id', ), 'CASCADE', null);
    $this->addRelation('termRelatedBytermId', 'term', RelationMap::MANY_TO_ONE, array('term_id' => 'id', ), 'CASCADE', null);
    $this->addRelation('termRelatedBytypeId', 'term', RelationMap::MANY_TO_ONE, array('type_id' => 'id', ), null, null);
	} // buildRelations()

} // RightsTermRelationTableMap
