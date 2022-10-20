<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class LoginController extends Controller
{

	public function redirectToProvider($provider)
	{
		$validated = $this->validateProvider($provider);
		if (!is_null($validated)) {
			return $validated;
		}
		return Socialite::driver($provider)->stateless()->redirect();
		//return Socialite::driver($provider)->redirect();
	}

	//$out = new \Symfony\Component\Console\Output\ConsoleOutput();
	//$out->writeln("Hello from Terminal");
	//error_log('Some message here.');


	public function handleProviderCallback($provider)
	{

		$validated = $this->validateProvider($provider);
		if (!is_null($validated)) {
			return $validated;
		}

		try {
			$userProvider = Socialite::driver($provider)->user();
		} catch (ClientException $exception) {
			return response()->json(['error' => 'Credenciales de google invalidas.'], 422);
		}

		$user = User::where('email', $userProvider->getEmail())->first();

		if (isset($user)) {
			$userCreated = User::firstOrCreate(
				[
					'email' => $userProvider->email
				],
				[
					//'email_verified_at' => now(),
					'name' => $userProvider->user['given_name'],
					'lastname' => $userProvider->user['family_name'],
					'status' => true
				]
			);

			$userCreated->providers()->updateOrCreate(
				[
					'provider' => $provider,
					'id_provider' => $userProvider->getId()
				],
				[
					'avatar' => $userProvider->getAvatar()
				]
			);

			$token = $userCreated->createToken('token-auth_token')->plainTextToken;
			return response()->json([
				"message" => "Usuario logueado",
				"user" =>  $userCreated,
				"image" =>  $userProvider->getAvatar(),
				"role" => $userCreated->roles[0]->name,
				"access_token" => $token
			]);
		} else {
			return response()->json([
				"status" => 0,
				"message" => "Usuario no registrado en el sistema",
			], 404);
		}
	}


	protected function validateProvider($provider)
	{
		//En caso se quiera iniciar sesion con facebook o github
		//if (!in_array($provider, ['facebook', 'github', 'google'])){
		//por el momento solo con google
		if (!in_array($provider, ['google'])) {
			return response()->json(['error' => 'Por favor usar google para loguearse'], 422);
		}
	}
}
