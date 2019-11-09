<?php
namespace App\Observers;

use App\Manager;
use Illuminate\Support\Facades\Log;

class ManagerObserver
{

    public function saving(Manager $manager)
    {
        Log::info('即将保存用户到数据库[' . $manager->mg_id . ']' . $manager->mg_name);
    }

   
    public function creating(Manager $manager)
    {
        Log::info('即将插入用户到数据库[' . $manager->mg_id . ']' . $manager->mg_name);
    }

   
    public function updating(Manager $manager)
    {
        Log::info('即将更新用户到数据库[' . $manager->mg_id . ']' . $manager->mg_name);
    }

   
    public function updated(Manager $manager)
    {
        Log::info('已经更新用户到数据库[' . $manager->mg_id . ']' . $manager->mg_name);
    }


    public function created(Manager $manager)
    {
        Log::info('已经插入用户到数据库[' . $manager->mg_id . ']' . $manager->mg_name);
    }


    public function saved(Manager $manager)
    {
        Log::info('已经保存用户到数据库[' . $manager->mg_id . ']' . $manager->mg_name);
    }
}
