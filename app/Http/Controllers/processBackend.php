<?php

namespace App\Http\Controllers;

use App\Process;
use Illuminate\Http\Request;

class processBackend extends Controller
{

    function deleteProcess($id){
        $processToDelete = Process::findOrFail($id);
        $processToDelete->delete();
        $allProcess = Process::all();
        return $allProcess;
    }
    function updateStatus($id){
        $process = Process::findOrFail($id);
        if($process->status == 'INACTIVE'){
            $process->status = 'ACTIVE';
        }else{
            $process->status = 'INACTIVE';
        }
        $process->save();
        return $process;
    }
    function saveProcess(Request $request){
        $process = new Process();
        $process->fileName = $request->file;
        $process->basis = $request->basis;
        $process->status = 'INACTIVE';
        $pID = rand(1000, 1999);
        
        sleep(1);

        $process->pID = $pID;
        $process->save();
        return $process;

    }
    function getProcess(Request $request){
        $processList = Process::all();
        return $processList;
    }
}
