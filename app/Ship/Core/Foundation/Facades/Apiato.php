<?php

namespace App\Ship\Core\Foundation\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Apiato
 *
 * Get the containers namespace value from the containers config file
 * @method static string getContainersNamespace()
 *
 * Get the containers names
 * @method static array getContainersNames()
 *
 * Get the port folders names
 * @method static array getShipFoldersNames()
 *
 * Get containers directories paths
 * @method static mixed getContainersPaths()
 *
 * Get Ship layer directories paths
 * @method static mixed getShipPath()
 *
 * Build and return an object of a class from its file path
 * @method static mixed getClassObjectFromFile(string $filePathName)
 *
 * Get the full name (name \ namespace) of a class from its file path
 * result example: (string) "I\Am\The\Namespace\Of\This\Class"
 * @method static string getClassFullNameFromFile(string $filePathName)
 *
 * Check if a word starts with another word
 * @method static bool stringStartsWith($word, $startsWith)
 *
 * @method static mixed|string uncamelize($word, string $splitter = " ", bool $uppercase = true)
 *
 * @method static mixed getLoginWebPageName() WrongConfigurationsException
 *
 * Return current api prefix, by default '/'
 * @method static string getApiPrefix()
 *
 * Return current api version
 * @method static string getApiVersion()
 *
 * Build namespace for a class in Container.
 * @method static string  buildClassFullName($containerName, $className)
 *
 * Get the last part of a camel case string.
 * Example input = helloDearWorld | returns = World
 * @method static mixed getClassType($className)
 *
 * @method static mixed verifyContainerExist($containerName) MissingContainerException
 *
 * @method static mixed verifyClassExist($className) ClassDoesNotExistException
 *
 * This function will be called from anywhere (controllers, Actions,..) by the Apiato facade.
 * The $class input will usually be an Action or Task.
 * @method static mixed call($class, array $runMethodArguments = [], array $extraMethodsToCall = []) UnstorableValueException
 *
 * This function calls another class but wraps it in a DB-Transaction. This might be useful for CREATE / UPDATE / DELETE
 * operations in order to prevent the database from corrupt data. Internally, the regular call() method is used!
 * @method static mixed transactionalCall($class, array $runMethodArguments = [], array $extraMethodsToCall = [])
 *
 * @see \App\Ship\Core\Foundation\Apiato
 */
class Apiato extends Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return 'Apiato';
  }
}
