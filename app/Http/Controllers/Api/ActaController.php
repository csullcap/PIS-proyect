<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Acta;
use Dotenv\Validator;

class ActaController extends Controller
{

    public function create(Request $request)
    {
        $request = Validator::make($request->all(), [
            'titulo' => 'required',
            'fecha' => 'required',
            'id_estandar' => 'required|exists:estandars,id',
            'file' => 'required',
        ]);

        if ($request->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Se necesita llenar todos los campos',
                'data' => $request->errors()
            ], 400);
        }

        $user = auth()->user();
        if (!($user->isAdmin() or $user->isEncargadoEstandar($request->id_estandar))) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para crear una acta',
            ], 401);
        }
        $acta = new Acta();
        $acta->titulo = $request->titulo;
        $acta->fecha = $request->fecha;
        $acta->id_estandar = $request->id_estandar;
        $acta->file = $request->file;
        $acta->save();
        return response()->json([
            'success' => true,
            'message' => 'Acta creada',
            'data' => $acta
        ], 200);
    }

    public function showActa($id)
    {
        $acta = Acta::find($id);
        if ($acta) {
            return response()->json([
                'success' => true,
                'message' => 'Acta encontrada',
                'data' => $acta
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Acta no encontrada',
                'data' => ''
            ], 404);
        }
    }

    public function listActas()
    {
        $actas = Acta::all();
        return response()->json([
            'success' => true,
            'message' => 'Actas encontradas',
            'data' => $actas
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request = Validator::make($request->all(), [
            'titulo' => 'present',
            'fecha' => 'present',
            'id_estandar' => 'present|exists:estandars,id',
            'file' => 'present',
        ]);

        $acta = Acta::find($id);
        if (!$acta) {
            return response()->json([
                'success' => false,
                'message' => 'Acta no encontrada',
            ], 404);
        }


        if ($request->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Se produjo un error al actualizar la acta',
                'data' => $request->errors()
            ], 400);
        }

        $user = auth()->user();
        if (!($user->isAdmin() or $user->isEncargadoEstandar($request->id_estandar))) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para actualizar una acta',
            ], 401);
        }

        $acta->titulo = isset($request->titulo) ? $request->titulo : $acta->titulo;
        $acta->fecha = isset($request->fecha) ? $request->fecha : $acta->fecha;
        $acta->id_estandar = isset($request->id_estandar) ? $request->id_estandar : $acta->id_estandar;
        $acta->file = isset($request->file) ? $request->file : $acta->file;
        $acta->save();

        return response()->json([
            'success' => true,
            'message' => 'Acta actualizada',
            'data' => $acta
        ], 200);
    }

    public function delete($id)
    {
        $acta = Acta::find($id);
        if (!$acta) {
            return response()->json([
                'success' => false,
                'message' => 'Acta no encontrada',
                'data' => ''
            ], 404);
        }

        $user = auth()->user();
        if (!($user->isAdmin() or $user->isEncargadoEstandar($acta->id_estandar))) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para eliminar una acta',
            ], 401);
        }

        $acta->delete();
        return response()->json([
            'success' => true,
            'message' => 'Acta eliminada',
        ], 200);
    }
}
