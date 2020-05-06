<?php

use Illuminate\Database\Seeder;
<<<<<<< HEAD
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public static $ano_inicio = 2018;

    public function run()
    {
        $tempo_start = Carbon::now();
        $this->command->line('>>>>>>>> INICIO dos Seeds');

        DB::statement("SET foreign_key_checks=0");
        DB::statement("SET unique_checks=0");
        DB::statement("SET autocommit=0");

        $this->call(CategoriasSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ContasSeeder::class);
        $this->call(MovimentosSeeder::class);
        $this->call(DocsSeeder::class);
        $this->call(AutorizacoesSeeder::class);
        $this->call(SoftDeletesSeeder::class);

        DB::statement("SET autocommit=1");
        DB::statement("SET unique_checks=1");
        DB::statement("SET foreign_key_checks=1");

        $this->command->line('>>>>>>>> FIM dos Seeds');
        $total_segundos = Carbon::now()->diffInSeconds($tempo_start);

        $this->command->line('Duração total em segundos: ' . $total_segundos);
=======

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
>>>>>>> 897f2a8ba67d29af4ffa3a24436333656e6d845a
    }
}
