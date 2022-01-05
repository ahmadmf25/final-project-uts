<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
#Import Model Patient
use App\Models\Patient;

class PatientController extends Controller
{
    public function index (){
        #Get all Resource / Mendapatkan Semua Data

        $patient = Patient::all();

        if ($patient) {
            $data = [
                'message' => "Get All Resource",
                $data = $patient
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not Found'
            ];
            return response()->json($data, 404);
        }
    }
    public function store(Request $request){
        #Add Resource/Menambahkan Data

        $validateData = $request->validate([
            'name' => "required",
            'phone' => "required|numeric",
            'address' => "required",
            'status' => "required",
            'in_date_at' => "required",
            'out_date_at' => "required"
        ]);
        
        $patient = Patient::create($validateData);
        
        $data = [
            'message' => "Resource added succesfully",
            'data' => $patient
        ];

        return response()->json($data, 201);
    }

    public function show($id){
        # Get Detail Resource / Mendapatkan data berdasarkan id

        $patient = Patient::find($id);

        if ($patient) {
            $data = [
                'message' => "Get Detail patient",
                'data' => $patient
            ];

            return response()->json($data,200);
        }
        else {
            $data = [
                'message' => "Data not found"
            ];

            return response()->json($data, 404);
        }
    }

    public function update(Request $request, $id){
        # Get Detail Resource / Mendapatkan data berdasarkan id
        # Edit Resource / mengupdate data patient

        $patient = Patient::find($id);

        if ($patient) {
            $patient->update([
                'name' => $request->name ?? $patient->name,
                'phone' => $request->phone ?? $patient->phone,
                'address' => $request->address ?? $patient->address,
                'status' => $request->status ?? $patient->status,
                'in_date_at' => $request->in_date_at ?? $patient->in_date_at,
                'out_date_at' => $request->out_date_at ?? $patient->out_date_at
            ]);

            $data = [
                'message' => "Resource is update successfully",
                'data' => $patient
            ];

            return response()->json($data, 200);
        }
        else {
            $data = [
                'message' => "Resource not found"
            ];

            return response()->json($data, 404);    
        }
    }

    public function destroy($id){
        # Delete Resource/Menghapus data

        $patient = Patient::find($id);

        if ($patient) {
            $patient->delete();

            $data = [
                'message' => "Resource is delete successfully"
            ];

            return response()->json($data, 200);
        }
        else {
            $data = [
                'message' => "Resource not found"
            ];

            return response()->json($data, 404);
        }
    }

    public function search($name){
        # Search Resource by name / Mencari data patient

        $patient = Patient::where('name', 'like', "%$name%")->get();

        if ($patient) {
            
            $response = [
                'message' => "Get searched resource",
                'data' => $patient
            ];

            return response()->json($response, 200);
        }

        else {
            $response = [
                'message' => "Resource not found"
            ];

            return response()->json($response, 404);
        } 
    }
    public function positive(){
        #Get Positive Resource / Mendapatkan data patient positif

        $patient = Patient::where('status','like', "%positive%")->get();
          
            $response = [
                'message' => "Get resource positive",
                'total' => count($patient),
                'response' => $patient
            ];

            return response()->json($response, 200);
        
    }
    public function recovered(){

        #Get Recovered Resource / Mendapatkan Data Patient Sembuh
        $patient = Patient::where('status','like', "%recovered%")->get();
          
        $response = [
            'message' => "Get resource recovered",
            'total' => count($patient),
            'response' => $patient
        ];

        return response()->json($response, 200); 
    }
    public function dead(){

        #Get Dead Resource / Mendaptakan Data Meninggal
        $patient = Patient::where('status','like', "%dead%")->get();
          
        $response = [
            'message' => "Get resource dead",
            'total' => count($patient),
            'response' => $patient
        ];

        return response()->json($response, 200); 
    }
}
