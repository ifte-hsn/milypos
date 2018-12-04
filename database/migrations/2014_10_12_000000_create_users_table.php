<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('active')->default(0);
            $table->string('activation_code')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('persist_code')->nullable();
            $table->string('reset_password_code')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('image_url')->nullable();
            $table->string('website')->nullable();
            $table->string('country')->nullable();
            $table->string('gravatar')->nullable();
            $table->string('jobtitle')->nullable();
            $table->integer('manager_id')->nullable()->default(NULL);
            $table->text('employee_num','50')->nullable()->default(NULL);

            // TODO: REMOVE
            $table->integer('company_id')->unsigned()->nullable();
            $table->string('locale',5)->nullable()->default(config('app.locale'));
            $table->boolean('show_in_list')->default(1);

            // Address
            $table->integer('location_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->string('state', 3)->nullable()->default(null);
            $table->string('zip', 10)->nullable()->default(null);


            $table->rememberToken();
            $table->timestamps();


            $table->index('activation_code');
            $table->index('reset_password_code');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
