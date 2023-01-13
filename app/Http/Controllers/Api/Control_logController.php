<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Control_log;
use Illuminate\Support\Facades\Storage;

class Control_logController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Control_log::All();

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
                'comment' => 'required',
                'attachments' => 'required|File|max:2048',
                'user_id' => 'required',
                'control_submission_id' => 'required',
                'type' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'success' => false,
                    'status' => 403,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 403);
            }

            $data = Control_log::create([
                'comment' => $request->comment,
                'attachments' => $request->file('attachments')->store('file/control_log', 'public'),
                'control_submission_id' =>   $request->control_submission_id,
                'user_id' =>  $request->user_id,
                'type' =>  $request->type,
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
        try{
            $data = Control_log::where('id', $id)->first();

            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => $data,
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
            $data = Control_log::find($id);

            $data->comment = $request->comment ? $request->comment : $data->comment;
            $data->type = $request->type ? $request->type : $data->type;
            // $data->attachments = $request->attachments ? $request->attachments : $data->attachments;
            $data->user_id = $request->user_id ? $request->user_id : $data->user_id;
            $data->control_submission_id = $request->control_submission_id ? $request->control_submission_id : $data->control_submission_id;
            
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
            $path = Control_log::find($id)->attachments;
            Storage::delete('public/'.$path);
            $data = Control_log::destroy($id);
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
