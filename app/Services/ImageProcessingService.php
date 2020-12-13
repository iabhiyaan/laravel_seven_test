<?php

namespace App\Services;

use Image;

class ImageProcessingService
{
   //save appropriate size of image for gallery thumbnail
   public function imageProcessing($image, $width, $height, $otherpath)
   {

      $input['imagename'] = Date("D-h-i-s") . '-' . rand() . '-' . '.' . $image->getClientOriginalExtension();

      $thumbPath = public_path('images/thumbnail');
      $mainPath = public_path('images/main');
      $listingPath = public_path('images/listing');

      $img = Image::make($image->getRealPath());
      $img->fit($width, $height)->save($mainPath . '/' . $input['imagename']);

      if ($otherpath == 'yes') {
         $img1 = Image::make($image->getRealPath());
         $img1->resize($width / 2, null, function ($constraint) {
            $constraint->aspectRatio();
         })->save($listingPath . '/' . $input['imagename']);

         $img1->fit(200, null, function ($constraint) {
            $constraint->aspectRatio();
         })->save($thumbPath . '/' . $input['imagename']);
         $img1->destroy();
      }

      $img->destroy();
      return $input['imagename'];
   }

   public function unlinkImage($imagename)
   {
      $thumbPath = public_path('images/thumbnail/') . $imagename;
      $mainPath = public_path('images/main/') . $imagename;
      $listingPath = public_path('images/listing/') . $imagename;
      if (file_exists($thumbPath)) {
         unlink($thumbPath);
      }

      if (file_exists($mainPath)) {
         unlink($mainPath);
      }

      if (file_exists($listingPath)) {
         unlink($listingPath);
      }

      return;
   }
}
