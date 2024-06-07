<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terraceria extends Model
{
    use HasFactory;

    protected $fillable = ['name','barcode','price', 'image'];

    public function getImageAttribute($image)
    {

        if ($image && file_exists('storage/' . $image))
            return $image;
        else
            return 'terracerias/noimage.png';
    }
}
