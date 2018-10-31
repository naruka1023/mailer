<?php

namespace App\Http\Controllers;

use App\Process;
use Illuminate\Http\Request;

class processBackend extends Controller
{

    function saveProcess(Request $request){
        $process = new Process();
        $pID = rand(1000, 1999);
        $process->pID = $pID;
        $process->fileName = $request->file;
        $process->basis = $request->frequency . '/' . $request->basis;
        $process->status = 'INACTIVE';
        $process->save();
        return $process;

    }
    function getProcess(Request $request){
        $processList = Process::all();
        return $processList;
    }
}
