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
                "username" => "admin", "password" => Hash::make("pass!123"),
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

            array("name" => "manage_incidents", "display_name" => "Can Manage Biorisk & Biosecurity Incidents", "guard_name" => "web"),
            array("name" => "register_incident", "display_name" => "Can Register BB Incidences", "guard_name" => "web"),
            array("name" => "summary_log", "display_name" => "Can view BB summary log", "guard_name" => "web"),
            array("name" => "facility_report", "display_name" => "Can create faility BB report", "guard_name" => "web"),

            array("name" => "view_names", "display_name" => "Can view patient names", "guard_name" => "web"),
            array("name" => "manage_patients", "display_name" => "Can add patients", "guard_name" => "web"),

            array("name" => "receive_external_test", "display_name" => "Can receive test requests", "guard_name" => "web"),
            array("name" => "request_test", "display_name" => "Can request new test", "guard_name" => "web"),
            array("name" => "accept_test_specimen", "display_name" => "Can accept test specimen", "guard_name" => "web"),
            array("name" => "reject_test_specimen", "display_name" => "Can reject test specimen", "guard_name" => "web"),
            array("name" => "change_test_specimen", "display_name" => "Can change test specimen", "guard_name" => "web"),
            array("name" => "start_test", "display_name" => "Can start tests", "guard_name" => "web"),
            array("name" => "enter_test_results", "display_name" => "Can enter tests results", "guard_name" => "web"),
            array("name" => "edit_test_results", "display_name" => "Can edit test results", "guard_name" => "web"),
            array("name" => "verify_test_results", "display_name" => "Can verify test results", "guard_name" => "web"),
            array("name" => "send_results_to_external_system", "display_name" => "Can send test results to external systems", "guard_name" => "web"),
            array("name" => "refer_specimens", "display_name" => "Can refer specimens", "guard_name" => "web"),

            array("name" => "manage_users", "display_name" => "Can manage users", "guard_name" => "web"),
            array("name" => "manage_test_catalog", "display_name" => "Can manage test catalog", "guard_name" => "web"),
            array("name" => "manage_lab_configurations", "display_name" => "Can manage lab configurations", "guard_name" => "web"),
            array("name" => "view_reports", "display_name" => "Can view reports", "guard_name" => "web"),
            array("name" => "manage_inventory", "display_name" => "Can manage inventory", "guard_name" => "web"),
            array("name" => "request_topup", "display_name" => "Can request top-up", "guard_name" => "web"),
            array("name" => "manage_qc", "display_name" => "Can manage Quality Control", "guard_name" => "web"),
            array("name" => "approve_test_results", "display_name" => "Can approve test results as the last phase", "guard_name" => "web"),
            array("name" => "cancel_test", "display_name" => "Can cancel a test", "guard_name" => "web"),
            array("name" => "manage_bills", "display_name" => "Can manage bills", "guard_name" => "web"),
            array("name" => "recall_report", "display_name" => "Can recall a report of a Patient", "guard_name" => "web")
        );

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        echo "Permissions table seeded\n";

        /* Roles table */
        $roles = array(
            array("name" => "Superadmin", "guard_name" => "web"),
            array("name" => "Technologist", "guard_name" => "web"),
            array("name" => "Receptionist", "guard_name" => "web")
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
