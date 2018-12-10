<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('per_page')->default(20);
            $table->string('site_name', 100)->default('Mily POS');
            $table->string('company_name', 100)->default('Mily POS');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->string('vat_no')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->integer('qr_code')->nullable()->default(NULL);
            $table->string('qr_text', 32)->nullable()->default(NULL);   $table->string('logo')->nullable()->default(NULL);
            $table->integer('thumbnail_max_h')->nullable()->default('50');
            $table->string('header_color')->nullable()->default(NULL);
            $table->string('barcode_type')->nullable()->default('QRCODE');
            $table->string('alt_barcode')->nullable()->default('C128');
            $table->boolean('alt_barcode_enabled')->nullable()->default('1');
            $table->string('default_currency',10)->nullable()->default(NULL);
            $table->text('custom_css')->nullable()->default(NULL);
            $table->enum('brand',['text_only', 'logo_only', 'text_logo'])->default('text_only');
            $table->string('locale',5)->nullable()->default(config('app.locale'));

            // Date time display format
            $table->string('date_display_format')->default('Y-m-d');
            $table->string('time_display_format')->default('h:i A');


            // Footer settings
            $table->char('support_footer', 5)->nullable()->default('on');
            $table->text('footer_text')->nullable()->default(null);
            $table->char('privacy_policy_link')->nullable()->default(null);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
