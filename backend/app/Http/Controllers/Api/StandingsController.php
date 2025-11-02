<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\IStandingsService;

class StandingsController extends Controller
{
    protected $standingsService;

    public function __construct(IStandingsService $standingsService)
    {
        $this->standingsService = $standingsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json([
                'message' => 'Clasificacion Recuperada con éxito',
                'data' => $this->standingsService->get(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al recuperar la clasificación',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
