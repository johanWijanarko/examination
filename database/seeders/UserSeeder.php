<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/users.json');
        $json = json_decode($json, true);
        
        foreach ($json as $key => $j) {

            User::create([
                'id' =>$j['id'],
                'name' =>$j['name'],
                'email' =>$j['email'],
                'password' =>bcrypt('123456'),
                'user_internal_id' => $j['user_internal_id'],
                'user_eksternal_id' =>$j['user_eksternal_id'],
                'login_as' =>$j['login_as'],
                'session_id' =>$j['session_id'],
                'user_foto' =>$j['user_foto']
            ]);
        }
    }
}
