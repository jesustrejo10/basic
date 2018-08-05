<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VenezuelanBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('venezuelan_banks')->truncate();
        
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO MERCANTIL C.A.',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANESCO BANCO UNIVERSAL',]);
        DB::table('venezuelan_banks')->insert(['name'=> '100%BANCO',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'ABN AMRO BANK',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCAMIGA BANCO MICROFINANCIERO, C.A.',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO ACTIVO BANCO COMERCIAL, C.A.',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO AGRICOLA',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO BICENTENARIO',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO CARONI, C.A. BANCO UNIVERSAL',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO DE DESARROLLO DEL MICROEMPRESARIO',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO DE VENEZUELA S.A.I.C.A.',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO DEL CARIBE C.A.',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO DEL PUEBLO SOBERANO C.A.',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO DEL TESORO',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO ESPIRITO SANTO, S.A.',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO EXTERIOR C.A.',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO INDUSTRIAL DE VENEZUELA.',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO INTERNACIONAL DE DESARROLLO, C.A.',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO NACIONAL DE CREDITO',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO OCCIDENTAL DE DESCUENTO.',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO PLAZA',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO PROVINCIAL BBVA',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCO VENEZOLANO DE CREDITO S.A.',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANCRECER S.A. BANCO DE DESARROLLO',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANFANB',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANGENTE',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'BANPLUS BANCO COMERCIAL C.A',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'CITIBANK.',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'CORP BANCA.',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'DELSUR BANCO UNIVERSAL',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'FONDO COMUN',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'INSTITUTO MUNICIPAL DE CR&#201;DITO POPULAR',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'MIBANCO BANCO DE DESARROLLO, C.A.',]);
        DB::table('venezuelan_banks')->insert(['name'=> 'SOFITASA',]);    }
}
