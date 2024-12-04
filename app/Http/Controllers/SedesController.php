<?php

namespace App\Http\Controllers;

use App\Models\Sedes;
use App\Models\Habitaciones;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\SedesResource;

class SedesController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $sedes = Sedes::all();
            if ($sedes->isEmpty()) { return $this->sendError('No se encontro sedes.'); }
            return $this->sendResponse('Listado sedes.', SedesResource::collection($sedes));
            //return response()->json(['status'=> true, 'sedes'=>$sedes], 200);
        } catch (\Throwable $th) {
            return $this->sendError('Fallo busqueda de sedes.', $th->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nombre' => 'required|unique:sedes|max:255',
            'ciudad' => 'required|max:255',
            'direccion' => 'required|max:255',
            'nit' => 'required|unique:sedes|max:50',
            'total_habitaciones' => 'required|min_digits:1|max_digits:9999',
        ]);

        if($validator->fails()){ return $this->sendError('Error validación de campos.', $validator->errors(), 442);  }

        try {
            $new_sede = Sedes::create( $input ); 
            return $this->sendResponse('Sede creada con exito!', new SedesResource($new_sede));
        } catch (\Throwable $th) {
            return $this->sendError('Ups! La sede no fue creada, intentelo nuevamente.', $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sede = Sedes::find($id);
        $habitaciones_asociadas = (Habitaciones::where('id_sedes', $id)->get())->sum('habitaciones');
        if (is_null($sede)) { 
            return $this->sendError('No se encontro esta sede.'); 
        }
        
        return $this->sendResponse('Acomodaciones de sede.', array("dataSede"=> $sede, "total"=> $sede->total_habitaciones, "asociadas"=> $habitaciones_asociadas) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $sedes = Sedes::findOrFail($id);

        $validator = Validator::make($input, [
            'nombre' => ['required', 'max:255', Rule::unique('sedes')->ignore($sedes)],
            'ciudad' => 'required|max:255',
            'direccion' => 'required|max:255',
            'nit' => ['required', 'max:50', Rule::unique('sedes')->ignore($sedes)],
            'total_habitaciones' => 'required|min_digits:1|max_digits:9999',
        ]);
   
        if($validator->fails()){ return $this->sendError('Error validación de campos.', $validator->errors(), 442);  }
   
        try {
            $sedes->update($input);
            return $this->sendResponse('Sede actualizada con exito!', new SedesResource($sedes));
        } catch (\Throwable $th) {
            return $this->sendError('Ups! La sede no fue actualizada, intentelo nuevamente.', $th->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $sede = Sedes::findOrFail($id)->delete();
            return $this->sendResponse('Sede eliminada con exito!', []);
        } catch (\Throwable $th) {
            return $this->sendError('Ups! La sede no fue eliminada, intentelo nuevamente.', $th->getMessage(), 500);
        }
    }
}
