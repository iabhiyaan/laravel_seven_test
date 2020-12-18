<?php

namespace App\Services;

use Image;

class MultipleImageCropService
{
   public function galleryImage($imageFile)
   {
      $files = $imageFile;

      foreach ($files as $file) {
         list($width, $height, $type, $attr) = getImageSize($file);
         if ($width < 400 && $height < 400) {
            continue;
         }

         $data = getImageSize($file);
         $width = $data[0];
         $height = $data[1];

         $thumbPath = public_path('images/thumbnail/');
         $mainPath = public_path('images/main/');
         $listingPath = public_path('images/listing/');

         $filename = Date("D-h-i-s") . '-' . rand() . '-' . '.' . $file->getClientOriginalExtension();
         $width = $data[0];
         $height = $data[1];

         $img = Image::make($file->getRealPath());
         $img->fit($width, $height)->save($mainPath . $filename);

         $img1 = Image::make($file->getRealPath());
         $img1->resize($width / 2, null, function ($constraint) {
            $constraint->aspectRatio();
         })->save($listingPath . $filename);

         $img1->fit(200, null, function ($constraint) {
            $constraint->aspectRatio();
         })->save($thumbPath . $filename);

         $detail['name'] = $filename;
         $detail['success'] = 'success';
         $detail['path'] = asset('images/main');

         // $name[] by giving array in last => push the other data in $name array
         /*
         E.g
         $name = [
            ['data1'],
            ['data2]
         ]; */

         $name[] = $detail;
      }
      return $name;
   }

   public function jcropProcess($imageFile, $coordinates)
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
      $finalImage = asset('images/main/' . $image);
      $image = '';

      return $finalImage;
   }

   public function removeImage($name)
   {
      $path = public_path('images/main');
      $thumbpath = public_path('images/thumbnail');
      $listingPath  = public_path('images/listing');
      if ((file_exists($path . '/' . $name)) && (file_exists($thumbpath . '/' . $name)) && (file_exists($listingPath . '/' . $name))) {
         unlink($path . '/' . $name);
         unlink($thumbpath . '/' . $name);
         unlink($listingPath . '/' . $name);
      }
   }
}
