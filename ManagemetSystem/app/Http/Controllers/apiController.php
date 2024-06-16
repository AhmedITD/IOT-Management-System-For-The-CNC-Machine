<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\gcode;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class apiController extends Controller
{
    function apiLogin(Request $request)
    {
        $request->validate([
                'name' => 'required',
                'password' => 'required'
                ]);
        $data = $request->only('name','password');
        if(Auth::attempt($data)){
            $user = User::where('name', $request->name)->first();
            $token = $user->createToken("auth_token")->plainTextToken;
            $data = ['token' => $token]; 
            return response()->json($data, 200);
        }else{
            $data = [
                "state" => "190",
                "messege" => "wrong info",
                "data" => ""
                ];
            return response()->json($data, 200);
        }
    }

    public function api()
    {
        $gcodes = gcode::all();
        $gcode = $gcodes->where('permit' ,1);
        foreach($gcode as $s){$gcodeOBJ = $s;}
        if($gcode->count() > 1)
        {
            $data = [
            "state" => "100",
            "messege" => "more than one permit!!",
            "data" => ""
            ];
        } elseif ($gcode->count() < 1)
        {
            $data = [
                "state" => "150",
                "messege" => "No permit!!",
                "data" => ""
                ];
        } elseif ($gcodeOBJ->realTimeInfo != "0")
        {
            $data = [
                "state" => "180",
                "messege" => "setting mode",
                "data" => $gcodeOBJ
                ];
        } else
        {
            $path = public_path("assets\\uploades\\" . $gcodeOBJ->gcode);
            $contnent = file_get_contents($path);
            $gcodeOBJ->gcodeContent = $this->parseCsvWithNewline($contnent);
            $data = [
            "state" => "200",
            "messege" => "succes",
            "data" => $gcodeOBJ
            ];
        }
        return response()->json($data, 200);
    }        
    
    function apipost(gcode $gcode, Request $request)
    {
        $stateCode = $request->code;
        $data = ['realTimeInfo' => $stateCode];
        $stateUpdate = $gcode->update($data);
        if ($stateUpdate) 
        {
            if ($request->code == "2") 
            {
                $data = [
                    'realTimeInfo' => "0",
                    'permit' => "0"
                ];
                $stateUpdate = $gcode->update($data);
            }
            if ($request->code == "3") 
            {
                $gcode->delete();
            }
            if ($request->code == "4") 
            {
                $gcode->delete();
            }
            return response()->json("state Recived", 200);
        } else 
        {
            return response()->json("state Not Recived!!", 200);
        }
    }
}
