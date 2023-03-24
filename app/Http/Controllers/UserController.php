<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ItemsExport;
use App\Imports\ItemsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::get();

        return view('users', compact('users'));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return Excel::download(new ItemsExport, 'users.xlsx');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import()
    {
        Excel::import(new ItemsImport,request()->file('file'));

        return back();
    }
}
