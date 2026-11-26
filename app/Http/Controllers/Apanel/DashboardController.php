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
        $projects = Project::with(['contributors', 'techStackItems'])
            ->orderByDesc('year')
            ->orderByDesc('id')
            ->get();

        return view('apanel.dashboard', [
            'user' => Auth::user(),
            'projects' => $projects,
            'projectCount' => $projects->count(),
            'publishedCount' => $projects->where('is_published', true)->count(),
            'draftCount' => $projects->where('is_published', false)->count(),
            'contributorCount' => ProjectContributor::count(),
            'fieldPostCount' => FieldPost::count(),
            'availableYears' => $projects->pluck('year')->unique()->sortDesc()->values(),
        ]);
    }
}
