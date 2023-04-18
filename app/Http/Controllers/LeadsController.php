<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\Facades\Toast;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use Symfony\Component\HttpFoundation\Response;

class LeadsController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('phone', 'LIKE', "%{$value}%");
                });
            });
        });

        $leads = QueryBuilder::for(Lead::class)
                            ->where(['user_id'=>$user_id])
                            ->where(['lead_status_id'=>'1'])
                            ->with(['lead_status', 'user'])
                            ->defaultSort('-id')
                            ->allowedSorts('phone', 'lead_status_id', 'created_at')
                            ->allowedFilters($globalSearch)
                            ->paginate()
                            ->withQueryString();

        // $leads = Lead::all();

        return view('agent.leads.index', [
            'leads' => SpladeTable::for($leads)
                ->defaultSort('-id')
                ->withGlobalSearch()
                ->column('phone', sortable: true)
                ->column('description', sortable: true)
                ->column('created_at', 'Date Added', sortable: true)
                ->column('action', canBeHidden: false),
        ]);
    }

    public function create()
    {
        $phone =  session('phone');

        if($phone == '') {
            return redirect('/dashboard');
            // return back();
        }

        return view('agent.leads.create')->with('phone', $phone );
    }

    public function check(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required'
        ]);

        $checkphone = $request->phone;

        $phone = preg_replace("/[^0-9]/", '', $checkphone);
        if (strlen($phone) == 11) $phone = preg_replace("/^1/", '',$phone);

        if (strlen($phone) != 10) {
            Toast::title('Whoops!')
            ->message('You entered an invalid phone number.')
            ->warning()
            ->autoDismiss(3);

            return back();
        }

        $p = $phone;

        $lead = new Lead;
        $lead->phone = $p;

        $record = false;
        $check = false;

        if(!$request->phone == '') {
            try {
                $q = Lead::where('phone', $p) -> first();
                if($q->phone == $p) {
                    $lead = $q;
                    $record = true;
                } else {

                }
            } catch(\Exception $e) {

                $check = true;
                // $lead = Lead::create($request->all());

                // Toast::title('Congrats!')
                //     ->message('New lead added.')
                //     ->autoDismiss(3);

                return redirect()->route('agent.leads.create')->with('phone', $p);
            }
        } else {
            return back();
        }

        Toast::title('Whoops!')
            ->message('Phone number already exists.')
            ->warning()
            ->autoDismiss(3);

        return back();
    }

    public function store(StoreLeadRequest $request)
    {
        $lead = Lead::create($request->all());

        Toast::title('Success!')
            ->message('New lead added.')
            ->autoDismiss(3);

        return redirect()->route('agent.dashboard');
    }

    public function edit(Lead $lead)
    {
        $lead_statuses = LeadStatus::pluck('status', 'id');
    
        $lead->load('user', 'lead_status');

        return view('agent.leads.edit', compact('lead', 'lead_statuses'));
    }

    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        $lead->update($request->all());

        Toast::title('Success!')
            ->message('Lead updated.')
            ->autoDismiss(3);

        return back();
    }

    public function destroy(Lead $lead)
    {

        $lead->delete();

        Toast::title('Success!')
            ->message('Lead deleted.')
            ->warning()
            ->autoDismiss(3);

        return back();
    }

    public function prospects()
    {
        $user_id = auth()->user()->id;

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('phone', 'LIKE', "%{$value}%");
                });
            });
        });

        $leads = QueryBuilder::for(Lead::class)
                            ->where(['user_id'=>$user_id])
                            ->where(['lead_status_id'=>'3'])
                            ->with(['lead_status', 'user'])
                            ->defaultSort('-id')
                            ->allowedSorts('phone', 'lead_status_id', 'updated_at')
                            ->allowedFilters($globalSearch)
                            ->paginate()
                            ->withQueryString();

        return view('agent.leads.index', [
            'leads' => SpladeTable::for($leads)
                ->defaultSort('-id')
                ->withGlobalSearch()
                ->column('phone', sortable: true)
                ->column('description', sortable: true, canBeHidden: false)
                ->column('updated_at', 'Last Updated On', sortable: true)
                ->column('action', canBeHidden: false),
        ]);
    }

    public function all()
    {
        $user_id = auth()->user()->id;

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('phone', 'LIKE', "%{$value}%");
                });
            });
        });

        $leads = QueryBuilder::for(Lead::class)
                            ->where(['user_id'=>$user_id])
                            ->with(['lead_status', 'user'])
                            ->defaultSort('-id')
                            ->allowedSorts('phone', 'lead_status_id', 'created_at')
                            ->allowedFilters('lead_status_id', $globalSearch)
                            ->paginate()
                            ->withQueryString();

        $lead_statuses = LeadStatus::pluck('status', 'id')->toArray();

        return view('agent.leads.index', [
            'leads' => SpladeTable::for($leads)
                ->defaultSort('-id')
                ->withGlobalSearch()
                ->column('phone', sortable: true)
                ->column('description', sortable: true, canBeHidden: false)
                ->column('lead_status_id', 'Lead Status')
                ->selectFilter('lead_status_id', $lead_statuses)
                ->column('action', canBeHidden: false),
        ]);
    }

    public function recent()
    {
        $user_id = auth()->user()->id;

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('phone', 'LIKE', "%{$value}%");
                });
            });
        });

        $leads = QueryBuilder::for(Lead::class)
                            ->where(['user_id'=>$user_id])
                            ->where('created_at', '>=', today()) // filters leads added within the last 7 days
                            ->with(['lead_status', 'user'])
                            ->defaultSort('-id')
                            ->allowedSorts('phone', 'lead_status_id', 'created_at')
                            ->allowedFilters('lead_status_id', $globalSearch)
                            ->paginate()
                            ->withQueryString();

        $lead_statuses = LeadStatus::pluck('status', 'id')->toArray();
        return view('agent.leads.index', [
            'leads' => SpladeTable::for($leads)
                ->defaultSort('-id')
                ->withGlobalSearch()
                ->column('phone', sortable: true)
                ->column('description', sortable: true, canBeHidden: false)
                ->column('lead_status_id', 'Lead Status')
                ->selectFilter('lead_status_id', $lead_statuses)
                ->column('created_at', 'Date Added', sortable: true)
                ->column('action', canBeHidden: false),
        ]);
    }

    public function team()
    {
        $user = auth()->user();

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('phone', 'LIKE', "%{$value}%");
                });
            });
        });

        $leads = QueryBuilder::for(Lead::class)
                            ->whereHas('user', function ($query) use ($user) {
                                $query->whereIn('id', $user->teams()->with('users')->get()->pluck('users.*.id')->flatten());
                            })
                            ->where(['lead_status_id'=>'3'])
                            ->with('lead_status:id,status', 'user:id,name')
                            ->defaultSort('-id')
                            ->allowedSorts('phone', 'updated_at')
                            ->allowedFilters([
                                $globalSearch,
                                AllowedFilter::exact('user_id'), // <-- Add this line
                            ])
                            ->paginate()
                            ->withQueryString();

        $team = auth()->user()->teams()->first(); // get the team of the logged-in user
        $user_names = $team->users()->pluck('name', 'id')->toArray(); // get the users of the team
        return view('agent.leads.index', [
            'leads' => SpladeTable::for($leads)
                ->defaultSort('-updated_at')
                ->withGlobalSearch()
                ->column('phone', sortable: true)
                ->column('description')
                ->column('user_id', 'Agent')
                ->selectFilter('user_id', $user_names)
                ->column('updated_at', 'Last Updated On', sortable: true)
                ->column('action', canBeHidden: false),
        ]);
    }
}
