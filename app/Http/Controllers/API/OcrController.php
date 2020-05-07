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
        //SAVE LOG
        $requestData = $request->all();
        $data = [
            "title" => "Line : api/ocr",
            "content" => json_encode($requestData, JSON_UNESCAPED_UNICODE),
        ];
        MyLog::create($data);        
        
        //GET ONLY FIRST EVENT
        $event = $requestData["events"][0];
        switch($event["type"]){
            case "message" : 
                $this->messageHandler($event);
                break;
            case "postback" : 
                $this->postbackHandler($event);
                break;
        }
    }

    public function messageHandler($event)
    {
        switch($event["message"]["type"]){
            case "image" :                 
                $this->imageHandler($event);
                break;
            case "location" :                 
                $this->locationHandler($event);
                break;
        }   

    }

    public function imageHandler($event)
    {
        //USE TO VERIFY YOURSELF
        //$channel_access_token = "PAWHiPcSKPa2aHS8...................H+QdB04t89/1O/w1cDnyilFU=";
        $channel_access_token = $this->channel_access_token;

        //LOAD REMOTE IMAGE AND SAVE TO LOCAL
        $binary_data  = $this->getImageFromLine($event["message"]["id"], $channel_access_token);                
        $filename = $this->random_string(50).".png";
        $new_path = storage_path('app/public/uploads/ocr/'.$filename);
        Image::make($binary_data)->save($new_path);
                        
        //ANALYSE IMAGE WITH GOOGLE VISION API
        $detected_text = $this->detectText($new_path);
        
        //CREATE OCR
        $data = [
            "title" => $detected_text['title'],
            "content" => $detected_text['content'],
            "numbers" => $detected_text['numbers'],
            "photo" => "uploads/ocr/".$filename,
            //"user_id" => "1", 
            "lineid" => $event["source"]["userId"],
            //"staffgaugeid" => "1",
            //"locationid" => "1",
            "msgocrid" => $event["message"]["id"],
        ];
        Ocr::create($data);

        //FINALLY REPLY TO USER                
        $this->replyToUser($data,$event, $channel_access_token);

    }

    public function locationHandler($event)
    {
        

    }

    
    public function detectText($path)
    {
        //https://onlinelearningportal.website/google-vision-api-implementation-with-laravel-5-8/
        
        //CALL GOOGLE VISION OBJECT AND DO TEXT DETECTION
        $key_path = storage_path('../public/CKartisan-c6f07fc70d07.json');
        $vision = new VisionClient(['keyFile' => json_decode(file_get_contents($key_path), true)]);         
        $image = $vision->image(file_get_contents($path), [ 'TEXT_DETECTION' ] );        
        $result = $vision->annotate($image);
        //print_r($result); exit;
        $texts = $result->text();

        //FIND OUT WATER LEVEL
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

    public function cleanNumber($text){
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
        $string_json = str_replace("<lineid>",$event["source"]["userId"],$string_json);
        //7
        $string_json = str_replace("<login>",$image_url,$string_json);
        //8
        $string_json = str_replace("<user_manual>",$image_url,$string_json);
        //9
        $string_json = str_replace("<msgocrid>",$event["message"]["id"],$string_json);
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

    public function postbackHandler($event)
    {
        
        $queryString = $event['postback']['data'];
        parse_str($queryString, $data);

        // update title in ocr
        
        $ocr = Ocr::where('lineid', $data['lineid'])
                ->where('msgocrid', $data['msgocrid'])
                ->first();

        $ocr->title = $data['title'];        
        $ocr->save();        
        
        //REPLY
        //CREATE OCR
        $new_data = [
            "title" => $ocr->title,
            "content" => $ocr->content,
            "numbers" => $ocr->numbers,
            "photo" => $ocr->photo,
        ];
        //Ocr::create($data);

        //FINALLY REPLY TO USER                
        $channel_access_token = $this->channel_access_token;
        $event['message'] = ['id' => ''.$data['msgocrid'].' (Updated)'];
        $this->replyToUser($new_data,$event, $channel_access_token);
        
        
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
