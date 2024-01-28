<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    // Specifying the primary key and table name
    protected $primaryKey = 'RecipeID';
    protected $table = 'Recipe';

    // Attributes that are mass assignable
    protected $fillable = [
        'Title', 
        'Description',
        'MainImagePath', 
        // Specify other columns here that you want to allow for mass assignment
    ];

    // Disabling timestamps if they are not used
    public $timestamps = false;

    // Hiding attributes when serializing the model
    protected $hidden = [
        // Specify fields here that should be hidden
    ];

    // Casting types for model attributes
    protected $casts = [
        // Specify type casting for fields here if needed
    ];
}
