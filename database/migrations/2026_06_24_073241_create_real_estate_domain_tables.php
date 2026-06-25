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
        // 1. admin
        Schema::create('admin', function (Blueprint $table) {
            $table->integer('User_ID')->primary();
            $table->string('Admin_Role', 50)->nullable();
            
            $table->foreign('User_ID')->references('User_ID')->on('user')->onDelete('cascade');
        });

        // 2. agent
        Schema::create('agent', function (Blueprint $table) {
            $table->integer('User_ID')->primary();
            $table->string('Agency_Name', 100)->nullable();
            $table->string('License_Number', 50)->nullable();
            $table->integer('Experience_Years')->nullable();
            $table->float('Rating')->nullable();
            
            $table->foreign('User_ID')->references('User_ID')->on('user')->onDelete('cascade');
        });

        // 3. buyer
        Schema::create('buyer', function (Blueprint $table) {
            $table->integer('User_ID')->primary();
            $table->string('Preference', 255)->nullable();
            
            $table->foreign('User_ID')->references('User_ID')->on('user')->onDelete('cascade');
        });

        // 4. renter
        Schema::create('renter', function (Blueprint $table) {
            $table->integer('User_ID')->primary();
            $table->date('Move_In_Date')->nullable();
            
            $table->foreign('User_ID')->references('User_ID')->on('user')->onDelete('cascade');
        });

        // 5. owner
        Schema::create('owner', function (Blueprint $table) {
            $table->integer('User_ID')->primary();
            $table->string('Ownership_Type', 50)->nullable();
            
            $table->foreign('User_ID')->references('User_ID')->on('user')->onDelete('cascade');
        });

        // 6. property_category
        Schema::create('property_category', function (Blueprint $table) {
            $table->integer('Category_ID')->autoIncrement();
            $table->string('Category_Name', 100)->nullable();
            $table->string('Category_Type', 50)->nullable();
        });

        // 7. property
        Schema::create('property', function (Blueprint $table) {
            $table->integer('Property_ID')->autoIncrement();
            $table->integer('Owner_ID')->nullable();
            $table->integer('Agent_ID')->nullable();
            $table->integer('Category_ID')->nullable();
            $table->string('Title', 150)->nullable();
            $table->text('Description')->nullable();
            $table->string('Location', 255)->nullable();
            $table->string('City', 100)->nullable();
            $table->string('State', 100)->nullable();
            $table->string('Zip_Code', 20)->nullable();
            $table->float('Area_Size')->nullable();
            $table->integer('Bedrooms')->nullable();
            $table->integer('Bathrooms')->nullable();
            $table->string('Property_Type', 50)->nullable();
            $table->decimal('Price', 12, 2)->nullable();
            $table->string('Availability_Status', 30)->nullable();
            
            $table->foreign('Owner_ID')->references('User_ID')->on('owner')->onDelete('cascade');
            $table->foreign('Agent_ID')->references('User_ID')->on('agent')->onDelete('set null');
            $table->foreign('Category_ID')->references('Category_ID')->on('property_category')->onDelete('set null');
        });

        // 8. amenity
        Schema::create('amenity', function (Blueprint $table) {
            $table->integer('Amenity_ID')->autoIncrement();
            $table->string('Amenity_Name', 100)->nullable();
            $table->string('Description', 255)->nullable();
        });

        // 9. property_amenity
        Schema::create('property_amenity', function (Blueprint $table) {
            $table->integer('Property_ID');
            $table->integer('Amenity_ID');
            
            $table->primary(['Property_ID', 'Amenity_ID']);
            $table->foreign('Property_ID')->references('Property_ID')->on('property')->onDelete('cascade');
            $table->foreign('Amenity_ID')->references('Amenity_ID')->on('amenity')->onDelete('cascade');
        });

        // 10. property_image
        Schema::create('property_image', function (Blueprint $table) {
            $table->integer('Image_ID')->autoIncrement();
            $table->integer('Property_ID')->nullable();
            $table->string('Image_Path', 255)->nullable();
            $table->date('Upload_Date')->nullable();
            $table->string('Caption', 255)->nullable();
            
            $table->foreign('Property_ID')->references('Property_ID')->on('property')->onDelete('cascade');
        });

        // 11. payment_scheme
        Schema::create('payment_scheme', function (Blueprint $table) {
            $table->integer('Scheme_ID')->autoIncrement();
            $table->integer('Property_ID')->nullable();
            $table->string('Scheme_Name', 100)->nullable();
            $table->string('Scheme_Type', 100)->nullable();
            $table->decimal('Advance_Percentage', 5, 2)->nullable();
            $table->integer('Installment_Months')->nullable();
            $table->string('Description', 255)->nullable();
            
            $table->foreign('Property_ID')->references('Property_ID')->on('property')->onDelete('cascade');
        });

        // 12. listing
        Schema::create('listing', function (Blueprint $table) {
            $table->integer('Listing_ID')->autoIncrement();
            $table->integer('Property_ID')->nullable();
            $table->integer('Created_By')->nullable();
            $table->string('Listing_Type', 50)->nullable();
            $table->decimal('Price', 12, 2)->nullable();
            $table->date('Listing_Date')->nullable();
            $table->date('Expire_Date')->nullable();
            $table->string('Status', 30)->nullable();
            $table->text('Description')->nullable();
            $table->boolean('Featured_Flag')->nullable();
            $table->integer('Total_Views')->nullable();
            
            $table->foreign('Property_ID')->references('Property_ID')->on('property')->onDelete('cascade');
            $table->foreign('Created_By')->references('User_ID')->on('user')->onDelete('cascade');
        });

        // 13. favorite_listing
        Schema::create('favorite_listing', function (Blueprint $table) {
            $table->integer('Favorite_ID')->autoIncrement();
            $table->integer('User_ID')->nullable();
            $table->integer('Listing_ID')->nullable();
            $table->date('Saved_Date')->nullable();
            
            $table->foreign('User_ID')->references('User_ID')->on('user')->onDelete('cascade');
            $table->foreign('Listing_ID')->references('Listing_ID')->on('listing')->onDelete('cascade');
        });

        // 14. inquiry
        Schema::create('inquiry', function (Blueprint $table) {
            $table->integer('Inquiry_ID')->autoIncrement();
            $table->integer('User_ID')->nullable();
            $table->integer('Listing_ID')->nullable();
            $table->text('Message')->nullable();
            $table->date('Inquiry_Date')->nullable();
            $table->string('Inquiry_Status', 30)->nullable();
            
            $table->foreign('User_ID')->references('User_ID')->on('user')->onDelete('cascade');
            $table->foreign('Listing_ID')->references('Listing_ID')->on('listing')->onDelete('cascade');
        });

        // 15. booking
        Schema::create('booking', function (Blueprint $table) {
            $table->integer('Booking_ID')->autoIncrement();
            $table->integer('User_ID')->nullable();
            $table->integer('Property_ID')->nullable();
            $table->integer('Owner_ID')->nullable();
            $table->integer('Agent_ID')->nullable();
            $table->date('Visit_Date')->nullable();
            $table->time('Visit_Time')->nullable();
            $table->string('Booking_Status', 30)->nullable();
            
            $table->foreign('User_ID')->references('User_ID')->on('user')->onDelete('cascade');
            $table->foreign('Property_ID')->references('Property_ID')->on('property')->onDelete('cascade');
            $table->foreign('Owner_ID')->references('User_ID')->on('owner')->onDelete('cascade');
            $table->foreign('Agent_ID')->references('User_ID')->on('agent')->onDelete('set null');
        });

        // 16. payment
        Schema::create('payment', function (Blueprint $table) {
            $table->integer('Payment_ID')->autoIncrement();
            $table->integer('User_ID')->nullable();
            $table->integer('Scheme_ID')->nullable();
            $table->decimal('Amount', 12, 2)->nullable();
            $table->date('Payment_Date')->nullable();
            $table->string('Payment_Method', 50)->nullable();
            $table->string('Payment_Status', 30)->nullable();
            
            $table->foreign('User_ID')->references('User_ID')->on('user')->onDelete('cascade');
            $table->foreign('Scheme_ID')->references('Scheme_ID')->on('payment_scheme')->onDelete('cascade');
        });

        // 17. review
        Schema::create('review', function (Blueprint $table) {
            $table->integer('Review_ID')->autoIncrement();
            $table->integer('User_ID')->nullable();
            $table->integer('Booking_ID')->nullable();
            $table->integer('Property_ID')->nullable();
            $table->integer('Agent_ID')->nullable();
            $table->integer('Rating')->nullable();
            $table->text('Comment')->nullable();
            $table->date('Review_Date')->nullable();
            
            $table->foreign('User_ID')->references('User_ID')->on('user')->onDelete('cascade');
            $table->foreign('Booking_ID')->references('Booking_ID')->on('booking')->onDelete('cascade');
            $table->foreign('Property_ID')->references('Property_ID')->on('property')->onDelete('cascade');
            $table->foreign('Agent_ID')->references('User_ID')->on('agent')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review');
        Schema::dropIfExists('payment');
        Schema::dropIfExists('booking');
        Schema::dropIfExists('inquiry');
        Schema::dropIfExists('favorite_listing');
        Schema::dropIfExists('listing');
        Schema::dropIfExists('payment_scheme');
        Schema::dropIfExists('property_image');
        Schema::dropIfExists('property_amenity');
        Schema::dropIfExists('amenity');
        Schema::dropIfExists('property');
        Schema::dropIfExists('property_category');
        Schema::dropIfExists('owner');
        Schema::dropIfExists('renter');
        Schema::dropIfExists('buyer');
        Schema::dropIfExists('agent');
        Schema::dropIfExists('admin');
    }
};
