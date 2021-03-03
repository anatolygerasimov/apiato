<?php

namespace App\Ship\Core\Foundation;

use App\Ship\Core\Traits\CallableTrait;
use App\Ship\Core\Exceptions\ClassDoesNotExistException;
use App\Ship\Core\Exceptions\MissingContainerException;
use App\Ship\Core\Exceptions\WrongConfigurationsException;
use Illuminate\Support\Facades\File;

/**
 * Class Blocks
 *
 * Helper Class to serve Blocks (Ship/Containers).
 */
class Apiato
{
  use CallableTrait;

  /**
   * The Blocks version.
   *
   * @var string
   */
  public const VERSION = '1.0.0';

  /**
   * Get the containers namespace value from the containers config file
   *
   * @return string
   */
  public function getContainersNamespace()
  {
    return config('apiato.containers.namespace');
  }

  /**
   * Get the containers names
   *
   * @return array
   */
  public function getContainersNames()
  {
    $containersNames = [];

    foreach ($this->getContainersPaths() as $containersPath) {
      $containersNames[] = basename($containersPath);
    }

    return $containersNames;
  }

  /**
   * Get the port folders names
   *
   * @return array
   */
  public function getShipFoldersNames()
  {
    $portFoldersNames = [];

    foreach ($this->getShipPath() as $portFoldersPath) {
      $portFoldersNames[] = basename($portFoldersPath);
    }

    return $portFoldersNames;
  }

  /**
   * Get containers directories paths
   *
   * @return mixed
   */
  public function getContainersPaths()
  {
    return File::directories(app_path('Containers'));
  }

  /**
   * @return mixed
   */
  public function getShipPath()
  {
    return File::directories(app_path('Ship'));
  }

  /**
   * Build and return an object of a class from its file path
   *
   * @param $filePathName
   *
   * @return mixed
   */
  public function getClassObjectFromFile($filePathName)
  {
    $classString = $this->getClassFullNameFromFile($filePathName);

    $object = new $classString;

    return $object;
  }

  /**
   * Get the full name (name \ namespace) of a class from its file path
   * result example: (string) "I\Am\The\Namespace\Of\This\Class"
   *
   * @param $filePathName
   *
   * @return  string
   */
  public function getClassFullNameFromFile($filePathName)
  {
    return $this->getClassNamespaceFromFile($filePathName) . '\\' . $this->getClassNameFromFile($filePathName);
  }

  /**
   * Get the class namespace form file path using token
   *
   * @param $filePathName
   *
   * @return  null|string
   */
  protected function getClassNamespaceFromFile($filePathName)
  {
    $src = file_get_contents($filePathName);

    $tokens       = token_get_all($src);
    $count        = count($tokens);
    $i            = 0;
    $namespace    = '';
    $namespace_ok = false;
    while ($i < $count) {
      $token = $tokens[$i];
      if (is_array($token) && $token[0] === T_NAMESPACE) {
        // Found namespace declaration
        while (++$i < $count) {
          if ($tokens[$i] === ';') {
            $namespace_ok = true;
            $namespace    = trim($namespace);
            break;
          }
          $namespace .= is_array($tokens[$i]) ? $tokens[$i][1] : $tokens[$i];
        }
        break;
      }
      $i++;
    }
    if (!$namespace_ok) {
      return null;
    } else {
      return $namespace;
    }
  }

  /**
   * Get the class name form file path using token
   *
   * @param $filePathName
   *
   * @return  mixed
   */
  protected function getClassNameFromFile($filePathName)
  {
    $php_code = file_get_contents($filePathName);

    $classes = [];
    $tokens  = token_get_all($php_code);
    $count   = count($tokens);
    for ($i = 2; $i < $count; $i++) {
      if ($tokens[$i - 2][0] == T_CLASS
        && $tokens[$i - 1][0] == T_WHITESPACE
        && $tokens[$i][0] == T_STRING
      ) {

        $class_name = $tokens[$i][1];
        $classes[]  = $class_name;
      }
    }

    return $classes[0];
  }

  /**
   * Check if a word starts with another word
   *
   * @param $word
   * @param $startsWith
   *
   * @return  bool
   */
  public function stringStartsWith($word, $startsWith)
  {
    return (substr($word, 0, strlen($startsWith)) === $startsWith);
  }

  /**
   * @param string $word
   * @param string $splitter
   * @param bool   $uppercase
   *
   * @return mixed|string
   */
  public function uncamelize($word, $splitter = " ", $uppercase = true)
  {
    $word = preg_replace('/(?!^)[[:upper:]][[:lower:]]/', '$0',
      preg_replace('/(?!^)[[:upper:]]+/', $splitter . '$0', $word));

    return $uppercase ? ucwords($word) : $word;
  }

  /**
   * @return string
   * @throws WrongConfigurationsException
   */
  public function getLoginWebPageName()
  {
    $loginPage = config('apiato.containers.login-page-url');

    if (is_null($loginPage)) {
      throw new WrongConfigurationsException();
    }

    return $loginPage;
  }

  /**
   * @return string
   * @throws WrongConfigurationsException
   */
  public function getAdminLoginWebPageName()
  {
    $loginPage = $this->getLoginWebPageName();

    return config('apiato.admin.prefix') . $loginPage;
  }

  /**
   * Return current api prefix, by default '/'
   *
   * @return string
   */
  public function getApiPrefix(): string
  {
    if ($prefix = config('apiato.api.prefix')) {
      if ($trimPrefix = trim($prefix, '/')) {
        $prefix = '/' . $trimPrefix . '/';
      }
    }
    return $prefix;
  }

  /**
   * Return current api version
   *
   * @return string
   */
  public function getApiVersion(): string
  {
    $version = '';

    if (config('apiato.api.enable_version_prefix')) {
      $version = config('apiato.api.version', $version);
    }

    return $version;
  }

  /**
   * Build namespace for a class in Container.
   *
   * @param $containerName
   * @param $className
   *
   * @return string
   */
  public function buildClassFullName($containerName, $className)
  {
    return 'App\Containers\\' . $containerName . '\\' . $this->getClassType($className) . 's\\' . $className;
  }

  /**
   * Get the last part of a camel case string.
   * Example input = helloDearWorld | returns = World
   *
   * @param $className
   *
   * @return  mixed
   */
  public function getClassType($className)
  {
    $array = preg_split('/(?=[A-Z])/', $className);

    return end($array);
  }

  /**
   * @param $containerName
   *
   * @throws MissingContainerException
   */
  public function verifyContainerExist($containerName)
  {
    if (!is_dir(app_path('Containers/' . $containerName))) {
      throw new MissingContainerException("Container ($containerName) is not installed.");
    }
  }

  /**
   * @param $className
   *
   * @throws ClassDoesNotExistException
   */
  public function verifyClassExist($className)
  {
    if (!class_exists($className)) {
      throw new ClassDoesNotExistException("Class ($className) is not installed.");
    }
  }
}
