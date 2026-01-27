<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Seeder;

use App\Models\Person;
use App\Helpers\RSAHelper;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        [$pub, $priv] = RSAHelper::generateRSAKeys();

        $person = new Person();
        $person->person_id = '1234567890';
        $person->setPin('1234');
        $person->public_key = $pub;
        $person->private_key = encrypt($priv);
        $person->save();
    }
}
