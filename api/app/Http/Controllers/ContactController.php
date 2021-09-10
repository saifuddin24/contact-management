<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactEmail;
use App\Models\ContactGroup;
use App\Models\ContactPhone;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function index( Request $request )
    {
        //

        $contact_list = Contact::query( )
            ->with('phone_numbers', 'emails', 'groups')
            ->where('user_id' , $request->user()->id )
            ->groupByRaw('id DESC' )
            ->get();
        return response([ 'contacts' =>  $contact_list ] , 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request )
    {
        //

        $fields = $request->validate([
            'name'      => 'required|string',
            'emails'      => 'required|array',
            'phones'     => 'required|array',
            'groups'     => 'required|array',
        ]);

        $contact = new Contact( );
        $contact->name = $fields['name'] ?? '';
        $contact->user_id = $request->user()->id;

        if( $contact->save() ) {
            $this->updateContactDetails( $contact, $fields );

            return response([
                'contact' => $contact,
                'message' => 'Contact successfully created!',
                'success' => true,
            ], 201);
        }

    }


    protected function updateContactDetails( Contact $contact, $fields){

        $contact_id = $contact->id;

        if( $contact_id ) {

            if( is_array( $fields['phones'] ) ) {
                $phones = [];
                foreach ($fields['phones'] as $phone ) {
                    $phones[] = [
                        'contact_id' => $contact_id,
                        'phone_number' => $phone
                    ];
                }
                ContactPhone::insert( $phones );
            }

            if( is_array( $fields['emails'] ) ) {
                $emails = [];
                foreach ($fields['emails'] as $email ) {
                    $emails[] = [
                        'contact_id' => $contact_id,
                        'email' => $email
                    ];
                }
                ContactEmail::insert( $emails );
            }

            if( is_array( $fields['groups'] ) ) {
                $groups = [];
                foreach ($fields['groups'] as $group_id ) {
                    $groups[] = [
                        'contact_id' => $contact_id,
                        'group_id' => $group_id
                    ];
                }
                ContactGroup::insert( $groups );
            }
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $contact = Contact::where('user_id', request()->user()->id)->find($id);
        if( $contact ) {
            $contact->id;

            ContactPhone::where( 'contact_id', $contact->id )->delete();
            ContactEmail::where( 'contact_id', $contact->id )->delete();
            ContactGroup::where( 'contact_id', $contact->id )->delete();

            $contact->delete();

            return response(['message' => 'Deleted', 'success' => true], 200);
        }

        return response(['message' => 'Not deleted', 'success' => false], 400 );
    }
}
