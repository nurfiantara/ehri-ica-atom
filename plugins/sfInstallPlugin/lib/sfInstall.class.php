<?php

/*
 */

// TODO: Integrate with symfony/data/bin/check_configuration.php
class sfInstall
{
  // Returns an array of missing dependencies
  // TODO: This is already implemented in PEAR.  Make this check more robust by
  // calling their code.
  // TODO: Break this up so we can give more detailed output (like which
  // extensions *are* loaded?
  public static function checkDependencies()
  {
    $dependencies = array();

    // Check if any dependencies are defined
    $packageXmlPath = sfConfig::get('sf_config_dir').'/package.xml';
    if (!file_exists($packageXmlPath))
    {
      return $dependencies;
    }

    $doc = new DOMDocument;
    $doc->load($packageXmlPath);

    $xpath = new DOMXPath($doc);
    $xpath->registerNamespace('p', 'http://pear.php.net/dtd/package-2.0');

    // Check if a minimum PHP version is defined, and if it is less than our
    // current version
    if (strlen($min = $xpath->evaluate('string(p:dependencies/p:required/p:php/p:min)', $doc->documentElement)) > 0 && version_compare(PHP_VERSION, $min) < 0)
    {
      $dependencies['php']['min'] = $min;
    }

    foreach ($xpath->query('p:dependencies/*/p:extension/p:name') as $node)
    {
      // nodeValue or textContent? http://php.net/DOMNode
      if (!extension_loaded($node->nodeValue))
      {
        $dependencies['extensions'][] = $node->nodeValue;
      }
    }

    return $dependencies;
  }

  public static function checkWritablePaths()
  {
    // FIXME: This is a late night hack.  It should probably get moved into its
    // own check.
    // Copied from sfFileLogger::initialize()
    if (!is_dir(sfConfig::get('sf_log_dir')))
    {
      mkdir(sfConfig::get('sf_log_dir'), 0777, true);
    }

    $writablePaths = array();

    $finder = sfFinder::type('any');

    foreach (array(sfConfig::get('sf_cache_dir'), sfConfig::get('sf_data_dir'), sfConfig::get('sf_log_dir')) as $path)
    {
      // FIXME: sfFinder::in() does not include the argument path
      if (!is_writable($path))
      {
        $writablePaths[] = $path;
      }

      foreach ($finder->in($path) as $path)
      {
        if (!is_writable($path))
        {
          $writablePaths[] = $path;
        }
      }
    }

    return $writablePaths;
  }

  public static function checkDatabasesYml()
  {
    $databasesYml = array();

    $databasesYmlPath = sfConfig::get('sf_config_dir').'/databases.yml';

    // Read databases.yml contents from existing databases.yml,
    // databases.yml.tmpl (for a Subversion checkout), or symfony skeleton
    // databases.yml, whichever is found first
    $databasesYmlPaths = array();
    $databasesYmlPaths[] = $databasesYmlPath;
    $databasesYmlPaths[] = $databasesYmlPath.'.tmpl';
    $databasesYmlPaths[] = sfConfig::get('sf_lib_dir').'/task/generator/skeleton/project/config/databases.yml';

    foreach ($databasesYmlPaths as $path)
    {
      if (false !== $databasesYmlContents = file_get_contents($path))
      {
        break;
      }
    }

    if (false === file_put_contents($databasesYmlPath, $databasesYmlContents))
    {
      $databasesYml['notWritable'] = 'notWritable';
    }

    return $databasesYml;
  }

