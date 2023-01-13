<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incident_report_comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class Incident_report_commentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = Incident_report_comment::All();
            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => ['Incident_report_comments' => $data],
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
                'comment' => 'required',
                'attachments' => 'required|File|max:2048',
                'user_id' => 'required',
                'incident_report_id' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'success' => false,
                    'status' => 403,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 403);
            }

            $incident_report_comment = Incident_report_comment::create([
                'comment' => $request->comment,
                'attachments' => $request->file('attachments')->store('file/report_comment', 'public'),
                'incident_report_id' =>   $request->incident_report_id,
                'user_id' =>  $request->user_id,
            ]);

            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => ['incident_report_comment' => $incident_report_comment]
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
            $data = Incident_report_comment::where('id', $id)->first();

            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => ['Incident_report_comment' => $data],
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
            $data = Incident_report_comment::find($id);

            $data->comment = $request->comment ? $request->comment : $data->comment;
            // $data->attachments = $request->attachments ? $request->attachments : $data->attachments;
            $data->user_id = $request->user_id ? $request->user_id : $data->user_id;
            $data->incident_report_id = $request->incident_report_id ? $request->incident_report_id : $data->incident_report_id;
            
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
            $path = Incident_report_comment::find($id)->attachments;
            Storage::delete('public/'.$path);
            $data = Incident_report_comment::destroy($id);
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
