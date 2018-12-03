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
            $table->string('site_name_abbr', 100)->default('M');
            $table->integer('qr_code')->nullable()->default(NULL);
            $table->string('qr_text', 32)->nullable()->default(NULL);
            $table->integer('display_asset_name')->nullable()->default(NULL);
            $table->integer('display_checkout_date')->nullable()->default(NULL); // TODO: Check and remove if necessary
            $table->integer('display_eol')->nullable()->default(NULL); // TODO: Check and remove if necessary
            $table->integer('auto_increment_assets')->default(0);
            $table->string('auto_increment_prefix')->default(0);
            $table->boolean('load_remote')->default(1); // TODO: Check and remove if necessary
            $table->string('logo')->nullable()->default(NULL);
            $table->string('mini_logo')->nullable()->default(NULL);
            $table->string('header_color')->nullable()->default(NULL);
            $table->string('alert_email')->nullable()->default(NULL);
            $table->boolean('alerts_enabled')->default(1);
            $table->longText('default_eula_text')->nullable()->default(NULL); // TODO: Check and remove if necessary
            $table->string('barcode_type')->nullable()->default('QRCODE');
            $table->string('alt_barcode')->nullable()->default('C128');
            $table->boolean('alt_barcode_enabled')->nullable()->default('1');
            $table->string('slack_endpoint')->nullable()->default(NULL);
            $table->string('slack_channel')->nullable()->default(NULL);
            $table->string('slack_botname')->nullable()->default(NULL);
            $table->string('default_currency',10)->nullable()->default(NULL);
            $table->text('custom_css')->nullable()->default(NULL);
            $table->enum('brand',['text_only', 'logo_only', 'text_logo'])->default('text_only');
            $table->string('locale',5)->nullable()->default(config('app.locale'));

            // Lebel settings
            $table->tinyInteger('labels_per_page')->default(30);
            $table->decimal('labels_width', 6, 5)->default(2.625);
            $table->decimal('labels_height', 6, 5)->default(1);
            $table->decimal('labels_pmargin_left', 6, 5)->default(0.21975);
            $table->decimal('labels_pmargin_right', 6, 5)->default(0.21975);
            $table->decimal('labels_pmargin_top', 6, 5)->default(0.5);
            $table->decimal('labels_pmargin_bottom', 6, 5)->default(0.5);
            $table->decimal('labels_display_bgutter', 6, 5)->default(0.07);
            $table->decimal('labels_display_sgutter', 6, 5)->default(0.05);
            $table->tinyInteger('labels_fontsize')->default(9);
            $table->decimal('labels_pagewidth', 7, 5)->default(8.5);
            $table->decimal('labels_pageheight', 7, 5)->default(11);
            $table->tinyInteger('labels_display_name')->default(0);
            $table->tinyInteger('labels_display_serial')->default(1);
            $table->tinyInteger('labels_display_tag')->default(1);


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
