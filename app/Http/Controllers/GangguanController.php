<?php

namespace App\Http\Controllers;

use App\Models\Gangguan;
use App\Models\Trainset;
use App\Models\Jadwal;
use App\Models\Proyek;
use App\Models\Task;
use Illuminate\Http\Request;

class GangguanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $q = $request->q;
        $items = Gangguan::where('nama_tempat', 'LIKE', "%$q%")
            ->paginate(10);

        // $cars = Trainset::all();
        $proyeks = Jadwal::all();
        $tempats = Proyek::all();
        // $tasks = Task::all();

        // $details = Detailservice::where('id_service', $request->id)->get();

        return view('gangguan.index', compact('items','proyeks', 'tempats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