  public static function checkPropelIni()
  {
    $propelIni = array();

    $propelIniPath = sfConfig::get('sf_config_dir').'/propel.ini';

    // Read propel.ini contents from existing propel.ini, propel.ini.tmpl (for
    // a Subversion checkout), or symfony skeleton propel.ini, whichever is
    // found first
    $propelIniPaths = array();
    $propelIniPaths[] = $propelIniPath;
    $propelIniPaths[] = $propelIniPath.'.tmpl';
    $propelIniPaths[] = sfConfig::get('sf_lib_dir').'/task/generator/skeleton/project/config/propel.ini';

    foreach ($propelIniPaths as $path)
    {
      if (false !== $propelIniContents = file_get_contents($path))
      {
        break;
      }
    }

    if (false === file_put_contents($propelIniPath, $propelIniContents))
    {
      $propelIni['notWritable'] = 'notWritable';
    }

    return $propelIni;
  }

  // TODO: Use sfWebBrowserPlugin
  protected static function get($url)
  {
    $request = sfContext::getInstance()->getRequest();

    // TODO: Error handling
    $handle = fsockopen($request->getHost(), 80, $null, $null, 5);
    fwrite($handle, implode("\r\n", array(
      'GET '.$url.' HTTP/1.1',
      'Host: '.$request->getHost()))."\r\n\r\n");
    fflush($handle);

    $contents = stream_get_contents($handle);
    fclose($handle);

    return $contents;
  }

  // Must be called after checkDatabasesYml() because the $noScriptNameUrl will
  // always fail if databases.yml does not exist
  public static function checkHtaccess()
  {
    $htaccess = array();

    $invalidContents = <<<EOF
Deliberately invalid .htaccess file.  Requests in this directory should only succeed if .htaccess files are completely ignored.

EOF;

    $optionsContents = <<<EOF
Options +FollowSymLinks +ExecCGI

EOF;

    $relativeUrlRoot = sfContext::getInstance()->getRequest()->getRelativeUrlRoot();

    $rewriteBase = 'RewriteBase '.$relativeUrlRoot;
    if ('/' === $relativeUrlRoot)
    {
      $rewriteBase = '#'.$rewriteBase;
    }
    else
    {
      $rewriteBase .= '/';
    }

    $checkModRewriteContents = <<<EOF
<IfModule mod_rewrite.c>
  RewriteEngine On

  # uncomment the following line, if you are having trouble
  # getting no_script_name to work
  $rewriteBase
  RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>

EOF;

    $modRewriteContents = <<<EOF
<IfModule mod_rewrite.c>
  RewriteEngine On

  # uncomment the following line, if you are having trouble
  # getting no_script_name to work
  $rewriteBase

  # we skip all files with .something
  #RewriteCond %{REQUEST_URI} \..+$
  #RewriteCond %{REQUEST_URI} !\.html$
  #RewriteRule .* - [L]

  # we check if the .html version is here (caching)
  RewriteRule ^$ index.html [QSA]
  RewriteRule ^([^.]+)$ $1.html [QSA]
  RewriteCond %{REQUEST_FILENAME} !-f

  # no, so we redirect to our front web controller
  RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>

EOF;

    $htaccessPath = sfConfig::get('sf_web_dir').'/.htaccess';

    // TODO: no_script_name should be a genUrl() option
    sfConfig::set('no_script_name', false);
    $url = sfContext::getInstance()->getController()->genUrl(array('module' => 'sfInstallPlugin', 'action' => 'callback'));

    sfConfig::set('no_script_name', true);
    $noScriptNameUrl = sfContext::getInstance()->getController()->genUrl(array('module' => 'sfInstallPlugin', 'action' => 'callback'));

    // Remember if the .htaccess file already exists
    $htaccessExists = file_exists($htaccessPath);

    // Check if the .htaccess file is writable and if .htaccess files are
    // completely ignored
    if (false === file_put_contents($htaccessPath, $invalidContents))
    {
      // Check if the configuration works before complaining
      if (false === strstr(self::get($noScriptNameUrl), 'Open-Source PHP Web Framework'))
      {
        $htaccess['notWritable'] = 'notWritable';
      }

      return $htaccess;
    }

    // FIXME: We created a new .htaccess file.  Make it world readable or
    // Apache may not be able to read it.
    if (!$htaccessExists)
    {
      chmod($htaccessPath, 0644);
    }

    // Check if .htaccess files are completely ignored
    if (false !== strstr(self::get($url), 'Open-Source PHP Web Framework'))
    {
      // Check if the configuration works before complaining
      if (false === strstr(self::get($noScriptNameUrl), 'Open-Source PHP Web Framework'))
      {
        $htaccess['ignored'] = 'ignored';
      }

      unlink($htaccessPath);

      return $htaccess;
    }

    $htaccessContents = array();

    // Check if Options allowed in .htaccess
    $htaccessContents[] = $optionsContents;
    file_put_contents($htaccessPath, implode("\n", $htaccessContents));
    if (false === strstr(self::get($url), 'Open-Source PHP Web Framework'))
    {
      $htaccess['optionsNotAllowed'] = 'optionsNotAllowed';
      $htaccessContents = array();
    }

    $checkHtaccessContents = $htaccessContents;

    // Check if the configuration works before complaining
    $htaccessContents[] = $modRewriteContents;
    file_put_contents($htaccessPath, implode("\n", $htaccessContents));
    if (false !== strstr(self::get($noScriptNameUrl), 'Open-Source PHP Web Framework'))
    {
      return array();
    }

    // TODO: Discriminate between mod_rewrite not enabled and mod_rewrite not
    // configured by putting valid mod_rewrite directives outside <IfModule>
    $checkHtaccessContents[] = $checkModRewriteContents;
    file_put_contents($htaccessPath, implode("\n", $checkHtaccessContents));
    if (false !== strstr(self::get($url), 'Open-Source PHP Web Framework'))
    {
      $htaccess['modRewriteNotConfigured'] = 'modRewriteNotConfigured';
    }

    file_put_contents($htaccessPath, implode("\n", $htaccessContents));

    return $htaccess;
  }

