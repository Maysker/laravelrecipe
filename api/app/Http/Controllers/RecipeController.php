<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe; // Import the Recipe model if you haven't done it already

class RecipeController extends Controller
{
    public function index()
    {
        // Get a list of recipes from the database
        $recipes = Recipe::all(['MainImagePath', 'Title', 'Description']);
        
        // Return the list of recipes in JSON format
        return response()->json($recipes);
    }
}
