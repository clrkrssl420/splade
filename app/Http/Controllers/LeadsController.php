<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
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
        // $leads = Lead::where(['user_id'=>$user_id])
        //              ->with(['lead_status', 'user'])
        //              ->paginate();

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

        Toast::title('Success, new lead added!')
            ->autoDismiss(3);

        return redirect()->route('dashboard');
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

        Toast::title('Lead updated successfully!')
            ->autoDismiss(3);

        return back();
    }

    public function destroy(Lead $lead)
    {

        $lead->delete();

        Toast::title('Lead successfully deleted!')
        ->danger()
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
                ->column('description', sortable: true, canBeHidden: false)
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
                            ->allowedFilters($globalSearch)
                            ->paginate()
                            ->withQueryString();

        // $leads = Lead::all();

        return view('agent.leads.index', [
            'leads' => SpladeTable::for($leads)
                ->defaultSort('-id')
                ->withGlobalSearch()
                ->column('phone', sortable: true)
                ->column('description', sortable: true, canBeHidden: false)
                ->column('lead_status_id', 'Lead Status')
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
                            ->where('created_at', '>=', now()->subDays(7)) // filters leads added within the last 7 days
                            ->with(['lead_status', 'user'])
                            ->defaultSort('-id')
                            ->allowedSorts('phone', 'lead_status_id', 'created_at')
                            ->allowedFilters($globalSearch)
                            ->paginate()
                            ->withQueryString();

        return view('agent.dashboard', [
            'leads' => SpladeTable::for($leads)
                ->defaultSort('-id')
                ->withGlobalSearch()
                ->column('phone', sortable: true)
                ->column('description', sortable: true, canBeHidden: false)
                ->column('lead_status_id', 'Lead Status')
                ->column('created_at', 'Date Added', sortable: true)
                ->column('action', canBeHidden: false),
        ]);
    }
}
