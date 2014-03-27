<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Admin_News extends Controller_Admin_Base
{


    public function action_index()
    {
        $news = new Model_News();

        $list_users = Model::factory('User')->get_user_list(false);
        $list_groups = Model::factory('Groups')->find_all();
        $this->template->content =
            View::factory('admin/messages/news', compact('list_users', 'list_groups'));
    }

    public function action_get_news()
    {
        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            $result = ORM::factory('News')->where('group_id', '=', $post['group_id'])->find_all();

            if ($result->count() > 0)
            {
                foreach($result as $k => $v)
                    $news[] = $v->as_array();

                $this->ajax_data($news);
            }
            else
            {
                $this->ajax_msg('Для данной группы новости не найдены. Добавьте чтонибудь используя форму выше.', 'error');
            }

        }
    }

    public function action_create()
    {
        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            try
            {
                ORM::factory('News')
                   ->values($post)
                   ->create();

                $this->ajax_data($post, 'OK. Добавлено');
            }
            catch(ORM_Validation_Exception $e)
            {
                $errors = $e->errors('validation');
                $this->ajax_msg(array_shift($errors), 'error');
            }

        }
    }




}