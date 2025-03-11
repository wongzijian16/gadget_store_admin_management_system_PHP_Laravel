<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserManagementController;
use Session;

class ProviderController extends Controller {
    
    public function adminmainpage1() {
        if (Session::has('login_status')) {
            $userManagementController = new UserManagementController(app()->make(repositoryInterface::class));
            return $userManagementController->readUser();
        }
    }
    
    public function customerpage1() {
        if (Session::has('login_status')) {
            $productController = new ProductController();
            $products = $productController->productMenu(request());
            return $products;
        }
    }

    public function redirect($provider) {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider) {
    $user = Socialite::driver($provider)->user();

    $username = !empty($user->name) ? $user->name : 'default_username';


    $existingUser = User::where('email', $user->email)->first();

    if (!$existingUser) {
        $newUser = User::create([
            'userId' => uniqid(),
            'username' => $username,
            'email' => $user->email,
            'phone' => '-',
            'address' => '-',
            'position' => '-',
            'password' => bcrypt(uniqid()),
        ]);

        $existingUser = $newUser;
    }
    
    session()->put('login_status', $existingUser);

    if ($existingUser->position === 'admin') {
        return redirect('adminmainpage1');
    } else {
        return redirect('customerpage1');
    }
}
}