<?php

namespace Ozzie\Nextstream;

class Nextstream
{
  /**
   * The permissions that exist within the application.
   *
   * @var array
   */
  public static $permissions = [];

  /**
   * The default permissions that should be available to new entities.
   *
   * @var array
   */
  public static $defaultPermissions = [];

  /**
   * Determine if any permissions have been registered with Jetstream.
   *
   * @return bool
   */
  public static function hasPermissions()
  {
    return count(static::$permissions) > 0;
  }

  /**
   * Define the available API token permissions.
   *
   * @param  array  $permissions
   * @return static
   */
  public static function permissions(array $permissions)
  {
    static::$permissions = $permissions;

    return new static;
  }

  /**
   * Define the default permissions that should be available to new API tokens.
   *
   * @param  array  $permissions
   * @return static
   */
  public static function defaultApiTokenPermissions(array $permissions)
  {
    static::$defaultPermissions = $permissions;

    return new static;
  }

  /**
   * Return the permissions in the given list that are actually defined permissions for the application.
   *
   * @param  array  $permissions
   * @return array
   */
  public static function validPermissions(array $permissions)
  {
    return array_values(array_intersect($permissions, static::$permissions));
  }
}
