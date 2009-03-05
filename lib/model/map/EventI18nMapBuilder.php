<?php



class EventI18nMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'lib.model.map.EventI18nMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(QubitEventI18n::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(QubitEventI18n::TABLE_NAME);
		$tMap->setPhpName('eventI18n');
		$tMap->setClassname('QubitEventI18n');

		$tMap->setUseIdGenerator(false);

		$tMap->addColumn('NAME', 'name', 'VARCHAR', false, 255);

		$tMap->addColumn('DESCRIPTION', 'description', 'LONGVARCHAR', false, null);

		$tMap->addColumn('DATE_DISPLAY', 'dateDisplay', 'VARCHAR', false, 255);

		$tMap->addForeignPrimaryKey('ID', 'id', 'INTEGER' , 'q_event', 'ID', true, null);

		$tMap->addPrimaryKey('CULTURE', 'culture', 'VARCHAR', true, 7);

	} 
} 