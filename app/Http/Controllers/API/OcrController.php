<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MyLog;

class OcrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $requestData = $request->all();
        //$content = json_decode(json_encode($requestData, JSON_UNESCAPED_UNICODE));
        
        //$bearerToken = $request->bearerToken();
        //echo $bearerToken;
        //USE TO VERIFY YOURSELF
        $channel_access_token = "PAWHiPcSKPa2aHS81w2TRB2sJP1IQmf6kBFxtSE8BD5FLarviYZ2U57SVXiSkNgAzgXYjLGO60jDHhPdLwcuzUQWZxYLebilp0J1I1mrm6Jsv6tu1p3iHKzm2I2rWIPjASnO9jnpz9oD4QZ/fxhH+QdB04t89/1O/w1cDnyilFU=";
        
        $first_event = $requestData["events"][0];
        $messeage = $first_event["message"];
        
        switch($message["type"]){
            case "image" : 
                $binary_data  = $this->getImageFromLine($messeage["id"], $channel_access_token);
                //$binary_data = file_get_contents($location);
                /*$im = imagecreatefromstring($binary_data);
                $width = imagesx($im);
                $height = imagesy($im);
                $requestData["width"] = $width;
                $requestData["height"] = $height;*/
                break;
        }
        
        $data = [
            "title" => "Test",
            "content" => json_encode($requestData, JSON_UNESCAPED_UNICODE),
        ];
        MyLog::create($data);

    }

    public function getImageFromLine($id, $channel_access_token){
        $opts = array('http' =>[
                'method'  => 'GET',
                //'header'  => "Content-Type: text/xml\r\n".
                'header' => 'Authorization: Bearer '.$channel_access_token,
                //'content' => $body,
                //'timeout' => 60
            ]
        );
                            
        $context  = stream_context_create($opts);
        https://api-data.line.me/v2/bot/message/11914912908139/content
        $url = "https://api-data.line.me/v2/bot/message/{$id}/content";
        $result = file_get_contents($url, false, $context);
        return $result;
    }

    public function test(Request $request)
    {
        /* example format of $requestData : http://staffgauge.ckartisan.com/api/ocr
        [
            "title" => "100",                //level of water
            "content" => [],                 //raw data (everything)
            "photo" => "https://......jpg" , //URL IMAGE
            "social_user_id" => "",          //line id
            "numbers" => [],                 //Array of only number
        ]
        */
        $requestData = $request->all();
        //KEEP LOG BEFORE DO ANYTHINGS
        if ($request->has('photo')) {
            //$requestData['photo'] =  Storage::putFile('uploads/ocr', new File($requestData['photo']));
            //$requestData['photo'] = $request->file('photo')->store('uploads/ocr', 'public');

            //FOR OCR 
            //$path = storage_path('app/public/'.$requestData['photo']);

            //GET PATH LIKE : http://............/xxx.jpg
            //$path = 'https://i.stack.imgur.com/koFpQ.png';
            //$requestData['photo'] = str_replace("\/","/", $requestData['photo']);
            $path = $requestData['photo'];
            
            //PATH FROM FIRESTORE : https://firebasestorage.googleapis.com/v0/b/royalirrigationfb.appspot.com/o/U239469c374d4e2337bbc5b4925938af8%2F10987025149678.jpg?alt=media&token=3a971dd0-12ee-42ba-9888-4eae5b29b371
            //WARNING : %2F and ?xxxxxxxxx
            //EXTRACT ONLY : xxx.jpg?alt=xxxxxxxxxxxxxxxxxxxxxx
            $filename = basename(str_replace("%2F","/", $path));
            //EXTRACT ONLY by remove ?xxxxxxxxx : xxx.jpg
            $filename = explode("?",$filename)[0];
            //NEW PATH : storage/app/public/uploads/ocr/xxx.jpg
            $new_path = storage_path('app/public/uploads/ocr/'.$filename);
            Image::make($path)->save($new_path);
            //$requestData['json_line'] = json_encode( $requestData );
            $requestData['json_line'] = basename($requestData['photo']);
            $requestData['photo'] = 'uploads/ocr/'.$filename;
            
            //echo $path;
            //$detected_text = $this->detect_text($path);

            //$requestData['title'] = $detected_text['title'];
            //$requestData['content'] = $detected_text['content'];

        }
        if ($request->has('content')) {
            $requestData['content'] = json_encode( $requestData['content'], JSON_UNESCAPED_UNICODE );
        }
        if ($request->has('numbers')) {
            $requestData['numbers'] = json_encode( $requestData['numbers'], JSON_UNESCAPED_UNICODE );
        }

        $requestData['user_id'] = 1;
        $requestData['locationid'] = 1;
        $requestData['staffgaugeid'] = 1;
        
        //ดึงข้อมูล location จาก lineid
        if ($request->has('lineid')) {
            $lineid = $requestData['lineid'];
            
            //ระวัง query นี้อาจมีผลลัพธ์ เป็น null
            $profile = Profile::where('lineid' , $lineid)->first();
            $requestData['user_id'] = $profile ? $profile->user_id : 1 ;
            
            
            //ระวัง query นี้อาจมีผลลัพธ์ เป็น null
            $location = Location::where('lineid' , $lineid)->latest()->first();

            $requestData['locationid'] = $location ? $location->id : 1 ;
            $requestData['staffgaugeid'] = $location ? $location->staffgaugeid : 1 ;
        }
        
            
        Ocr::create($requestData);
        $arr = [
            'status' => 'success'
        ];
        return  json_encode( $arr, JSON_UNESCAPED_UNICODE );
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
