<?php

namespace App\Services;

use Image;

class ImageCropService
{

   public function imageProcess($imageFile)
   {
      $image = $imageFile;
      $data = getImageSize($image);
      $thumbPath = public_path('images/thumbnail/');
      $mainPath = public_path('images/main/');
      $listingPath = public_path('images/listing/');

      $filename = Date("D-h-i-s") . '-' . rand() . '-' . '.' . $image->getClientOriginalExtension();;

      $width = $data[0];
      $height = $data[1];

      $img = Image::make($image->getRealPath());
      $img->fit($width, $height)->save($mainPath . $filename);

      $img1 = Image::make($image->getRealPath());
      $img1->resize($width / 2, null, function ($constraint) {
         $constraint->aspectRatio();
      })->save($listingPath . $filename);

      $img1->fit(200, null, function ($constraint) {
         $constraint->aspectRatio();
      })->save($thumbPath . $filename);

      $detail['name'] = $filename;
      $detail['success'] = 'success';
      $detail['path'] = asset('images/main');

      return $detail;
   }

   public function cropProcess($imageFile, $coordinates)
   {
      $image = $imageFile;
      [$xAxis, $yAxis, $width, $height] = $coordinates;

      $mainImagePath = public_path('images/main/');
      $listingImagePath = public_path('images/listing/');
      $thumbImagePath = public_path('images/thumbnail/');

      $x = $xAxis * 2;
      $y = $yAxis * 2;
      $w = $width * 2;
      $h = $height * 2;

      $img = Image::make('images/main/' . $image);

      $img->crop((int) $w, (int) $h, (int) $x, (int) $y);

      $img->save($mainImagePath . $image);
      $img->save($listingImagePath . $image);
      $img->save($thumbImagePath . $image);
      // $finalImage='images/temp/thumb'.$image;
      $finalImage = asset('images/thumbnail/' . $image);
      $image = '';

      return $finalImage;
   }
}
