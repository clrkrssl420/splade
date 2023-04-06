<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\Facades\Toast;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use Symfony\Component\HttpFoundation\Response;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('team_name', 'LIKE', "%{$value}%");
                });
            });
        });

        $teams = QueryBuilder::for(Team::class)
                            ->with('team_leader', 'users')
                            ->defaultSort('id')
                            ->allowedSorts('id', 'name')
                            ->allowedFilters($globalSearch)
                            ->paginate()
                            ->withQueryString();

        return view('admin.teams.index', [
            'teams' => SpladeTable::for($teams)
                ->defaultSort('id')
                ->withGlobalSearch()
                ->column('team_name', sortable: true, canBeHidden: false)
                ->column('team_leader_id', 'Team Leader', canBeHidden: false)
                ->column('users', 'Members', canBeHidden: false)
                ->column('action', canBeHidden: false),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $team_leaders = User::pluck('name', 'id')->toArray();
        $users = User::pluck('name', 'id')->toArray();

        return view('admin.teams.create', compact('users', 'team_leaders'));
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

        $teamLeaderId = $request->input('team_leader_id');
        $team->users()->attach($teamLeaderId);
        $team->users()->syncWithoutDetaching($request->input('users', []));

        Toast::title('Success!')
            ->message('New team added.')
            ->autoDismiss(3);
            
        return redirect()->route('admin.teams.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        $team_leaders = User::pluck('name', 'id')->toArray();
        $users = User::pluck('name', 'id')->toArray();

        $team->load('team_leader', 'users');

        return view('admin.teams.edit', compact('users', 'team', 'team_leaders'));
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
        $team->users()->sync($request->input('users', []));

        Toast::title('Success!')
            ->message('Team updated successfully.')
            ->autoDismiss(3);

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

        Toast::title('Success!')
            ->message('Team deleted.')
            ->warning()
            ->autoDismiss(3);

        return back();
    }
}
