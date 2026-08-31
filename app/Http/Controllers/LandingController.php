<?php

namespace App\Http\Controllers;

use App\Services\LandingService;
use Inertia\Inertia;
use Inertia\Response;

class LandingController extends Controller
{
    public function __invoke(LandingService $landingService): Response
    {
        return Inertia::render('Welcome', $landingService->getLandingData());
    }
}
