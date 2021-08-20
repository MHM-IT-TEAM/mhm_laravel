<?php

namespace App\Http\Controllers\V1\medical\generalist;

use App\Http\Controllers\Controller;
use App\Models\Generalist;
use Illuminate\Http\Request;

class GeneralistController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $process= new Generalist();
        $process->store($request);
    }

    public function show($id)
    {
        return Generalist::with(['consultation'])->find($id);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
