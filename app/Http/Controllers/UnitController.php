<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit; // Ensure you have a Unit model

class UnitController extends Controller
{
    public function index()
    {
        // Fetch units from the database
        $units = Unit::all(); // Adjust this query as needed

        // Return the view with units data
        return view('projectt.mnitem.page', compact('units'));
    }
}
