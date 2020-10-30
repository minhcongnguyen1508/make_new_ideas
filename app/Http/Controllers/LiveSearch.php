<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LiveSearch extends Controller
{
    
    function action(Request $request){
        $output = '';
        if($request->ajax()){
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('posts')
                        ->where('title', 'like', '%'.$query.'%')
                        ->get();
            } 


            $total_row = $data->count();
            
            if($total_row > 0){
                foreach($data as $row){
                    $output .= '<a href="" class="search-link">'.$row->title.'</a><hr>';
                } 
                
            } else {
                $output = '<p> No data found ahihi</p>';
            }

         

            $data = array(
                'result_data'=>$output,

            );

            echo json_encode($data);
        }

        
    }
}