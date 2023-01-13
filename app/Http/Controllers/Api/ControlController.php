<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Control;
use Illuminate\Support\Facades\Validator;

class ControlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Control::All();
        return response()->json([
            'success' => true,
            'status' => 200,
            'data' => $data,
            'count' => $data->count()
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
                'name' => 'required',
                'description' => 'required',
                'category' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'success' => false,
                    'status' => 403,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 403);
            }

            $data = Control::create([
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
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
        $data = Control::find($id);

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
            $data = control::find($id);

            $data->name = $request->name ? $request->name : $data->name;
            $data->description = $request->description ? $request->description : $data->description;
            $data->category = $request->category ? $request->category : $data->category;
            
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
           
            $data = Control::destroy($id);
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
