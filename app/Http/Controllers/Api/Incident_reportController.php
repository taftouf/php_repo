<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incident_report;
use Illuminate\Support\Facades\Validator;

class Incident_reportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = Incident_report::All();
            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => ['incident_reports' => $data],
                'count' => $data->count()
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
                'title' => 'required',
                'report' => 'required',
                'rootCause' => 'required',
                'correctiveAction' => 'required',
                'startTime' => 'required',
                'endTime' => 'required',
                'nbCaliforniaIndividualsAffected' => 'required|numeric',
                'contactFirstName' => 'required',
                'contactLastName' => 'required',
                'contactPhone' => 'required',
                'contactEmail' => 'required|email',
                'contactTitle' => 'required',
                'organization_id' => 'required',
                'user_id' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'success' => false,
                    'status' => 403,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 403);
            }

            $event = Incident_report::create([
                'title' => $request->title,
                'report' => $request->report,
                'rootCause' => $request->rootCause,
                'correctiveAction' => $request->correctiveAction,
                'startTime' =>  $request->startTime,
                'endTime' =>  $request->endTime,
                'nbCaliforniaIndividualsAffected' =>  $request->nbCaliforniaIndividualsAffected,
                'contactFirstName' =>  $request->contactFirstName,
                'contactLastName' =>  $request->contactLastName,
                'contactPhone' =>  $request->contactPhone,
                'contactEmail' =>  $request->contactEmail,
                'contactTitle' =>  $request->contactTitle,
                'organization_id' =>  $request->organization_id,
                'user_id' =>  $request->user_id,
            ]);

            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => $event
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
        try{
            $data = Incident_report::where('id', $id)->first();
            $incident_report_comments = Incident_report::find($id)->incident_report_comments;

            return response()->json([
                'success' => true,
                'status' => 200,
                'incident_report' => $data,
                'incident_report_comment' => $incident_report_comments,
            ], 200);
        }catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
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
            $data = Incident_report::find($id);

            $data->title = $request->title ? $request->title : $data->title;
            $data->report = $request->report ? $request->report : $data->report;
            $data->rootCause = $request->rootCause?$request->rootCause:$data->rootCause;
            $data->correctiveAction = $request->correctiveAction ? $request->correctiveAction : $data->correctiveAction;
            $data->startTime = $request->startTime ? $request->startTime :  $data->startTime;
            $data->endTime = $request->endTime ? $request->endTime : $data->endTime;
            $data->nbCaliforniaIndividualsAffected = $request->nbCaliforniaIndividualsAffected ? $request->nbCaliforniaIndividualsAffected : $data->nbCaliforniaIndividualsAffected;
            $data->contactFirstName = $request->contactFirstName ? $request->contactFirstName : $data->contactFirstName;
            $data->contactLastName = $request->contactLastName ? $request->contactLastName : $data->contactLastName;
            $data->contactPhone = $request->contactPhone ? $request->contactPhone : $data->contactPhone;
            $data->contactEmail = $request->contactEmail ? $request->contactEmail : $data->contactEmail;
            $data->contactTitle = $request->contactTitle ? $request->contactTitle : $data->contactTitle;
            $data->organization_id = $request->organization_id ? $request->organization_id : $data->organization_id;
            $data->user_id = $request->user_id ? $request->user_id : $data->user_id;
            
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
            $data = Incident_report::destroy($id);
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
