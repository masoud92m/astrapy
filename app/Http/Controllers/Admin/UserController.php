<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::orderByDesc('id');
        if ($request->id) {
            $query->where('id', $request->id);
        }
        if ($request->name) {
            $query->where('name', 'like', str_replace(' ', '%', ' ' . $request->name . ' '));
        }
        if ($request->mobile) {
            $query->where('mobile', 'like', str_replace(' ', '%', ' ' . $request->mobile . ' '));
        }
        $items = $query->paginate(30);
        return view('admin.users.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'mobile' => strtolower(fa2en($request->get('mobile'))),
            'age' => fa2en($request->get('age')),
        ]);
        $request->validate([
            'mobile' => ['required'],
            'name' => 'required',
            'age' => 'required',
            'password' => ['nullable', 'confirmed'],
            'password_confirmation' => ['required_with:password'],
        ]);

        $data = $request->only(['name', 'age']);

        if ($request->subscription_started_at) {
            $data['subscription_started_at'] = Verta::parseFormat('Y/m/d', $request->subscription_started_at)->toCarbon();
        }

        if ($request->subscription_expires_at) {
            $data['subscription_expires_at'] = Verta::parseFormat('Y/m/d', $request->subscription_expires_at)->toCarbon();
        }

        $data['is_admin'] = $request->has('is_admin');
        $data['mobile'] = $request->get('mobile');

        if($request->has('password') && $request->password){
            $data['password'] = Hash::make($request->get('password'));
        }

        $item = User::where('mobile', $request->mobile)->first();
        if ($item) {
            Log::create([
                'causer_id' => Auth::id(),
                'item_id' => $item->id,
                'section' => 'user',
                'action' => 'update',
                'old_data' => json_encode($item),
                'new_data' => json_encode($data),
            ]);
            $item->update($data);
        } else {
            $item = User::create($data);
            Log::create([
                'causer_id' => Auth::id(),
                'item_id' => $item->id,
                'section' => 'user',
                'action' => 'create',
                'new_data' => json_encode($item),
            ]);
        }
        $item->podcasts()->sync($request->get('podcasts'));
        return redirect()->route('users.index', ['mobile' => $item->mobile]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = User::with('podcasts')->findOrFail($id);
        $item->subscription_started_at = $item->subscription_started_at
            ? Verta::instance($item->subscription_started_at)->format('Y/m/d')
            : null;

        $item->subscription_expires_at = $item->subscription_expires_at
            ? Verta::instance($item->subscription_expires_at)->format('Y/m/d')
            : null;

        return view('admin.users.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->merge([
            'age' => fa2en($request->get('age')),
        ]);
        $request->validate([
            'mobile' => ['required'],
            'name' => 'required',
            'age' => 'required',
            'password' => ['nullable', 'confirmed'],
            'password_confirmation' => ['required_with:password'],
        ]);

        $data = $request->only(['name', 'age', 'mobile']);

        $data['subscription_started_at'] = null;
        $data['subscription_expires_at'] = null;

        if ($request->subscription_started_at) {
            $data['subscription_started_at'] = Verta::parseFormat('Y/m/d', $request->subscription_started_at)->toCarbon();
        }

        if ($request->subscription_expires_at) {
            $data['subscription_expires_at'] = Verta::parseFormat('Y/m/d', $request->subscription_expires_at)->toCarbon();
        }

        if($request->has('password') && $request->password){
            $data['password'] = Hash::make($request->get('password'));
        }

        $data['is_admin'] = $request->has('is_admin');

        $item = User::find($id);
        Log::create([
            'causer_id' => Auth::id(),
            'item_id' => $item->id,
            'section' => 'user',
            'action' => 'update',
            'old_data' => json_encode($item),
            'new_data' => json_encode($data),
        ]);
        $item->update($data);
        $item->podcasts()->sync($request->get('podcasts'));
        return redirect()->route('users.index', ['mobile' => $item->mobile]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
