<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class UserController extends Controller
{
    protected $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }
    public function login()
    {
        return view('login.login');
    }
    public function logout()
    {
        DB::statement("SET SQL_MODE=''");
        if (auth()->user()) {
            DB::connection('mysql6')->table('login_history')->insert([
                'User_Name' => auth()->user()->User_Name,
                'activity' => 'Logout',
                'InDate' => date('Y-m-d H:i:s'),
            ]);
        }

        Session::flush();
        Auth::logout();
        return redirect("/")->with("success", 'You Log-Out Successfully !');
    }
    public function CheckLogin(Request $request)
    {
        // DB::statement("SET SQL_MODE=''");


        $user_check = User::where('User_Name', '=', $request->User_Name)
            ->where('Password', '=', $request->Password)
            ->first();

        if (($user_check)) {
            if (Auth::guard('web')->attempt($request->only(['User_Name', 'Password']))) {
                DB::connection('mysql6')->table('login_history')->insert([
                    'User_Name' => auth()->user()->User_Name,
                    'activity' => 'Login',
                    'InDate' => date('Y-m-d H:i:s'),
                ]);

                return redirect("dashboard");
            }
        }
        return redirect('/')->with("error", "Please enter the valid username and password");
    }
    /**
     * Add and View User
     */
    public function allUsers()
    {
        return view('Users.allUsers');
    }
    public function getAllUsers()
    {
        $getAllUsers = DB::table('userinfologin.login as db1')
            ->leftJoin('installinfo.userinfo_login as db2', 'db2.User', '=', 'db1.User_Name')
            ->select(['db1.*', 'db2.Mobile', 'db2.Email', 'db2.IsActive'])
            ->orderBy('User_Name')
            ->get();

        // dd($getAllUsers);
        return view('Users.allUsersPagination', compact('getAllUsers'));
    }
    public function updateUserStatus(Request $request)
    {
        // dd($request->all());
        if ($request->status == true) {
            $status = 1;
        } else {
            $status = 0;
        }
        /**
         *
         * Check User in Login table
         *
         */
        $checkUserLogintbl = DB::connection('mysql6')->table('login')->where('User_Name', $request->username)->first();
        if ($checkUserLogintbl) {
            /**
             *
             * Check User in Userinfo_login table
             *
             */
            $checkUser = DB::connection('mysql')->table('userinfo_login')->where('User', $request->username)->first();
            if (!empty($checkUser) || $checkUser != null) {
                // dd($status);
                $resp = DB::connection('mysql')->table('userinfo_login')->where('User', $request->username)
                    // ->limit(1)
                    ->update([
                        'IsActive' => $request->status,
                        //  'InDate' => date('Y-m-d H:i:s')
                    ]);
            } else {
                $resp = DB::connection('mysql')->table('userinfo_login')
                    ->insert([
                        'User' => $request->username,
                        'IsActive' => $request->status,
                        'InDate' => date('Y-m-d H:i:s')
                    ]);
            }
            if ($resp == true) {
                return response()->json(['msg' => 'User Status Updated Successfully.', 'class' => 'success']);
            } else {
                return response()->json(['msg' => 'Failed to Update status.', 'class' => 'error']);
            }
        } else {
            return response()->json(['msg' => 'User Does not Exist..!', 'class' => 'error']);
        }
    }
    public function updateContactDetails(Request $request)
    {
        /**
         *
         * Check User in Login table
         *
         */
        $checkUserLogintbl = DB::connection('mysql6')->table('login')->where('User_Name', $request->User_Name)->first();
        if ($checkUserLogintbl) {
            /**
             *
             * Check User in Userinfo_login table
             *
             */
            $checkUser = DB::connection('mysql')->table('userinfo_login')->where('User', $request->User_Name)->first();
            if (!empty($checkUser) || $checkUser != null) {
                // dd($status);
                $resp = DB::connection('mysql')->table('userinfo_login')->where('User', $request->User_Name)
                    // ->limit(1)
                    ->update([
                        'Mobile' => $request->Mobile,
                        'Email' => $request->Email,
                        //  'InDate' => date('Y-m-d H:i:s')
                    ]);
            } else {
                $resp = DB::connection('mysql')->table('userinfo_login')
                    ->insert([
                        'User' => $request->User_Name,
                        'Mobile' => $request->Mobile,
                        'Email' => $request->Email,
                        'InDate' => date('Y-m-d H:i:s')
                    ]);
            }
            if ($resp == true) {
                return response()->json(['msg' => 'User Contact Details Updated Successfully.', 'class' => 'success']);
            } else {
                return response()->json(['msg' => 'Failed to Update Contact Details.', 'class' => 'error']);
            }
        } else {
            return response()->json(['msg' => 'User Does not Exist..!', 'class' => 'error']);
        }
    }

    public function AddUser(Request $request)
    {

        $checkUser = DB::connection('mysql6')->table('login')->where('User_Name', $request->User_Name)->first();

        if (empty($checkUser)) {

            $addUser = DB::connection('mysql6')->table('login')->insertGetId([
                "FullName" => $request->FullName,
                "User_Name" => $request->User_Name,
                "Display_Name" => $request->Display_Name,
                "Password" => $request->Password
            ]);

            if ($addUser == true) {

                //add Mobile and email in userinfo_login
                if (!empty($request->Mobile) || !empty($request->Email)) {
                    $resp = DB::connection('mysql')->table('userinfo_login')
                        ->insert([
                            'User' => $request->User_Name,
                            'Mobile' => $request->Mobile,
                            'Email' => $request->Email,
                            'InDate' => date('Y-m-d H:i:s')
                        ]);
                }

                //add new user in permission table
                DB::connection('mysql6')->table('userpermissionmaster')->insert([
                    'user_id' => $addUser,
                    'User_Name' => $request->User_Name
                ]);

                return response()->json(['msg' => 'User Added Successfully.', 'class' => 'success']);
            } else {
                return response()->json(['msg' => 'Failed to add user..!', 'class' => 'error']);
            }
        } else {
            return response()->json(['msg' => 'Username already Exists..!', 'class' => 'error']);
        }
    }

    public function deleteUser(Request $request)
    {

        try {

            $deleteUser = DB::connection('mysql6')
                ->table('login')
                ->where('User_Name', $request->User_Name)
                ->where('id', $request->id)
                ->delete();


            if ($deleteUser) {
                return response()->json(['msg' => 'User deleted successfully..!', 'class' => 'success']);
            } else {
                return response()->json(['msg' => 'Failed to delete user..!', 'class' => 'error']);
            }
        } catch (\Exception $e) {
            return response()->json(['msg' => 'Something went wrong..!', 'class' => 'error']);
        }
    }

    public function changeUserPass(Request $request)
    {
        try {

            $changePass = DB::connection('mysql6')
                ->table('login')
                ->where('User_Name', $request->username)
                ->where('id', $request->id)
                ->update([
                    'Password' => $request->newPass
                ]);

            if ($changePass) {
                return response()->json(['msg' => 'Password changed successfully..!', 'class' => 'success']);
            } else {
                return response()->json(['msg' => 'Failed to change pass..!', 'class' => 'error']);
            }
        } catch (\Throwable $th) {
            return response()->json(['msg' => 'Something went wrong..!', 'class' => 'error']);
        }
    }

    /**
     * User Permissions
     */
    public function UserPermissions()
    {
        return view('Users.userPermissions');
    }
    public function getPermissionData()
    {
        $getData = DB::connection('mysql6')->table('userpermissionmaster')
            ->select('userpermissionmaster.*')
            ->join('login', 'login.User_Name', '=', 'userpermissionmaster.User_Name')
            ->orderBy('User_Name')
            ->get();
        return view('Users.userPermissionPaging', compact('getData'));
    }


    public function grantAccess(Request $request)
    {
        $grantAccess = DB::connection('mysql6')->table('userpermissionmaster')->where('User_Name', $request->username)->update([
            "NewAct" => $request->NewAct,
            "DlrScore" => $request->DlrScore,
            "OnlinePurchasePDF" => $request->OnlinePurchasePDF,
            "DlrActCount" => $request->DlrActCount,
            "DlrReg" => $request->DlrReg,
            "PriceList" => $request->PriceList,
            "MyAct" => $request->MyAct,
            "BlockKeys" => $request->BlockKeys,
            "ScratchKeys" => $request->ScratchKeys,
            "ReleaseKeys" => $request->ReleaseKeys,
            "APKSMS" => $request->APKSMS,
            "LastActs" => $request->LastActs,
            "Kayako" => $request->Kayako,
            "changeIP" => $request->changeIP,
            "ManageUsers" => $request->ManageUsers,
            "LoginHistory" => $request->LoginHistory,
            "UserPermission" => $request->UserPermission,
            "AndroidAct" => $request->AndroidAct,
            "Articles" => $request->Articles,
            "AddDays" => $request->AddDays,
            "TechSupportNo" => $request->TechSupportNo,
            "SendEmail" => $request->SendEmail,
            "FindOrder" => $request->FindOrder,
            "StateActCnt" => $request->StateActCnt,
            "ActGraph" => $request->ActGraph,
            "UpdDlrInfo" => $request->UpdDlrInfo,
            "OTPmaster" => $request->OTPmaster,
            "PndReq" => $request->PndReq,
            "ConvertLic" => $request->ConvertLic,
            "modifiedAt" => date('Y-m-d H:i:s'),
            "modifiedBy" => auth()->user()->User_Name,
        ]);
        if ($grantAccess == true) {
            return response()->json(['msg' => 'User Permissions Updated Successfully..!', 'class' => 'success']);
        } else {
            return response()->json(['msg' => 'Failed to update user permissions..!', 'class' => 'error']);
        }
    }

    public function syncNewUsers()
    {
        try {

            $getAvailableUsersNames = DB::connection('mysql6')->table('login')->get();

            $cnt = 0;

            if (!empty($getAvailableUsersNames)) {

                foreach ($getAvailableUsersNames as $val) {
                    $User_Name = $val->User_Name;
                    $user_id = $val->id;

                    $checkIfUserExist = DB::connection('mysql6')->table('userpermissionmaster')->where('User_Name', $User_Name)->count();
                    if ($checkIfUserExist == 0) {
                        DB::connection('mysql6')->table('userpermissionmaster')->insert([
                            'User_Name' => $User_Name,
                            'user_id' => $user_id,
                        ]);
                        $cnt++;
                    }
                }

                return response()->json(['msg' => $cnt . ' Users Synced Successfully..!', 'class' => 'success']);
            } else {
                return response()->json(['msg' => 'Users Does not Exist..!', 'class' => 'error']);
            }
        } catch (\Exception $e) {
            return response()->json(['msg' => 'Something went..!', 'class' => 'error']);
            return response()->json($e->getMessage());
        }
    }

    /**
     * Login Activity
     */

    public function LoginHistory()
    {
        return view('Users.loginHistrory');
    }

    public function getUserActivity()
    {
        $getData = DB::connection('mysql6')->table('login_history')->orderByDesc('id')->get();
        return view('Users.loginHistoryPagination', compact('getData'));
    }


    public function  updateDefaultVals()
    {
        try {
            $update =   DB::connection('mysql6')->table('userpermissionmaster')->update([
                'SalesEnq' => 1, 'SendEmail' => 1, 'SendSms' => 1, 'SuppWMS' => 1, 'NewAct' => 1,
                'DlrReg' => 1, 'ForSales' => 1, 'DlrActCount' => 1, 'MyAct' => 1, 'TechSupportNo' => 1,
                'RnwWMS' => 1, 'ReactEmail' => 1, 'ReactReq' => 1, 'DlrScore' => 1, 'OnlinePurchasePDF' => 1,
                'PriceList' => 1, 'PndReq' => 1, 'AndroidAct' => 1, 'Articles' => 1, 'cloudbkpKey' => 1,
            ]);
            return $update;
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * =======================================
     */


    // public function removeDupl()
    // {


    //     $getAvailableUsersNames = DB::connection('mysql6')->table('userpermissionmaster')->get();

    //     $cnt = 0;
    //     $cnt2 = 0;

    //     if (!empty($getAvailableUsersNames)) {

    //         foreach ($getAvailableUsersNames as $val) {
    //             $User_Name = $val->User_Name;


    //             $checkIfUserExist = DB::connection('mysql6')->table('login')->where(DB::raw('upper(User_Name)'), strtoupper($User_Name))->count();
    //             if ($checkIfUserExist == 0) {

    //                 echo '<pre>';
    //                 echo 'Does not Exist :' . $User_Name;
    //                 echo '</pre>';

    //                 $cnt++;
    //             } else {

    //                 echo '<pre>';
    //                 echo 'Exist : ' . $User_Name;
    //                 echo '</pre>';
    //                 $cnt2++;
    //             }
    //         }

    //         return response()->json([
    //             'No' => $cnt . 'Does not Exist',
    //             '   Yes' => $cnt2 . ' Exist',



    //             'class' => 'success'
    //         ]);
    //     } else {
    //         return response()->json(['msg' => 'Users Does not Exist..!', 'class' => 'error']);
    //     }
    // }
}
