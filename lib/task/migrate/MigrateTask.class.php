<?php

/*
 * This file is part of Qubit Toolkit.
 *
 * Qubit Toolkit is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
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
class MigrateTask extends sfBaseTask
{
  protected
    $data,
    $dataModified = false,
    $initialVersion,
    $targetVersion,
    // list of migratable releases
    $validReleases = array(
      '1.0.3',
      '1.0.4',
      '1.0.5',
      '1.0.6',
      '1.0.7',
      '1.0.8'
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

  [./symfony propel:migrate qubit_data_1.0.8.yml|INFO]
EOF;

    $this->addArguments(array(
      new sfCommandArgument('datafile', sfCommandArgument::REQUIRED, 'The yaml data file containing the current site data')
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', true),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'cli'),
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
      throw new Exception('The file '.$arguments['datafile'].' is not readable.');
    }

    // Get target application version for data migration
    if (isset($options['target-version']))
    {
      if (!preg_match('/^\d+$/', $options['target-version']) || !in_array($options['target-version'], $this->validReleases))
      {
        throw new Exception('Invalid target version "'.$options['target-version'].'".');
      }

      $this->targetVersion = $options['target-version'];
    }

    // load yml dumpfile into an array ($this->data)
    $yamlParser = new sfYamlParser;
    $this->data = $yamlParser->parse(file_get_contents($arguments['datafile']));

    // Determine current version of the application (according to settings)
    if (null !== $this->initialVersion = $this->getDataVersion())
    {
      $this->logSection('migrate', 'Initial data version '.$this->initialVersion);
    }

    // At version 1.0.8 we switched from versioning by release to fine-grained
    // versions (integer)
    if (preg_match('/^\d+$/', $this->initialVersion))
    {
      $this->migrateFineGrained();
    }
    else
    {
      $this->migratePre108();

      if (null == $this->targetVersion || preg_match('/^\d+$/', $this->targetVersion))
      {
        $this->migrateFineGrained();
      }
    }

    // write new data.yml file (if data was modified)
    if ($this->dataModified)
    {
      $this->writeMigratedData($arguments['datafile']);
    }
    else
    {
      $this->logSection('migrate', 'The specified data file is up-to-date, no migration done.');
    }
  }

  protected function migratePre108()
  {
    // If target release is not set, then use last major milestone
    $targetVersion = $this->targetVersion;
    if (null == $targetVersion)
    {
      $targetVersion = '1.0.8';
    }

    // Incrementally call the upgrade task for each intervening release from
    // initial release to the target release
    $initialIndex = array_search($this->initialVersion, $this->validReleases);
    if (false === $initialIndex)
    {
      $initialIndex = count($this->validReleases) - 2;
    }

    $finalIndex = array_search($targetVersion, $this->validReleases);

    if ($initialIndex !== false && $finalIndex !== false && $initialIndex < $finalIndex)
    {
      for ($i = $initialIndex; $i < $finalIndex; $i++)
      {
        $this->migrator = QubitMigrateFactory::getMigrator($this->data, $this->validReleases[$i]);
        $this->data = $this->migrator->execute();
        $this->dataModified = true;

        // Set release
        if ('1.0.7' == $this->validReleases[$i])
        {
          $this->version = 0; // After 1.0.7 use integer versions
        }
        else
        {
          $this->version = $this->validReleases[$i+1];
        }

        $this->logSection('migrate', 'Data migrated to Release '.$this->validReleases[$i+1]);
      }
    }
  }

  protected function migrateFineGrained()
  {
    if (preg_match('/^\d+$/', $this->initialVersion))
    {
      $this->version = $this->initialVersion;
    }
    else
    {
      $this->version = 0;
    }

    while (null !== $this->version && (null === $this->targetVersion || $this->targetVersion < $this->version))
    {
      $migrator = QubitMigrateFactory::getMigrator($this->data, $this->version);
      $this->data = $migrator->execute();
      $this->dataModified = true;

      $this->version = $migrator::FINAL_VERSION;
    }

    if (null == $this->version)
    {
      // Set version to value in data/fixtures/settings.yml
      $parser = new sfYamlParser;
      $data = $parser->parse(file_get_contents(sfConfig::get('sf_data_dir').'/fixtures/settings.yml'));
      $this->version = $data['QubitSetting']['version']['value'];
    }

    $this->logSection('migrate', 'Data migrated to Release '.$migrator::MILESTONE.' v'.$this->version);
  }

  protected function writeMigratedData($originalFileName)
  {
    $migratedFileName = 'migrated_data_'.date('YmdHis').'.yml';
    $dir = dirname($originalFileName);
    $migratedFileName = $dir.DIRECTORY_SEPARATOR.$migratedFileName;

    $yamlDumper = new sfYamlDumper();
    $yamlData = sfYaml::dump($this->data, 3);

    // Remove single quotes from <?php statements to prevent errors on load
    $yamlData = preg_replace("/'(\<\?php echo .+ \?\>)'/", '$1', $yamlData);

    file_put_contents($migratedFileName, $yamlData);
    $this->logSection('migrate', 'Migrated data written to "'.$migratedFileName.'"');
  }

  protected function getDataVersion()
  {
    $currentVersion = null;
    foreach ($this->data['QubitSetting'] as $setting)
    {
      if ($setting['name'] == 'version')
      {
        if (preg_match('/^\d+$/', $setting['value']['en'], $matches))
        {
          $currentVersion = $matches[0];
        }
        else if (preg_match('/\d\.\d(\.\d)?/', $setting['value']['en'], $matches))
        {
          $currentVersion = $matches[0];
        }

        break;
      }
    }

    return $currentVersion;
  }

  protected function setDataVersion()
  {
    foreach ($this->data['QubitSetting'] as $key => $value)
    {
      if ('version' == $value['name'])
      {
        $version = $value['value'][$value['source_culture']];
        break;
      }
    }

    $this->data['QubitSetting'][$key]['value'][$this->data['QubitSetting'][$key]['source_culture']] = $this->version;

    return $this;
  }
}
