<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Models\LeadStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ProtoneMedia\Splade\SpladeTable;
use ProtoneMedia\Splade\Facades\Toast;
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
                 
                 return redirect()->route('leads.create')->with('phone', $p);
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

        return redirect()->route('leads.index');
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
