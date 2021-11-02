<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\User;
use App\Profile;
use App\Settings;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = array(
            array('User', array(
                'Browse',
                'Read',
                'Edit',
                'Add',
                'Delete'
            )),
            array('Profile', array(
                'Browse',
                'Read',
                'Edit',
                'Add',
                'Delete'
            )),
            array('Inventory', array(
                'Browse',
                'Read',
                'Edit',
                'Add',
                'Delete'
            )),
            array('Setting', array(
                'Browse',
                'Read',
                'Edit',
                'Add',
                'Delete'
            ))
        );

        foreach ($models as $model) {
            foreach ($model[1] as $permission){
                Permission::create([
                    'name' => stringSlug($permission).'-'.stringSlug($model[0]),
                    'display_name' => $permission, 'table_name' => stringSlug($model[0]),
                    'table_display_name' => $model[0]
                ]);
            }
        }

        $roles = array(
            'Super Admin',
            'Administrator',
            'Community Leader',
            'Farmer',
            'Loan Provider',
            'Borrower',
            'BFAR',
            'Enterprise Client'
        );

        foreach($roles as $role) {
            Role::create(array(
                'name' => stringSlug($role),
                'display_name' => $role
            ));
        }

        $user = new User();
        $user->name = 'Super Admin';
        $user->email = 'superadmin@agrabah.ph';
        $user->password = bcrypt('agrabah');
        $user->passkey = 'agrabah';
        $user->active = 1;
        if($user->save()) {
            $user->assignRole(stringSlug('Super Admin'));
            $user->markEmailAsVerified();

            $profile = new Profile();
            $profile->first_name = 'Super';
            $profile->last_name = 'Admin';
            $profile->save();

            $setting = new Settings();
            $setting->name = stringSlug('SMS');
            $setting->display_name = 'SMS';
            $setting->value = 'Switch for SMS Notification';
            $setting->is_active = 0;
            $setting->save();

            $setting = new Settings();
            $setting->name = stringSlug('Agrabah mobile number');
            $setting->display_name = 'Agrabah mobile number';
            $setting->save();

            $setting = new Settings();
            $setting->name = stringSlug('Finance Service Fee');
            $setting->display_name = 'Finance Service Fee';
            $setting->value = 0;
            $setting->is_active = 0;
            $setting->save();

            $setting = new Settings();
            $setting->name = stringSlug('BFAR');
            $setting->display_name = 'BFAR';
            $setting->value = 'bfar';
            $setting->is_active = 1;
            $setting->save();

            $setting = new Settings();
            $setting->name = 'service_fee_percentage';
            $setting->display_name = 'Server Fee Percentage';
            $setting->value = 5.25;
            $setting->save();

            $setting = new Settings();
            $setting->name = 'spot_market_next_bid';
            $setting->display_name = 'Next Bid Minimum';
            $setting->value = 5;
            $setting->save();
        }

    }
}
