<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Candidate;

class CandidatesController extends Controller
{
    public function index(){
        return response()->json(Candidate::get(),200);     
    }

    public function show($id){
        $candidate = Candidate::find($id);
        if(is_null($candidate)){
            return response()->json('Record not found',404);
        }
        return response()->json($candidate, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),$this->validator());
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $candidate = Candidate::create($request->all());
        return response()->json($candidate,201);   
    }

    public function update(Request $request, $id){
        $candidate = Candidate::find($id);
        if(is_null($candidate)){
            return response()->json('Record not found',404);
        }
        $candidate->update($request->all());
        return response()->json($candidate,200);
    }

    public function destroy(Request $request, $id){
        $candidate = Candidate::find($id);
        if(is_null($candidate)){
            return response()->json('Record not found',404);
        }
        $candidate->delete();
        return response()->json(null,204);
    }

    protected function validator()
    {
        $validateFields = [
            'picture' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'birth_date' => 'required|date_format:Y-m-d',
            'gender_id' => 'nullable',
            'preferred_notification_id' => 'nullable',
            'title_id' => 'required',
            'marital_status_id' => 'nullable',
            'immigration_status_id' => 'nullable',
            'passport_country_id' => 'nullable',
            'passport_no' => 'nullable',
            'nationality' => 'nullable',
            'notice_period' => 'nullable',
            'first_name' => 'required|string|min:0|max:50',
            'surname' => 'required|string|min:0|max:50',
            'email' => 'nullable',
            'phone' => 'nullable',
            'id_number' => 'required|string|min:1|max:50',
            'date_available' => 'nullable|string|min:0',
            'overview' => 'nullable|string|min:0',
            'cover' => 'nullable|string|min:0',
            'url' => 'nullable|string|min:0',
            'addr_line_1' => 'nullable|string|min:0|max:50',
            'addr_line_2' => 'nullable|string|min:0|max:50',
            'addr_line_3' => 'nullable|string|min:0|max:50',
            'addr_line_4' => 'nullable|string|min:0|max:50',
            'city' => 'nullable|string|min:0|max:50',
            'province' => 'nullable|string|min:0|max:50',
            'zip_code' => 'nullable|string|min:0|max:50'
        ];

        return $validateFields;
    }
}
