<?php

namespace App\Http\Controllers;

use App\Http\Resources\return_final;
use App\Models\ResultLiterary;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ResultLiteraryController extends Controller
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
                    if ($importData[1]>600 || $importData[2]>400 || $importData[3]>400
                        || $importData[4]>200 || $importData[5]>300 || $importData[6]>300
                        || $importData[7]>400 || $importData[8]>200
                    ){
                        $s['message'] = 'some input field was wrong';
                        return response()->json($s);
                    }


                    $sum = $importData[1]+$importData[2]+$importData[3]+$importData[4]+$importData[5]+$importData[6]
                        +$importData[7];
                    $totalsum = $sum + $importData[8];

                    $state = true;
                    if ($importData[1]<300 || $importData[2]<160 || $importData[3]<160
                        || $importData[4]<80 || $importData[5]<120 || $importData[6]<120
                        || $importData[7]<160 || $importData[8]<80
                        || $sum<1100 || $totalsum<1180
                    ){
                        $state = false;
                    }
                    $insertData = array(
                        "subscriptionNumber"=> $importData[0],
                        "arabic"=> $importData[1],
                        "english"=> $importData[2],
                        "france"=> $importData[3],
                        "national"=> $importData[4],
                        "history"=> $importData[5],
                        "geography"=> $importData[6],
                        "phalsafah"=> $importData[7],
                        "eslamic"=> $importData[8],
                        "sum"=>$sum,
                        "state"=> $state,
                        "totalSum"=>$totalsum
                    );
                    ResultLiterary::create($insertData);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json(['message' => $e->getMessage()]);
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
        $res = ResultLiterary::all();
        return response()->json(return_final::collection($res));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
