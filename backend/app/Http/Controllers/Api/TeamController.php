<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\AlreadyExistsException;
use App\Http\Controllers\Controller;
use App\Interfaces\Services\ITeamService;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    protected $teamService;

    public function __construct(ITeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json([
                'message' => 'Equipos Recuperados con éxito',
                'data' => $this->teamService->getAll(),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al recuperar los equipos',
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
                'name' => 'required|string|min:3|max:50',
            ]);

            $newTeam = $this->teamService->save($request->only(['name']));

            return response()->json([
                'message' => 'Equipo creado con exito',
                'data' => $newTeam,
            ], 200);

        } catch (AlreadyExistsException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e->getMessage(),
            ], 409);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al guardar el equipo',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
