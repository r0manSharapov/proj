<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Item;
  
class SearchController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data = User::select("email")
                ->where("email","LIKE","%{$request->input('query')}%")
                ->get();
        $dataModified = array();
        foreach ($datas as $data)
        {
            $dataModified[] = $data->email;
        }
    
        return response()->json($dataModified);
    }
}