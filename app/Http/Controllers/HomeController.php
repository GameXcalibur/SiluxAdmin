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
        $offlineDevs = \DB::select('SELECT * FROM lastOnline WHERE hubSerial = "'.$data["hubSer"].'" AND extra = "Offline"');
        $offlineRet = "";

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
        $returnObj['offDev'] = $offlineRet;
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
            return redirect()->route('profile');
		}

		return redirect()->route('login.2');
    }
}
