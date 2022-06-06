<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','barcode','cost','price','stock','alerts','image','category_id'];

    //obtener la relacion en ambas partes
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getImagenAttribute(){
        if(file_exists('storage/products/' . $this->image))
        return $this->image;
        else
        return 'noimage.jpg';
    }
}
