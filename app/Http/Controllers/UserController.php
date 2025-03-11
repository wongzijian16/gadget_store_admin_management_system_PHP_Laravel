<?php

namespace App\Http\Controllers;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ProductController;
use App\Repository\repositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Session;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    public function adminmainpage() {
        if (Session::has('login_status')) {
            $userManagementController = new UserManagementController(app()->make(repositoryInterface::class));
            return $userManagementController->readUser();
        }
    }

    public function adminloginpage() {
        return view("userblade.adminlogin");
    }
    
    public function customerpage() {
        if (Session::has('login_status')) {
            $productController = new ProductController();
            $products = $productController->productMenu(request());
            return $products;
        }
    }

    public function adminloginfunction(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $user = User::where('email', '=', $request->email)->first();

        if ($user) {
            if (hash::check($request->password, $user->password)) {
                $user->password = "";
                $request->Session()->put('login_status', $user);
                Log::create([
                    'userId' => Session::get('login_status')->userId,
                    'userType' => Session::get('login_status')->position,
                    'logStatus' => 'login',
                ])->save();

                if ($user->position === 'admin') {
                    return redirect('adminmainpage');
                } elseif ($user->position === 'customer') {
                    return redirect('customerpage');
                }
            } else {
                return back()->with('fail', 'Invalid password');
            }
        } else {
            return back()->with('fail', 'This email is not register before');
        }
    }

    
    
    
    public function logout() {
        if (Session::has('login_status')) {
            Log::create([
                'userId' => Session::get('login_status')->userId,
                'userType' => Session::get('login_status')->position,
                'logStatus' => 'logout',
            ])->save();

            Auth::logout();

            Session::flush();
            Session::regenerate();
            return redirect('adminloginpage');
        }
    }

    public function adminregisterpage() {
        return view("userblade.adminregisterform");
    }

    public function registernewAdmin(Request $request) {
        $request->validate([
            'id' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|min:10',
            'address' => 'required',
            'position' => 'required',
            'password' => 'required|min:8',
            'confirmpassword' => 'required|same:password'
        ]);

        $user = new User();
        $user->userId = $request->id;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->position = $request->position;
        $user->password = Hash::make($request->password);

        $result = $user->save();

        if ($result) {
            return back()->with('success', 'Successfully registered an account');
        } else {
            return back()->with('fail', 'Please enter correct information and try again');
        }
    }

    public function profile() {
        $info = array();
        if (Session::has('login_status')) {
            $info = User::where('userId', '=', Session::get('login_status')->userId)->first();
        }
        return view('/userblade/profile', compact('info'));
    }

    public function editprofile() {
        $info = array();
        if (Session::has('login_status')) {
            $info = User::where('userId', '=', Session::get('login_status')->userId)->first();
        }
        return view('userblade.updateprofile', compact('info'));
    }

    public function adminprofileupdate(Request $request) {
        $request->validate([
            'username' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        if (Session::has('login_status')) {
            $user = User::find(Session::get('login_status')->userId);
            $user->username = $request->username;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->update();
            return back()->with('success', 'Successfully edited information');
        }
        return back()->with('fail', 'Please try again');
    }

    public function changepassword() {
        return view("userblade.editpassword");
    }

    public function updatepassword(Request $request) {
        $request->validate([
            'currentpassword' => 'required',
            'newpassword' => 'required|min:8',
            'confirmpassword' => 'required|same:newpassword'
        ]);

        if (Session::has('login_status')) {
            $user = User::find(Session::get('login_status')->userId);
            if (hash::check($request->currentpassword, $user->password)) {
                $user->password = Hash::make($request->newpassword);
                $user->update();
                return back()->with('success', 'Successfully edited password');
            }
        }
        return back()->with('fail', 'Please try again');
    }

    public function readLog() {
        return view("userblade.adminlog");
    }

    public function renderUserLogRecords(Request $request) {

        date_default_timezone_set("Asia/Kuala_Lumpur");
        $covert_log_date = strtotime($request->logDate);
        $formated_log_date = date('Y-m-d', $covert_log_date);
        $userType1 = $request->userType;
        $logsRecords = Log::whereDate('created_at', $formated_log_date)->orderBy('created_at', 'asc')
                        ->where('userType', $userType1)->get();

        $xml = new \DOMDocument;
        $adminlogs = $xml->createElement('adminlogs');
        $xml->appendChild($adminlogs);
        foreach ($logsRecords as $logsRecord) {
            $log = $xml->createElement('log');
            $userId = $xml->createElement('userId', $logsRecord->userId);
            $userType = $xml->createElement('userType', $logsRecord->userType);
            $logStatus = $xml->createElement('logStatus', $logsRecord->logStatus);
            $logDate = $xml->createElement('logDate', $logsRecord->created_at);

            $adminlogs->appendChild($log);
            $log->setAttribute('id', $logsRecord->id);

            $log->appendChild($userId);
            $log->appendChild($userType);
            $log->appendChild($logStatus);
            $log->appendChild($logDate);
        }

        $xml->formatOutput = TRUE;
        $xsl = new \DOMDocument;
        $xsl->load('xsl\adminlogs.xsl');

        $proc = new \XSLTProcessor;

        $proc->importStyleSheet($xsl);

        echo $proc->transformToXML($xml);
    }
    

    public function profile1() {
        $info = array();
        if (Session::has('login_status')) {
            $info = User::where('userId', '=', Session::get('login_status')->userId)->first();
        }
        return view('/userblade/profile1', compact('info'));
    }
    
    
     public function editprofile1() {
        $info = array();
        if (Session::has('login_status')) {
            $info = User::where('userId', '=', Session::get('login_status')->userId)->first();
        }
        return view('userblade.updateprofile1', compact('info'));
    }
    
    
    
    
    
    public function changepassword1() {
        return view("userblade.editpassword1");
    }
    
}
