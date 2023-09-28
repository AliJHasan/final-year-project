<?php

namespace App\Http\Controllers;

use App\Http\Resources\return_final;
use App\Models\ResultScientific;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ResultScientificController extends Controller
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
                    if ($importData[1]>400 || $importData[2]>300 || $importData[3]>300
                    || $importData[4]>200 || $importData[5]>600 || $importData[6]>400
                        || $importData[7]>200 || $importData[8]>300 || $importData[9]>200
                    ){
                        $s['message'] = 'some input field was wrong';
                        return response()->json($s);
                    }


                    $sum = $importData[1]+$importData[2]+$importData[3]+$importData[4]+$importData[5]+$importData[6]
                        +$importData[7]+$importData[8];
                    $totalsum = $sum + $importData[9];

                    $state = true;
                    if ($importData[1]<160 || $importData[2]<120 || $importData[3]<120
                        || $importData[4]<80 || $importData[5]<240 || $importData[6]<160
                        || $importData[7]<80 || $importData[8]<120 || $importData[9]<80
                        || $sum<1080 || $totalsum<1160
                    ){
                        $state = false;
                    }
                    $insertData = array(
                        "subscriptionNumber"=> $importData[0],
                        "arabic"=> $importData[1],
                        "english"=> $importData[2],
                        "france"=> $importData[3],
                        "national"=> $importData[4],
                        "math"=> $importData[5],
                        "physics"=> $importData[6],
                        "chemistry"=> $importData[7],
                        "science"=> $importData[8],
                        "eslamic"=> $importData[9],
                        "sum"=>$sum,
                        "state"=> $state,
                        "totalSum"=>$totalsum
                    );
                    ResultScientific::create($insertData);
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




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $res = ResultScientific::all();
        return response()->json(return_final::collection($res));
    }

}
