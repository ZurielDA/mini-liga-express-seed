<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\AlreadyExistsException;
use App\Http\Controllers\Controller;
use App\Interfaces\Services\ISportMatchService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SportMatchController extends Controller
{
    protected $sportMatchService;

    public function __construct(ISportMatchService $sportMatchService)
    {
        $this->sportMatchService = $sportMatchService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json([
                'message' => 'Partidos recuperados con éxito',
                'data' => $this->sportMatchService->getAll(),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al recuperar los partidos',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function pending()
    {
        try {
            return response()->json([
                'message' => 'Partidos recuperados con éxito',
                'data' => $this->sportMatchService->getPending(),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al recuperar los partidos',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request)
    {
        try {
            $request->validate([
                'home_team_id' => 'required|int',
                'away_team_id' => 'required|int',
                'played_at' => 'required|date',
            ]);

            $newTeam = $this->sportMatchService->save($request->only([
                'home_team_id',
                'away_team_id',
                'played_at',
            ]));

            return response()->json([
                'message' => 'Partido guardado con exito',
                'data' => $newTeam,
            ], 200);

        } catch (AlreadyExistsException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e->getMessage(),
            ], 409);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al guardar el partido',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function result(Request $request, string $id)
    {
        try {
            $request->merge(['id' => $id]);

            $request->validate([
                'id' => 'required|integer',
                'home_score' => 'required|int',
                'away_score' => 'required|int',
            ]);

            $newSportMatch = $this->sportMatchService->update($request->id, $request->only(['home_score', 'away_score']));

            return response()->json([
                'message' => 'Partido actualizado con exito',
                'data' => $newSportMatch,
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el Partido',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
