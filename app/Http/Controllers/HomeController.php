<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function profile(){
        return view('profile');

    }
    public function devices(){


        return view('devices');

    }
    public function errors(){


        return view('errors');

    }



    public function logViewer(){

        $hubs = \DB::select('SELECT DISTINCT hubSerial, hubName FROM hubPermissions');

        //dd($hubs);

        return view('logViewer', [
            'hubs' => $hubs
        ]);

    }

    public function deleteDevice(Request $request){
        $data = $request->all();
        $returnObj = [];
        $returnObj['live'] = false;
        $data1 = [];
        $data1['api_key'] = 'abcd132453wq069n';
        $data1['hubSerial'] = $data["hub"];
        $data1['cmd'] = 'getDevices';
        $data1['page'] = 1;

        $hubResDevices = $this->api("POST", "156.38.138.34/api/api_pass.php", $data1);
        return response()->json($returnObj);


    }



    public function getHubInfo(Request $request){
        $data = $request->all();
        $returnObj = [];
        $offlineRet = "";
        $onBattRet = "";
        $battOpen = "";
        $battShort = "";
        $allDevices = "";





        if($data["live"] == "true"){
            $data1 = [];
            $data1['api_key'] = 'abcd132453wq069n';
            $data1['hubSerial'] = $data["hubSer"];
            $data1['cmd'] = 'getDevices';
            $data1['page'] = 1;
    
    
            $totalHubDevices = [];
            $hubResDevices = $this->getDevicesS($data["hubSer"]);
            $hubResDevices = json_decode($hubResDevices, true);
            array_push($totalHubDevices , ...$hubResDevices['live_response']);
            $page = 1;
            while(count($hubResDevices['live_response']) == 8){
                $page++;
                $hubResDevices = $this->getDevicesS($data["hubSer"], $page);
                $hubResDevices = json_decode($hubResDevices, true);
                array_push($totalHubDevices , ...$hubResDevices['live_response']);
    
            }

            foreach($totalHubDevices as $totalHubDevice){
                $deviceObj = \DB::select('SELECT * FROM devices WHERE serial_no = "'.$totalHubDevice['serial_no'].'"');

                $allDevices .= '<tr>';
    
                if(!$deviceObj){
                    $allDevices .= '<td>';
                    $allDevices .= 'NO NAME';
                    $allDevices .= '</td>';
    
                    $allDevices .= '<td>';
                    $allDevices .= 'NO TYPE';
                    $allDevices .= '</td>';
                }else{
    
                    $allDevices .= '<td>';
                    $allDevices .= $deviceObj[0]->device_name;
                    $allDevices .= '</td>';
    
                    $deviceType = \DB::select('SELECT * FROM device_types WHERE code = "'.$deviceObj[0]->type.'"');
    
                    $allDevices .= '<td>';
                    $allDevices .= $deviceType[0]->name;
                    $allDevices .= '</td>';
                }
    
    
    
                $allDevices .= '<td>';
                $allDevices .= $totalHubDevice['serial_no'];
                $allDevices .= '</td>';
    

    
    
                if(!$deviceObj){
                    $allDevices .= '<td>';
                    $allDevices .= 'N/A';
                    $allDevices .= '</td>';
                }else{
    
                    $allDevices .= '<td>';
                    $allDevices .= $deviceObj[0]->date_time_registered;
                    $allDevices .= '</td>';
                }
    
                $allDevices .= '<td class="td-actions text-right">';
                if($deviceType[0]->name == 'EMERGENCY_LIGHT')
                    $allDevices .= '<a rel="tooltip" class="btn btn-info btn-link"  data-original-title="" onclick="viewSchedule(\''.$data["hubSer"].'\', \''.$totalHubDevice['serial_no'].'\');" title=""><i class="material-icons">schedule</i><div class="ripple-container"></div></a>';

                $allDevices .= '<a rel="tooltip" class="btn btn-danger btn-link"  data-original-title="" onclick="deleteDevice(\''.$data["hubSer"].'\', \''.$totalHubDevice['serial_no'].'\');" title=""><i class="material-icons">delete</i><div class="ripple-container"></div></a>';

                $allDevices .= '</td>';
    
                $allDevices .= '</tr>';

                if($totalHubDevice['state'] == '019' || $totalHubDevice['state'] == '010'){
                    $offlineRet .= '<tr>';
    
                    if(!$deviceObj){
                        $offlineRet .= '<td>';
                        $offlineRet .= 'NO NAME';
                        $offlineRet .= '</td>';
        
                        $offlineRet .= '<td>';
                        $offlineRet .= 'NO TYPE';
                        $offlineRet .= '</td>';
                    }else{
        
                        $offlineRet .= '<td>';
                        $offlineRet .= $deviceObj[0]->device_name;
                        $offlineRet .= '</td>';
        
                        $deviceType = \DB::select('SELECT * FROM device_types WHERE code = "'.$deviceObj[0]->type.'"');
        
                        $offlineRet .= '<td>';
                        $offlineRet .= $deviceType[0]->name;
                        $offlineRet .= '</td>';
                    }
        
        
        
                    $offlineRet .= '<td>';
                    $offlineRet .= $totalHubDevice['serial'];
                    $offlineRet .= '</td>';
        
        
                    $offlineRet .= '<td>';
                    $offlineRet .= $data["hubSer"];
                    $offlineRet .= '</td>';
        
        
                    if(!$deviceObj){
                        $offlineRet .= '<td>';
                        $offlineRet .= 'N/A';
                        $offlineRet .= '</td>';
                    }else{
        
                        $offlineRet .= '<td>';
                        $offlineRet .= $deviceObj[0]->date_time_registered;
                        $offlineRet .= '</td>';
                    }
        
        
        
                    $offlineRet .= '</tr>';
                }else if($totalHubDevice['state'] == '011' || $totalHubDevice['state'] == '012' || $totalHubDevice['state'] == '013' || $totalHubDevice['state'] == '014' || $totalHubDevice['state'] == '015' || $totalHubDevice['state'] == '016' || $totalHubDevice['state'] == '017' || $totalHubDevice['state'] == '018'){
                    $onBattRet .= '<tr>';
    
                    if(!$deviceObj){
                        $onBattRet .= '<td>';
                        $onBattRet .= 'NO NAME';
                        $onBattRet .= '</td>';
        
                        $onBattRet .= '<td>';
                        $onBattRet .= 'NO TYPE';
                        $onBattRet .= '</td>';
                    }else{
        
                        $onBattRet .= '<td>';
                        $onBattRet .= $deviceObj[0]->device_name;
                        $onBattRet .= '</td>';
        
                        $deviceType = \DB::select('SELECT * FROM device_types WHERE code = "'.$deviceObj[0]->type.'"');
        
                        $onBattRet .= '<td>';
                        $onBattRet .= $deviceType[0]->name;
                        $onBattRet .= '</td>';
                    }
        
        
        
                    $onBattRet .= '<td>';
                    $onBattRet .= $totalHubDevice['serial_no'];
                    $onBattRet .= '</td>';
        
        
                    $onBattRet .= '<td>';
                    $onBattRet .= $data["hubSer"];
                    $onBattRet .= '</td>';
        
        
                    if(!$deviceObj){
                        $onBattRet .= '<td>';
                        $onBattRet .= 'N/A';
                        $onBattRet .= '</td>';
                    }else{
        
                        $onBattRet .= '<td>';
                        $onBattRet .= $deviceObj[0]->date_time_registered;
                        $onBattRet .= '</td>';
                    }
        
        
        
                    $onBattRet .= '</tr>';
                }else if($totalHubDevice['state'] == '009'){
                    $battOpen .= '<tr>';
    
                    if(!$deviceObj){
                        $battOpen .= '<td>';
                        $battOpen .= 'NO NAME';
                        $battOpen .= '</td>';
        
                        $battOpen .= '<td>';
                        $battOpen .= 'NO TYPE';
                        $battOpen .= '</td>';
                    }else{
        
                        $battOpen .= '<td>';
                        $battOpen .= $deviceObj[0]->device_name;
                        $battOpen .= '</td>';
        
                        $deviceType = \DB::select('SELECT * FROM device_types WHERE code = "'.$deviceObj[0]->type.'"');
        
                        $battOpen .= '<td>';
                        $battOpen .= $deviceType[0]->name;
                        $battOpen .= '</td>';
                    }
        
        
        
                    $battOpen .= '<td>';
                    $battOpen .= $totalHubDevice['serial_no'];
                    $battOpen .= '</td>';
        
        
                    $battOpen .= '<td>';
                    $battOpen .= $data["hubSer"];
                    $battOpen .= '</td>';
        
        
                    if(!$deviceObj){
                        $battOpen .= '<td>';
                        $battOpen .= 'N/A';
                        $battOpen .= '</td>';
                    }else{
        
                        $battOpen .= '<td>';
                        $battOpen .= $deviceObj[0]->date_time_registered;
                        $battOpen .= '</td>';
                    }
        
        
        
                    $battOpen .= '</tr>';
                }else if($totalHubDevice['state'] == '000'){
                    $battShort .= '<tr>';
    
                    if(!$deviceObj){
                        $battShort .= '<td>';
                        $battShort .= 'NO NAME';
                        $battShort .= '</td>';
        
                        $battShort .= '<td>';
                        $battShort .= 'NO TYPE';
                        $battShort .= '</td>';
                    }else{
        
                        $battShort .= '<td>';
                        $battShort .= $deviceObj[0]->device_name;
                        $battShort .= '</td>';
        
                        $deviceType = \DB::select('SELECT * FROM device_types WHERE code = "'.$deviceObj[0]->type.'"');
        
                        $battShort .= '<td>';
                        $battShort .= $deviceType[0]->name;
                        $battShort .= '</td>';
                    }
        
        
        
                    $battShort .= '<td>';
                    $battShort .= $totalHubDevice['serial_no'];
                    $battShort .= '</td>';
        
        
                    $battShort .= '<td>';
                    $battShort .= $data["hubSer"];
                    $battShort .= '</td>';
        
        
                    if(!$deviceObj){
                        $battShort .= '<td>';
                        $battShort .= 'N/A';
                        $battShort .= '</td>';
                    }else{
        
                        $battShort .= '<td>';
                        $battShort .= $deviceObj[0]->date_time_registered;
                        $battShort .= '</td>';
                    }
        
        
        
                    $battShort .= '</tr>';
                }else{
                    continue;
                }

                // switch($totalHubDevice['state']){
                //     case '009':
                //     case '000':
                //         if(isset($deviceStats[$hubForAccount->hubSerial]['off']))
                //             $deviceStats[$hubForAccount->hubSerial]['off']++;
                //         else
                //             $deviceStats[$hubForAccount->hubSerial]['off'] = 1;
                //         break;
                //     default:
                //         if(isset($deviceStats[$hubForAccount->hubSerial]['on']))
                //             $deviceStats[$hubForAccount->hubSerial]['on']++;
                //         else
                //             $deviceStats[$hubForAccount->hubSerial]['on'] = 1;
                //         break;


                // }

        
    
                    
            }

        }else{
            $offlineDevs = \DB::select('SELECT * FROM lastOnline WHERE hubSerial = "'.$data["hubSer"].'" AND extra = "Offline"');
    
            foreach($offlineDevs as $r){
                $deviceObj = \DB::select('SELECT * FROM devices WHERE serial_no = "'.$r->serial.'"');
    
    
                $offlineRet .= '<tr>';
    
                if(!$deviceObj){
                    $offlineRet .= '<td>';
                    $offlineRet .= 'NO NAME';
                    $offlineRet .= '</td>';
    
                    $offlineRet .= '<td>';
                    $offlineRet .= 'NO TYPE';
                    $offlineRet .= '</td>';
                }else{
    
                    $offlineRet .= '<td>';
                    $offlineRet .= $deviceObj[0]->device_name;
                    $offlineRet .= '</td>';
    
                    $deviceType = \DB::select('SELECT * FROM device_types WHERE code = "'.$deviceObj[0]->type.'"');
    
                    $offlineRet .= '<td>';
                    $offlineRet .= $deviceType[0]->name;
                    $offlineRet .= '</td>';
                }
    
    
    
                $offlineRet .= '<td>';
                $offlineRet .= $r->serial;
                $offlineRet .= '</td>';
    
    
                $offlineRet .= '<td>';
                $offlineRet .= $r->hubSerial;
                $offlineRet .= '</td>';
    
    
                if(!$deviceObj){
                    $offlineRet .= '<td>';
                    $offlineRet .= 'N/A';
                    $offlineRet .= '</td>';
                }else{
    
                    $offlineRet .= '<td>';
                    $offlineRet .= $deviceObj[0]->date_time_registered;
                    $offlineRet .= '</td>';
                }
    
    
    
                $offlineRet .= '</tr>';
    
                
            }

            $allDevs = \DB::select('SELECT * FROM lastOnline WHERE hubSerial = "'.$data["hubSer"].'"');

            foreach($allDevs as $r){
                $deviceObj = \DB::select('SELECT * FROM devices WHERE serial_no = "'.$r->serial.'"');
    
    
                $allDevices .= '<tr>';
    
                if(!$deviceObj){
                    $allDevices .= '<td>';
                    $allDevices .= 'NO NAME';
                    $allDevices .= '</td>';
    
                    $allDevices .= '<td>';
                    $allDevices .= 'NO TYPE';
                    $allDevices .= '</td>';
                }else{
    
                    $allDevices .= '<td>';
                    $allDevices .= $deviceObj[0]->device_name;
                    $allDevices .= '</td>';
    
                    $deviceType = \DB::select('SELECT * FROM device_types WHERE code = "'.$deviceObj[0]->type.'"');
    
                    $allDevices .= '<td>';
                    $allDevices .= $deviceType[0]->name;
                    $allDevices .= '</td>';
                }
    
    
    
                $allDevices .= '<td>';
                $allDevices .= $r->serial;
                $allDevices .= '</td>';
    
    
                $allDevices .= '<td>';
                $allDevices .= $r->hubSerial;
                $allDevices .= '</td>';
    
    
                if(!$deviceObj){
                    $allDevices .= '<td>';
                    $allDevices .= 'N/A';
                    $allDevices .= '</td>';
                }else{
    
                    $allDevices .= '<td>';
                    $allDevices .= $deviceObj[0]->date_time_registered;
                    $allDevices .= '</td>';
                }
    
    
    
                $allDevices .= '</tr>';
    
                
            }

        }


        $returnObj['offDev'] = $offlineRet;
        $returnObj['battOpen'] = $battOpen;

        $returnObj['onBattDev'] = $onBattRet;
        $returnObj['allDevices'] = $allDevices;

        $returnObj['battShort'] = $battShort;


        return response()->json($returnObj);

    }

    public function dashboard(){
        $lastOnlineDevs = \DB::select('SELECT * FROM lastOnline');
        $deviceStats = [];
        foreach($lastOnlineDevs as $lastOnlineDev){


            $deviceStats[$lastOnlineDev->hubSerial][$lastOnlineDev->serial]['status'] = $lastOnlineDev->extra;


            switch($lastOnlineDev->extra){
                case 'Offline':
                    if(isset($deviceStats[$lastOnlineDev->hubSerial]['off']))
                        $deviceStats[$lastOnlineDev->hubSerial]['off']++;
                    else
                        $deviceStats[$lastOnlineDev->hubSerial]['off'] = 1;
                    break;
                case 'Online':
                    if(isset($deviceStats[$lastOnlineDev->hubSerial]['on']))
                        $deviceStats[$lastOnlineDev->hubSerial]['on']++;
                    else
                        $deviceStats[$lastOnlineDev->hubSerial]['on'] = 1;
                    break;
            }
            if(isset($deviceStats[$lastOnlineDev->hubSerial]['total']))
                $deviceStats[$lastOnlineDev->hubSerial]['total']++;
            else
                $deviceStats[$lastOnlineDev->hubSerial]['total'] = 1;

                
        }

        foreach($deviceStats as $key=>&$deviceStat){
            $hubPerm = \DB::select('SELECT * FROM hubPermissions WHERE hubSerial = "'.$key.'" AND email = "'.\Auth::user()->email.'"');
            if(!$hubPerm){
                unset($deviceStats[$key]);
                continue;
            }else{

                $deviceStat['name'] = $hubPerm[0]->hubName;

            }
            $percentageOff = 0;
            if(isset($deviceStat['off']))   
                $percentageOff = $deviceStat['off']/$deviceStat['total']*100;
            $deviceStat['percentOff'] = $percentageOff;
            $deviceStat['status'] = 'Online';
            $deviceStat['statusH'] = '#3CBC3C';

            if($percentageOff > 80){
                $deviceStat['status'] = 'Offline';
            $deviceStat['statusH'] = '#FF2828';

            }
        }
        return view('dashboard', [
            'hubs' => $deviceStats
        ]);

    }

    public function api($method, $url, $data = false){
        $curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
    
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
    

    
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
        $result = curl_exec($curl);
    
        curl_close($curl);
    
        return $result;
    }

    public function hubs(){
        $hubsForAccount = \DB::select('SELECT * FROM hubPermissions WHERE email = "'.\Auth::user()->email.'"');
        $deviceStats = [];
        foreach($hubsForAccount as $hubForAccount){


            $deviceStats[$hubForAccount->hubSerial]['api_response'] = FALSE;     

            $deviceStats[$hubForAccount->hubSerial]['active'] = $hubForAccount->hubIsActive;


            $deviceStats[$hubForAccount->hubSerial]['off'] = '-';


            $deviceStats[$hubForAccount->hubSerial]['on'] = '-';

            $deviceStats[$hubForAccount->hubSerial]['total'] = '-';



            $deviceStats[$hubForAccount->hubSerial]['name'] = $hubForAccount->hubName;

            
            $percentageOff = 0;
            if(isset($deviceStats[$hubForAccount->hubSerial]['off']))   
                $percentageOff = 100;
            $deviceStats[$hubForAccount->hubSerial]['percentOff'] = '-';
            $deviceStats[$hubForAccount->hubSerial]['status'] = 'Connecting..';
            $deviceStats[$hubForAccount->hubSerial]['statusH'] = '#aaa';



                
        }

        return view('dashboard', [
            'hubs' => $deviceStats
        ]);

    }

    function logResponse($liveResponse) {
        global $totalResponse;
      
        $ints = bin2hex($liveResponse);
        $pageContents = substr( $ints, 16 ); 
        $lower = 0;
        $upper = 16;
      
        
        $line = [];
        for ($x = 0; $x <= 33; $x++) {
          $line["entry-$x"] = substr( $pageContents, $lower, 32);
          
      
          // $row = substr( $pageContents, $lower, 32);
      
          // $time = hexdec(substr( $row, 0, 8 ));
          // $lineS["time"] = $time; 
      
          // $line["page $x"] = $lineS;
      
          $lower += 32;
          $upper += 16;
      
          // $device['mac'] = $singleDevice[1];
        }
      
      
      
        
        // $index = hexdec(substr( $ints, 16, 16 )); 
      
        // $respSplit = explode('&', $liveResponse);
        // array_splice($respSplit, 0, 1);
      
        // $type = "";
        // switch ($respSplit[13]) {
        //   case '102\n' : $type = 'ProEM IntelliHub'; break;
        //   case '100\n' : $type = 'Control IntelliHub V1'; break;
        //   case '101\n' : $type = 'Control IntelliHub V2'; break;
        //   case '102' : $type = 'ProEM IntelliHub'; break;
        //   case '100' : $type = 'Control IntelliHub V1'; break;
        //   case '101' : $type = 'Control IntelliHub V2'; break;
        //   case 102 : $type = 'ProEM IntelliHub'; break;
        //   case 100 : $type = 'Control IntelliHub V1'; break;
        //   case 101 : $type = 'Control IntelliHub V2'; break;
        //   default : $type = 'IntelliHub'; echo $respSplit[13]; break;
        // }
      
      
        // $resp = ['type'=>$type];
        // $resp['version'] = $respSplit[1];
        // $resp['serial'] = $respSplit[0];
        // $resp['hubTime'] = $respSplit[6];
        // $resp['timeZone'] = $respSplit[7];
        // $resp['connectivity'] = $respSplit[9];
        // $resp['isUpgrading'] = $respSplit[12];
        // $resp['radioChannel'] = $respSplit[10];
      
        $totalResponse['live_response'] = $line;
        $response = json_encode($totalResponse);
        return $response;
      }

    function hubInfoResponse($liveResponse) {
        global $totalResponse;
      
        $respSplit = explode('&', $liveResponse);
        array_splice($respSplit, 0, 1);
      
        $type = "";
        switch ($respSplit[13]) {
          case '102\n' : $type = 'ProEM IntelliHub'; break;
          case '100\n' : $type = 'Control IntelliHub V1'; break;
          case '101\n' : $type = 'Control IntelliHub V2'; break;
          case '102' : $type = 'ProEM IntelliHub'; break;
          case '100' : $type = 'Control IntelliHub V1'; break;
          case '101' : $type = 'Control IntelliHub V2'; break;
          case 102 : $type = 'ProEM IntelliHub'; break;
          case 100 : $type = 'Control IntelliHub V1'; break;
          case 101 : $type = 'Control IntelliHub V2'; break;
          default : $type = 'IntelliHub - ' + $respSplit[13]; break;
        }
      
      
        $resp = ['type'=>$type];
        $resp['version'] = $respSplit[1];
        $resp['serial'] = $respSplit[0];
        $resp['hubTime'] = $respSplit[6];
        $resp['timeZone'] = $respSplit[7];
        $resp['connectivity'] = $respSplit[9];
        $resp['isUpgrading'] = $respSplit[12];
        $resp['radioChannel'] = $respSplit[10];
      
        $totalResponse['live_response'] = $resp;
        $response = json_encode($totalResponse);
        return $response;
      }

    function genericSLResponse($liveResponse) {
        global $totalResponse;
      
        $respSplit = explode('=', $liveResponse);
        array_splice($respSplit, 0, 1);
      
        $totalResponse['live_response'] = $respSplit;
        $response = json_encode($totalResponse);
        return $response;
    }

    function getResponseResponseBuilder($liveResponse, $hubSerial){

        global $totalResponse;
        global $conn;
      
        $cmd_type = $_POST['responseForCmdType'];
        $called = $_POST['responseForCmdType'];
      
        if($called == 'setGeyserSchedule'){
      
          $schArr = ['days'=>''];
          $schArr['days'] = '01010110';
          $schArr['index'] = '1';
          $schArr['startHour'] = '10';
          $schArr['startMins'] = '01';
          $schArr['duration'] = '300';
      
          $totalResponse['dummy_resp'] = $schArr;
        }else if($called == 'setTollenoSchedule'){
          $schArr = ['days'=>''];
          $schArr['days'] = '01010110';
          $schArr['index'] = '1';
          $schArr['startHour'] = '10';
          $schArr['startMins'] = '01';
          $schArr['duration'] = '300';
          $schArr['relay'] = '3';
      
          $totalResponse['dummy_resp'] = $schArr;
      
        }else if($called == 'createEditProEMSelfTest'){
      
          $schArr = ['days'=>''];
          $schArr['days'] = '255';
          $schArr['index'] = '1';
          $schArr['startHour'] = '10';
          $schArr['startMins'] = '01';
          $schArr['duration'] = '300';
          $schArr['w49t56'] = '255';
          $schArr['w41t48'] = '255';
          $schArr['w33t40'] = '255';
          $schArr['w25t32'] = '255';
          $schArr['w17t24'] = '255';
          $schArr['w9t16'] = '255';
          $schArr['w1t8'] = '255';
      
          $totalResponse['dummy_resp'] = $schArr;
      
      
      
          $respSplit = explode('=', $liveResponse);
          array_splice($respSplit, 0, 1);
      
          $ints = bin2hex($liveResponse);
            
              $index = hexdec(substr( $ints, 16, 2 )); 
              $days = hexdec(substr( $ints, 18, 2 )); 
              $hour = hexdec(substr( $ints, 20, 2 )); 
              $minutes = hexdec(substr( $ints, 22, 2 )); 
              $duration = hexdec(substr( $ints, 24, 4 )); 
              $w49t56 = hexdec(substr( $ints, 28, 2 )); 
              $w41t48 = hexdec(substr( $ints, 30, 2 )); 
              $w33t40 = hexdec(substr( $ints, 32, 2 )); 
              $w25t32 = hexdec(substr( $ints, 34, 2 )); 
              $w17t24 = hexdec(substr( $ints, 36, 2 )); 
              $w9t16 = hexdec(substr( $ints, 38, 2 )); 
              $w1t8 = hexdec(substr( $ints, 40, 2 )); 
      
      
          $liveRespArr['index'] = $index;
          $liveRespArr['days'] = $days;
          $liveRespArr['hour'] = $hour;
          $liveRespArr['minutes'] = $minutes;
          $liveRespArr['duration'] = $duration;
          $liveRespArr['w49t56'] = $w49t56;
          $liveRespArr['w41t48'] = $w41t48;
          $liveRespArr['w33t40'] = $w33t40;
          $liveRespArr['w25t32'] = $w25t32;
          $liveRespArr['w17t24'] = $w17t24;
          $liveRespArr['w9t16'] = $w9t16; 
          $liveRespArr['w1t8'] = $w1t8;
      
          $totalResponse['live_response'] = $liveRespArr;
      
          $response = json_encode($totalResponse);
          return  $response;
      
      
        //   $sql12 = "SELECT * FROM proEM_Schedules WHERE pSchedDSerial = '$deviceSerialForResponse' AND pSchedIdx = '$index'";
        //   $result12 = $conn->query($sql12);
      
        //   if ($result12->num_rows > 0) {
        //     $sql11 = "UPDATE proEM_Schedules SET pSchedDays = '$days', pSchedHour = '$hour', pSchedMin = '$minutes', pSchedDurA = '0', pSchedDurB = '$duration', pSchedw49t56 = '$w49t56', pSchedw41t48 = '$w41t48', pSchedw33t40 = '$w33t40', pSchedw25t32 = '$w25t32', pSchedw17t24 = '$w17t24', pSchedw9t16 = '$w9t16', pSchedw1t8 = '$w1t8', pSchedHex = '', pSchedHubSerial = '$hubSerial' WHERE pSchedDSerial = '$deviceSerialForResponse' AND pSchedIdx = '$index'";
        //   } else {
        //     $sql11 = "INSERT INTO proEM_Schedules (pSchedDSerial, pSchedIdx, pSchedDays, pSchedHour, pSchedMin, pSchedDurA, pSchedDurB, pSchedw49t56, pSchedw41t48, pSchedw33t40, pSchedw25t32, pSchedw17t24, pSchedw9t16, pSchedw1t8, pSchedHex, pSchedHubSerial) 
        //     VALUES ('$deviceSerialForResponse', '$index', '$days', '$hour', '$minutes', '0', '$duration', '$w49t56', '$w41t48', '$w33t40', '$w25t32', '$w17t24', '$w9t16', '$w1t8', '', '$hubSerial')";
        //   }
      
        //   $result11 = $conn->query($sql11);
      
      
        }else if($called == 'getGensenseTemps'){
      
          $schArr = ['upper'=>''];
          $schArr['upper'] = '210';
          $schArr['lower'] = '3';
      
          $totalResponse['dummy_resp'] = $schArr;
        }else if($called == 'getGeyserExtra'){
      
          $schArr = ['errors'=>''];
          $schArr['errors'] = '0';
          $schArr['geyserTemp'] = '25';
          $schArr['solarTemp'] = '55';
          $schArr['maxTemp'] = '50';
          $schArr['variance'] = '5';
          $schArr['schedActive'] = '1';
          $schArr['monitoring'] = '1';
      
          $totalResponse['dummy_resp'] = $schArr;
      
        }else if($called == 'getProEMExtra'){
      
          $schArr = ['vLoad'=>''];
          $schArr['vLoad'] = '750';
          $schArr['vc1'] = '740';
          $schArr['vc2'] = '650';
      
          $totalResponse['dummy_resp'] = $schArr;
      
          $respSplit = explode('=', $liveResponse);
          array_splice($respSplit, 0, 1);
      
          $ints = bin2hex($liveResponse);
            
              $num3 = hexdec(substr( $ints, 16, 2 )); 
              $num3b = hexdec(substr( $ints, 18, 2 )); 
              $num4 = hexdec(substr( $ints, 20, 4 )); 
              $num5b = hexdec(substr( $ints, 24, 4 )); 
              $num7 = hexdec(substr( $ints, 28, 4 )); 
              $num9 = hexdec(substr( $ints, 32, 4 )); 
              $num10 = hexdec(substr( $ints, 36, 4 )); 
      
      
          $liveRespArr['vLoad'] = $num4;
          $liveRespArr['vc1'] = $num5b;
          $liveRespArr['vc2'] = $num7;
      
          $totalResponse['live_response'] = $liveRespArr;
      
          $response = json_encode($totalResponse);
          return  $response;
      
        }else if($called == 'getProEMSchedules'){
      
          $schArr = ['days'=>''];
          $schArr['days'] = '255';
          $schArr['index'] = '1';
          $schArr['startHour'] = '10';
          $schArr['startMins'] = '01';
          $schArr['duration'] = '300';
          $schArr['w49t56'] = '255';
          $schArr['w41t48'] = '255';
          $schArr['w33t40'] = '255';
          $schArr['w25t32'] = '255';
          $schArr['w17t24'] = '255';
          $schArr['w9t16'] = '255';
          $schArr['w1t8'] = '255';
      
          $totalResponse['rawRes'] = $liveResponse;
      
      
      
          $respSplit = explode('=', $liveResponse);
          
          array_splice($respSplit, 0, 1);
      
          $ints = bin2hex($liveResponse);
            
              $index = hexdec(substr( $ints, 16, 2 )); 
              $days = hexdec(substr( $ints, 18, 2 )); 
              $hour = hexdec(substr( $ints, 20, 2 )); 
              $minutes = hexdec(substr( $ints, 22, 2 )); 
              $duration = hexdec(substr( $ints, 24, 4 )); 
              $w49t56 = hexdec(substr( $ints, 28, 2 )); 
              $w41t48 = hexdec(substr( $ints, 30, 2 )); 
              $w33t40 = hexdec(substr( $ints, 32, 2 )); 
              $w25t32 = hexdec(substr( $ints, 34, 2 )); 
              $w17t24 = hexdec(substr( $ints, 36, 2 )); 
              $w9t16 = hexdec(substr( $ints, 38, 2 )); 
              $w1t8 = hexdec(substr( $ints, 40, 2 )); 
      
      
          $liveRespArr['index'] = $index;
          $liveRespArr['days'] = $days;
          $liveRespArr['hour'] = $hour;
          $liveRespArr['minutes'] = $minutes;
          $liveRespArr['duration'] = $duration;
          $liveRespArr['w49t56'] = $w49t56;
          $liveRespArr['w41t48'] = $w41t48;
          $liveRespArr['w33t40'] = $w33t40;
          $liveRespArr['w25t32'] = $w25t32;
          $liveRespArr['w17t24'] = $w17t24;
          $liveRespArr['w9t16'] = $w9t16; 
          $liveRespArr['w1t8'] = $w1t8;
      
          $totalResponse['live_response'] = $liveRespArr;
      
          $response = json_encode($totalResponse);
          return $response;
      
        //   $sql13 = "SELECT * FROM proEM_Schedules WHERE pSchedDSerial = '$deviceSerialForResponse' AND pSchedIdx = '$index'";
        //   $result13 = $conn->query($sql13);
      
        //   if ($result13->num_rows > 0) {
        //     $sql14 = "UPDATE proEM_Schedules SET pSchedDays = '$days', pSchedHour = '$hour', pSchedMin = '$minutes', pSchedDurA = '0', pSchedDurB = '$duration', pSchedw49t56 = '$w49t56', pSchedw41t48 = '$w41t48', pSchedw33t40 = '$w33t40', pSchedw25t32 = '$w25t32', pSchedw17t24 = '$w17t24', pSchedw9t16 = '$w9t16', pSchedw1t8 = '$w1t8', pSchedHex = '', pSchedHubSerial = '$hubSerial' WHERE pSchedDSerial = '$deviceSerialForResponse' AND pSchedIdx = '$index'";
        //   } else {
        //     $sql14 = "INSERT INTO proEM_Schedules (pSchedDSerial, pSchedIdx, pSchedDays, pSchedHour, pSchedMin, pSchedDurA, pSchedDurB, pSchedw49t56, pSchedw41t48, pSchedw33t40, pSchedw25t32, pSchedw17t24, pSchedw9t16, pSchedw1t8, pSchedHex, pSchedHubSerial) 
        //     VALUES ('$deviceSerialForResponse', '$index', '$days', '$hour', '$minutes', '0', '$duration', '$w49t56', '$w41t48', '$w33t40', '$w25t32', '$w17t24', '$w9t16', '$w1t8', '', '$hubSerial')";
        //   }
      
        //   $result14 = $conn->query($sql14);
      

      
        }else if($called == 'getPairedDevices'){
      
          $schArr = ['devices'=>'111111111,222222222,333333333'];
      
          $totalResponse['dummy_resp'] = $schArr;
      
      
        }else if($called == 'onOff'){
          $totalResponse['dummy_resp'] = '200';
      
          // $respSplit = explode('=', $liveResponse);
          $respSplit = preg_split('/[=,]/', $liveResponse);
          array_splice($respSplit, 0, 1);
      
          $totalResponse['live_response'] = $respSplit[0];
          $response = json_encode($totalResponse);
          return $response;
        }
    }

    

    function deviceListResponse($liveResponse, $hubSerial) {
        global $totalResponse;
        global $conn;
      
        $respSplit = explode('&', $liveResponse);
        array_splice($respSplit, 0, 1);
      
        $devArr = [];
        foreach ($respSplit as $deviceInArr) {
          $singleDevice = $respSplit = preg_split('/[,<>]/', $deviceInArr);
      
          $device = ['index'=>$singleDevice[0]];
          $device['mac'] = $singleDevice[1];
          $device['serial'] = $singleDevice[2];
          $device['type'] = $singleDevice[3];
          $device['state'] = $singleDevice[4];
          $device['tier'] = $singleDevice[5];
          $device['route1'] = $singleDevice[6];
          $device['route2'] = $singleDevice[7];
          $device['route3'] = $singleDevice[8];
          $device['route4'] = $singleDevice[9];
          $device['route5'] = $singleDevice[10];
          $device['route6'] = $singleDevice[11];
          $device['route7'] = $singleDevice[12];
          $device['neighbourCount'] = $singleDevice[13];
          $device['neighbour1'] = $singleDevice[14];
          $device['neighbour2'] = $singleDevice[15];
          $device['neighbour3'] = $singleDevice[16];
          $device['neighbour4'] = $singleDevice[17];
          $device['state2'] = $singleDevice[19];
          $device['version'] = $singleDevice[20];
          //TODO: write to devices table
      
          $serial = $singleDevice[2];
          $idx = $singleDevice[0];
          $type = $singleDevice[3];
          $mac = $singleDevice[1];
          $state = $singleDevice[4];
          $state2 = $singleDevice[19];
          $state3 = $singleDevice[20];
          
      
          $name = "";
          $favorite = "";
          $area = "";
          $reg = "";
          $dtreg = "";
          $s4 = "";
          $e1 = "";
          $e2 = "";
          $ds1 = "";
          $ds2 = "";
          $ds3 = "";
          $ds4 = "";
          $linkedTo = "";
          $delay = "";
          $rc = "";
          $added = "";
          $ip = "";
          $sql2 = "SELECT * FROM devices WHERE serial_no = '$serial'";
            $device = \DB::select($sql2)[0];
            //dd($device);
      
          if ($device) {
              $name = $device->device_name; 
              $favorite = $device->favorite; 
              $area = $device->d_area; 
              $reg = $device->registered; 
              $dtreg = $device->date_time_registered; 
              $s4 = $device->state4; 
              $e1 = $device->extra1; 
              $e2 = $device->extra2; 
              $ds1 = $device->devSpecific1; 
              $ds2 = $device->devSpecific2; 
              $ds3 = $device->devSpecific3; 
              $ds4 = $device->devSpecific4; 
              $linkedTo = $device->linkedTo; 
              $delay = $device->responseDelay; 
              $rc = $device->retryCount; 
              $added = $device->added; 
              $ip = $device->device_ip; 
          }
      
          $sql5 = "REPLACE INTO devices (serial_no, device_index, device_name, type, mac_address, favorite, hub_serial_no, d_area, registered, date_time_registered, state, state2, state3, state4, extra1, extra2, devSpecific1, devSpecific2, devSpecific3, devSpecific4, linkedTo, responseDelay, retryCount, added, device_Ip) 
                        VALUES ('$serial', '$idx', '$name', '$type', '$mac', '$favorite', '$hubSerial', '$area', '$reg', '$dtreg', '$state', '$state2', '$state3', '$s4', '$e1', '$e2', '$ds1', $ds2, '$ds3', '$ds4', '$linkedTo', '$delay', '$rc', '$added', '$ip')";
        //$resp5 = \DB::statement($sql5);
          
          array_push($devArr, $device);
        }
      
        $totalResponse['live_response'] = $devArr;
        $response = json_encode($totalResponse);
        return $response;
      }

    function socketHandler($message,$hubSerial){
        $response = "";
        global $cmd;
      
        $host    = "156.38.138.36";
        $port    = 7419;
        // create socket
        $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
        // connect to server
        $result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");
        // The message array  ontains all 100 pages requests for a single hub as well as the handshake code.
        // I use &$m as I want to work with the actual array not an instance of it. This way I can dynamically edit and respond to the handshake without having to have multiple methods.
        // The & just means its pointing to that specific location in memory.
        foreach($message as &$m){
          socket_write($socket, $m, strlen($m)) or die("Could not connect to server\n");
          socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array('sec' => 3, 'usec' => 0));
          // get server response
          socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 3, 'usec' => 0));
          //I removed the code to kill the process if the hub doesn't respond so it will just keep trying other hubs.
          //I need to add code to check if a hub does not respond to stop trying it and move onto a different hub.
          $result = socket_read ($socket, 2048) or die("IntelliHub not responding\n");
          
      
      
          switch ($m) {
            case 'u':    $result_arr = explode ("?", $result);   $message[1] = "au?" . $result_arr[1] . "," . $hubSerial;  break;
            case (substr( $m, 0, 3 ) === "au?"):    break;
            default:   break;
          }
          switch ($result) {
            case (substr( $result, 0, 2 ) === "hl"):    $response .= $this->deviceListResponse($result, $hubSerial); break;
            case (substr( $result, 0, 3 ) === "eul"):    $response .=  $result; $response +=  "|"; break;
            case (substr( $result, 0, 2 ) === "hi"):    $response .= $this->hubInfoResponse($result); break;
            case (substr( $result, 0, 3 ) === "log"):    $response .= $this->logResponse($result); break;
            case (substr( $result, 0, 2 ) === "sl"): 
              if(strpos($cmd, 'Response') != false) {
                $response .= $this->getResponseResponseBuilder($result, $hubSerial); break;
              }else{
                $response .= $this->genericSLResponse($result); break;
              }

              break;
            case (substr( $result, 0, 2 ) === "hv"):    $response .= $this->genericSLResponse($result); break;
            case (substr( $result, 0, 2 ) === "cl"):    $response .= $this->genericSLResponse($result); break;
            default:   break;
          }
        }
        socket_close($socket);
        return $response;
    }

    function getDevicesS($hubSerial, $page = 0){

        global $totalResponse;
        $comsPass = \DB::select('SELECT coms_password FROM hubs WHERE hub_serial_no = "'.$hubSerial.'"')[0]->coms_password;
        //dd($comsPass);
      
        $totalResponse = ['errors'=>''];
        $totalResponse['sent'] = $hubSerial . ' | hub';
      
          $hiMessages = ["u"];
          array_push($hiMessages, "au?");
          array_push($hiMessages,"ss!".$hubSerial.",hl?pw=".$comsPass."&part=".$page."\n");
          return $this->socketHandler($hiMessages, $hubSerial);

    }

    function getProEMSchedules($hubSerial, $devSer, $schedID){
        global $totalResponse;
        $comsPass = \DB::select('SELECT coms_password FROM hubs WHERE hub_serial_no = "'.$hubSerial.'"')[0]->coms_password;
      

        $d = str_replace(' ', '', $devSer);
        // $schedCmd = $_POST['schedCmd'];
        $schedIdx = $schedID;
        $hiMessages = ["u"];
        array_push($hiMessages, "au?");
        array_push($hiMessages,"ss!".$hubSerial.",sl?pw=".$comsPass."&".$d.",1," . chr(42) . chr($schedIdx));
        return $this->socketHandler($hiMessages, $hubSerial);
      
    }

    function hsbcCellReport(){


        $hsbcCells = \DB::select('SELECT * FROM hsbc_cellNumber_link');
        $fileName = 'hsbcRep.csv';
     
             $headers = array(
                 "Content-type"        => "text/csv",
                 "Content-Disposition" => "attachment; filename=$fileName",
                 "Pragma"              => "no-cache",
                 "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                 "Expires"             => "0"
             );
     
             $columns = array('Hub Name', 'Hub Serial', 'Cell Number', 'Start Date', 'Expiry Date', 'Hub Assoc. Email');
     
             $callback = function() use($hsbcCells, $columns) {
                 $file = fopen('php://output', 'w');
                 fputcsv($file, $columns);
     
                 foreach($hsbcCells as $hsbcCell){

                    $expDate = date('Y-m-d', strtotime($hsbcCell->startDate . " +1 year") );
                    if($expDate < '2023-01-01')
                        continue;
                    $hubPerm = \DB::select('SELECT * FROM hubPermissions WHERE hubSerial = "'.$hsbcCell->hubSerialCell.'"');
                    $hub_name = "No Name";
                    $email = "No Email";
        
                    if($hubPerm){
                        // /dd($hubPerm);
                        $hub_name = $hubPerm[0]->hubName;
                        $email = $hubPerm[0]->email;
        
                    }
                     $row['Hub Name']  = $hub_name;
                     $row['Hub Serial']    = $hsbcCell->hubSerialCell;
                     $row['Cell Number']    = $hsbcCell->cellNumber;
                     $row['Start Date']  = $hsbcCell->startDate;
                     $row['Expiry Date']  = date('Y-m-d', strtotime($hsbcCell->startDate . " +1 year") );
                     $row['Hub Assoc. Email']  = $email;

     
                     fputcsv($file, array($row['Hub Name'], $row['Hub Serial'], $row['Cell Number'], $row['Start Date'], $row['Expiry Date'], $row['Hub Assoc. Email']));
                 }
     
                 fclose($file);
             };
     
             return response()->stream($callback, 200, $headers);
    }

    function getResponse($hubSerial, $devSer ,$command){

        global $totalResponse;
        $comsPass = \DB::select('SELECT coms_password FROM hubs WHERE hub_serial_no = "'.$hubSerial.'"')[0]->coms_password;

        $serial = $devSer;


        $cmdToSend = 7;
        switch($command){
        case 'onOff': $cmdToSend = 7; break;
        case 'setGeyserSchedule': $cmdToSend = 42; break;
        case 'setTollenoSchedule': $cmdToSend = 42; break;
        case 'createEditProEMSelfTest': $cmdToSend = 42; break;
        case 'getProEMSchedules': $cmdToSend = 42; break;
        case 'getGensenseTemps': $cmdToSend = 44; break;
        case 'getGeyserExtra': $cmdToSend = 44; break;
        case 'getProEMExtra': $cmdToSend = 44; break;
        case 'getPairedDevices': $cmdToSend = 44; break;
        default: break;
        }

        $totalResponse = ['errors'=>''];
        $totalResponse['sent'] = $serial . ' | ' . $command;


        $hiMessages = ["u"];
        array_push($hiMessages, "au?");
        array_push($hiMessages,"ss!".$hubSerial.",sl?pw=".$comsPass."&".$serial.",250," . chr($cmdToSend) . chr(250));
        return $this->socketHandler($hiMessages, $hubSerial);

    }

    public function hubTest(){
        $response = $this->getDevicesS('823087088');
        dd($response);
    }

    public function getSchedule(Request $request){
        $data = $request->all();
        $returnObj = [];


        $allSchedules = [];
        $devSchedules = \DB::select('SELECT * FROM proEM_Schedules WHERE pSchedDSerial ="'.$data["device"].'"');

        $returnObj['state'] = '1';
        if(count($devSchedules) < 1){
            $returnObj['state'] = '0';
        }


        foreach($devSchedules as $devSchedule){
            switch($devSchedule->pSchedIdx){
                case 1:
                    $returnObj['weekly'] = [];
                    $returnObj['weekly']["days"] = [];
                    $returnObj['weekly']["hour"] = sprintf("%02d", $devSchedule->pSchedHour);
                    $returnObj['weekly']["mins"] = sprintf("%02d", $devSchedule->pSchedMin);
                    $returnObj['weekly']["duration"] = sprintf("%02d", $devSchedule->pSchedDurB);

                    break;
                case 2:
                    break;
                case 3:
                    break;
                case 4:
                    break;
                default:
                    break;
            }
        }
        //dd($devSchedules);

        return response()->json($returnObj);

    }

    public function lastOnlineRef(){
        $ret = exec('curl http://156.38.138.34/RelayServerPullLogs/manualRefresh.php > lastOnLogs.txt &');
        return $ret;
    }

    public function hubOverviewInit(Request $request){
        $data = $request->all();

        $deviceStats = [];


        $totalHubDevices = [];
        $hubResDevices = $this->getDevicesS($data["hubSer"]);
        if(str_contains($hubResDevices, "IntelliHub not responding")){
            $hubForAccount = \DB::select('SELECT * FROM hubPermissions WHERE hubSerial = "'.$data["hubSer"].'"')[0];
            $deviceStats['on'] = 0;
            $deviceStats['off'] = 0;
            $lastOnlineDevs = \DB::select('SELECT * FROM lastOnline WHERE hubSerial ="'.$hubForAccount->hubSerial.'"');
            if(count($lastOnlineDevs) < 1){
                $deviceStats['api_response'] = false;     
                $deviceStats['active'] = $hubForAccount->hubIsActive;


                $deviceStats['off'] = 0;
 

                $deviceStats['on'] = 0;

                $deviceStats['total'] = 0;


    
                $deviceStats['name'] = $hubForAccount->hubName;
    
                
                $percentageOff = 0;
                if(isset($deviceStats['off']))   
                    $percentageOff = 100;
                $deviceStats['percentOff'] = $percentageOff;
                $deviceStats['status'] = 'Online';
                $deviceStats['statusH'] = '#ccc';
    
                if($percentageOff > 80){
                    $deviceStats['status'] = 'Offline';
                    $deviceStats['statusH'] = '#aaa';
    
                }
            }
            foreach($lastOnlineDevs as $lastOnlineDev){
    
                $deviceStats['api_response'] = false;
                $deviceStats['active'] = $hubForAccount->hubIsActive;

                $deviceStats[$lastOnlineDev->serial]['status'] = $lastOnlineDev->extra;
    
    
                switch($lastOnlineDev->extra){
                    case 'Offline':
                        if(isset($deviceStats['off']))
                            $deviceStats['off']++;
                        else
                            $deviceStats['off'] = 1;
                        break;
                    case 'Online':
                        if(isset($deviceStats['on']))
                            $deviceStats['on']++;
                        else
                            $deviceStats['on'] = 1;
                        break;
                }
                if(isset($deviceStats['total']))
                    $deviceStats['total']++;
                else
                    $deviceStats['total'] = 1;


    
                $deviceStats['name'] = $hubForAccount->hubName;
    
                
                $percentageOff = 0;
                if(isset($deviceStats['off']))   
                    $percentageOff = $deviceStats['off']/$deviceStats['total']*100;
                $deviceStats['percentOff'] = $percentageOff;
                $deviceStats['status'] = 'Online';
                $deviceStats['statusH'] = '#ccc';
    
                if($percentageOff > 80){
                    $deviceStats['status'] = 'Offline';
                    $deviceStats['statusH'] = '#aaa';
    
                }
    
                    
            }
        }else{
            $hubResDevices = json_decode($hubResDevices, true);
            array_push($totalHubDevices , ...$hubResDevices['live_response']);
            $page = 1;
            while(count($hubResDevices['live_response']) == 8){
                $page++;
                $hubResDevices = $this->getDevicesS($data["hubSer"], $page);
                $hubResDevices = json_decode($hubResDevices, true);
                array_push($totalHubDevices , ...$hubResDevices['live_response']);
    
            }
            //dd($totalHubDevices);
    
            $hubForAccount = \DB::select('SELECT * FROM hubPermissions WHERE hubSerial = "'.$data["hubSer"].'"')[0];
            $deviceStats['on'] = 0;
            $deviceStats['off'] = 0;
            //dd($totalHubDevices);
            foreach($totalHubDevices as $totalHubDevice){
    
                $deviceStats['api_response'] = true;
                $deviceStats['active'] = $hubForAccount->hubIsActive;
    
                $deviceStats[$totalHubDevice['serial_no']]['status'] = $totalHubDevice['state'];
    
    
    
                switch($totalHubDevice['state']){
                    case '019':
                    case '010':
                        if(isset($deviceStats['off']))
                            $deviceStats['off']++;
                        else
                            $deviceStats['off'] = 1;
                        break;
                    default:
                        if(isset($deviceStats['on']))
                            $deviceStats['on']++;
                        else
                            $deviceStats['on'] = 1;
                        break;
    
    
                }
                if(isset($deviceStats['total']))
                    $deviceStats['total']++;
                else
                    $deviceStats['total'] = 1;
    
    
    
                $deviceStats['name'] = $hubForAccount->hubName;
    
                
                $percentageOff = 0;
                if(isset($deviceStats['off']))   
                    $percentageOff = $deviceStats['off']/$deviceStats['total']*100;
                $deviceStats['percentOff'] = $percentageOff;
                $deviceStats['status'] = 'Online';
                $deviceStats['statusH'] = '#3CBC3C';
    
                if($percentageOff > 80){
                    $deviceStats['status'] = 'Offline';
                    $deviceStats['statusH'] = '#FF2828';
                }
            }
        }


        return response()->json($deviceStats);

        
    }

    public function getDevices(Request $request){
        $data = $request->all();
        if(isset($data['getAllDevices'])){
            $results = \DB::select('SELECT d.serial_no, d.device_name, t.`name` as type, d.mac_address, d.hub_serial_no, h.hubName, d.date_time_registered FROM devices d LEFT JOIN device_types t ON t.code = d.`type` LEFT JOIN hubPermissions h ON h.hubSerial = d.hub_serial_no WHERE `type` = "026"');

            $return = "";


            foreach($results as $r){
                $return .= '<tr>';

                $return .= '<td>';
                $return .= $r->serial_no;
                $return .= '</td>';

                $return .= '<td>';
                $return .= $r->device_name;
                $return .= '</td>';


                $return .= '<td>';
                $return .= $r->type;
                $return .= '</td>';

                $return .= '<td>';
                $return .= $r->hub_serial_no;
                $return .= '</td>';

                $return .= '<td>';
                $return .= $r->hubName;
                $return .= '</td>';

                $return .= '<td>';
                $return .= date('d-M-Y', strtotime($r->date_time_registered));
                $return .= '</td>';

                $return .= '<td class="actions">';
                $return .= '<i class="material-icons text-success">edit</i><i class="material-icons text-danger">delete</i>';
                $return .= '</td>';


                $return .= '</tr>';

                
            }
            echo $return;

        }

        if(isset($data['getNonameDevices'])){
            $results = \DB::select("SELECT d.serial_no, d.device_name, t.`name` as type, d.mac_address, d.hub_serial_no, h.hubName, d.date_time_registered, l.`time` as lastOnline FROM devices d
            LEFT JOIN device_types t ON t.code = d.`type` 
            LEFT JOIN hubPermissions h ON h.hubSerial = d.hub_serial_no
            LEFT JOIN lastOnline l ON l.serial = d.serial_no
            WHERE d.device_name = ''");

            $return = "";


            foreach($results as $r){
                $return .= '<tr>';

                $return .= '<td>';
                $return .= $r->serial_no;
                $return .= '</td>';

                $return .= '<td>';
                $return .= $r->device_name;
                $return .= '</td>';


                $return .= '<td>';
                $return .= $r->type;
                $return .= '</td>';

                $return .= '<td>';
                $return .= $r->hub_serial_no;
                $return .= '</td>';

                $return .= '<td>';
                $return .= $r->hubName;
                $return .= '</td>';

                $return .= '<td>';
                $return .= date('d-M-Y', strtotime($r->date_time_registered));
                $return .= '</td>';

                $return .= '<td>';
                $return .= $r->lastOnline;
                $return .= '</td>';

                $return .= '<td class="actions">';
                $return .= '<button class="btn btn-xs btn-primary">Remove</button>';
                $return .= '</td>';


                $return .= '</tr>';

                
            }
            echo $return;
        }

    }

    public function getUsers(){
        dd(User::get());
    }
    public function login2(Request $request){
        
        $data = $request->all();
		$user = User::where('email', $data['email'])->where('password', $data['password'])->first();
		if($user){
            \Auth::login($user, false);
            return redirect()->route('hubs');
		}

		return redirect()->route('login.2');
    }
}
