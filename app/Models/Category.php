<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = ['name','image'];

    //Para poder eliminar con relaciones de tablas
    //obtener la relacion en ambas partes
    public function products(){
        return $this->hasMany(Product::class);
    }

    public function getImagenAttribute(){
        if(file_exists('storage/categories/' . $this->image))
        return $this->image;
        else
        return 'noimage.jpg';
    }


}