  public static function checkSettingsYml($noScriptName)
  {
    $settingsYml = array();

    $settingsYmlPath = sfConfig::get('sf_app_config_dir').'/settings.yml';

    // Read settings.yml contents from existing settings.yml, settings.yml.tmpl
    // (for a Subversion checkout), or symfony skeleton settings.yml, whichever
    // is found first
    $settingsYmlPaths = array();
    $settingsYmlPaths[] = $settingsYmlPath;
    $settingsYmlPaths[] = $settingsYmlPath.'.tmpl';
    $settingsYmlPaths[] = sfConfig::get('sf_lib_dir').'/task/generator/skeleton/app/app/config/settings.yml';

    foreach ($settingsYmlPaths as $path)
    {
      if (false !== $settingsYmlContents = file_get_contents($path))
      {
        break;
      }
    }

    // TODO: Make this pattern more robust, or parse the YAML?
    $settingsYmlContents = preg_replace('/^(prod:\v+  .settings:\v+    no_script_name:\h*)[^\v]+/', '\1'.($noScriptName ? 'true' : 'false'), $settingsYmlContents);

    if (false === file_put_contents($settingsYmlPath, $settingsYmlContents))
    {
      $settingsYml['notWritable'] = 'notWritable';
    }

    $dispatcher = sfContext::getInstance()->getEventDispatcher();
    $formatter = new sfAnsiColorFormatter;

    chdir(sfConfig::get('sf_root_dir'));

    // FIXME: By instantiating a new application configuration the cache clear
    // task may change these settings, leading to bugs in code which expects
    // them to remain constant
    $saveDebug = sfConfig::get('sf_debug');
    $saveLoggingEnabled = sfConfig::get('sf_logging_enabled');

    // FIXME: We do not want to cache anything during install, but currently we
    // must clear the cache after adding enabling sfInstallPlugin : (
    $cacheClear = new sfCacheClearTask($dispatcher, $formatter);
    $cacheClear->run();

    sfConfig::set('sf_debug', $saveDebug);
    sfConfig::set('sf_logging_enabled', $saveLoggingEnabled);

    return $settingsYml;
  }

