<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
