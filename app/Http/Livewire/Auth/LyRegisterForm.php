<?php

namespace App\Http\Livewire\Auth;

use App\Mail\NewUserNotification;
use App\Models\Country;
use App\Models\Department;
use App\Models\District;
use App\Models\Person;
use App\Models\Province;
use App\Models\Universities;
use App\Models\User;
use App\Models\UserDevice;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\DniController;
use App\Mail\NewUserOnlineEmail;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;

class LyRegisterForm extends Component
{
    public $country_id = 'PE';
    public $email;
    public $password;
    public $countries;

    public $info = false;
    public $departments = [];
    public $provinces = [];
    public $districts = [];

    public $identity_document_type_id = 1;
    public $number = null;
    public $names = null;
    public $last_name_father = null;
    public $last_name_mother = null;
    public $full_name = null;
    public $address = null;
    public $mobile_phone = null;
    public $sex = null;
    public $birth_date = null;
    public $department_id = null;
    public $province_id = null;
    public $district_id = null;
    public $user_id = null;
    public $university_id;

    public $universities = [];
    public $user;
    public $inputsDisabled = false;

    public function mount()
    {
        $this->countries = Country::all();
    }

    public function render()
    {
        if ($this->country_id) {
            $this->departments = Department::where('country_id', $this->country_id)->get();
        }

        $this->getProvences();
        $this->getDistricts();

        return view('livewire.auth.ly-register-form');
    }

    public function save()
    {

        $userFind = User::where('email', $this->email)->first();

        if ($userFind) {
            if ($userFind->email_verified_at) {
                return redirect()->route('ly-login');
            } else {
                if (Person::where('user_id', $userFind->id)->first()) {
                    return redirect()->route('ly-login');
                    $this->info = false;
                } else {
                    //dd(Department::where('country_id', $this->country_id)->toSql());
                    //dd($this->country_id);
                    $this->departments = Department::where('country_id', $this->country_id)->get();
                    $this->universities = Universities::where('country', $this->country_id)->get();

                    $this->info = true;
                }
            }

            $this->user_id = $userFind->id;
            $this->user = $userFind;
        } else {
            $this->validate([
                'password' => 'required|min:8',
                'email' => 'required|email|unique:users,email',
                'country_id' => 'required'
            ]);

            $array = explode("@", $this->email);

            $this->user = User::create([
                'name' => $array[0],
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'country_id' => $this->country_id,
            ]);

            $this->departments = Department::where('country_id', $this->country_id)->get();
            $this->universities = Universities::where('country', $this->country_id)->get();

            $this->user_id = $this->user->id;
            $this->user->assignRole('Student');
            $this->info = true;
        }
    }

    public function getProvences()
    {
        if ($this->department_id) {
            list($dep, $cou) = explode('-', $this->department_id);
            $this->provinces = Province::where('department_id', $dep)
                ->where('country_id', $cou)
                ->get();
        }
    }

    public function getDistricts()
    {
        if ($this->province_id) {
            list($pro, $cou) = explode('-', $this->province_id);

            $this->districts = District::where('province_id', $pro)
                ->where('country_id', $cou)
                ->get();
        }
    }


