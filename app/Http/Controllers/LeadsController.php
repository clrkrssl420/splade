<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LeadStatus;
use ProtoneMedia\Splade\SpladeTable;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use Symfony\Component\HttpFoundation\Response;

class LeadsController extends Controller
{
    public function index()
    {
        
        $user_id = auth()->user()->id;

        $leads = Lead::where(['user_id'=>$user_id])
                     ->with(['lead_status', 'user'])
                     ->paginate();

        // $leads = Lead::all();



        return view('leads.index', [
            'leads' => SpladeTable::for($leads)
                ->column('id')
                ->column('phone')
                ->column('description')
                ->column('lead_status_id', 'Status'),
        ]);
    }

    public function create()
    {

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $lead_statuses = LeadStatus::pluck('status', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('leads.create', compact('lead_statuses', 'users'));
    }

    public function store(StoreLeadRequest $request)
    {
        $lead = Lead::create($request->all());

        return redirect()->route('admin.leads.index');
    }

    public function edit(Lead $lead)
    {

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        // $lead_statuses = LeadStatus::pluck('status', 'id')->prepend(trans('global.pleaseSelect'), '');

        $lead->load('user', 'lead_status');

        return view('admin.leads.edit', compact('lead', 'lead_statuses', 'users'));
    }

    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        $lead->update($request->all());

        return redirect()->route('admin.leads.index');
    }

    public function destroy(Lead $lead)
    {

        $lead->delete();

        return back();
    }
}
