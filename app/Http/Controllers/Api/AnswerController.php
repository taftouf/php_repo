<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questionnaire;
use App\Models\Organization;

use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function set_user_answers(Request $request, $org_id, $user_id)
    {
        try{
            $questionnaire = Questionnaire::all();
            $data = json_decode($request->getContent());

            for ($i=0; $i < $questionnaire->count(); $i++) { 
                if($questionnaire[$i]->id == $data[$i]->question_id){
                    $questionnaire[$i]->organizations()->attach($org_id, [
                        "user_id" => $user_id,
                        "answers" => $data[$i]->answers
                    ]);
                }else
                    return response()->json([
                        'success' => false,
                        'status' => 403,
                        'message' => 'invalid data'
                    ], 403);
                
            }
           
            return response()->json([
                'success' => true,
                'status' => 200,
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function get_user_answers($org_id, $user_id){
        try{
            $org = Organization::find(2);
             
             $data = $org->with('questionnaires')->find($org_id);

            return $data->questionnaires;
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