    public function saveInfo()
    {

        $this->validate([
            //'number' => 'required|unique:people,number',
            'number' => 'required',
            'names' => 'required|max:150',
            'last_name_father' => 'required|max:150',
            'last_name_mother' => 'required|max:150',
            'birth_date' => 'required',
            'university_id' => 'required'
        ]);

        $confirmationCode = Str::random(6);
        $startTime = Carbon::now();
        $endTime = $startTime->copy()->addMinutes(5);

        $this->user->name = trim($this->names);
        $this->user->unique_code = $confirmationCode;
        $this->user->start_time_code = $startTime;
        $this->user->end_time_code = $endTime;

        $this->user->save();

        list($dpid, $dco) = explode('-', $this->department_id);
        list($prid, $pco) = explode('-', $this->province_id);

        if($this->district_id){
            list($dtid, $tco) = explode('-', $this->district_id);
        }else{
            $dtid = null;
        }
        


        Person::create([
            'identity_document_type_id' => $this->identity_document_type_id,
            'number' => trim($this->number),
            'names' => trim($this->names),
            'last_name_father' => trim($this->last_name_father),
            'last_name_mother' => trim($this->last_name_mother),
            'full_name' => ($this->names . ' ' . $this->last_name_father . ' ' . $this->last_name_mother),
            'address' => trim($this->address),
            'mobile_phone' => trim($this->mobile_phone),
            'sex' => 1,
            'birth_date' => $this->birth_date,
            'email' => trim($this->email),
            'department_id' => trim($dpid),
            'province_id' => trim($prid),
            'district_id' => $dtid ? trim($dtid) : null,
            'country_id' => $this->country_id,
            'university_id' => $this->university_id,
            'user_id' => $this->user->id
        ]);


        ////aca se loguea el usuario
        Auth::attempt(array('email' => $this->user->email, 'password' => $this->password));

        /////Crear device token //////////////////////////////////////////////

        $this->user = User::find(Auth::id());

        // Generar un nuevo token de dispositivo
        $deviceToken = Str::uuid()->toString();

        // Asignar el nuevo token de dispositivo al usuario en la base de datos
        $this->user->device_token = $deviceToken;
        $this->user->save();

        // Guardar el token de dispositivo en el almacenamiento local del navegador
        setcookie('device_token', $deviceToken, time() + (86400 * 2), '/'); // Almacena la cookie durante 1 días

        //////////////////////////////////////////////////////////////////////////////device token/////////

        //notificación de correo al correo de notificaciones .env MAIL_TO_NOTIFICATIONS si notificaciones new user está activado
        if (env('NOTIFICATIONS_NEW_USER')) {
            $correo = new NewUserNotification($this->user->name, $this->user->email, null, trim($confirmationCode));
            Mail::to(env('MAIL_TO_NOTIFICATIONS'))->send($correo);
        }

        $newCorreo = new NewUserOnlineEmail([
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'user_code' => trim($confirmationCode)
        ]);

        Mail::to(trim($this->email))->send($newCorreo);

        $agent = new Agent();
        $deviceName = $agent->device() ?: 'Desconocido'; // Nombre del dispositivo o 'Desconocido' si no está disponible
        $userAgent = $deviceName = 'Desconocido' ? request()->header('User-Agent') : $deviceName;
        $deviceIP = request()->ip();
        $deviceOS = $agent->platform() ?: 'Desconocido'; // Sistema operativo
        $browser = $agent->browser() ?: 'Desconocido'; // Navegador
        $token = Str::uuid()->toString();
            setcookie('token_' . $this->user->id, $token, time() + (86400 * 2*180), '/'); // Almacena la cookie durante 180 días
            $newDevice = UserDevice::create([
                'user_id' => $this->user->id,
                'device_name' => $userAgent,
                'device_ip' => $deviceIP,
                'device_os' => $deviceOS,
                'browser' => $browser,
                'token' => $token,
                'is_verified' => true,
            ]);

        return redirect()->intended('dashboard');
    }

    public function consultaDni()
    {
        if (strlen($this->number) == 8 && $this->country_id == 'PE') {
            $DniController = new DniController();
            $maxAttempts = 2; // Número máximo de intentos permitidos
            $attempt = 1; // Contador de intentos
            $rechicken = false;

            // Inhabilitar los inputs
            $this->inputsDisabled = true;

            do {
                try {
                    $data = $DniController->consultaDniPost($this->number);
                    $this->names = ucwords(strtolower($data['nombres']));
                    $this->last_name_father = ucwords(strtolower($data['apellidoPaterno']));
                    $this->last_name_mother = ucwords(strtolower($data['apellidoMaterno']));

                    // Si no se produce ningún error, salimos del bucle
                    break;
                } catch (\Throwable $th) {
                    $this->names = '';
                    $this->last_name_father = '';
                    $this->last_name_mother = '';
                }

                // Si se produce un error, esperamos 350 ms antes del siguiente intento
                usleep(350000); // 350 ms = 350,000 microsegundos

                $attempt++; // Incrementamos el contador de intentos
            } while ($attempt <= $maxAttempts);

            if ($attempt > $maxAttempts) {
            }
        } else {
        }
        // Habilitar los inputs después de la ejecución
        $this->inputsDisabled = false;
    }
}
