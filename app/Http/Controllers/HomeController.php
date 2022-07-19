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
            $hubResDevices = $this->api("POST", "156.38.138.34/api/api_pass.php", $data1);
            $hubResDevices = json_decode($hubResDevices, true);
            array_push($totalHubDevices , ...$hubResDevices['live_response']);
            while(count($hubResDevices['live_response']) == 8){
                $data1['page']++;
                $hubResDevices = $this->api("POST", "156.38.138.34/api/api_pass.php", $data1);
                $hubResDevices = json_decode($hubResDevices, true);
                array_push($totalHubDevices , ...$hubResDevices['live_response']);
    
            }

            foreach($totalHubDevices as $totalHubDevice){
                $deviceObj = \DB::select('SELECT * FROM devices WHERE serial_no = "'.$totalHubDevice['serial'].'"');

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
                $allDevices .= $totalHubDevice['serial'];
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
                    $allDevices .= '<a rel="tooltip" class="btn btn-info btn-link"  data-original-title="" onclick="viewSchedule(\''.$data["hubSer"].'\', \''.$totalHubDevice['serial'].'\');" title=""><i class="material-icons">schedule</i><div class="ripple-container"></div></a>';

                $allDevices .= '<a rel="tooltip" class="btn btn-danger btn-link"  data-original-title="" onclick="deleteDevice(\''.$data["hubSer"].'\', \''.$totalHubDevice['serial'].'\');" title=""><i class="material-icons">delete</i><div class="ripple-container"></div></a>';

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
                    $onBattRet .= $totalHubDevice['serial'];
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
                    $battOpen .= $totalHubDevice['serial'];
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
                    $battShort .= $totalHubDevice['serial'];
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

    public function getSchedule(Request $request){
        $data = $request->all();
        $returnObj = [];
        $data1 = [];
        $data1['api_key'] = 'abcd132453wq069n';
        $data1['hubSerial'] = $data["hub"];
        $data1['devSerial'] = $data["device"];

        $data1['cmd'] = 'getProEMSchedules';
        $data1['index'] = 1;

        $allSchedules = [];
        $hubResSchedules = $this->api("POST", "156.38.138.34/api/api_pass.php", $data1);
        if(str_contains($hubResSchedules, "IntelliHub not responding")){
            $returnObj['status'] = FALSE;
        }else{

            $returnObj['status'] = TRUE;
            $returnObj['data'] = json_decode($hubResSchedules, true);
            $returnObj['dataSent'] = $data1;

            $data1 = [];
            $data1['api_key'] = 'abcd132453wq069n';
            $data1['hubSerial'] = $data["hub"];
            $data1['devSerial'] = $data["device"];
    
            $data1['cmd'] = 'getResponse';
            $data1['responseForCmdType'] = 'getProEMSchedules';
            usleep(10000);
            $hubResSchedulesResponse = $this->api("POST", "156.38.138.34/api/api_pass.php", $data1);

            $returnObj['dataRes'] = json_decode($hubResSchedulesResponse, true);




        }

        return response()->json($returnObj);

    }

    public function hubOverviewInit(Request $request){
        $data = $request->all();

        $deviceStats = [];
        $data1 = [];
        $data1['api_key'] = 'abcd132453wq069n';
        $data1['hubSerial'] = $data["hubSer"];
        $data1['cmd'] = 'getDevices';
        $data1['page'] = 1;


        $totalHubDevices = [];
        $hubResDevices = $this->api("POST", "156.38.138.34/api/api_pass.php", $data1);
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
            while(count($hubResDevices['live_response']) == 8){
                $data1['page']++;
                $hubResDevices = $this->api("POST", "156.38.138.34/api/api_pass.php", $data1);
                $hubResDevices = json_decode($hubResDevices, true);
                array_push($totalHubDevices , ...$hubResDevices['live_response']);
    
            }
            //dd($totalHubDevices);
    
            $hubForAccount = \DB::select('SELECT * FROM hubPermissions WHERE hubSerial = "'.$data["hubSer"].'"')[0];
            $deviceStats['on'] = 0;
            $deviceStats['off'] = 0;
    
            foreach($totalHubDevices as $totalHubDevice){
    
                $deviceStats['api_response'] = true;
                $deviceStats['active'] = $hubForAccount->hubIsActive;
    
                $deviceStats[$totalHubDevice['serial']]['status'] = $totalHubDevice['state'];
    
    
    
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
