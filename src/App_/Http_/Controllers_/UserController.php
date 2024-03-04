<?php

namespace App\Http\Controllers;

use App\Core\App;
use App\Core\CSRF;
use App\Models\User;
use App\Core\Session;
use App\Core\Redirect;
use App\Http\Feedback;
use App\Models\Authenticate\Role;
use App\Models\Authenticate\Password;

class UserController
{
	private const USER_CREATE_SUCCESS = "The user was created";
	private const USER_CREATE_FAIL = "The user was not created";
	private const USER_UPDATE_SUCCESS = "The user was saved";
	private const USER_UPDATE_FAIL = "The changes were not saved";
	private const USER_DESTROY_SUCCESS = "The user has been deleted";
	private const IMAGE_UPDATE_FAIL = "The image was not saved";
	private const IMAGE_UPDATE_FAIL_SIZE = "The file is too large (max " . PROFILE_IMAGE_MAX_SIZE_MB . " MB)";
	private const IMAGE_DELETE_FAIL = "The image was not deleted";
	private const PASSWORD_UPDATE_FAIL = "The password was not changed";

	/**
	 * Show all user posts
	 */
	public static function index()
	{
		Feedback::for('user_create_success')->toast([
			'text' => static::USER_CREATE_SUCCESS,
			'style' => 'success',
			'icon' => 'fa-regular fa-check-circle',
		]);

		Feedback::for('user_destroy_success')->toast([
			'text' => static::USER_DESTROY_SUCCESS,
			'style' => 'danger',
			'icon' => 'fa-regular fa-check-circle',
		]);

		$activeUsers = User::get([
			'where' => ['status = 1'], 
			'orderBy' => ['first_name ASC', 'id ASC']
		]);

		$inactiveUsers = User::get([
			'where' => ['status = 0'], 
			'orderBy' => ['first_name ASC', 'id ASC']
		]);

		return App::view('users/index.php', [
			'title' => 'User Accounts',
			'activeUsers' => $activeUsers,
			'inactiveUsers' => $inactiveUsers
		]);
	}

	/**
	 * View a single user
	 */
	public static function show(int $userId)
	{
		Feedback::for('user_update_success')->toast([
			'text' => static::USER_UPDATE_SUCCESS,
			'style' => 'success',
			'icon' => 'fa-regular fa-check-circle',
		]);

		$user = User::findOrFail($userId);

		$user['created_by_string'] = $user['updated_by_string'] = "<small class=\"text-muted\">n/a</small>";

		if ($user['created_at'] || $user['created_by']) {
			$createdAt = $user['created_at'] ?: null;
			$createdBy = ($user['created_by'] && User::find($user['created_by'])) 
				? User::find($user['created_by'])['full_name'] 
				: "<small class=\"text-muted\">n/a</small>";
			$user['created_by_string'] = $createdAt . " av " . $createdBy;
		}

		if ($user['updated_at'] || $user['updated_by']) {
			$createdAt = $user['updated_at'] ?: null;
			$createdBy = ($user['updated_by'] && User::find($user['updated_by'])) 
				? User::find($user['updated_by'])['full_name'] 
				: "<small class=\"text-muted\">n/a</small>";
			$user['updated_by_string'] = $createdAt . " av " . $createdBy;
		}

		return App::view('users/show.php', [
			'title' => $user['full_name'],
			'breadcrumbs' => [
				['title' => 'User Accounts', 'url' => '/users'],
				['title' => $user['full_name'], 'url' => '/users/' . $user['id'], 'active' => true]
			],
			'user' => $user
		]);
	}

	/**
	 * View the edit user form
	 */
	public static function edit(int $userId)
	{
		$user = User::findOrFail($userId);

		Feedback::for('user_update_failed')->toast([
			'text' => static::USER_UPDATE_FAIL,
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

		return App::view('users/edit.php', [
			'title' => $user['full_name'],
			'breadcrumbs' => [
				['title' => 'User Accounts', 'url' => '/users'],
				['title' => $user['full_name'], 'url' => '/users/' . $user['id']],
				['title' => 'Edit', 'url' => '/users/' . $user['id'] . '/edit', 'active' => true]
			],
			'user' => $user,
			'rolesList' => rolesSelect(
				Role::get(['orderBy' => ['id DESC']]), 
				[
					'selected' => old('role', $user['role_id'])
				]),
			'errors' => Session::get('errors', []),
		]);
	}

	/**
	 * Update a user post in the database
	 */
	public static function update(int $userId)
	{
		if (! CSRF::validate()) {
			App::abort(405);
		}

		$form = $_POST['form'];

		// Edit user info
		if ($form == 'edit-user-info') {		
			// Update user data
			if (! User::update($_POST, $userId)) {
				Redirect::to("/users/$userId/edit")->with('feedback', 'user_update_failed');	
			}

			// Update image if submitted
			if (! empty($_FILES['image']['name'])) {
				if ($_FILES['image']['size'] > PROFILE_IMAGE_MAX_SIZE) {
					Redirect::to("/users/$userId")->with('feedback', 'image_update_failed_size');
				}

				if (! User::updateImage($userId)) {
					Redirect::to("/users/$userId")->with('feedback', 'image_update_failed');
				}
			}

			// Delete image
			if (isset($_POST['deleteImage'])) {
				if (! User::deleteImage($userId)) {
					Redirect::to("/users/$userId")->with('feedback', 'image_delete_failed');
				}
			}

		// Update password
		} elseif ($form == 'update-password') {
			if (! Password::update($_POST['password'], $_POST['password_repeat'], $userId)) {
				Redirect::to("/profile")->with('feedback', 'password_update_failed');
			}
		}	
		
		Redirect::to("/users/$userId")->with('feedback', 'user_update_success');
	}

	/**
	 * Delete a user from the database
	 */
	public static function destroy(int $userId)
	{
		if (! CSRF::validate()) {
			App::abort(405);
		}

		User::destroy($userId);

		Redirect::to("/users")->with('feedback', 'user_destroy_success');
	}

	/**
	 * View the create user form
	 */
	public static function create()
	{
		Feedback::for('user_create_failed')->toast([
			'text' => static::USER_CREATE_FAIL,
			'style' => 'danger',
			'icon' => 'fa-solid fa-xmark',
		]);

		CSRF::newToken();

		return App::view('users/create.php', [
			'title' => 'New User Account',
			'rolesList' => rolesSelect(
				Role::get(['orderBy' => ['id DESC']]), 
				[
					'includeEmpty' => true,
					'selected' => old('role')
				]),
			'errors' => Session::get('errors', []),
		]);		
	}

	/**
	 * Save a new user to the database
	 */
	public static function store()
	{
		if (! CSRF::validate()) {
			App::abort(405);
		}

		// Update user data
		if (! User::store($_POST)) {
			Redirect::to("/users/create")->with('feedback', 'user_create_failed');	
		}

		$newUserId = Session::get('newUserId');

		// Update image if submitted
		if (! empty($_FILES['image']['name'])) {
			if ($_FILES['image']['size'] > 10000000) {
				Redirect::to("/users/$newUserId")->with('feedback', 'image_update_failed_size');
			}			

			if (! User::updateImage($newUserId)) {
				Redirect::to("/users/$newUserId")->with('feedback', 'image_update_failed');
			}
		}
		
		Redirect::to("/users")->with('feedback', 'user_create_success');
	}
}