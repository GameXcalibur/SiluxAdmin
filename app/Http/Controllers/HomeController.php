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

    public function getDevices(Request $request){
        $data = $request->all();
        if(isset($data['getAllDevices'])){
            $results = \DB::select('SELECT d.serial_no, d.device_name, t.`name` as type, d.mac_address, d.hub_serial_no, h.hubName, d.date_time_registered FROM devices d LEFT JOIN device_types t ON t.code = d.`type` LEFT JOIN hubPermissions h ON h.hubSerial = d.hub_serial_no ');

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
