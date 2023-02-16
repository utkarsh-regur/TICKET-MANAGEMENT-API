<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\Project as ProjectResource;

class ProjectController extends Controller
{
/**
     * @OA\Get(
     *     path="/api/projects",
     *     tags={"Projects"},
     *     summary="Get all projects",
     *     description="Get all projects",
     *     operationId="index",
     *     security={{"passport": {}},},
     *     @OA\Response(
     *         response=200,
     *         description="All projects fetched successfully",
     *         @OA\MediaType(
     *           mediaType="application/json",
     *          )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error in fetching projects"
     *     )
     * )
     */
    public function index()
    {
        $projects = Project::all();

        return response()->json([
            'status'=>true,
            'projects'=> $projects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

 /**
     * @OA\Post(
     *     path="/api/projects/new",
     *     tags={"Projects"},
     *     summary="Create a new project",
     *     description="Create a new project",
     *     operationId="store",
     *     security={{"passport": {}},},
     *      @OA\RequestBody(
     *      required=true,   
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string"
     *                      ),
     *                 ),
     *                 example={
     *                     "title":"Project title",
     *                     "description":"Project description",
     *                }
     *             )
     *         )
     *      ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Project created successfully",
     *         @OA\MediaType(
     *           mediaType="application/json",
     *          )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error in creating project"
     *     )
     * )
     */
    public function store(ProjectRequest $request)
    {
        $project = Project::create($request->all());
        return response()->json([
            'status'=>true,
            'message'=>'Project created succesfully',
            'project'=>$project
        ], 200);
    }

/**
     * @OA\Get(
     *     path="/api/projects/{projectId}",
     *     tags={"Projects"},
     *     summary="Get a projects",
     *     description="Get a projects",
     * security={{"passport": {}},},
     *     @OA\Parameter(
    *       description="ID of Project",
    *       in="path",
    *       name="projectId",
    *       required=true,
    *       example="1",
    *       @OA\Schema(
    *       type="integer",
    *       format="int64"
    *       )
    *       ),
     *     operationId="show",
     *     @OA\Response(
     *         response=200,
     *         description="All projects details fetched successfully",
     *               @OA\MediaType(
     *           mediaType="application/json",
     *          )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error in fetching user details"
     *     )
     * )
     */
    public function show($id)
    {
        $project = Project::find($id);
        if (is_null($project)) {
            return $this->sendError('Project does not exist.');
        }

        return response()->json([
            'status'=>true,
            'message'=>'Project loaded succesfully',
            'project'=>new ProjectResource($project)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

 /**
     * @OA\Put(
     *     path="/api/projects/edit/{projectId}",
     *     tags={"Projects"},
     *     summary="Update a project",
     *     description="Update a project",
     *     operationId="update",
     *     security={{"passport": {}},},
     *      @OA\Parameter(
    *       description="ID of Project",
    *       in="path",
    *       name="projectId",
    *       required=true,
    *       example="1",
    *       @OA\Schema(
    *       type="integer",
    *       format="int64"
    *       )
    *       ),
     *      @OA\RequestBody(
     *      required=true,   
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string"
     *                      ),
     *                 ),
     *                 example={
     *                     "title":"New Project title",
     *                     "description":"New Project description",
     *                }
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Project updated successfully",
     *         @OA\MediaType(
     *           mediaType="application/json",
     *          )
     *      
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error in updating project"
     *     )
     * )
     */
    public function update(ProjectRequest $request, Project $project, $id)
    {
        $projects = Project::all();
        $project = Project::find($id);
        
        if (is_null($project)) {
             return response()->json([
            'error'=>'Project does not exist',
            'projects'=> $projects
        ]);
    }
        $project->update($request->all());
        return response()->json([
            'status'=>true,
            'message'=>'Project updated succesfully',
            'project'=>$project
        ], 200);
        
    }


    /**
     * @OA\Delete(
     *     path="/api/projects/delete/{projectId}",
     *     tags={"Projects"},
     *     summary="Delete a project",
     *     description="Delete a project",
     *     operationId="destroy",
     *     security={{"passport": {}},},
     *     @OA\Parameter(
    *       description="ID of Project",
    *       in="path",
    *       name="projectId",
    *       required=true,
    *       example="1",
    *       @OA\Schema(
    *       type="integer",
    *       format="int64"
    *       )
    *       ),
     *     @OA\Response(
     *         response=200,
     *         description="Project deleted successfully",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *          )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error in deleting project"
     *     )
     * )
     */
    public function destroy(Project $project, $id)
    {
        $project = Project::find($id);
        $projects = Project::all();

        if (is_null($project)) {
             return response()->json([
            'error'=>'Project does not exist',
            'projects'=> $projects
        ]);

        }

        $project->delete();
        return response()->json([
            'status'=>true,
            'message'=>'Project deleted succesfully',
        ], 200);
    }
}
