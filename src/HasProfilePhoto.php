<?php

namespace Ozzie\Nextstream;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Ozzie\Nextstream\Features;

trait HasProfilePhoto
{
  /**
   * Update the user's profile photo.
   *
   * @param  \Illuminate\Http\UploadedFile  $photo
   * @return void
   */
  public function updateProfilePhoto(UploadedFile $photo)
  {
    tap($this->profile_photo_path, function ($previous) use ($photo) {
      $this->forceFill([
        'profile_photo_path' => $photo->storePublicly(
          'profile-photos',
          ['disk' => $this->profilePhotoDisk()]
        ),
      ])->save();

      if ($previous) {
        Storage::disk($this->profilePhotoDisk())->delete($previous);
      }
    });
  }

  /**
   * Delete the user's profile photo.
   *
   * @return void
   */
  public function deleteProfilePhoto()
  {
    if (!Features::hasProfilePhotoFeatures()) {
      return;
    }

    Storage::disk($this->profilePhotoDisk())->delete($this->profile_photo_path);

    $this->forceFill([
      'profile_photo_path' => null,
    ])->save();
  }

  /**
   * Get the URL to the user's profile photo.
   *
   * @return string
   */
  public function getProfilePhotoUrlAttribute()
  {
    return $this->profile_photo_path
      ? Storage::disk($this->profilePhotoDisk())->url($this->profile_photo_path)
      : $this->defaultProfilePhotoUrl();
  }

  /**
   * Get the default profile photo URL if no profile photo has been uploaded.
   *
   * @return string
   */
  protected function defaultProfilePhotoUrl()
  {
    return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
  }

  /**
   * Get the disk that profile photos should be stored on.
   *
   * @return string
   */
  protected function profilePhotoDisk()
  {
    return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : 'public';
  }
}