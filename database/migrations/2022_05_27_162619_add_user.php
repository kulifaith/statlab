<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AddUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         // seeding on the go! STARTS HERE

        Model::unguard();


        /* Users table */
        $usersData = array(
            array(
                "username" => "admin", "password" => Hash::make("12345"),
                "email" => "", "name" => "Administrator", "designation" => "Systems Administrator",
                "facility_id" => config('constants.FACILITY_ID')
            ),
        );

        foreach ($usersData as $user)
        {
            $users[] = User::create($user);
        }
        echo "users seeded\n";

        /* Permissions table */
        $permissions = array(

            array("name" => "manage_course", "display_name" => "Can Manage Course", "guard_name" => "web"),
            array("name" => "manage_rows", "display_name" => "Can Manage Addition of Rows", "guard_name" => "web"),
            array("name" => "manage_records", "display_name" => "Can Manage Records", "guard_name" => "web"),
            array("name" => "manage_reports", "display_name" => "Can Manage Reports", "guard_name" => "web")
        );

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        echo "Permissions table seeded\n";

        /* Roles table */
        $roles = array(
            array("name" => "Superadmin", "guard_name" => "web"),
            array("name" => "Lab Attendant", "guard_name" => "web")
        );
        foreach ($roles as $role) {
            Role::create($role);
        }
        echo "Roles table seeded\n";
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
