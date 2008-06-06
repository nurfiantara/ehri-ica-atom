<?php



class PhysicalObjectMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.PhysicalObjectMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('q_physical_object');
		$tMap->setPhpName('PhysicalObject');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('ID', 'Id', 'int' , CreoleTypes::INTEGER, 'q_object', 'ID', true, null);

		$tMap->addForeignKey('INFORMATION_OBJECT_ID', 'InformationObjectId', 'int', CreoleTypes::INTEGER, 'q_information_object', 'ID', false, null);

		$tMap->addForeignKey('LOCATION_ID', 'LocationId', 'int', CreoleTypes::INTEGER, 'q_term', 'ID', false, null);

		$tMap->addColumn('PARENT_ID', 'ParentId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('LFT', 'Lft', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('RGT', 'Rgt', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('SOURCE_CULTURE', 'SourceCulture', 'string', CreoleTypes::VARCHAR, true, 7);

	} 
} 