<?php

class User
{
    private $_db,
        $_data,
        $_sessionName,
        $_cookieName,
        $_isLoggedIn;

    public function __construct($user = null)
    {
        $this->_db = Database::getInstance();

        $this->_sessionName = Config::get('session/session_name');

        $this->_cookieName = Config::get('remember/cookie_name');

        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);

                if ($this->find($user)) {
                    $this->_isLoggedIn = true;
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function update($fields = array(), $id = null)
    {
        if (!$id && $this->isLoggedIn()) {
            $id = $this->data()->user_id;
        }

        if (!$this->_db->update('users', 'user_id', $id, $fields)) {
            throw new Exception('Unable to update the user.');
        }
    }

    public function create($fields = array())
    {
        if (!$this->_db->insert('users', $fields)) {
            throw new Exception("Unable to create the user.");
        }
    }

    public function find($user = null)
    {
        if ($user) {
            $field = (is_numeric($user)) ? 'user_id' : 'username';

            $data = $this->_db->get('users', array($field, '=', $user));

            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
    }

    public function login($username = null, $password = null, $remember = false)
    {
        if (!$username && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->user_id);
        } else {
            $user = $this->find($username);

            if ($user) {
                if (Password::check($password, $this->data()->password)) {
                    Session::put($this->_sessionName, $this->data()->user_id);

                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_sessions', array('user_id', '=', $this->data()->user_id));

                        if (!$hashCheck->count()) {
                            $this->_db->insert(
                                'users_sessions',
                                array(
                                    'user_id' => $this->data()->user_id,
                                    'hash' => $hash
                                )
                            );
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }

                    return true;
                }
            }
        }

        return false;
    }

    public function hasPermission($key)
    {
        $group = $this->_db->get('groups', array('group_id', '=', $this->data()->groups));

        if ($group->count()) {
            $permissions = json_decode($group->first()->permissions, true);

            if ($permissions[$key] == true) {
                return true;
            }
        }

        return false;
    }

    public function exists()
    {
        return (!empty($this->_data)) ? true : false;
    }

    public function logout()
    {
        $this->_db->delete('users_sessions', array('user_id', '=', $this->data()->user_id));

        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    public function data()
    {
        return $this->_data;
    }

    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }

    public function isAdmin()
    {
        if ($this->isLoggedIn()) {
            $userData = $this->data();
            if (property_exists($userData, 'is_admin') && $userData->is_admin == 1) {
                return true;
            }
        }

        return false;
    }

    public function deleteMe()
    {
        if ($this->isLoggedIn()) {
            $id = $this->data()->user_id;
        }

        if (!$this->_db->delete('users', array('user_id', '=', $id))) {
            throw new Exception('Unable to update the user.');
        }
    }

    public static function getAllUsers()
    {
        $users = Database::getInstance()->query("SELECT * FROM users ORDER BY user_id ASC");
        //return list of users
        return $users;
    }

    public static function getUserById($user_id)
    {
        $user = Database::getInstance()->get('users', array('user_id', '=', $user_id));
        return $user->first();
    }

    public static function getUserByMail($email)
    {
        $user = Database::getInstance()->get('users', array('email', '=', $email));
        return $user->first();
    }

    public static function switchAdminState($user_id)
    {
        $user = Database::getInstance()->get('users', array('user_id', '=', $user_id));
        $user = $user->first();

        $is_admin = $user->is_admin;
        if ($is_admin == 1) {
            $is_admin = 0;
        } else {
            $is_admin = 1;
        }

        $db = Database::getInstance();
        if (!$db->update('users', 'user_id', $user_id, array('is_admin' => $is_admin))) {
            throw new Exception('There was a problem updating the user.');
        }
    }

    public static function checkVerificationByUsername($username)
    {
        try {
            $db = Database::getInstance();
            $user = $db->get('users', array('username', '=', $username))->first();
            $user_id = $user->user_id;
            $verification = $db->get('verifications', array('user_id', '=', $user_id))->first();
            if ($verification) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            // Handle the exception
            error_log($e->getMessage());
            return false; // or throw the exception again depending on your needs
        }
    }

    public static function getVerificationCode($user_id)
    {
        $db = Database::getInstance();
        $verification = $db->get('verifications', array('user_id', '=', $user_id))->first();
        return $verification->verification_code;
    }

    public static function makeVerified($user_id)
    {
        $db = Database::getInstance();
        if (!$db->delete('verifications', array('user_id', '=', $user_id))) {
            throw new Exception('There was a problem deleting the verification entry.');
        }
    }

    public static function getUserIdByUsername($username)
    {
        $db = Database::getInstance();
        $user = $db->get('users', array('username', '=', $username))->first();
        return $user->user_id;
    }

    public static function createVerificationCode($user_id)
    {
        $db = Database::getInstance();

        $verification_code = random_int(100000, 999999);

        if (!$db->insert('verifications', array('user_id' => $user_id, 'verification_code' => $verification_code))) {
            throw new Exception('There was a problem creating the verification code.');
        }
    }

    public static function checkVerification($user_id, $verification_code)
    {
        $db = Database::getInstance();

        $verification = $db->get('verifications', array('user_id', '=', $user_id))->first();

        if ($verification_code == $verification->verification_code) {
            return true;
        } else {
            return false;
        }
    }

    public static function makeUnverified($user_id)
    {
        $db = Database::getInstance();

        $verification_code = random_int(100000, 999999);

        if (!$db->update('verifications', 'user_id', $user_id, array('verification_code' => $verification_code))) {
            throw new Exception('There was a problem updating the verification code.');
        }
    }

    public static function delete($user_id)
    {
        if (!$user_id && $user_id != 0) {
            throw new Exception('Missing user ID');
        }

        $db = Database::getInstance();

        // Disable foreign key checks
        $db->query("SET FOREIGN_KEY_CHECKS=0");

        if (!$db->delete('users', array('user_id', '=', $user_id))) {
            throw new Exception('There was a problem deleting the user.');
        }

        $db->delete('reviews', array('user_id', '=', $user_id));
        $db->delete('orders', array('user_id', '=', $user_id));
        $db->delete('users_sessions', array('user_id', '=', $user_id));

        // Enable foreign key checks
        $db->query("SET FOREIGN_KEY_CHECKS=1");
    }

    public static function isVerified($user_id)
    {
        $db = Database::getInstance();
        $verification = $db->get('verifications', array('user_id', '=', $user_id))->first();
        if ($verification) {
            return false;
        } else {
            return true;
        }
    }
}
