<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::All();
        return response()->json([
            'success' => true,
            'status' => 200,
            'data' => $events,
            'count' => $events->count()
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
                'title' => 'required',
                'address' => 'required',
                'startTime' => 'required',
                'endTime' => 'required',
                'color' => 'required',
                'note' => 'required',
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

            $event = Event::create([
                'title' => $request->title,
                'address' => $request->address,
                'startTime' => $request->startTime,
                'endTime' => $request->endTime,
                'color' =>$request->color,
                'note' => $request->note,
                'organization_id' => $request->organization_id,
                'user_id' => $request->user_id
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
        try {
            $event = Event::where('id', $id)->first();
            
            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => $event,
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
            $event = Event::find($id);

            $event->title = $request->title?$request->title:$event->title;
            $event->address = $request->address ? $request->address : $event->address;
            $event->startTime = $request->startTime ? $request->startTime :  $event->startTime;
            $event->endTime = $request->endTime ? $request->endTime : $event->endTime;
            $event->color = $request->color ? $request->color : $event->color;
            $event->note = $request->note ? $request->note : $event->note;
            $event->organization_id = $request->organization_id ? $request->organization_id : $event->organization_id;
            $event->user_id = $request->user_id ? $request->user_id : $event->user_id;
            
            $event->save();
            
            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => $event,
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
            $event = Event::destroy($id);
            if($event)
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
