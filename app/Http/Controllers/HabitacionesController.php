<?php

namespace App\Http\Controllers;

use App\Models\Habitaciones;
use App\Models\Sedes;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\HabitacionesResource;

class HabitacionesController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $habitaciones = Habitaciones::all();
            return $this->sendResponse('Listado acomodaciones.', HabitacionesResource::collection($habitaciones));
        } catch (\Throwable $th) {
            return $this->sendError('No existen acomodaciones.', $th->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'id_sedes' => 'required',
            'tipo' => ['required', 'max:124', Rule::unique('tipo_habitaciones_sedes')->where('id_sedes', $input['id_sedes'])],
            'habitaciones' => 'required|min_digits:1|max_digits:9999',
        ]);

        if($validator->fails()){ return $this->sendError('Error validación de campos.', $validator->errors(), 442);  }

        try {
            $new_habitacion = Habitaciones::create( $input ); 
            return $this->sendResponse('Acomodación creada con exito!', new HabitacionesResource($new_habitacion));
        } catch (\Throwable $th) {
            return $this->sendError('Ups! La acomodación no fue creada, intentelo nuevamente.', $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $habitaciones = Habitaciones::where('id_sedes', $id)->get();
        if ($habitaciones->isEmpty()) { 
            return $this->sendError('No se encontro acomodación para esta sede.'); 
        }

        return $this->sendResponse('Resultado de acomodación por sede.', HabitacionesResource::collection($habitaciones));
    }

    /**
     * Display the specified resource.
     */
    public function edit($id)
    {
        $habitacion = Habitaciones::find($id);
        if (is_null($habitacion)) { 
            return $this->sendError('No se encontro esta acomodación.'); 
        }
        
        $sede = Sedes::find($habitacion->id_sedes);
        $habitaciones_asociadas = (Habitaciones::where('id_sedes', $habitacion->id_sedes)->get())->sum('habitaciones');
 
        return $this->sendResponse('Acomodacion de sede.', array("dataAcomodacion"=> $habitacion, "total"=> $sede->total_habitaciones, "asociadas"=> $habitaciones_asociadas) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $habitacion = Habitaciones::findOrFail($id);

        $validator = Validator::make($input, [
            'tipo' => ['required', 'max:124', Rule::unique('tipo_habitaciones_sedes')->where('id_sedes', $habitacion->id_sedes)->ignore($habitacion)],
            'habitaciones' => 'required|min_digits:1|max_digits:9999',
        ]);
   
        if($validator->fails()){ return $this->sendError('Error validación de campos.', $validator->errors(), 442);  }
   
        try {
            $habitacion->update($input);
            return $this->sendResponse('Acomodación actualizada con exito!', new HabitacionesResource($habitacion));
        } catch (\Throwable $th) {
            return $this->sendError('Ups! La acomodación no fue actualizada, intentelo nuevamente.', $th->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $habitacion = Habitaciones::findOrFail($id)->delete();
            return $this->sendResponse('Acomodación eliminada con exito!', []);
        } catch (\Throwable $th) {
            return $this->sendError('Ups! La acomodación no fue eliminada, intentelo nuevamente.', $th->getMessage(), 500);
        }
    }
}
