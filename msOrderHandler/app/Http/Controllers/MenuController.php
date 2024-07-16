<?php

namespace App\Http\Controllers;

use App\Services\MenuService;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{

    private $menuService;
    public function __construct()
    {
        $this->menuService = new MenuService();
    }
    public function __invoke()
    {
        try {
            $dishes = $this->menuService->getDishes();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json($dishes, 200);
    }
}
