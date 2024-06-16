<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\gcode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
class gcodeController extends Controller
{
    function index()
    {
        $gcodes = gcode::all();
        return view("gcodes/index", ['gcodes' => $gcodes]);
    }

    function create()
    {
        return view("gcodes/create");
    }

    function createPost(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|string|max:255',
        'password' => 'required|min:6|confirmed',
        'photo' => 'mimes:jpg,jpeg,png|between:0.0000000001,5000000',
        'gcode' => 'required|mimes:text,txt,gcode|between:0.0000000001,5000000'
        ]);
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        if($request->has(['photo']))
        {
        $data['photo'] = $request->photo->store('images', 'public');
        }
        $data['gcode'] = $request->gcode->store('gcodes', 'public');
        $newgcode = gcode::create($data);
        if ($newgcode) 
        {
            return redirect(route(name: 'gcodes'))->with('succes', 'Created');
        }
    }

    function edite(gcode $gcode)
    {
        return view("gcodes/edite", ['gcode' => $gcode]);
    }

    function update(gcode $gcode, Request $request)
    {
        $data = $request->validate(
        [
        'name' => 'required|string|max:255',
        'email' => 'required|email|string|max:255',
        'password' => 'required|min:6|confirmed',
        'photo' => 'mimes:jpg,jpeg,png|between:0.0000000001,5000000',
        'gcode' => 'required|mimes:text,txt,gcode|between:0.0000000001,5000000'
        ]
        );
        $path = public_path('assets/uploades') ;
        if($gcode['photo'] != '')
        {
        unlink($path . '/' .  $gcode->photo);
        }
        unlink($path . '/' .  $gcode->gcode);
        $data = 
        [
            'name'=> $request->name, 
            'email'=> $request->email,
            'password'=>Hash::make($request->password),
            'gcode'=>$request->gcode->store('gcodes', 'public')
        ];
        if($request->has(['photo']))
        {
            $data['photo'] = $request->photo->store('images', 'public');
        }
        $update = $gcode->update($data);
        return redirect(route(name: 'gcodes'))->with('succes', 'updated');
    }
    
    function delete(gcode $gcode)
    {
        $path = public_path('assets/uploades') ;
        $photoPath = $gcode->photo;
        $gcodePath = $gcode->gcode;
        if($gcode['photo'] != '')
        {
        unlink($path . '/' .  $photoPath);
        }
        unlink($path . '/' .  $gcodePath);
        $gcode->delete();
        return redirect(route(name: 'gcodes'))->with('succes', 'deleted');
    }

    function ask(gcode $gcode)
    {
        return view("gcodes/ask", ['gcode' => $gcode]);
    }

    function askPost(gcode $gcode, Request $request)
    {
        $check = Hash::check($request->password ,$gcode->password);
        if($check)
        {
            $data['permit'] ='1';
            $gcode->update($data);
            return redirect(route(name: 'gcodes'))->with('succes', 'permited');
        } else
        {
            return redirect(route(name: 'gcodes'))->with('error', 'Failed');
        }
    }

    function RealTime()
    {
        $gcodes = gcode::all();
        $gcode = $gcodes->where('permit' ,1);
        if($gcode->count() > 1)
        {
            $gcodeRealTime_fromphp = "more than one permit!!";
        } elseif ($gcode->count() < 1) 
        {
            $gcodeRealTime_fromphp = "no permit untill know";
        } else
        {
            foreach($gcode as $s){$gcodeOBJ = $s;}
            switch($gcodeOBJ->realTimeInfo)
            {
                case "0": $gcodeRealTime_fromphp = "off";
                    break;
                case "1": $gcodeRealTime_fromphp = "Get Req Recived, Proccing";
                    break;
                case "2": $gcodeRealTime_fromphp = "end Proccing";
                    break;
                case "3": $gcodeRealTime_fromphp = "setting the speed";
                    break;
                case "4": $gcodeRealTime_fromphp = "setting the accelration";
                    break;            
                default: $gcodeRealTime_fromphp = "Unknown status";
                    break;           
            }
        }
    $gcodeRealTime = ['gcodeRealTime_fromphp' => $gcodeRealTime_fromphp];
    return view('gcodes/RealTime')->with('gcodeRealTime', $gcodeRealTime);
    }

    function Settings(Request $request)
    {
        return view('gcodes/Settings');
    }
    
    function SettingsPost(Request $request)
    { 
        $TheSelect = $request->selsect;
        $value = $request->value;
        switch($TheSelect)
        {
            case "theSpeed": 
                if (is_numeric($value) && floor($value) == $value) 
                {
                    $value = (int) $value; // Convert to integer
                    if($value <= 5000 && $value >= 500)
                    {
                    $strvalue = (string) $value;
                    $data = 
                    [
                        'settings_value' =>  $strvalue,
                        'realTimeInfo' => "3",
                        'permit' => "1",
                        'name' => "fake",
                        'email' => "fake",
                        'password' =>"fake",
                        'photo' =>"fake",
                        'gcode' =>"fake"
                    ];   
                    $newgcode = gcode::create($data);
                    return redirect(route(name: 'gcodes'))->with('succes', 'updating...');
                    } else 
                    {
                        $error = "too hight or low speed plez enter a nother value";
                    }
                } else 
                {
                    $error = "The value must be a valid integer.";
                }
                break;
            case "theAcceleration": 
                if (is_numeric($value) && floor($value) == $value) 
                {
                    $value = (int) $value; // Convert to integer
                    if($value <= 1000 && $value >= 100)
                    {
                    $data = 
                    [
                        'settings_value' => $value,
                        'realTimeInfo' => "4",
                        'permit' => "1",
                        'name' => "fake",
                        'email' => "fake",
                        'password' =>"fake",

                        'photo' =>"fake",
                        'gcode' =>"fake"
                    ];
                    $newgcode = gcode::create($data);
                    return redirect(route(name: 'gcodes'))->with('succes', 'updating...');
                    } else 
                    {
                        $error = "too hight or low Acceleration plez enter a nother value";
                    }
                } else 
                {
                    $error = "The value must be a valid integer.";
                }
                break;
            default: $error = "unkown select";
                break;
        }
        return redirect(route(name: 'Settings'))->with('error', $error);
    }
}
