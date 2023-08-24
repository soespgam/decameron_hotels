<?php

namespace App\Http\Controllers;
use App\Models\hotels;
use Illuminate\Http\Request;

class hotelsController extends Controller
{
    public function get_hotels()
    {
        $hotels= hotels::all();
        return response()->json($hotels);
    }

    public function create_hotel(Request $request)
    {
        try {
            $hotel = new hotels;
            $hotel->name = $request->name;
            $hotel->city = $request->city;
            $hotel->address = $request->address;
            $hotel->capacity = $request->capacity;
            $hotel->nit = $request->nit;
            $hotel->estandar = $request->estandar;
            $hotel->junior = $request->junior;
            $hotel->suite = $request->suite;
            $hotel->ava_estandar = $request->ava_estandar;
            $hotel->ava_junior = $request->ava_junior;
            $hotel->ava_suite = $request->ava_suite;
            $hotel->save();
            return response()->json($hotel);
        } catch (\Throwable $th) {
            $res ="el hotel ya existe";
            return response()->json([
                'message'=> $res
            ], 501);
        }
        
    }
    
    public function get_hotel_by_id($id){
        $hotel_by_id= hotels::find($id);
        return response()->json($hotel_by_id);
    }

}
