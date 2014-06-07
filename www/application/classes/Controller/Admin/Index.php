<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Index extends Controller_Admin_Base
{

    public function action_index()
	{

        /*$this->auto_render = false;

        echo exec('chmod +x '.__FILE__);
        $crontab = new CrontabManager();
        $job = $crontab->newJob();
        $job->on('* * * * *');
        $job->onMinute('1')->doJob('curl --silent http://roquie.tk/index/cron &>/dev/null');
        $crontab->add($job);
        $crontab->save();

        //Find string
        $cronjob = '2	*	*	*	*	/usr/bin/curl --silent http://roquie.tk/index/cron &>/dev/null # a5x5es';

        $newcron = str_replace($cronjob, '', $crontab->listJobs());
        file_put_contents('/tmp/crontab.txt', $newcron.PHP_EOL);
        echo exec('crontab /tmp/crontab.txt');

        //echo $crontab->listJobs();
        //get contents of cron tab
        $output = shell_exec('crontab -l');
        echo "<pre>$output</pre>";


        exit;*/

        $list_users = Model::factory('User')->get_user_list(false);
        $list_groups = Model::factory('Group')->find_all();
        $instructors = Model::factory('Office')->getStaffs('инструктор');
        $edu = ORM::factory('Education')->find_all();
        $national = ORM::factory('Nationality')->find_all();
        $type_doc = ORM::factory('Documents')->find_all();

        $this->template->content = View::factory('admin/index', compact('list_users', 'instructors', 'list_groups', 'edu', 'national', 'type_doc'));
	}

}