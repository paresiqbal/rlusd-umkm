<?php

namespace App\Http\Controllers;

use App\Services\Lightcast\LightcastSkillService;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index(Request $request, LightcastSkillService $lightcastSkillService)
    {
        $query = $request->query('query') ?? 'css';

        $skils = $lightcastSkillService->searchSkill($query);

        return $skils;
    }
}
