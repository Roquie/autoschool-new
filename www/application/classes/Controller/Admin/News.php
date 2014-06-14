<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Admin_News extends Controller_Admin_Base
{


    public function action_index()
    {
        $news = new Model_News();

        $list_users = Model::factory('User')->get_user_list(false);
        $list_groups = Model::factory('Group')->find_all();
        $this->template->content =
            View::factory('admin/messages/news', compact('list_users', 'list_groups'));
    }

    public function action_get_news()
    {
        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            $news = ORM::factory('News')
                       ->where('group_id', '=', (int)$post['group_id'])
                       ->order_by('id', 'desc')
                       ->find_all();

            if ($news->count() > 0)
            {
                $this->ajax_data(
                    View::factory('admin/html/thisnews', compact('news'))->render()
                );
            }
            else
            {
                $this->ajax_msg('Для данной группы новости не найдены. Добавьте чтонибудь используя форму.', 'error');
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
                $pk = ORM::factory('News')
                   ->values($post)
                   ->create()->pk();

                if (isset($post['email_send']))
                {
                    $query = DB::select('email', 'imya', 'name')
                        ->from('listeners')
                        ->where('group_id', '=', (int)$post['group_id'])
                        ->join('users')
                        ->on('users.id', '=', 'listeners.user_id')
                        ->join('groups')
                        ->on('listeners.group_id', '=', 'groups.id')
                        ->execute();

                    if ($query->count() > 0)
                    {

                        foreach($query->as_array() as $value)
                        {
                            $mail_content = View::factory('tmpmail/admin/add_news')
                                ->set('username', $value['imya'])
                                ->set('group', $value['name'])
                                ->set('news_title', $post['title'])
                                ->set('news_text', $post['message']);

                            $message = View::factory('tmpmail/template', compact('mail_content'));

                            try
                            {
                                Email::factory('Новости. Автошкола МПТ', $message, 'text/html')
                                    ->to($value['email'])
                                    ->from(Kohana::$config->load('settings.email'), 'Автошкола МПТ')
                                    ->send();
                            }
                            catch(Swift_SwiftException $e)
                            {
                                $this->ajax_msg('Ошибка отправки писем. Возможно, неправильно настроено SMTP - '.$e->getMessage(), 'error');
                            }
                        }

                    }
                    else
                    {
                        $this->ajax_msg('В этой группе нет слушателей (чего быть не должно)', 'error');
                    }
                }

                $news = ORM::factory('News')->where('id', '=', $pk)->find();

                if ($news->loaded())
                {
                    $this->ajax_data(
                        //@todo: способ веселого молочника (object)array($news)
                        View::factory('admin/html/thisnews')->set('news', (object)array($news))->render(),
                        'OK. Добавлено'
                    );
                }
                else
                {
                    $this->ajax_msg('Чтото стало с базой :(', 'error');
                }

            }
            catch(ORM_Validation_Exception $e)
            {
                $errors = $e->errors('validation');
                $this->ajax_msg(array_shift($errors), 'error');
            }

        }
    }

    public function action_remove()
    {
        $post = $this->request->post();

        if (Security::is_token($post['csrf']) && $this->request->method() === Request::POST)
        {
            $result = ORM::factory('News', (int)$post['news_id']);

            if ($result->loaded())
            {
                try
                {
                    ORM::factory('News', (int)$post['news_id'])
                        ->delete();

                    $this->ajax_msg('Новость удалена');
                }
                catch(Database_Exception $e)
                {
                    $this->ajax_msg($e->getMessage(), 'error');
                }
            }
            else
            {
                $this->ajax_msg('Новость в БД не найдена', 'error');
            }

        }
    }




}