<?php



class NoteMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.NoteMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('q_note');
		$tMap->setPhpName('Note');

		$tMap->setUseIdGenerator(true);

		$tMap->addForeignKey('OBJECT_ID', 'ObjectId', 'int', CreoleTypes::INTEGER, 'q_object', 'ID', true, null);

		$tMap->addForeignKey('TYPE_ID', 'TypeId', 'int', CreoleTypes::INTEGER, 'q_term', 'ID', false, null);

		$tMap->addColumn('SCOPE', 'Scope', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addForeignKey('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, 'q_user', 'ID', false, null);

		$tMap->addForeignKey('PARENT_ID', 'ParentId', 'int', CreoleTypes::INTEGER, 'q_note', 'ID', false, null);

		$tMap->addColumn('LFT', 'Lft', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('RGT', 'Rgt', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('SOURCE_CULTURE', 'SourceCulture', 'string', CreoleTypes::VARCHAR, true, 7);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

	} 
} 