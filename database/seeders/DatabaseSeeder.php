<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'pozicija_tipId' => 1,
                'lokacijaId' => 1,
                'lokacijaId' => 1,
                'name' => 'ivan',
                'email' => 'bangledez@yahoo.com',
                'password' => Hash::make('aaaaaaaa'),
            ],
            [
                'pozicija_tipId' => 1,
                'lokacijaId' => 1,
                'lokacijaId' => 1,
                'name' => 'Role',
                'email' => 'role@iznadsrbije.rs',
                'password' => Hash::make('aaaaaaaa'),
            ],
        
        ]);
    
        DB::table('korisnik_radni_statuses')->insert([
            ['korisnikId' => 1,'radni_statusId' => 1],
            ['korisnikId' => 2,'radni_statusId' => 2],
        ]);
    
        DB::table('pozicija_tips')->insert([
            ['naziv' => 'admin'],
            ['naziv' => 'Šef servisa'],
            ['naziv' => 'Serviser'],
            ['naziv' => 'Prodavac'],
        ]);
    
        DB::table('radni_status_tips')->insert([
            ['rs_naziv' => 'Radi'],
            ['rs_naziv' => 'Odmor'],
            ['rs_naziv' => 'Bolovanje'],
            ['rs_naziv' => 'Slobodan dan'],
        ]);
    
        DB::table('stranicas')->insert([
            ['naziv' => 'Početna', 'route_name' => 'dashboard', 'menu_order' => 1],
            ['naziv' => 'Korisnici', 'route_name' => 'users', 'menu_order' => 2],
            ['naziv' => 'Pozicija - stranica', 'route_name' => 'user-permissions', 'menu_order' => 3],
            ['naziv' => 'Test', 'route_name' => 'pages', 'menu_order' => 4],
        ]);
    
        DB::table('pozicija_prikaz_stranicas')->insert([
            ['pozicija_tipId' => 1, 'stranicaId' => 1],
            ['pozicija_tipId' => 1, 'stranicaId' => 2],
            ['pozicija_tipId' => 1, 'stranicaId' => 3],
            ['pozicija_tipId' => 1, 'stranicaId' => 4],
            ['pozicija_tipId' => 2, 'stranicaId' => 1],
            ['pozicija_tipId' => 2, 'stranicaId' => 2],
        ]);
    }
}
