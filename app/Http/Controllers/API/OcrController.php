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

        $data = [
            "title" => "Line : api/ocr",
            "content" => "[1,2,3,4,5]",
            "photo" => "uploads/ocr/".$filename,
        ];
        $event = json_decode('{"type":"message","replyToken":"788723e1b9334e6890995c636ae6ad6a","source":{"userId":"U60d0f0345820dae230b04e5c79971d0e","type":"user"},"timestamp":1588763175613,"mode":"active","message":{"type":"image","id":"11915933589867","contentProvider":{"type":"line"}}}', true);
        //1
        $string_json = str_replace("<image>",$image_url,$string_json);
        //2
        $string_json = str_replace("<message_id>",$event["message"]["id"],$string_json);
        //3
        $string_json = str_replace("<content>",$data["content"],$string_json);
        //4
        $string_json = str_replace("<numbers>",$data["content"],$string_json);        
        //5
        $n = $data['title'];        
        if(is_numeric($n)){            
            $levels = [$n-10,$n-5,$n+5,$n+10,$n-2,$n-4,$n-6,$n-8];
        }else{
            $levels = ["-","-","-","-","-","-","-","-"];
        }
        $string_json = str_replace("<min0>",$levels[0],$string_json);
        $string_json = str_replace("<min1>",$levels[1],$string_json);
        $string_json = str_replace("<min2>",$levels[2],$string_json);
        $string_json = str_replace("<min3>",$levels[3],$string_json);
        $string_json = str_replace("<min4>",$levels[4],$string_json);
        $string_json = str_replace("<min5>",$levels[5],$string_json);
        $string_json = str_replace("<min6>",$levels[6],$string_json);
        $string_json = str_replace("<min7>",$levels[7],$string_json);
        //6
        $string_json = str_replace("<user_id>",$event["source"]["userId"],$string_json);
        //7
        $string_json = str_replace("<login>",$image_url,$string_json);
        //8
        $string_json = str_replace("<user_manual>",$image_url,$string_json);
        $message =  json_decode($string_json, true); 
        
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
                    "title" => $detected_text['title'],
                    "content" => $detected_text['content'],
                    "numbers" => $detected_text['numbers'],
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
        $title = "-";
        $description=[];
        $numbers=[];
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
                    /*
                    if($title){
                        if($temp < $title){
                            $title = $temp;
                        }
                    }else{
                        $title = $temp;
                    }
                    */
                    $title = $temp;
                    $numbers[] = $temp;
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
            "numbers" => json_encode($numbers, JSON_UNESCAPED_UNICODE ),
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
        //$template_path = storage_path('../public/json/flexbubble-test.json');  
        $template_path = storage_path('../public/json/flexbubble-reply.json'); 
        //$template_path = storage_path('../public/json/text-reply.json');       
        $string_json = file_get_contents($template_path);
        $image_url = url('/storage')."/".$data["photo"];

        //1
        $string_json = str_replace("<image>",$image_url,$string_json);
        //2
        $string_json = str_replace("<message_id>",$event["message"]["id"],$string_json);
        
        //3
        $string_json = str_replace("<content>","-",$string_json);
        
        //4
        $numbers = join(",",json_decode($data["numbers"]));
        if(empty($numbers)){ $numbers = "-";}
        $string_json = str_replace("<numbers>",$numbers,$string_json); 
        
        $string_json = str_replace("<title>",$data["title"],$string_json); 
              
        //5
        $n = $data['title'];        
        if(is_numeric($n)){            
            $levels = [$n-10,$n-5,$n+5,$n+10,$n-2,$n-4,$n-6,$n-8];
        }else{
            $levels = ["-","-","-","-","-","-","-","-"];
        }
        $string_json = str_replace("<min0>",$levels[0],$string_json);
        $string_json = str_replace("<min1>",$levels[1],$string_json);
        $string_json = str_replace("<min2>",$levels[2],$string_json);
        $string_json = str_replace("<min3>",$levels[3],$string_json);
        $string_json = str_replace("<min4>",$levels[4],$string_json);
        $string_json = str_replace("<min5>",$levels[5],$string_json);
        $string_json = str_replace("<min6>",$levels[6],$string_json);
        $string_json = str_replace("<min7>",$levels[7],$string_json);
        
        //6
        $string_json = str_replace("<user_id>",$event["source"]["userId"],$string_json);
        //7
        $string_json = str_replace("<login>",$image_url,$string_json);
        //8
        $string_json = str_replace("<user_manual>",$image_url,$string_json);
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
