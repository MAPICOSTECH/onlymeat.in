<?php

namespace Helpers;

class Session {

    //check login
    public static function loginCheck($autoRedirect = true) {
        if ($_SESSION[GEOMETRY_APP_SESSION]['user_guid'] == '' || $_SESSION[GEOMETRY_APP_SESSION]['subscription_status'] != 'active') {
            $loggedIn = false;
        } else {
            $loggedIn = true;
        }

        //if not logged in, redirect automatically
        if ($autoRedirect && !$loggedIn) {
            header('location:' . GEOMETRY_BASE_URL . '/account/login.php');
            echo 'No login';
            exit;
        }
        return $loggedIn;
    }

    public static function reset() {
        $_SESSION[GEOMETRY_APP_SESSION] = null;
    }

    public static function set($key, $value) {
        $_SESSION[GEOMETRY_APP_SESSION][$key] = $value;
    }

    public static function get($key) {
        return $_SESSION[GEOMETRY_APP_SESSION][$key];
    }

    public static function checkUserRole($role) {
        self::hasUserRole($role, true);
    }

    public static function checkUserRoleAny($rolesArray) {
        self::hasUserRoleAny($rolesArray, true);
    }

    public static function hasUserRole($role, $autoRedirect = false) {

        if (strpos($_SESSION[GEOMETRY_APP_SESSION]['user_app_roles'], $role) !== FALSE) {
            $hasRole = true;
        } else {
            $hasRole = false;
        }

        //if not logged in, redirect automatically
        if ($autoRedirect && !$hasRole) {
            header('location:' . PATH_TO_ROOT . '/home/'); //redirect to home page after login
            exit;
        }
        return $hasRole;
    }

    public static function hasUserRoleAny($rolesArray, $autoRedirect = true) {

        if (is_array($rolesArray) && count($rolesArray) > 0) {
            foreach ($rolesArray as $roleToCheck) {
                if (strpos($_SESSION[GEOMETRY_APP_SESSION]['user_app_roles'], $roleToCheck) !== FALSE)
                    $hasRole = true;
            }

            //if no role and specified autoRedirect, redirect
            if ($autoRedirect && !$hasRole) {
                header('location:' . PATH_TO_ROOT . '/home/'); //redirect to home page after login
                exit;
            }
            return $hasRole;
        }
    }

}
