<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Twitter extends Controller
{
    public function action_tweets()
    {
        $tweets = Twitter::factory()->getTweets();
        echo View::factory('tweets', array(
            'tweets' => $tweets
        ))->render();
    }

    public function action_add_tweet()
    {
        $this->auto_render = false;
        $csrf = $this->request->post('csrf');

        if (Security::is_token($csrf) && $this->request->method() === Request::POST) {

            $post = $this->request->post();

            $valid = new Validation(
                Arr::map(
                    'Security::xss_clean',
                    Arr::map('trim', $post)
                )
            );

            $valid->label('message', 'Поле "твит"');
            $valid->rule('message', 'not_empty');
            $valid->rule('message', 'min_length', array(':value', 1));
            $valid->rule('message', 'max_length', array(':value', 140));

            if ($valid->check())
            {
                $result = Twitter::factory()->addTweet($post['message']);

                $errors = array();

                if (isset($result->errors)) {
                    foreach ($result->errors as $key => $value) {
                        $errors[] = $value->message;
                    }
                    echo $this->ajax_data($errors, null, 'error');
                } else {
                    echo $this->ajax_msg('Твит опубликован');
                }
            }
            else
            {
                $this->ajax_data($valid->errors('validation'), null, 'error');
            }

        }
    }

}
