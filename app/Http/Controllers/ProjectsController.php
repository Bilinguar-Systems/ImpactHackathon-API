<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProjectsController extends Controller
{
    public function createProject(Request $request) {
        $validatedData = $request->validate([
            'item_code' => 'required|unique:projects|max:255',
            'project' => 'required|max:255',
            'location' => 'nullable|max:255',
            'hectars' => 'nullable',
        ]);

        return Project::create([
            'user_id' => Auth::user()->id,
            'item_code' => $request->item_code,
            'project' => $request->project,
            'location' => $request->location,
            'hectars' => $request->hectars,
        ]);

    }

    public function getProject($project_id) {
        return Project::where('id', '=', $project_id)->first();
    }

    public function searchProject(Request $request) {
        $term = $request->get('term', '');

        return Project::where('project', 'like', '%'. $term . '%')->paginate(10);
    }

    public function deleteProject($project_id) {
        $project = Project::where('id', '=', $project_id)->firstOrFail();

        if ($project_id->user_id != Auth::user()->id) {
            return response(null, Response::HTTP_FORBIDDEN);
        }

        $project->delete();

        return $project;
    }
}
