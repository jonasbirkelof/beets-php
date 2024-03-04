<?php

namespace App\Http\Controllers;

use App\Core\App;
use App\Core\CSRF;
use App\Models\User;
use App\Core\Session;
use App\Core\Redirect;
use App\Http\Feedback;
use App\Models\Profile;
use App\Models\Authenticate\Password;

class ProfileController
{
	private const PROFILE_UPDATE_SUCCESS = "The changes were saved";
	private const PROFILE_UPDATE_FAIL = "The changes were not save";
	private const IMAGE_UPDATE_FAIL = "The images was not saved";
	private const IMAGE_UPDATE_FAIL_SIZE = "The file is too large (max " . PROFILE_IMAGE_MAX_SIZE_MB . " MB)";
	private const IMAGE_DELETE_FAIL = "The image was not deleted";
	private const PASSWORD_UPDATE_FAIL = "The password was not changed";

	/**
	 * Show the edit profile form
	 */
	public static function edit()
	{
		$user = Profile::findOrFail();

		Feedback::for('profile_update_success')->toast([
			'text' => static::PROFILE_UPDATE_SUCCESS,
			'style' => 'success',
			'icon' => 'fa-solid fa-check-circle',
		]);
		
		Feedback::for('profile_update_failed')->toast([
			'text' => static::PROFILE_UPDATE_FAIL,
			'style' => 'danger',
			'icon' => 'fa-solid fa-xmark',
		]);
		
		Feedback::for('image_update_failed')->toast([
			'text' => static::IMAGE_UPDATE_FAIL,
			'style' => 'danger',
			'icon' => 'fa-solid fa-xmark',
		]);
		
		Feedback::for('image_update_failed_size')->toast([
			'text' => static::IMAGE_UPDATE_FAIL_SIZE,
			'style' => 'danger',
			'icon' => 'fa-solid fa-xmark',
		]);
		
		Feedback::for('image_delete_failed')->toast([
			'text' => static::IMAGE_DELETE_FAIL,
			'style' => 'danger',
			'icon' => 'fa-solid fa-xmark',
		]);
		
		Feedback::for('password_update_failed')->toast([
			'text' => static::PASSWORD_UPDATE_FAIL,
			'style' => 'danger',
			'icon' => 'fa-solid fa-xmark',
		]);

		CSRF::newToken();

		return App::view('profile.php', [
			'title' => 'Profile',
			'user' => $user,
			'errors' => Session::get('errors', []),
		]);
	}

	/**
	 * Update a user profile in the database
	 */
	public static function update()
	{
		if (! CSRF::validate()) {
			App::abort(405);
		}
		
		$form = $_POST['form'];

		// Edit user info
		if ($form == 'edit-user-info') {
			// Update profile data
			if (! Profile::update($_POST)) {
				Redirect::to("/profile")->with('feedback', 'profile_update_failed');
			}

			// Update image if submitted
			if (! empty($_FILES['image']['name'])) {
				if ($_FILES['image']['size'] > PROFILE_IMAGE_MAX_SIZE) {
					Redirect::to("/profile")->with('feedback', 'image_update_failed_size');
				}

				if (! User::updateImage(User::id())) {
					Redirect::to("/profile")->with('feedback', 'image_update_failed');
				}
			}

			// Delete image if removed
			if (isset($_POST['deleteImage'])) {
				if (! User::deleteImage(User::id())) {
					Redirect::to("/profile")->with('feedback', 'image_delete_failed');
				}
			}

		// Update password
		} elseif ($form == 'update-password') {
			if (! Password::update($_POST['password'], $_POST['password_repeat'], User::id())) {
				Redirect::to("/profile")->with('feedback', 'password_update_failed');
			}
		}		
		
		Redirect::to("/profile")->with('feedback', 'profile_update_success');
	}
}