<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $groups = Group::where([ 'user_id' => $request->user()->id ])->get([ 'name','id' ]);

        return  response(['groups' => $groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $fields = $request->validate([
            'name' => 'required|string|unique:groups,name',
        ]);

        $group = new Group( );

        $group->name = $fields['name'];
        $group->user_id = $request->user()->id;

        if( $group->save() ) {
            return response([
                'group' => $group,
                'success' => true,
                'message' => 'Group Created successfully'
            ], 201);
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

        $group = Group::where(([ 'user_id' => $request->user()->id ]))->find( $id );

//        return $request->input();

        $fields = $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('groups','name' )
                    ->ignore( $group->name,'name')
            ],
        ]);


        $group->name = $fields['name'];

        if( $group->save() ) {
            return response([
                'group' => $group,
                'success' => true,
                'message' => 'Group Updated successfully'
            ], 200);
        }

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

        $group = Group::where( 'user_id', request( )->user()->id )->find( $id );

        if( $group ) {
            $group->delete( );
            return response([
                'success' => true,
                'message' => 'Group deleted successfully'
            ], 200);
        }

    }
}
