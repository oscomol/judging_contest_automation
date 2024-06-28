<?php

namespace App\Http\Controllers;
use App\Models\Administrator;
use Illuminate\Http\Request;

class AdminCtrl extends Controller
{
    public function index(){
       
        return view('facilitator.admin.index',[
            'admins' =>Administrator::orderBy('created_at', 'DESC')->paginate(7)
        ]);
    }
    public function search(Request $request)
    {
        $searchQuery = $request->input('search');
    
        $admins = Administrator::where('username', 'like', '%' . $searchQuery . '%')
                       ->orderBy('created_at', 'DESC')
                       ->paginate(7);

        return view('facilitator.admin.searchResult', [
            'admins' => $admins,
            'searchQuery' => $searchQuery
        ]);
    }
    public function store(Request $request){
       try{
       Administrator::create([
            'username' =>  $request->username,
            'password' =>  $request->password
            ]);
    
            return redirect('/jca/admin')->with('adminCreated', "Admin: {$request->username} registered successfully!");
       }catch(\Exception $e){
        return back()->with('adminCreateErr',  $request->username . ' is not available!');
       }
    }
    public function update(Request $request, Administrator $administrator){
        try{
            $administrator = Administrator::findOrFail($request -> admin);

            $administrator->username = $request->username;
            $administrator->password = $request->password;
    
            $administrator->save();
    
            return redirect('/jca/admin')->with('adminUpdated', "Admin: {$request->username} updated successfully!");
            }catch(\Exception $e){
             return back()->with('adminCreateErr',  $request->username . ' is not available!');
            }
    }

    public function destroy(Request $request, Administrator $admin){
        $admin->delete();

        if(session('username') == $request->username){
            return redirect(route('admin.logout'));
        }else{
            return redirect('/jca/admin')->with('adminDeleted', "Admin: {$request->username} deleted successfully!");
        }
    }
}
