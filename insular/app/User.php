<?php

namespace App;

use Illuminate\Http\Request;
use File;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{


    use Notifiable;

    /**
     * Aqui van los atributos de la tabla que seran editables por el modelo.
     * Normalmente se declaran todos y ya.
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'profile_img_url',
        'country_id',
        'wallet_id',
        'active' ,
        'verified',
        'ready_to_withdraw',
        'in_verified_process',
        'passport_number',
        'passport_img_url',
        'account_id'
    ];


    /**
     * estos datos son sensibles por lo que cuando haces select *, al colocarlos en este array no seran devueltos.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $ruleForCreate = [

        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required',
        'password' => 'required',
        'country_id' => 'required',
        'profile_image' => 'required'

    ];

    public $ruleForUpdate = [

        'first_name' => 'required',
        'last_name' => 'required',
        'password' => 'required',
        'country_id' => 'required'
    ];

    public $ruleForVerify = [
        'passport_number' => 'required',
        'passport_image' => 'required'
    ];

    public $ruleForUpdateStatus = [
        'status' => 'required'
    ];


    /**
     * Metodo encargado de generar una nueva instancia de la clase User y Wallet.
     * @param Request $request en esta instancia van almacenados todos los campos eviados por el POST
     * @return User|\Illuminate\Contracts\Validation\Validator
     */
    public static function generateUser(Request $request){


        $validatorModel = new User; /// Creamos un objeto tipo user (solo para tener una instancia y poder usar el validator.
        $validator = Validator::make($request->all(),$validatorModel->ruleForCreate); //aca le pasamos al request las reglas definidas en esta clase

        //Caso 1. Que los parametros enviados al API seran erroneos, en este caso le retornamos al usuario un JSON con los errores.
        if($validator->fails()){

            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = $validator->errors();
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);

        }

        //Caso 2, el email es unique, debemos revisar si ya existe ese registro.
        $persistentUser = User::where('email',$request->get('email') )
            ->take(1)
            ->get();

        if ($persistentUser->first()) {

            //En caso de que exista le mandamos el error al usuario.
            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = "The email sended is already registered, try another";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }


        //Caso 3 Errores creando las imagenes.
        $savedImg = false;
        if( $request->hasFile('profile_image') ) {

            if(substr($request->file('profile_image')->getMimeType(), 0, 5) == 'image') {

                $file = $request->file('profile_image');

                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                if($file->move('uploads/', $filename)){
                    $savedImg = true;
                }
            }

        }


        //caso 4, si creamos ok, procedemos a crear el wallet y asignarlo al usuario.

        $wallet = Wallet::generateWallet();

        if($wallet != null ){
            $user = new User($request->all());
            $user -> wallet_id = $wallet->id;
            if($savedImg) {

                $user->profile_img_url = URL_UPLOAD.$filename;
            }
        }


        $encrypted = Crypt::encryptString($request->get('password'));
        $user->password  =$encrypted;
        //Caso 5, si estamos ok y el usuario es guardado en bd. retorno el Json con la respuesta exitosa.
        if($user->save()){
            $response = new BaseResponse();

            $response-> data= $user;
            $response-> message = "success";
            $response ->status = "200";

            return json_encode($response,JSON_UNESCAPED_SLASHES);

        }else{
            //Caso 6, por algun motivo no funciono. lanzamos error generl.
            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = "Unexpected error, please try again later.";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }

    }

    public static function requestValidateProcess(Request $request, $userId){

        $validatorModel = new User; /// Creamos un objeto tipo user (solo para tener una instancia y poder usar el validator.
        $validator = Validator::make($request->all(),$validatorModel->ruleForVerify); //aca le pasamos al request las reglas definidas en esta clase

        //Caso 1. Que los parametros enviados al API seran erroneos, en este caso le retornamos al usuario un JSON con los errores.
        if($validator->fails()){

            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = $validator->errors();
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);

        }

        $persistentUser = User::where('id',$userId )
            ->take(1)
            ->get();


        if (!$persistentUser->first()) {
            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = "The user is not registered";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);

        }

        //Caso 3 Errores creando las imagenes.
        $savedImg = false;
        if( $request->hasFile('passport_image') ) {


            $file = $request->file('passport_image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename =time().'.'.$extension;
            if($file->move('passports/', $filename)){
                $savedImg = true;
            }

        }else{
            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = "The  image is not supported. Try with another image";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }


        if($savedImg){
            $persistentUser->passport_number = $request->get('passport_number');
            $persistentUser->passport_img_url = URL_PASSPORT_IMAGES.$filename;
        }else{
            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = "The  image is not supported. Try with another image";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }


        $values = [
            'passport_number'=>  $request->get('passport_number'),
            'passport_img_url'=>  URL_PASSPORT_IMAGES.$filename,
            'in_verified_process' => 1
        ];


        if(DB::update('update users set
                      passport_number = \''.$values['passport_number'].'\' ,
                      in_verified_process = '.$values['in_verified_process'].' ,
                      verified = 0 ,
                      passport_img_url = \''.$values['passport_img_url'].'\' where id = ?', [$userId])){

            $updatedUser = User::where('id',$userId )
                ->take(1)
                ->get();

            $response = new BaseResponse();

            $response-> data= $updatedUser->first();
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

    public static function validateUser(Request $request, $userId){
        $persistentUser = User::where('id',$userId )
            ->take(1)
            ->get();


        if (!$persistentUser->first()) {

            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = "The user is not registered";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);

        }

        if($persistentUser -> first()-> passport_number == null ||
                $persistentUser ->first()->passport_img_url == null){

            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = "The user doesn't has passport information";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);

        }
        $newStatus = $start = Input::get('new_status');

        if($persistentUser->first()->verified == $newStatus){

            $response = new BaseResponse();

            $response-> data= $persistentUser;
            $response-> message = "success";
            $response ->status = "200";

            return json_encode($response,JSON_UNESCAPED_SLASHES);

        }


        if(DB::update('update users set
                      verified = '.$newStatus.' , in_verified_process = 0 where id = ? in_verified_process', [$userId])){

            $updatedUser = User::where('id',$userId )
                ->take(1)
                ->get();

            $response = new BaseResponse();

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

    public static function generateUserAccount(Request $request, $userId){

        $persistentUser = User::where('id',$userId )
            ->take(1)
            ->get();


        if (!$persistentUser->first()) {

            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = "The user is not registered";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);

        }

        $account=  new Account($request->all());


        $validator = Validator::make($request->all(),Account::getRulesForCreateAccount()); //aca le pasamos al request las reglas definidas en esta clase

        //Caso 1. Que los parametros enviados al API seran erroneos, en este caso le retornamos al usuario un JSON con los errores.
        if($validator->fails()){

            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = $validator->errors();
            $response ->status = "500";

            return $response->toJson();

        }

        //$account = Account::generateUserAccount( $request);

        if ($account->save())
        {
            //$persistentUser->account_id = $account->id;

            DB::update('update users set
                      account_id = '.$account->id.' where id = ?', [$userId]);

            $persistentUser[0]['account'] = $account;

            $response = new BaseResponse();

            $response-> data= $persistentUser[0];
            $response-> message = "the account was registered correctly";
            $response ->status = "200";


        }



        return (json_encode($response,JSON_UNESCAPED_SLASHES));

    }

    public static function updateProfileInformation(Request $request, $userId){

        //At First, we need to check the type of update
        //type 1 Only the main information (except the email)
        //Type 2 the passport Information
        //Type 3 the withdraw account information

        if($request->get('update_type') == null){
            $response = new BaseResponse();

            $response-> message = "Error, the update_type is required.";
            $response ->status = "500";
            //$response-> data= "[]";

            return json_encode($response,JSON_UNESCAPED_SLASHES);

        }

        $updateType = $request->get('update_type');
        $persistentUser = User::where('id',$userId )
            ->take(1)
            ->get();

        if (!$persistentUser->first()) {

            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = "The user is not registered";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);

        }
        $userForPassword = User::find($userId)->first();
        $validCred = false;
        if($userForPassword == null){
            $response = new BaseResponse();

            $response ->status = "500";
            $response-> message = "Error, please check your email address.";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }else{

/*
            $password = 'pass1234';

            $encryptedPassword = encrypt($password);
            $decryptedPassword = decrypt($encryptedPassword);

            $password == $decryptedPassword // true

*/
            echo ($userForPassword->password);

            $encrypted = Crypt::encryptString($request->get('password'));
            echo ("<br>");
            echo ($encrypted);
            die();
            if($userForPassword->password == $request->get('password')){
                $response = new BaseResponse();

                $response ->status = "200";
                $response-> message = "success";
                $response-> data= $userForPassword;
                $validCred = true;

            }else{
                $response = new BaseResponse();

                $response ->status = "501";
                $response-> message = "Error, please check your password.";
                //$response-> data= "[]";

                return json_encode($response,JSON_UNESCAPED_SLASHES);
            }

        }


        if($updateType==1){

            $validatorModel = new User; /// Creamos un objeto tipo user (solo para tener una instancia y poder usar el validator.
            $validator = Validator::make($request->all(),$validatorModel->ruleForUpdate);
            if($validator->fails()){

                $response = new BaseResponse();

                //$response-> data= "[]";
                $response-> message = $validator->errors();
                $response ->status = "500";

                return json_encode($response,JSON_UNESCAPED_SLASHES);

            }else{

                $savedImg = false;
                if( $request->hasFile('profile_image') ) {

                    if(substr($request->file('profile_image')->getMimeType(), 0, 5) == 'image') {

                        $file = $request->file('profile_image');

                        $extension = $file->getClientOriginalExtension(); // getting image extension
                        $filename =time().'.'.$extension;
                        if($file->move('uploads/', $filename)){
                            $savedImg = true;
                        }
                    }else{
                        $response = new BaseResponse();

                        //$response-> data= "[]";
                        $response-> message = "The  image is not supported. Try with another image";
                        $response ->status = "500";

                        return json_encode($response,JSON_UNESCAPED_SLASHES);
                    }

                }else{
                    $savedImg = false;
                }

                if(!$savedImg){
                  $values = [
                      'first_name' => $request->get('first_name'),
                      'last_name' => $request->get('last_name'),
                      'country_id' => $request->get('country_id')
                  ];

                  if(DB::update('update users set
                        first_name = \''.$values['first_name'].'\' ,
                        last_name = \''.$values['last_name'].'\' ,
                        country_id = '.$values['country_id'].'  where id = ?', [$userId])){

                      $updatedUser = User::where('id',$userId )
                          ->get()->first();

                      $response = new BaseResponse();

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

                $values = [
                    'first_name' => $request->get('first_name'),
                    'last_name' => $request->get('last_name'),
                    'password' => $request->get('password'),
                    'country_id' => $request->get('country_id'),
                    'profile_img_url' =>  URL_UPLOAD.$filename
                ];

                if(DB::update('update users set
                      first_name = \''.$values['first_name'].'\' ,
                      last_name = \''.$values['last_name'].'\' ,
                      password = \''.$values['password'].'\' ,
                      country_id = '.$values['country_id'].' ,
                      profile_img_url = \''.$values['profile_img_url'].'\' where id = ?', [$userId])){

                    $updatedUser = User::where('id',$userId )
                        ->get()->first();

                    $response = new BaseResponse();

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

        if($updateType ==2){
            return User::requestValidateProcess($request,$userId);
        }

        if($updateType == 3){
            return User::generateUserAccount($request,$userId);
        }

        $response = new BaseResponse();

        $response-> message = "Error, the update_type is required.";
        $response ->status = "500";
        //$response-> data= "[]";

        return json_encode($response,JSON_UNESCAPED_SLASHES);

    }

    public static function updateUserStatus(Request $request, $userId){

        $persistentUser = User::where('id',$userId )
            ->take(1)
            ->get();


        if (!$persistentUser->first()) {
            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = "The user is not registered";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);

        }

        $newStatus =  $request->get('status');


        if($persistentUser->first()->status == $newStatus){

            return "the same status";

        }


        if($newStatus == "")
        {
            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = "The status is required";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }

        if(filter_var($newStatus, FILTER_VALIDATE_INT) === false || ($newStatus != 1 && $newStatus != 2))
        {
            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = "The status should be 1 for active and 0 for inactive.";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }

        $values = [
            'status'=>  $request->get('status')
        ];

        if(DB::update('update users set
                      active = '.$values['status'].'  where id = ?', [$userId])){

            $updatedUser = User::where('id',$userId )
                ->take(1)
                ->get();

            $response = new BaseResponse();

            $response-> data= $updatedUser;
            $response-> message = "success";
            $response ->status = "200";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }else{
            $response = new BaseResponse();

            //$response-> data= "[]";
            $response-> message = "Unexpected error, please contact the admin.";
            $response ->status = "500";

            return json_encode($response,JSON_UNESCAPED_SLASHES);
        }

    }


}
