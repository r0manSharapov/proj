<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public static $users = [];

    private $photoPath = 'public/fotos';
    private $files_M = [];
    private $files_F = [];
    // date em que user é criado.
    // Vamos acrescentanto users de forma aleatória e ao longo do tempo
    private $date;
    private $hash;

    public function run()
    {
        $this->command->line('--- > Criar Users');
        DB::table('users')->truncate();

        $this->command->line('Fotos vão ser armazenados na pasta ' . storage_path('app/' . $this->photoPath));

        // Apaga as fotos antigas
        try {
            Storage::deleteDirectory($this->photoPath);
        } catch (Exception $e) { // Por vezes só apaga à segunda tentativa
            Storage::deleteDirectory($this->photoPath);
        } finally {
            Storage::makeDirectory($this->photoPath);
        }


        // Preencher files_M com fotos de Homens e files_F com fotos de mulheres
        $allFiles = collect(File::files(database_path('seeds/fotos')));
        foreach ($allFiles as $f) {
            if (strpos($f->getPathname(), 'M_')) {
                $this->files_M[] = $f->getPathname();
            } else {
                $this->files_F[] = $f->getPathname();
            }
        }

        $this->hash = Hash::make('123');

        $faker = \Faker\Factory::create('pt_PT');

        // ALTERAR SE NECESSÀRIO
        $this->date = Carbon::create(DatabaseSeeder::$ano_inicio, 1, 1);
        $hoje = Carbon::now();
        $i = 1;
        while ($this->date < $hoje) {
            $totalUsersDia = rand(0, 3);
            for ($j = 0; $j < $totalUsersDia; $j++) {
                $array = $this->createUserArray($faker);
                if ($i <= 6) {
                    if ($i == 1) {
                        $array["email"] = "adm@mail.pt";
                        $array["adm"] = 1;
                    } else {
                        $array["email"] = "u" . $i . "@mail.pt";
                    }
                } else {
                    $array["adm"] = rand(1, 50) == 2 ? true : false;
                    $array["bloqueado"] = rand(1, 20) == 2 ? true : false;
                }

                $gender = $array["gender"];
                unset($array["gender"]);
                $id = DB::table('users')->insertGetId($array);
                $array["data"] = $this->date;
                $array["gender"] = $gender;
                $array["id"] = $id;
                UsersSeeder::$users[$id] = $array;
                if ($i % 100 == 0) {
                    $this->command->line('Criado User nº ' . $i . ', na data ' . $this->date->toDateString());
                }
                $i++;
            }
            $this->date->addDay();
        }
        $total = $i - 1;

        $i = 1;
        foreach (UsersSeeder::$users as $arrayUser) {
            if ($arrayUser["id"] < 10) {
                $this->addFoto($arrayUser);
            } else
            if (rand(1, 3) == 2) {
                $this->addFoto($arrayUser);
            }
            if ($i % 100 == 0) {
                $this->command->line('Criada foto do User nº ' . $i . '/' . $total);
            }
            $i++;
        }
    }

    private function addFoto($arrayUser)
    {
        if ($arrayUser["gender"] == 'male') {
            $file = $this->files_M[array_rand($this->files_M)];
        } else {
            $file = $this->files_F[array_rand($this->files_F)];
        }
        $targetDir = storage_path('app/' . $this->photoPath);
        $newfilename = $arrayUser['id'] . "_" . uniqid() . '.jpg';
        File::copy($file, $targetDir . '/' . $newfilename);
        $arrayUser["foto"] = $newfilename;
        DB::table('users')->where('id',  $arrayUser['id'])->update(['foto' => $newfilename]);
    }

    private $used_emails = [];
    private function createUserArray($faker)
    {
        $created_at = $this->date->copy()->addSeconds(rand(0, 86399));  // 1 dia tem 24*60*60 segundos (86400 segundos)
        $email_verified_at = $created_at->copy()->addSeconds(rand(30, 999999));
        $updated_at = Carbon::now()->subSeconds(rand(30, 5000000));

        //nas data mais recentes iria dar erro:
        //$updated_at = $faker->dateTimeBetween($email_verified_at, 'now');
        // Em vez disso, optei por garantir que não dá erro,
        // mas ignorei a ordem das datas - pode ser updated and de created!!

        $gender = $faker->randomElement(['male', 'female']);
        $firstname = $faker->firstName($gender);
        $lastname = $faker->lastName();
        $secondname = $faker->numberBetween(1, 3) == 2 ? "" : " " . $faker->firstName($gender);
        $number_middlenames = $faker->numberBetween(1, 6);
        $number_middlenames = $number_middlenames == 1 ? 0 : ($number_middlenames >= 5 ? $number_middlenames - 3 : 1);
        $middlenames = "";
        for ($i = 0; $i < $number_middlenames; $i++) {
            $middlenames .= " " . $faker->lastName();
        }
        $fullname = $firstname . $secondname . $middlenames . " " . $lastname;

        $email = strtolower($this->stripAccents($firstname) . "." . $this->stripAccents($lastname) . "@mail.pt");
        $i = 2;
        while (in_array($email, $this->used_emails)) {
            $email = strtolower($this->stripAccents($firstname) . "." . $this->stripAccents($lastname) . "." . $i . "@mail.pt");
            $i++;
        }
        $this->used_emails[] = $email;

        return [
            "name" => $fullname,
            "email" => $email,
            "password" => $this->hash, // Deveria ser Hash::make('123'), mas só se fez 1 hash para melhor desempenho
            "remember_token" => null,
            "adm" => false,
            "bloqueado" => false,
            "NIF" => $faker->randomNumber($nbDigits = 9, $strict = true),
            "telefone" => $faker->phoneNumber,
            "foto" => null,
            "created_at" => $created_at->toDateTimeString(),
            "updated_at" => $updated_at->toDateTimeString(),
            "email_verified_at" => $email_verified_at->toDateTimeString(),
            "gender" => $gender,
        ];
    }

    private function stripAccents($stripAccents)
    {
        $from = 'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ';
        $to =   'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY';
        $keys = array();
        $values = array();
        preg_match_all('/./u', $from, $keys);
        preg_match_all('/./u', $to, $values);
        $mapping = array_combine($keys[0], $values[0]);
        return strtr($stripAccents, $mapping);
    }
}
