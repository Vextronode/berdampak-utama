<?php

namespace App\Http\Controllers\Apanel;

use App\Http\Controllers\Controller;
use App\Models\FieldPost;
use App\Models\Project;
use App\Models\ProjectContributor;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the administration panel dashboard.
     */
    public function index(): View
    {
        return view('apanel.dashboard', [
            'user' => Auth::user(),
            'projectCount' => Project::count(),
            'contributorCount' => ProjectContributor::count(),
            'fieldPostCount' => FieldPost::count(),
        ]);
    }
}

