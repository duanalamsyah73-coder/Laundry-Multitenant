<?php
namespace App\Modules\Account\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller {
 public function showLogin() { return view('account.login'); }
 public function showRegister() { return view('account.register'); }
 public function register(Request $request) {
  $data=$request->validate(['name'=>'required|string|max:100','email'=>'required|email|unique:users,email','password'=>'required|string|min:8|confirmed']);
  $user=User::create(['name'=>$data['name'],'email'=>$data['email'],'password'=>Hash::make($data['password']),'role'=>'customer']);
  Auth::login($user); $request->session()->regenerate(); return redirect()->route('customer.home')->with('success','Akun berhasil dibuat.');
 }
 public function login(Request $request) {
  $credentials=$request->validate(['email'=>'required|email','password'=>'required|string']);
  if (!Auth::attempt($credentials, $request->boolean('remember'))) return back()->withErrors(['email'=>'Email atau password salah.'])->onlyInput('email');
  $request->session()->regenerate(); return redirect()->intended(route('customer.home'));
 }
 public function logout(Request $request) { Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); return redirect()->route('customer.home'); }
}
