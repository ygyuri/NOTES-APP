<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveAdditionalUserFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bio',
                'location',
                'preferences',
                'social_media_links',
                'contact',
                'permissions',
                'email_verified',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('bio')->nullable()->comment('Allow users to provide a short bio or description about themselves.');
            $table->string('location')->nullable()->comment('Allow users to specify their location.');
            $table->json('preferences')->nullable()->comment('Allow users to set preferences for their account.');
            $table->json('social_media_links')->nullable()->comment('Allow users to include links to their social media profiles (Instagram, Twitter, Facebook, and TikTok).');
            $table->string('contact')->nullable()->comment('Allow users to provide additional contact information such as phone number or secondary email address.');
            $table->string('permissions')->nullable()->comment('Implement a roles and permissions system to manage user roles and access levels within your application.');
            $table->boolean('email_verified')->default(false)->comment('Keep track of whether the user\'s email address has been verified.');
        });
    }
}