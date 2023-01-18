<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Organization::All();
        return response()->json([
            'success' => true,
            'status' => 200,
            'data' => ['organizations' => $data],
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
                'address' => 'required',
                'state' => 'required',
                'city' => 'required',
                'logo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'timezone' => 'required',
                'currency' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'success' => false,
                    'status' => 403,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 403);
            }

            $data = Organization::create([
                'name' => $request->name,
                'description' => $request->description,
                'state' => $request->state,
                'city' => $request->city,
                'logo' => $request->file('logo')->store('file/orgs', 'public'),
                'timezone' => $request->timezone,
                'currency' => $request->currency,
                'address' => $request->address
            ]);

            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => ['organization' => $data]
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
        try {
            
            $data = Organization::where('id', $id)->with('users', 'incident_reports')->get();
            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => $data
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
            $data = Organization::find($id);

            $data->name = $request->name ? $request->name : $data->name;
            $data->address = $request->address ? $request->address : $data->address;
            $data->description = $request->description ? $request->description :  $data->description;
            $data->state = $request->state ? $request->state : $data->state;
            $data->city = $request->city ? $request->city : $data->city;
            $data->logo = $request->logo ? $request->logo : $data->logo;
            $data->timezone = $request->timezone ? $request->timezone : $data->timezone;
            $data->currency = $request->currency ? $request->currency : $data->currency;
            
            $data->save();
            
            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => ['organization' => $data],
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
            $path = Organization::find($id)->logo;
            Storage::delete('public/'.$path);
            
            $data = Organization::destroy($id);
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
