<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('unlocked_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id')->nullable(); //optional
            $table->unsignedBigInteger('employer_id')->nullable(); //optional
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->timestamps();

            //TODO: Locations from where user can Unlocked themselves
            //Job offer from list
            //Sent job offers
            //From list of Campaigns
            //Company page Unlocked (1-click apply)
            //Direct message
            //Manual unlocked ??? Employer_ID/Campaign_Id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unlocked_contacts');
    }
};
