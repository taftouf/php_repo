<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questionnaire;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
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

            if($questionnaire->count() != count($data)){
                return response()->json([
                            'success' => false,
                            'status' => 403,
                            'message' => 'invalid data'
                        ], 403);
            }
    
            $i = 0;
            while (count($data) > $i) {
                if(!$questionnaire->find($data[$i]->question_id)){
                    return response()->json([
                        'success' => false,
                        'status' => 403,
                        'message' => 'invalid data'
                    ], 403);
                }else if(($questionnaire->find($data[$i]->question_id)->isMultiple == 0 && count($data[$i]->answers) != 1) || count($data[$i]->answers) < 1){
                    return response()->json([
                        'success' => false,
                        'status' => 403,
                        'message' => 'invalid data'
                    ], 403);
                }
                $i++;
            }
            
            $i = 0;
            while (count($data) > $i) {
                $questionnaire->find($data[$i]->question_id)->organizations()->attach($org_id, [
                    "user_id" => $user_id,
                    "answers" => $data[$i]->answers
                ]);
                $i++;
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

            $data = DB::select('select * from organization_questionnaire where user_id='.$user_id.' and organization_id='.$org_id);
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
}