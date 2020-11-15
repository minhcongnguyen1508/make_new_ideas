<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
  public function index(){
    $category = DB::table('categories')->get();
    $notifications = DB::table('notifications')->where('notifiable_id',Auth::id())->get();
    return view('frontend.homepage', ['category' => $category,'notifications'=> $notifications]);
  }
}
