<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        try {
            $user = new User();
            Validate::validate("email", $request->email) ? $user->email = $request->email : Validate::errorMessage("Email Já existente");
            
            $user->name = $request->name;
            $user->kind_user = $request->kind_user;
            $user->password = bcrypt($request->password);

            if(isset($request->id_user_master))
            {
                $user->id_user_master = $request->id_user_master;
            }

        } catch (Exception $e) {
            print_r(
                json_encode(
                    [
                        "Erro" => $e->getMessage()
                    ]
                )
            );
        }
    }
}

class Validate
{
    public static function validate(string $field, $value)
    {
        try {
            if(User::where($field, $value) == null){
                return true;
            }
            return false;
        } catch (Exception $e) {
            print_r(
                json_encode(
                    [
                        "Erro" => $e->getMessage()
                    ]
                )
            );
        }
    }

    public static function errorMessage(string $message)
    {
        return response()->json([
            "error" => $message
        ], 400);
    }
}
