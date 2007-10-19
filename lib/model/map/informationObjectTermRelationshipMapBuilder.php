<?php



class informationObjectTermRelationshipMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.informationObjectTermRelationshipMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('propel');

		$tMap = $this->dbMap->addTable('information_object_term_relationship');
		$tMap->setPhpName('informationObjectTermRelationship');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('INFORMATION_OBJECT_ID', 'InformationObjectId', 'int', CreoleTypes::INTEGER, 'information_object', 'ID', false, null);

		$tMap->addForeignKey('TERM_ID', 'TermId', 'int', CreoleTypes::INTEGER, 'term', 'ID', false, null);

		$tMap->addForeignKey('RELATIONSHIP_TYPE_ID', 'RelationshipTypeId', 'int', CreoleTypes::INTEGER, 'term', 'ID', false, null);

		$tMap->addColumn('RELATIONSHIP_NOTE', 'RelationshipNote', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('RELATIONSHIP_START_DATE', 'RelationshipStartDate', 'string', CreoleTypes::VARCHAR, false, null);

		$tMap->addColumn('RELATIONSHIP_END_DATE', 'RelationshipEndDate', 'string', CreoleTypes::VARCHAR, false, null);

		$tMap->addColumn('DATE_DISPLAY', 'DateDisplay', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 