<?php

declare(strict_types=1);

namespace App\Services;

class StoreFilesService
{
  private string $imageStoregePath = '';
  private string $imageStoregeUrl = '';
  public function __construct()
  {
    $this->imageStoregePath = '../Storage/UserProfileImg';
    $this->imageStoregeUrl = 'http://localhost/todoapp/app/Storage/UserProfileImg';
  }
  public function storeUserProfileImage(?array $profileImageFile): self
  {
    if ($profileImageFile) {
      $imageExt = explode('.', $profileImageFile['name']);
      $imageExt = end($imageExt);

      // Uploaded image storage path to move the uploaded image to
      $this->imageStoregePath = $this->imageStoregePath . '/' . time() . '_profileImg' . '.' . $imageExt;
      move_uploaded_file($profileImageFile['tmp_name'], $this->imageStoregePath);

      // Uploaded image url to be stored in database
      $this->imageStoregeUrl = $this->imageStoregeUrl . '/' . time() . '_profileImg' . '.' . $imageExt;

      return $this;
    } else {
      $this->imageStoregeUrl  = $this->imageStoregeUrl  . '/' . 'default_profileImg.png';

      return $this;
    }
  }

  public function getUserProfileImageUrl() : string {
    return $this->imageStoregeUrl;
  }
}
