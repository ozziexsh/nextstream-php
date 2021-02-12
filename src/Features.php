<?php

namespace Ozzie\Nextstream;

class Features
{
  public static function enabled(string $feature)
  {
    return in_array($feature, config('nextstream.features', []));
  }


  public static function accountDeletion()
  {
    return 'account-deletion';
  }

  public static function hasAccountDeletionFeatures()
  {
    return static::enabled(static::accountDeletion());
  }

  public static function api()
  {
    return 'api';
  }

  public static function hasApiFeatures()
  {
    return static::enabled(static::api());
  }

  public static function profilePhotos()
  {
    return 'profile-photos';
  }

  public static function hasProfilePhotoFeatures()
  {
    return static::enabled(static::profilePhotos());
  }
}