  // TODO: Move to sfSearchPlugin
  protected static function getSearchIndexes()
  {
    $searchIndexes = array();

    $finder = sfFinder::type('file')->name('*.class.php');

    foreach ($finder->in(sfConfig::get('sf_lib_dir').'/search') as $path)
    {
      require_once $path;
    }

    // Copied from sfCommandApplication::registerTasks()
    foreach (get_declared_classes() as $className)
    {
      $class = new ReflectionClass($className);
      if ($class->isSubclassOf('xfIndexSingle'))
      {
        $searchIndex = new $className;
        $searchIndexes[$searchIndex->getName()] = $searchIndex;
      }
    }

    return $searchIndexes;
  }

  // TODO: Break this up so we can send status to the user immediately
  public static function checkSearchIndex()
  {
    $searchIndex = array();

    $dispatcher = sfContext::getInstance()->getEventDispatcher();
    $formatter = new sfAnsiColorFormatter;

    chdir(sfConfig::get('sf_root_dir'));

    foreach (self::getSearchIndexes() as $index)
    {
      $populate = new xfPopulateTask($dispatcher, $formatter);

      try
      {
        $populate->run(array($index->getName()));
      }
      catch (Exception $e)
      {
        $searchIndex[] = $e;
      }
    }

    return $searchIndex;
  }

  public static function configureDatabase($databaseName, $databaseUsername, $databasePassword)
  {
    $database = array();

    $dsn = 'mysql://';
    if (strlen($databaseUsername) > 0)
    {
      $usernameAndPassword = $databaseUsername;
      if (strlen($databasePassword) > 0)
      {
        $usernameAndPassword .= ':'.$databasePassword;
      }

      $dsn .= $usernameAndPassword.'@';
    }

    $dsn .= 'localhost/'.$databaseName;

    $dispatcher = sfContext::getInstance()->getEventDispatcher();
    $formatter = new sfAnsiColorFormatter;

    chdir(sfConfig::get('sf_root_dir'));

    $configureDatabase = new sfConfigureDatabaseTask($dispatcher, $formatter);
    $configureDatabase->run(array($dsn));

    // FIXME: By instantiating a new application configuration the cache clear
    // task may change these settings, leading to bugs in code which expects
    // them to remain constant
    $saveDebug = sfConfig::get('sf_debug');
    $saveLoggingEnabled = sfConfig::get('sf_logging_enabled');

    // FIXME: We do not want to cache anything during install, but currently we
    // must clear the cache after configuring the database : (
    $cacheClear = new sfCacheClearTask($dispatcher, $formatter);
    $cacheClear->run();

    sfConfig::set('sf_debug', $saveDebug);
    sfConfig::set('sf_logging_enabled', $saveLoggingEnabled);

    try
    {
      $databaseManager = sfContext::getInstance()->getDatabaseManager();

      // FIXME: Currently need to reload after configuring the database
      $databaseManager->loadConfiguration();

      sfContext::getInstance()->getDatabaseConnection('propel');
    }
    catch (Exception $e)
    {
      $database[] = $e;
    }

    return $database;
  }

  public static function insertSql()
  {
    $dispatcher = sfContext::getInstance()->getEventDispatcher();
    $formatter = new sfAnsiColorFormatter;

    chdir(sfConfig::get('sf_root_dir'));

    $insertSql = new sfPropelInsertSqlTask($dispatcher, $formatter);
    $insertSql->run();
  }

  public static function loadData()
  {
    $dispatcher = sfContext::getInstance()->getEventDispatcher();
    $formatter = new sfAnsiColorFormatter;

    chdir(sfConfig::get('sf_root_dir'));

    $loadData = new sfPropelLoadDataTask($dispatcher, $formatter);
    $loadData->run(array('qubit'));
  }
}