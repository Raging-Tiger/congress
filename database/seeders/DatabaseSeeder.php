<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
define('ENABLED_NOTIFICATIONS', 1);
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with default values and statuses
     * according to the Software specification.
     *
     * @return void
     */
    public function run()
    {
        /* Default application roles */
        \App\Models\Role::create(array('name' => 'Admin'));
        \App\Models\Role::create(array('name' => 'Private participant'));
        \App\Models\Role::create(array('name' => 'Commercial participant'));
        \App\Models\Role::create(array('name' => 'Reviewer'));
        \App\Models\Role::create(array('name' => 'Blocked'));
        
        
        \App\Models\User::create(array('name' => 'admin',
                                       'email' => 'admin@medcongress.test',
                                       'password' => bcrypt('secret'),
                                       'email_notifications' => ENABLED_NOTIFICATIONS,
                                       'role_id' => 1,));
        
        \App\Models\NotificationType::create(array('name' => 'Public',
                                                   'description' => 'Any visitor will see the announcement'));
        \App\Models\NotificationType::create(array('name' => 'Private',
                                                   'description' => 'Messages can be seen by registrated users'));
        
        
        \App\Models\Language::create(array('name' => 'English', 'language_code' => 'en'));
        \App\Models\Language::create(array('name' => 'Russian', 'language_code' => 'ru'));
    }
}
