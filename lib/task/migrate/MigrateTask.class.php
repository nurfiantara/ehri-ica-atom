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
 * Migrate qubit data model
 *
 * @package    qubit
 * @subpackage migration
 * @version    svn: $Id$
 * @author     David Juhasz <david@artefactual.com>
 */
class UpgradeTask extends sfBaseTask
{
  // Qubit Generic Icon list
  private $validVersions = array(
    '1.0.3',
    '1.0.4',
    '1.0.5'
  );

  /**
   * @see sfBaseTask
   */
  protected function configure()
  {
    $this->namespace = 'propel';
    $this->name = 'migrate';
    $this->briefDescription = 'Migrate the database schema and existing data for compatibility with a newer version of Qubit.';
    $this->detailedDescription = <<<EOF
The [propel:migrate|INFO] task modifies the given YAML dump file with changes to the data structure and fixtures in subsequent versions of the application:

  [./symfony propel:migrate qubit_data_1.0.3.yml|INFO]
EOF;

    $this->addArguments(array(
      new sfCommandArgument('datafile', sfCommandArgument::REQUIRED, 'The yaml data file containing the current site data')
    ));

    $this->addOptions(array(
      new sfCommandOption('target-version', 'T', sfCommandOption::PARAMETER_OPTIONAL, 'Specify the target version for the migrated data')
    ));
  }

  /**
   * @see sfBaseTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    if (!is_readable($arguments['datafile']))
    {
      $this->log('The file '.$arguments['datafile'].' is not readable.');
      die();
    }

    // Get target application version for data migration
    if (isset($options['target-version']))
    {
      if (!in_array($options['target-version'], $this->validVersions))
      {
        $this->log('Invalid target version "'.$options['target-version'].'".');
        die();
      }

      $this->targetVersion = $options['target-version'];
    }
    else
    {
      // Set final version to last value in migration version array
      $this->targetVersion = end($this->validVersions);
    }

    // load yml dumpfile into an array ($data)
    $yamlParser = new sfYamlParser;
    $data = $yamlParser->parse(file_get_contents($arguments['datafile']));

    // Determine current version of the application (according to settings)
    $this->initialVersion = $this->getDataVersion($data);
    $this->logSection('migrate', 'Initial data version '.$this->initialVersion);

    $migrator = new QubitMigrateData($data);

    // Incrementally call the upgrade task for each intervening version from
    // initial version to the target version
    $initialIndex = array_search($this->initialVersion, $this->validVersions);
    $finalIndex = array_search($this->targetVersion, $this->validVersions);

    if ($initialIndex !== false && $finalIndex !== false && $initialIndex < $finalIndex)
    {
      for ($i = $initialIndex; $i < $finalIndex; $i++)
      {
        switch ($this->validVersions[$i])
        {
          case '1.0.3':
            $migrator->migrate103to104();
            $this->logSection('migrate', 'Data migrated to version 1.0.4');
            break;
          case '1.0.4':
            $migrator->migrate104to105();
            $this->logSection('migrate', 'Data migrated to version 1.0.5');
            break;
        }
      }
    }

    // write new data.yml file (if data was modified)
    if ($migrator->isDataModified())
    {
      $this->writeMigratedData($arguments['datafile'], $migrator->getData());
    }
    else
    {
      $this->logSection('migrate', 'The specified data file is up-to-date, no migration done.');
    }
  }

  protected function writeMigratedData($originalFileName, $data)
  {
    $migratedDataVersion = $this->getDataVersion($data);
    $migratedFileName = 'migrated_data_v'.str_replace('.', '', $migratedDataVersion).'.yml';
    $dir = dirname($originalFileName);
    $migratedFileName = $dir.DIRECTORY_SEPARATOR.$migratedFileName;

    $yamlDumper = new sfYamlDumper();
    $yamlData = sfYaml::dump($data, 3);

    // Remove single quotes from <?php statements to prevent errors on load
    $yamlData = preg_replace("/'(\<\?php echo .+ \?\>)'/", '$1', $yamlData);

    file_put_contents($migratedFileName, $yamlData);
    $this->logSection('migrate', 'Migrated data written to "'.$migratedFileName.'"');
  }

  protected function getDataVersion($data)
  {
    $currentVersion = null;
    foreach ($data['QubitSetting'] as $setting)
    {
      if ($setting['name'] == 'version')
      {
        preg_match('/\d\.\d\.\d/', $setting['value']['en'], $matches);
        $currentVersion = $matches[0];
        break;
      }
    }

    return $currentVersion;
  }
}