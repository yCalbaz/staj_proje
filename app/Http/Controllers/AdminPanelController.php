<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class AdminPanelController extends Controller
{
    const ADMIN_ROLE_ID =1;
    const SATICI_ROLE_ID = 2;
    const MUSTERI_ROLE_ID=3;

    public function showLoginForm()
    {
        if(Auth::check()){
            $user = Auth::user();
            Session::put('user_authority', $user->authority_id);
            return $this->redirectUser($user);
        }
        return view('admin_panel_giris'); 
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::user();
            Session::put('user_authority',$user->authority_id);
            return $this->redirectUser($user);
        }

        return redirect()->back()->with('error', 'Giriş bilgileri hatalı.')->withInput();
    }

    public function showRegisterForm()
     {
         return view('musteri_uye_ol');
     }

    public function customerRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:members,email',
            'password' => 'required',
        ]);

        $customer_id = $this->databaseCustomerId();

        Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'authority_id' => self::MUSTERI_ROLE_ID,
            'customer_id' => $customer_id,
        ]);

        return redirect()->route('musteri.uye_ol')->with('success', 'Müşteri üye eklendi :)');
    }

    protected function databaseCustomerId()
    {
        $lastCustomer = Member::whereNotNull('customer_id')->orderBy('customer_id', 'desc')->first();
        return $lastCustomer ? $lastCustomer->customer_id + 1 : 1;
    }


    protected function redirectUser($user)
    {
        $authority = Session::get('user_authority');
        switch($authority){
            case self::ADMIN_ROLE_ID:
                return redirect()->route('adminPanel');
            case self::SATICI_ROLE_ID:
                return redirect()->route('saticiPanel');
            case self::MUSTERI_ROLE_ID:
                return redirect()->route('musteriPanel');

            default:
            return route('/');
        }
    }

    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function showAdminPanel()
    {
        if(session('user_authority') !== self::ADMIN_ROLE_ID){
            return redirect()->route('login');
        }
        return view('admin_panel');
    }
    public function showSaticiPanel()
    {
        if(session('user_authority') !== self::SATICI_ROLE_ID){
            return redirect()->route('login');
        }
        return view('satici_panel');
    }
    public function showMusteriPanel()
    {
        if(session('user_authority') !== self::MUSTERI_ROLE_ID){
            return redirect()->route('login');
        }
        $products =  $this->getProduct();
        return view('anasayfa', compact('products'));
    }
    protected function getProduct()
    {
        return Product::orderBy('id', 'desc')->take(10)->get();
    }
    

    
}