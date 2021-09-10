<?php

namespace Database\Seeders;

use Database\Factories\ContactEmailFactory;
use Database\Factories\ContactFactory;
use Database\Factories\ContactGroupFactory;
use Database\Factories\ContactPhoneFactory;
use Database\Factories\GroupFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

         \App\Models\User::factory(100 )
             ->create()
             ->each( function ( $user ){
                 echo "user created name: ". $user->name . " \n";

                 GroupFactory::$user_id = $user->id;
                 ContactFactory::$user_id = $user->id;

                 $groupCount = rand(2,5);
                 $contactCount = rand( 40,50);

                $groups = \App\Models\Group::factory( $groupCount )->create(  );


                \App\Models\Contact::factory( $contactCount )->create(  )
                    ->each( function( $contact ) use( $groupCount, $groups ){

                        echo "Contact created name: ". $contact->name . " \n";

                        $phoneCount = rand( 2,5 );
                        $emailCount = rand( 2,5 );
                        $contactGroupCount = 1;


                        ContactPhoneFactory::$contact_id = $contact->id;
                        ContactEmailFactory::$contact_id = $contact->id;
                        ContactGroupFactory::$contact_id = $contact->id;

                        $group = $groups[ rand( 0, $groupCount - 1 ) ];

                        ContactGroupFactory::$group_id = $group->id;

                        echo "\n\tPhone Numbers\n";
                        \App\Models\ContactPhone::factory( $phoneCount )->create(  )->each(function($phone){
                            echo "\tPhone: " . $phone->phone_number . "\n";
                        });

                        echo "\n\tEmails\n";
                        \App\Models\ContactEmail::factory( $emailCount )->create(  )->each(function($email){
                            echo "\tEmail: " . $email->email . "\n";
                        });

                        echo "\n\tGroup\n";
                        \App\Models\ContactGroup::factory( $contactGroupCount )->create(  )
                            ->each(function($email) use($group){
                                echo "\tGroup: " . $group->name . "\n\n";
                            });;

                    });
             });



    }
}
