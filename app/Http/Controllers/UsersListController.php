<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use App\User;


class UsersListController extends Controller
{
    public function index(){
        $users= User::paginate(5);
        return view('usersList')->withAllUsers($users);
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $users = User::where('name','like','%'.$search.'%')->orwhere('email','like','%'.$search.'%')->paginate(5);

        return view('usersList')->withAllUsers($users);

    }


    /*public function filterUsersList(Request $request)
    {

        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myList a").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

    }*/
}
