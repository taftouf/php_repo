<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Control_submission;

class Control_submissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Control_submission::All();

        return response()->json([
            'success' => true,
            'status' => 200,
            'data' => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'control_id' => 'required',
                'organization_id' => 'required',
                'assignedTo' => 'required',
                'riskLevel' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'success' => false,
                    'status' => 403,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 403);
            }

            $data = Control_submission::create([
                'control_id' => $request->control_id,
                'organization_id' => $request->organization_id,
                'assignedTo' => $request->assignedTo,
                'riskLevel' => $request->riskLevel,

            ]);

            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Control_submission::find($id);

        return response()->json([
            'success' => true,
            'status' => 200,
            'data' => $data,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $data = control_submission::find($id);

            $data->control_id = $request->control_id ? $request->control_id : $data->control_id;
            $data->organization_id = $request->organization_id ? $request->organization_id : $data->organization_id;
            $data->assignedTo = $request->assignedTo ? $request->assignedTo : $data->assignedTo;
            $data->riskLevel = $request->riskLevel ? $request->riskLevel : $data->riskLevel;
            
            $data->save();
            
            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => $data,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
           
            $data = Control_submission::destroy($id);
            if($data)
                return response()->json([
                    'success' => true,
                    'status' => 200,
                ], 200); 
            else
                return response()->json([
                    'success' => false,
                    'message' => 'not found',
                    'status' => 403,
                ], 403);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
