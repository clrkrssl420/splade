<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\Facades\Toast;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Symfony\Component\HttpFoundation\Response;

class PermissionsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('permission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $permissions = QueryBuilder::for(Permission::class)
                            ->defaultSort('id')
                            ->allowedSorts('id', 'title')
                            ->paginate()
                            ->withQueryString();

        // $leads = Lead::all();

        return view('admin.permissions.index', [
            'permissions' => SpladeTable::for($permissions)
                ->defaultSort('id')
                ->column('id', sortable: true)
                ->column('title', sortable: true, canBeHidden: false)
                ->column('action', canBeHidden: false),
        ]);
    }

    public function create()
    {
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create($request->all());

        Toast::title('New Permission Created!')
            ->autoDismiss(3);

        return redirect()->route('admin.permissions.index');
    }

    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('permission_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->all());

        Toast::title('Permission Updated!')
            ->autoDismiss(3);

        return back();
    }

    public function show(Permission $permission)
    {
        abort_if(Gate::denies('permission_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.show', compact('permission'));
    }

    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission->delete();

        Toast::title('Permission Removed!')
            ->danger()
            ->autoDismiss(3);

        return back();
    }
}
