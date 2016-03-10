<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use View;
use Session;
use Cookie;
use Auth;
use Mail;
use Log;
use Storage;
use Hash;
use File;
use App\User;
use App\Project;
use App\Epic;
use App\Team;

class AccountController extends Controller
{

	public function accountPage()
	{
		return view('account/user_account')->with('user', Auth::user())
                                       ->with('is_account', true)
																			 ->with('themes', getAvailableThemes())
																			 ->with('header', 'nav.account.account_header')
                                       ->with('container_overflow', true);
	}

	public function uploadAvatar(Request $request){

		if ($request->hasFile('image') && $request->file('image')->isValid() ) {
			$file = $request->file('image');

			if(isset($file)){
				$user = User::find(Auth::user()->id);

				Storage::disk('local')->put('/users_avatars/'.Auth::user()->id.'.png',  File::get($file));

				$user->use_gravatar = 0;
				$user->save();

				return response()->json(['success' => true, 'value' => asset('storage/app/users_avatars/'.Auth::user()->id.'.png')]);

			} else {
				return response()->json(['success' => false, 'error' => 'No valid file provided.']);

			}

		}

		return response()->json(['success' => false, 'error' => 'No valid data provided.']);

	}

	public function accountUpdateUserTheme(Request $request){
		$user = User::find($request->id);
		if(isset($user)){

			$user->theme = $request->theme;
			$user->save();

			return response()->json(['success' => true, 'value' => $request->theme]);

		} else {
			return response()->json(['success' => false, 'error' => 'Cannot find the specified user.']);

		}
	}

	public function accountUpdateUsername(Request $request){
		$user = User::find($request->id);
		if(isset($user)){

			$user->name = $request->name;
			$user->save();

			return response()->json(['success' => true, 'value' => $request->name]);

		} else {
			return response()->json(['success' => false, 'error' => 'Cannot find the specified user.']);

		}
	}

	public function accountUpdateEmail(Request $request){
		$user = User::find($request->id);
		if(isset($user)){
			$user->email = $request->email;
			$user->save();

			return response()->json(['success' => true, 'value' => $request->email]);

		} else {
			return response()->json(['success' => false, 'error' => 'Cannot find the specified user.']);

		}

	}

	public function accountUpdatePassword(Request $request){

		$user = User::find($request->id);
		if(isset($user)){
			$credentials = [
			    'email' => $user->email,
			    'password' => $request->current,
			];

			if(\Auth::validate($credentials)) {
				// Validate the new password length and also it has been correctly confirmed
				if($request->new == $request->confirm){
					if(strlen($request->new) < 6 ){
						return response()->json(['success' => false, 'error' => 'The new password must be at least 6 chars long.']);

					} else {
						$user->fill([
								'password' => Hash::make($request->new)
						])->save();

						return response()->json(['success' => 'true']);

					}

				} else {
					return response()->json(['success' => false, 'error' => 'You must correctly confirm the new password you want to use.']);

				}

			} else {
				return response()->json(['success' => false, 'error' => 'You provide a wrong current password.']);

			}

		} else {
			return response()->json(['success' => false, 'error' => 'Cannot find the specified user.']);

		}

	}

	public function accountUseGravatar(){

		try{
			$user = User::find(Auth::user()->id);
			$user->use_gravatar = 1;
			$user->save();

			return response()->json(['success' => true, 'value' => 'http://gravatar.com/avatar/'.md5( $user->email )]);

		} catch(Exception $e){
			return response()->json(['success' => false, 'error' => $e->getMessage()]);
		}

	}

}
