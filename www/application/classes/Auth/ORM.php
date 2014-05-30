<?php defined('SYSPATH') OR die('No direct access allowed.');

class Auth_ORM extends Kohana_Auth_ORM
{
    /**
     * вход по телефону слушателя
     * @param $user
     * @param string $password
     * @param bool $remember
     * @return bool
     */
    protected function _login($user, $password, $remember)
    {
        if ( ! is_object($user))
        {
            $username = $user;

            // Load the user
            $user = ORM::factory('User');
            if ($user->unique_key($username) === 'hash')
            {
                $listeners = new Model_Listeners();
                $result = $listeners->where('tel', '=', Text::removeThanDigits($username))->find();

                $user->where($user->unique_key($username), '=', $result->user->hash)->find();
            }
            else
            {
                $user->where($user->unique_key($username), '=', $username)->find();
            }
        }

        if (is_string($password))
        {
            // Create a hashed password
            $password = $this->hash($password);
        }

        // If the passwords match, perform a login
        if ($user->has('roles', ORM::factory('Role', array('name' => 'login'))) AND $user->password === $password)
        {
            if ($remember === TRUE)
            {
                // Token data
                $data = array(
                    'user_id'    => $user->pk(),
                    'expires'    => time() + $this->_config['lifetime'],
                    'user_agent' => sha1(Request::$user_agent),
                );

                // Create a new autologin token
                $token = ORM::factory('User_Token')
                    ->values($data)
                    ->create();

                // Set the autologin cookie
                Cookie::set('authautologin', $token->token, $this->_config['lifetime']);
            }

            // Finish the login
            $this->complete_login($user);

            return TRUE;
        }

        // Login failed
        return FALSE;
    }

    /**
     * ну эт тоже
     * @param mixed $user
     * @param bool $mark_session_as_forced
     * @return bool|void
     */
    public function force_login($user, $mark_session_as_forced = FALSE)
    {
        if ( ! is_object($user))
        {
            $username = $user;

            // Load the user
            $user = ORM::factory('User');
            if ($user->unique_key($username) === 'hash')
            {
                $listeners = new Model_Listeners();
                $result = $listeners->where('tel', '=', Text::removeThanDigits($username))->find();

                $user->where($user->unique_key($username), '=', $result->user->hash)->find();
            }
            else
            {
                $user->where($user->unique_key($username), '=', $username)->find();
            }
        }

        if ($mark_session_as_forced === TRUE)
        {
            // Mark the session as forced, to prevent users from changing account information
            $this->_session->set('auth_forced', TRUE);
        }

        // Run the standard completion
        $this->complete_login($user);
    }


}