<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\ComparisonResource;
use App\Http\Resources\Test;
use App\Models\ComparisonResultScientific;
use App\Models\ComparisonScientific;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Validator;

class ComparisonScientificController extends Controller
{
    public function uploadContent(Request $request)
    {
        $file = $request->file('uploaded_file');
        if ($file) {
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $this->checkUploadedFileProperties($extension, $fileSize);
            $location = 'uploads';
            $file->move($location, $filename);
            $filepath = public_path($location . "/" . $filename);
            $file = fopen($filepath, "r");
            $importData_arr = array();
            $i = 0;
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);
                if ($i == 0) {
                    $i++;
                    continue;
                }
                for ($c = 0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata[$c];
                }
                $i++;
            }
            fclose($file);
            $j = 0;
            foreach ($importData_arr as $importData) {
                $j++;
                try {
                DB::beginTransaction();
                $insertData = array(
                    "name"=> $importData[1],
                    "city"=> $importData[2],
                    "avg"=> $importData[3],
                    "maxStudentsNumber"=> $importData[4],
                );
                ComparisonScientific::create($insertData);
                DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json(['message' => "something went wrong"]);
                }
            }
            return response()->json(['message' => "$j records successfully uploaded"
            ]);
        } else {
            return response()->json(['message' => "No file was uploaded"]);
        }

    }
    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = array("csv", "xlsx");
        $maxFileSize = 2097152;
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {

            }else {
                throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE);
            }
        } else {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
        }
    }

    public function index()
    {
        $res = ComparisonScientific::all();
        return response()->json(ComparisonResource::collection($res));
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input , [
            'name' => 'required',
            'city' => 'required',
            'avg' => 'required',
            'maxStudentsNumber' => 'required',
        ]);
        if ($validator->fails()){
            $res['msg'] = "an error accoured";
            return $res;
        }
        $res = ComparisonScientific::create($input);
        return response()->json("done successfully");
    }




    public function register(Request $request){
        $input = $request->all();
        ComparisonResultScientific::create($input);
        return response()->json("done",200);


    }
}
