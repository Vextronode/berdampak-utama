<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function show(string $slug): View
    {
        $project = Project::published()
            ->with('contributors')
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProjects = Project::published()
            ->where('id', '!=', $project->id)
            ->orderByDesc('year')
            ->take(2)
            ->get();

        return view('projects.show', compact('project', 'relatedProjects'));
    }
}
