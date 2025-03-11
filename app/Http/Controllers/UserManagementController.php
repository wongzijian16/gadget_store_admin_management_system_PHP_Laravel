<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repository\repositoryInterface;

class UserManagementController extends Controller
{
    private $repositoryUser;

    public function __construct(repositoryInterface $userRepository) {
        $this->repositoryUser = $userRepository;
    }

    public function readUser() {
        $user = $this->repositoryUser->getAllUser();
        return view("userblade.usermanagementpage", compact('user'));
    }

    public function editUserForm($id) {

        $user = $this->repositoryUser->findUser($id);

        return view("userblade.edituserform", compact('user'));
    }

    public function editUserDetail(Request $request) {
        $request->validate([
            'username' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);
        $cus = $request->only([
            'username',
            'phone',
            'address'
        ]);

        $result = $this->repositoryUser->updateUser($request->id, $cus);

        if ($result) {
            return back()->with('success', 'You have successfully edit customer new information');
        } else {
            return back()->with('fail', 'Please try again');
        }
    }

    public function deleteuser($id) {
        $result = $this->repositoryUser->deleteUser($id);

        if ($result) {
            return back()->with('success', 'You have successfully delete customer');
        } else {
            return back()->with('fail', 'Please try again');
        }
    }
}
