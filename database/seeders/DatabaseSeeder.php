<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    
    public function run(): void
    {
        // Disable foreign key checks for seeding
        //DB::statement('PRAGMA foreign_keys = OFF;');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data
        DB::table('review')->truncate();
        DB::table('payment')->truncate();
        DB::table('booking')->truncate();
        DB::table('inquiry')->truncate();
        DB::table('favorite_listing')->truncate();
        DB::table('listing')->truncate();
        DB::table('payment_scheme')->truncate();
        DB::table('property_image')->truncate();
        DB::table('property_amenity')->truncate();
        DB::table('amenity')->truncate();
        DB::table('property')->truncate();
        DB::table('property_category')->truncate();
        DB::table('owner')->truncate();
        DB::table('renter')->truncate();
        DB::table('buyer')->truncate();
        DB::table('agent')->truncate();
        DB::table('admin')->truncate();
        DB::table('user')->truncate();

        // 1. Seed User
        $users = [
            [
                'User_ID' => 1,
                'Full_Name' => 'Ali Khan',
                'Email' => 'ali@gmail.com',
                'Phone_Number' => '03001234567',
                'Identity_Type' => 'CNIC',
                'Identity_Number' => '12345',
                'Password' => Hash::make('123456'),
                'Registration_Date' => '2025-06-01',
                'Status' => 'Active'
            ],
            [
                'User_ID' => 2,
                'Full_Name' => 'Sara Ahmed',
                'Email' => 'sara@gmail.com',
                'Phone_Number' => '03111234567',
                'Identity_Type' => 'CNIC',
                'Identity_Number' => '54321',
                'Password' => Hash::make('123456'),
                'Registration_Date' => '2025-06-02',
                'Status' => 'Active'
            ],
            [
                'User_ID' => 3,
                'Full_Name' => 'Ahmed Raza',
                'Email' => 'ahmed@gmail.com',
                'Phone_Number' => '03221234567',
                'Identity_Type' => 'CNIC',
                'Identity_Number' => '67890',
                'Password' => Hash::make('123456'),
                'Registration_Date' => '2025-06-03',
                'Status' => 'Active'
            ]
        ];
        DB::table('user')->insert($users);

        // 2. Seed Admin
        DB::table('admin')->insert([
            'User_ID' => 1,
            'Admin_Role' => 'System Administrator'
        ]);

        // 3. Seed Agent
        DB::table('agent')->insert([
            'User_ID' => 3,
            'Agency_Name' => 'Dream Homes',
            'License_Number' => 'LIC001',
            'Experience_Years' => 5,
            'Rating' => 4.8
        ]);

        // 4. Seed Buyer
        DB::table('buyer')->insert([
            'User_ID' => 1,
            'Preference' => 'House'
        ]);

        // 5. Seed Renter
        DB::table('renter')->insert([
            'User_ID' => 2,
            'Move_In_Date' => '2025-07-01'
        ]);

        // 6. Seed Owner
        DB::table('owner')->insert([
            'User_ID' => 2,
            'Ownership_Type' => 'Individual'
        ]);

        // 7. Seed Property Categories
        $categories = [
            ['Category_ID' => 1, 'Category_Name' => 'Residential', 'Category_Type' => 'House'],
            ['Category_ID' => 2, 'Category_Name' => 'Commercial', 'Category_Type' => 'Office'],
            ['Category_ID' => 3, 'Category_Name' => 'Residential', 'Category_Type' => 'Apartment'],
            ['Category_ID' => 4, 'Category_Name' => 'Commercial', 'Category_Type' => 'Shop']
        ];
        DB::table('property_category')->insert($categories);

        // 8. Seed Amenities
        $amenities = [
            ['Amenity_ID' => 1, 'Amenity_Name' => 'Swimming Pool', 'Description' => 'Large swimming pool'],
            ['Amenity_ID' => 2, 'Amenity_Name' => 'Gymnasium', 'Description' => 'State-of-the-art gym'],
            ['Amenity_ID' => 3, 'Amenity_Name' => '24/7 Security', 'Description' => 'Guarded gate & CCTV'],
            ['Amenity_ID' => 4, 'Amenity_Name' => 'Backup Generator', 'Description' => 'Uninterrupted power supply']
        ];
        DB::table('amenity')->insert($amenities);

        // 9. Seed Property
        DB::table('property')->insert([
            'Property_ID' => 1,
            'Owner_ID' => 2,
            'Agent_ID' => 3,
            'Category_ID' => 1,
            'Title' => 'Luxury House',
            'Description' => 'Beautiful family house with spacious backyard and luxury fittings.',
            'Location' => 'DHA Phase 6',
            'City' => 'Lahore',
            'State' => 'Punjab',
            'Zip_Code' => '54000',
            'Area_Size' => 2500,
            'Bedrooms' => 4,
            'Bathrooms' => 3,
            'Property_Type' => 'House',
            'Price' => 15000000.00,
            'Availability_Status' => 'Available'
        ]);

        // 10. Seed Property Amenity
        DB::table('property_amenity')->insert([
            'Property_ID' => 1,
            'Amenity_ID' => 1
        ]);

        // 11. Seed Property Image
        DB::table('property_image')->insert([
            'Image_ID' => 1,
            'Property_ID' => 1,
            'Image_Path' => 'properties/dummy1.jpg',
            'Upload_Date' => '2025-06-05',
            'Caption' => 'Front View'
        ]);

        // 12. Seed Payment Scheme
        DB::table('payment_scheme')->insert([
            'Scheme_ID' => 1,
            'Property_ID' => 1,
            'Scheme_Name' => 'Easy Installment',
            'Scheme_Type' => 'Monthly',
            'Advance_Percentage' => 20.00,
            'Installment_Months' => 24,
            'Description' => '24 Month Installment Plan'
        ]);

        // 13. Seed Listing
        DB::table('listing')->insert([
            'Listing_ID' => 1,
            'Property_ID' => 1,
            'Created_By' => 3,
            'Listing_Type' => 'Sale',
            'Price' => 15000000.00,
            'Listing_Date' => '2025-06-10',
            'Expire_Date' => '2025-12-31',
            'Status' => 'Active',
            'Description' => 'Luxury House for Sale',
            'Featured_Flag' => 1,
            'Total_Views' => 100
        ]);

        // 14. Seed Favorite Listing
        DB::table('favorite_listing')->insert([
            'Favorite_ID' => 1,
            'User_ID' => 1,
            'Listing_ID' => 1,
            'Saved_Date' => '2025-06-15'
        ]);

        // 15. Seed Inquiry
        DB::table('inquiry')->insert([
            'Inquiry_ID' => 1,
            'User_ID' => 1,
            'Listing_ID' => 1,
            'Message' => 'Is this property still available?',
            'Inquiry_Date' => '2025-06-15',
            'Inquiry_Status' => 'Open'
        ]);

        // 16. Seed Booking
        DB::table('booking')->insert([
            'Booking_ID' => 1,
            'User_ID' => 1,
            'Property_ID' => 1,
            'Owner_ID' => 2,
            'Agent_ID' => 3,
            'Visit_Date' => '2025-06-20',
            'Visit_Time' => '10:00:00',
            'Booking_Status' => 'Confirmed'
        ]);

        // 17. Seed Payment
        DB::table('payment')->insert([
            'Payment_ID' => 1,
            'User_ID' => 1,
            'Scheme_ID' => 1,
            'Amount' => 500000.00,
            'Payment_Date' => '2025-06-10',
            'Payment_Method' => 'Bank Transfer',
            'Payment_Status' => 'Completed'
        ]);

        // 18. Seed Review
        DB::table('review')->insert([
            'Review_ID' => 1,
            'User_ID' => 1,
            'Booking_ID' => 1,
            'Property_ID' => 1,
            'Agent_ID' => 3,
            'Rating' => 5,
            'Comment' => 'Excellent property and service',
            'Review_Date' => '2025-06-21'
        ]);

        // --- SEED ADDITIONAL DATA ---
        // Let's create another User who is Agent + Owner
        DB::table('user')->insert([
            'User_ID' => 4,
            'Full_Name' => 'Kamran Shah',
            'Email' => 'kamran@gmail.com',
            'Phone_Number' => '03331234567',
            'Identity_Type' => 'CNIC',
            'Identity_Number' => '111222',
            'Password' => Hash::make('123456'),
            'Registration_Date' => '2025-06-04',
            'Status' => 'Active'
        ]);
        DB::table('owner')->insert([
            'User_ID' => 4,
            'Ownership_Type' => 'Company'
        ]);
        DB::table('agent')->insert([
            'User_ID' => 4,
            'Agency_Name' => 'Apex Realty',
            'License_Number' => 'LIC002',
            'Experience_Years' => 8,
            'Rating' => 4.9
        ]);

        // Create properties for Kamran (Owner 4)
        DB::table('property')->insert([
            [
                'Property_ID' => 2,
                'Owner_ID' => 4,
                'Agent_ID' => 4,
                'Category_ID' => 3, // Apartment
                'Title' => 'Modern Apartment in Gulberg',
                'Description' => 'Modern 2-bedroom apartment with skyline view.',
                'Location' => 'Gulberg III',
                'City' => 'Lahore',
                'State' => 'Punjab',
                'Zip_Code' => '54660',
                'Area_Size' => 1200,
                'Bedrooms' => 2,
                'Bathrooms' => 2,
                'Property_Type' => 'Apartment',
                'Price' => 8000000.00,
                'Availability_Status' => 'Available'
            ],
            [
                'Property_ID' => 3,
                'Owner_ID' => 4,
                'Agent_ID' => 3, // Assigned to Ahmed Raza
                'Category_ID' => 2, // Office
                'Title' => 'Premium Corporate Office',
                'Description' => 'Spacious corporate office in commercial hub.',
                'Location' => 'Blue Area',
                'City' => 'Islamabad',
                'State' => 'ICT',
                'Zip_Code' => '44000',
                'Area_Size' => 3500,
                'Bedrooms' => 0,
                'Bathrooms' => 4,
                'Property_Type' => 'Office',
                'Price' => 45000000.00,
                'Availability_Status' => 'Available'
            ],
            [
                'Property_ID' => 4,
                'Owner_ID' => 2, // Sara (Owner)
                'Agent_ID' => 4, // Kamran (Agent)
                'Category_ID' => 3, // Apartment
                'Title' => 'Cozy Studio Apartment',
                'Description' => 'Charming furnished studio apartment near university.',
                'Location' => 'Clifton Block 5',
                'City' => 'Karachi',
                'State' => 'Sindh',
                'Zip_Code' => '75600',
                'Area_Size' => 600,
                'Bedrooms' => 1,
                'Bathrooms' => 1,
                'Property_Type' => 'Apartment',
                'Price' => 35000.00, // Rental price per month
                'Availability_Status' => 'Rented'
            ]
        ]);

        // Seed some amenities for these properties
        DB::table('property_amenity')->insert([
            ['Property_ID' => 2, 'Amenity_ID' => 2],
            ['Property_ID' => 2, 'Amenity_ID' => 3],
            ['Property_ID' => 3, 'Amenity_ID' => 3],
            ['Property_ID' => 3, 'Amenity_ID' => 4],
            ['Property_ID' => 4, 'Amenity_ID' => 3]
        ]);

        // Seed listings
        DB::table('listing')->insert([
            [
                'Listing_ID' => 2,
                'Property_ID' => 2,
                'Created_By' => 4,
                'Listing_Type' => 'Sale',
                'Price' => 8000000.00,
                'Listing_Date' => '2025-06-11',
                'Expire_Date' => '2025-12-31',
                'Status' => 'Active',
                'Description' => 'Beautiful Gulberg apartment for sale.',
                'Featured_Flag' => 1,
                'Total_Views' => 250
            ],
            [
                'Listing_ID' => 3,
                'Property_ID' => 3,
                'Created_By' => 3,
                'Listing_Type' => 'Sale',
                'Price' => 45000000.00,
                'Listing_Date' => '2025-06-12',
                'Expire_Date' => '2025-12-31',
                'Status' => 'Active',
                'Description' => 'Premium commercial space for sale.',
                'Featured_Flag' => 0,
                'Total_Views' => 80
            ],
            [
                'Listing_ID' => 4,
                'Property_ID' => 4,
                'Created_By' => 4,
                'Listing_Type' => 'Rent',
                'Price' => 35000.00,
                'Listing_Date' => '2025-06-12',
                'Expire_Date' => '2025-08-31',
                'Status' => 'Active',
                'Description' => 'Studio apartment for rent.',
                'Featured_Flag' => 0,
                'Total_Views' => 140
            ]
        ]);

        // Seed payment schemes for new properties
        DB::table('payment_scheme')->insert([
            [
                'Scheme_ID' => 2,
                'Property_ID' => 2,
                'Scheme_Name' => 'Standard Installment',
                'Scheme_Type' => 'Quarterly',
                'Advance_Percentage' => 15.00,
                'Installment_Months' => 12,
                'Description' => '1 Year Quarterly Installment Plan'
            ],
            [
                'Scheme_ID' => 3,
                'Property_ID' => 4,
                'Scheme_Name' => 'Rent Contract',
                'Scheme_Type' => 'Monthly',
                'Advance_Percentage' => 100.00, // 1 month deposit
                'Installment_Months' => 1,
                'Description' => 'Monthly Rental Payment'
            ]
        ]);

        // Re-enable foreign key checks
        //DB::statement('PRAGMA foreign_keys = ON;');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
    }
}
