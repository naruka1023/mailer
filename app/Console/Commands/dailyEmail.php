<?php

namespace App\Console\Commands;
use App\Process;
use App\MailCl;

use Illuminate\Console\Command;

class dailyEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails to potential clientele daily';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $processArray = Process::all();
        foreach($processArray as $process){
            if($process->basis == 'day' && $process->status == "ACTIVE"){
                $mail = MailCl::findOrFail(4234);
                Mail::raw($process->fileName, function ($message){
                    $message->from('p.muangsaen@gmail.com');
                    $message->to($mail->email)->subject('Lessons from Tony');
                });
                // foreach($mailArray as $mail){
                //     //send Mail 
                // }
            }
        }
    }
}
