<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\Facades\Toast;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Requests\MassDestroyRoleRequest;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{
    public function index()
    {
        $roles = QueryBuilder::for(Role::class)
                            ->with('permissions')
                            ->defaultSort('id')
                            ->allowedSorts('id', 'title')
                            ->paginate()
                            ->withQueryString();

        return view('admin.roles.index', [
            'roles' => SpladeTable::for($roles)
                ->defaultSort('id')
                ->column('id', sortable: true)
                ->column('title', sortable: true, canBeHidden: false)
                ->column('permissions')
                ->column('action', canBeHidden: false),
        ]);
    }

    public function create()
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::pluck('title', 'id')->toArray();

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        Toast::title('New Role Added!')
            ->autoDismiss(3);

        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role)
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::pluck('title', 'id')->toArray();

        $role->load('permissions');

        return view('admin.roles.edit', compact('permissions', 'role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        Toast::title('Role Successfully Updated!')
            ->autoDismiss(3);

        return back();
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role->delete();

        Toast::title('Role Deleted!')
            ->danger()
            ->autoDismiss(3);

        return back();
    }
}
