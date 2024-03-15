<?php

use App\Core\App;
use App\Core\Session;

/**
 * Mark a nav-item as active when visited.
 */
function setActiveNavItem($urlArray = [], $returnStr = null)
{
	$currentUrl = $_SERVER['REQUEST_URI'];
    $returnStr = $returnStr ?? 'active';
	$match = false;

	foreach ($urlArray as $inputUrl) {
		if (substr($inputUrl, -2) === '/*') {
            // If the URL ends with a trailing slash and asterisk (wildcard), 
            // check if the current URL starts with it (with removed asterisk)
            if (strpos($currentUrl, substr($inputUrl, 0, -1)) === 0) 
                $match = true;
        } else {
            // Otherwise, perform an exact match comparison
            if ($currentUrl === $inputUrl) 
                $match = true;
        }
	}

	return $match ? $returnStr : null;
}

/**
 * Translate user account status ID.
 */
function userAccountStatus($status = null)
{
    require ROOT . '/config/data.php';

    if ($status === null) App::error("No user account status code submitted");

    return $userAccountStatusCodes[$status];
}

/**
 * Return a Fontawesome icon based on user account status.
 */
function userAccountStatusIcon($status = null)
{
    require ROOT . '/config/data.php';

    $unknownStatusIcon = '<i class="fa-solid fa-fw fa-question-circle text-secondary" data-bs-toggle="tooltip" data-bs-title="Status unknown"></i>';
    
    $statusCodes = [
        0 => '<i class="fa-solid fa-fw fa-times-circle text-danger" data-bs-toggle="tooltip" data-bs-title="' . $userAccountStatusCodes[$status]['title'] . '"></i>',
        1 => '<i class="fa-solid fa-fw fa-check-circle text-success" data-bs-toggle="tooltip" data-bs-title="' . $userAccountStatusCodes[$status]['title'] . '"></i>'
    ];

    return key_exists($status, $statusCodes) ? $statusCodes[$status]: $unknownStatusIcon;
}

/**
 * Translate checkbox state.
 */
function checkboxState($input)
{
    return $input === 1 ? 'checked' : null;
}

/**
 * Return a Bootstrap breadcrumb component.
 */
function breadcrumbs($breadcrumbsArray = array())
{
    echo "<nav aria-label='breadcrumb'>";
    echo "<ol class='breadcrumb m-0 mb-3 small'>";
    foreach ($breadcrumbsArray as $bc) {
        if (isset($bc['active']) && $bc['active'] == true) {
            echo "<li class='breadcrumb-item active'>" . $bc['title'] . "</li>";
        } else {
            echo "<li class='breadcrumb-item'><a href='" . $bc['url'] . "' class='link-secondary'>" . $bc['title'] . "</a></li>";
        }
    }
    echo "</ol>";
    echo "</nav>";
}

/**
 * Return a styled asterisk for required input fields.
 */
function required()
{
    return '<span class="text-danger">*</span>';
}

/**
 * Return a div with a Bootstrap class if the input has a validation error.
 */
function inputErrorMessage($field)
{
    if (! key_exists($field, Session::get('errors', []))) {
        return "";
    }
    
    foreach (Session::get('errors')[$field] as $message) {
        return "<div class=\"invalid-feedback\">$message</div>";
    }
}

/**
 * Return a Bootstrap class if the input has a validation error.
 */
function inputErrorStyle($field)
{
    return key_exists($field, Session::get('errors', [])) ? "is-invalid" : "";
}

/**
 * Return otions for a <select> input based on an array of roles.
 */
function rolesSelect(array $rolesList, array $args = [])
{
    $includeEmpty = $args['includeEmpty'] ?? false;
    $selected = $args['selected'] ?? null;
    $rolesSelectOptions = $includeEmpty ? "<option id=\"\" value=\"\"></option>" : null;
    
    foreach ($rolesList as $role) {
        $isSelected = $role['id'] == $selected ? 'selected' : null;
        $rolesSelectOptions .= "
            <option id=\"{$role['id']}\" value=\"{$role['id']}\" $isSelected>
                {$role['long_name']} ({$role['name']})
            </option>
        ";
    }

    return $rolesSelectOptions;
}

/**
 * Generate a new image name based on the user ID and timestamp.
 */
function profileImageName($userId = null)
{
	$id = $userId ?? \App\Models\User::id();
	$date = date("YmdHis");
	$fileName = $_FILES['image']['name'];

	return "uid$id-$date-$fileName";
}