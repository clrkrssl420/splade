<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::with(['team_leader', 'members'])->get();

        return view('admin.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $team_leaders = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $members = User::pluck('name', 'id');

        return view('admin.teams.create', compact('members', 'team_leaders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamRequest $request)
    {
        $team = Team::create($request->all());
        $team->members()->sync($request->input('members', []));

        return redirect()->route('admin.teams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        $team->load('team_leader', 'members', 'teamSales');

        return view('admin.teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        $team_leaders = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $members = User::pluck('name', 'id');

        $team->load('team_leader', 'members');

        return view('admin.teams.edit', compact('members', 'team', 'team_leaders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $team->update($request->all());
        $team->members()->sync($request->input('members', []));

        return redirect()->route('admin.teams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $team->delete();

        return back();
    }
}
