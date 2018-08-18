<?php

namespace App\Http\Controllers;

use App\BaseResponse;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Country;

class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $userList = User::all();
      //dd($userList);
      //die();
      return view('users', compact('userList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $response = new BaseResponse();

        $response ->status = "200";
        $response-> message = "success";
        $response-> data= $user;

        return json_encode($response,JSON_UNESCAPED_SLASHES);
    }

    public function seeUserDetail($userId){
      $user = User::find($userId);
      $country = Country::find($user->country_id);
      $user->country = $country;

      if($user == null){
        return redirect('home');
      }else {
        return view ('user_detail',  compact('user'));
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function createUser(Request $request){

        return User::generateUser($request);
    }

    public function requestValidateProcess(Request $request, $naturalPersonId){

        return User::requestValidateProcess($request,$naturalPersonId);
    }

    public function validateUser(Request $request, $naturalPersonId){

        return User::validateUser($request,$naturalPersonId);
    }

    public function generateUserAccount(Request $request, $naturalPersonId){

        return User::generateUserAccount($request,$naturalPersonId);

    }

    public function updateUserInformation(Request $request, $naturalPersonId){
        return User::updateProfileInformation($request,$naturalPersonId);
    }

    public function changeActiveStatus(Request $request, $naturalPersonId){
        return User::updateUserStatus($request,$naturalPersonId);
    }

    public function getAllUsers(){

        $response = new BaseResponse();

        $response ->status = "200";
        $response-> message = "success";
        $response-> data= User::all();


        return json_encode($response,JSON_UNESCAPED_SLASHES);

    }

    public function loginUser(Request $request){

        $email = $request->get('email');
        $password=$request->get('password');

        if($email == null || $email == ""){

            $response = new BaseResponse();

            $response ->status = "500";
            $response-> message = "Error, the email is required.";
            //$response-> data= "[]";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }

        if($password == null || $password ==""){

            $response = new BaseResponse();

            $response ->status = "500";
            $response-> message = "Error, the password is required.";
            //$response-> data= "[]";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }

        $user = User::select()->where('email',$email)->first();

        if($user == null){
            $response = new BaseResponse();

            $response ->status = "500";
            $response-> message = "Error, por favor verifica tu dirección de correo electrónico.";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }else{
            $testVal = $user->password;
            $salt = $request->get('email') . $password . "INSULARKEYAFTER";
            $hashed = hash('sha512',$salt);


            if($testVal == $hashed){
                $response = new BaseResponse();

                $response ->status = "200";
                $response-> message = "success";
                $response-> data= $user;

                return json_encode($response,JSON_UNESCAPED_SLASHES);
            }else{
                $response = new BaseResponse();

                $response ->status = "500";
                $response-> message = "Error, por favor verifica tu contraseña.";
                //$response-> data= "[]";

                return json_encode($response,JSON_UNESCAPED_SLASHES);
            }

        }

    }

    public function validateUserViaAdmin(Request $request, $userId){

        $persistentUser = User::where('id',$userId )
            ->take(1)
            ->get();



        if (!$persistentUser->first()) {

            $response = new BaseResponse();
            return redirect('home');

        }

        if($persistentUser -> first()-> passport_number == null ||
                $persistentUser ->first()->passport_img_url == null){

            return redirect('users');


        }
        $newStatus = $start = Input::get('new_status');

        if($persistentUser->first()->verified == $newStatus){
          return redirect('users');
        }


        if(DB::update('update users set
                      verified = '.$newStatus.' , in_verified_process = 0 where id = ? ', [$userId])){

            $updatedUser = User::where('id',$userId )
                ->take(1)
                ->get();

            $response = new BaseResponse();

            return redirect('users/'.$userId);

            $response-> data= $updatedUser;
            $response-> message = "success";
            $response ->status = "200";

            return json_encode($response,JSON_UNESCAPED_SLASHES);

        }else{
            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = "Unexpected error, please contact the admin";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }


    }


}
