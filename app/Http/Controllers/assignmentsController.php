<?php

namespace App\Http\Controllers;
use App\Models\assignments;
use App\Models\hotels;
use Illuminate\Http\Request;
use DB;

class assignmentsController extends Controller
{
    public function get_assignment(Request $request)
    {
        $assignments= DB::select(
            'SELECT count(assignments.type_room) as cantidad, assignments.type_room ,assignments.type_accommodation 
             FROM assignments
             WHERE assignments.fk_hotel ='.$request->fk_hotel.'
             GROUP BY assignments.type_accommodation,assignments.type_room');
        return response()->json($assignments);
    }

    public function validate_type_assignment($type_room ,$type_assignment){
        $validate_assignment = true;

        if($type_room == 'estandar' && ($type_assignment == 'triple' || $type_assignment == 'cuadruple')){
            $validate_assignment = false;
        }else

        if($type_room == 'junior' && ($type_assignment== 'sencilla' || $type_assignment== 'doble')){
            $validate_assignment = false;
        }else

        if($type_room == 'suite' && $type_assignment== 'cuadruple'){
            $validate_assignment = false;
        }
        
        return $validate_assignment;
    }

    public function newAssigment($type_room,$type_accommodation,$fk_hotel){
        $assigment = new assignments;
        $assigment->type_room = $type_room;
        $assigment->type_accommodation = $type_accommodation;
        $assigment->fk_hotel = $fk_hotel;
        $assigment->save();
    }

    public function create_assigment(Request $request)
    {
        
        $id =$request->fk_hotel;
        $validateAssignment=$this->validate_type_assignment( $request->type_room ,$request->type_accommodation);
        $hotel_by_id= hotels::find($id);
        if($validateAssignment){
            $capacidad = $hotel_by_id->ava_estandar + $hotel_by_id->ava_junior+ $hotel_by_id->ava_suite;

            if($capacidad == 0){
                $res ="el hotel esta en su maxima capacidad , intenta con otro hotel";
                return response()->json([
                    'message'=> $res
                ], 201);
            }else{
                if($request->type_room == 'estandar' && $hotel_by_id->ava_estandar >0){
                    $this->newAssigment($request->type_room,$request->type_accommodation,$request->fk_hotel);
                    hotels::where('id', $id)->update(['ava_estandar' => $hotel_by_id->ava_estandar-1]);
                    $res ="se asigno una habitacion ,quedan".($hotel_by_id->ava_estandar-1)."disponibles";
                    return response()->json([
                        'message'=> $res
                    ], 200);

                }else if($request->type_room == 'junior' && $hotel_by_id->ava_junior >0){
                    $this->newAssigment($request->type_room,$request->type_accommodation,$request->fk_hotel);
                    hotels::where('id', $id)->update(['ava_junior' => $hotel_by_id->ava_junior-1]);

                    $res ="se asigno una habitacion ,quedan".($hotel_by_id->ava_junior-1)."disponibles";
                    return response()->json([
                        'message'=> $res
                    ], 200);


                }else if($request->type_room == 'suite' && $hotel_by_id->ava_suite >0){
                    $this->newAssigment($request->type_room,$request->type_accommodation,$request->fk_hotel);
                    hotels::where('id', $id)->update(['ava_suite' => $hotel_by_id->ava_suite-1]);

                    $res ="se asigno una habitacion ,quedan".($hotel_by_id->ava_suite-1)."disponibles";
                    return response()->json([
                        'message'=> $res
                    ], 200);

                }else{
                    $res = "este tipo de asignacion no esta disponoble , intenta con otro tipo, hay : ";
                    return response()->json([
                        'message'=> $res,
                        'ava_junior' =>  $hotel_by_id->ava_junior,
                        'ava_estandar' => $hotel_by_id->ava_estandar,
                        'ava_suite' => $hotel_by_id->ava_suite
                    ], 201);
                }
            }
        }else {
            $res ="asignacion incorrecta";
            return response()->json([
                'message'=> $res
            ], 201);
        }
    }
}
