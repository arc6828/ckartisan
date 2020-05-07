<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MyLog;
use App\Ocr;

use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\VisionClient;

use Intervention\Image\ImageManagerStatic as Image;


class OcrController extends Controller
{
    public $channel_access_token = "PAWHiPcSKPa2aHS81w2TRB2sJP1IQmf6kBFxtSE8BD5FLarviYZ2U57SVXiSkNgAzgXYjLGO60jDHhPdLwcuzUQWZxYLebilp0J1I1mrm6Jsv6tu1p3iHKzm2I2rWIPjASnO9jnpz9oD4QZ/fxhH+QdB04t89/1O/w1cDnyilFU=";
        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $result = $this->getImageFromLine("11914912908139", $this->channel_access_token);
        
        //header('Content-Type: image/jpeg');
        //echo $result;

        //echo Image::make($result)->mime();
         $this->random_string(50);
        //$size = $image->filesize();            
        
        $filename = $this->random_string(50).".png";
        $new_path = storage_path('app/public/uploads/ocr/'.$filename);


        $template_path = storage_path('../public/json/flexbubble-reply.json');        
        $string_json = file_get_contents($template_path);
        $image_url = url('/storage')."/";
        $string_json = str_replace("<image>",$image_url,$string_json);
        $message =  json_decode($string_json, true); 
        print_r($message);
        
        /*
        Image::make($result)->save($new_path);
        echo 'uploads/ocr/'.$filename;
        $url = url('/')."/storage/uploads/ocr/".$filename;
        echo "<br>".$url;
        echo "<br>"."<img src='{$url}' />";
        */
        

        //$img64 = base64_encode($result);
        //echo "img src='{$img64}'";
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
        $data = [
            "title" => "Line : api/ocr",
            "content" => json_encode($requestData, JSON_UNESCAPED_UNICODE),
        ];
        MyLog::create($data);

        //$content = json_decode(json_encode($requestData, JSON_UNESCAPED_UNICODE));
        
        //$bearerToken = $request->bearerToken();
        //echo $bearerToken;
        //USE TO VERIFY YOURSELF
        //$channel_access_token = "PAWHiPcSKPa2aHS81w2TRB2sJP1IQmf6kBFxtSE8BD5FLarviYZ2U57SVXiSkNgAzgXYjLGO60jDHhPdLwcuzUQWZxYLebilp0J1I1mrm6Jsv6tu1p3iHKzm2I2rWIPjASnO9jnpz9oD4QZ/fxhH+QdB04t89/1O/w1cDnyilFU=";
        $channel_access_token = $this->channel_access_token;
        
        //GET FIRST EVENT
        $event = $requestData["events"][0];
        $message = $event["message"];
        
