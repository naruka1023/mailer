<?php

use Illuminate\Database\Seeder;
use App\Mail;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mailRepo = App\Mail::all();
        $index = count($mailRepo);
        foreach($mailRepo as $mail){
           if(strpos($mail->name, '.') !== false){
               $mail->name = str_replace('.', ' ', $mail->name);
               $mail->save();
           }
           echo --$index . ' emails remaining' . "\r\n";
        }
    }
}
