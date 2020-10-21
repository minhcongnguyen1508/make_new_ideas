<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Use App\Models\Category;

class HomepageController extends Controller
{
  public function index(){
    $category = DB::table('categories')->get();
    
    return view('frontend.homepage', ['category' => $category]);
  }
}