        switch($message["type"]){
            case "image" : 
                $binary_data  = $this->getImageFromLine($message["id"], $channel_access_token);
                
                $filename = $this->random_string(50).".png";
                $new_path = storage_path('app/public/uploads/ocr/'.$filename);
                Image::make($binary_data)->save($new_path);
                //echo 'uploads/ocr/'.$filename;
                //$url = url('/')."/storage/uploads/ocr/".$filename;
                //echo "<br>".$url;
                //echo "<br>"."<img src='{$url}' />";
                
                //GOOGLE VISION API
                //$path = storage_path('app/public/'.$requestData['photo']);
                //echo $path;
                $detected_text = $this->detect_text2($new_path);

                //$requestData['title'] = $detected_text['title'];
                //$requestData['content'] = $detected_text['content'];
                
                //CREATE OCR
                $data = [
                    "title" => "Line : api/ocr",
                    "content" => $detected_text['content'],
                    "photo" => "uploads/ocr/".$filename,
                ];
                Ocr::create($data);

                
                
                $this->replyToUser($data,$event, $channel_access_token);
                break;
        }      
        

    }


    function detect_text2($path)
    {
        //https://onlinelearningportal.website/google-vision-api-implementation-with-laravel-5-8/
        $key_path = storage_path('../public/CKartisan-c6f07fc70d07.json');
        $vision = new VisionClient(['keyFile' => json_decode(file_get_contents($key_path), true)]); 
        
        $image = $vision->image(file_get_contents($path), 
        [
            'TEXT_DETECTION'
        ]);
        
        $result = $vision->annotate($image);
        //print_r($result); exit;
        $texts = $result->text();
        $title = null;
        $description=[];
        $first = true;
        if($texts){
            foreach($texts as $key=>$text)
            {
                if($first) {$first = false; continue;}
                $description[]=$text->description();
                //GET CLEAN DATA 
                $temp = $this->cleanNumber($text->description());
                //ถ้าได้ตัวเลขน้อยกว่าเดิม ให้บันทึก
                if($temp){
                    if($title){
                        if($temp < $title){
                            $title = $temp;
                        }
                    }else{
                        $title = $temp;
                    }
                }

                //echo $text->description() ;
                //print_r($text->info());
                /*$bounds = [];
                foreach ($text->boundingPoly()['vertices'] as $vertex) {
                    $bounds[] = sprintf('(%d,%d)', $vertex['x'], $vertex['y']);
                }
                print('Bounds: ' . join(', ',$bounds) . PHP_EOL);*/
                //echo "<br>";
            }
        }
        return [
            "title" => $title,
            "content" => json_encode($description, JSON_UNESCAPED_UNICODE ),
        ];
        // fetch text from image //
        //print_r($description);    

    }

    function cleanNumber($text){
        //REMOVE E
        $text = str_replace("E","",$text);
        //REMOVE .
        $text = str_replace(".","",$text);
        //REMOVE SPACEBAR
        $text = str_replace(" ","",$text);
        //CONVERT to float
        $number = floatval($text);
        if($number){
            return $number;
            //CONVERT to int
            $number = intval($number);
            if($number){
                //divisible with 10 but not 0
                if($number % 10 == 0){
                    return $number;
                }
            }            
        }        
        return false;
    }

    public function replyToUser($data, $event, $channel_access_token){
        /*
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('<channel access token>');
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '<channel secret>']);

        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
        $response = $bot->replyMessage('<replyToken>', $textMessageBuilder);

        echo $response->getHTTPStatus() . ' ' . $response->getRawBody();

        $body = [
            "replyToken" => $event["replyToken"],
            "messages" => [
                [
                    "type" => "text",
                    "text"=> "ขอบคุณสำหรับข้อมูล ". $data['content']
                ]
            ],
        ];
        */
        $template_path = storage_path('../public/json/flexbubble-reply.json');        
        $string_json = file_get_contents($template_path);
        $image_url = url('/storage')."/".$data["photo"];
        $string_json = str_replace("<image>",$image_url,$string_json);
        $message =  json_decode($string_json, true); 
        $body = [
            "replyToken" => $event["replyToken"],
            "messages" => [ $message ],
        ];

        $opts = [
            'http' =>[
                'method'  => 'POST',
                'header'  => "Content-Type: application/json \r\n".
                            'Authorization: Bearer '.$channel_access_token,
                'content' => json_encode($body, JSON_UNESCAPED_UNICODE),
                //'timeout' => 60
            ]
        ];
                            
        $context  = stream_context_create($opts);
        //https://api-data.line.me/v2/bot/message/11914912908139/content
        $url = "https://api.line.me/v2/bot/message/reply";
        $result = file_get_contents($url, false, $context);

        //SAVE LOG
        $data = [
            "title" => "https://api.line.me/v2/bot/message/reply",
            "content" => json_encode($result, JSON_UNESCAPED_UNICODE),
        ];
        MyLog::create($data);
        return $result;

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
        //https://api-data.line.me/v2/bot/message/11914912908139/content
        $url = "https://api-data.line.me/v2/bot/message/{$id}/content";
        $result = file_get_contents($url, false, $context);
        return $result;
    }

    public function random_string($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
    
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
    
        return $key;
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
