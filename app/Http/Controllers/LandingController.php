<?php

namespace App\Http\Controllers;

use App\Models\FieldPost;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(Request $request): View
    {
        $selectedYear = $request->query('year', 'semua');

        $availableYears = Project::published()
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();

        $projects = Project::published()
            ->with(['contributors' => function ($q) {
                $q->orderBy('sort_order');
            }])
            ->orderByDesc('year')
            ->orderBy('id')
            ->get();

        $fieldPosts = FieldPost::latest('activity_date')
            ->take(3)
            ->get();

        return view('landing', compact(
            'projects',
            'fieldPosts',
            'availableYears',
            'selectedYear'
        ));
    }
}
