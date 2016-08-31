<?php

use Illuminate\Database\Seeder;

class TblIncSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$now = Carbon\Carbon::now();
        App\Models\TblInc::insert([
            [
            	'inc' => '03555',
            	'item_name' => 'WRENCH,BOX',
            	'short_name' => 'WRENCH,BOX',
            	'sap_code' => '03555',
            	'sap_char_id' => '03555',
            	'eng_definition' => 'A NONADJUSTABLE WRENCH HAVING A BOX WRENCHING FEATURE ON ONE OR BOTH ENDS. EXCLUDES WRENCH, OPEN END BOX; AND WRENCH, BOX AND OPEN END, COMBINATION.',
            	'ind_definition' => 'KUNCI PAS NONADJUSTABLE MEMILIKI FITUR BOKS PADA SATU ATAU KEDUA UJUNGNYA. KECUALI WRENCH, BOX OPEN END; DAN WRENCH, BOX DAN TERBUKA END, KOMBINASI.',
            	'created_by' => 2,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
            	'inc' => '03768',
            	'item_name' => 'ELBOW,PIPE',
            	'short_name' => 'ELBOW',
            	'sap_code' => '03768',
            	'sap_char_id' => '03768',
            	'eng_definition' => 'A FITTING THAT FORMS AN ANGLE OF LESS THAN 180 DEGREES (3.141 RADIANS) FROM THE STRAIGHT FLOW. BOTH CONNECTING ENDS HAVE STANDARD PIPE THREADS OR ARE UNTHREADED AND DESIGNED TO ACCOMMODATE A PIPE. IT MAY HAVE SIDE OR HEEL INLET(S). SEE ALSO ELBOW, TUBE; AND CONNECTOR, MULTIPLE, FLUID PRESSURE LINE. EXCLUDES BEND, SOIL PIPE. FOR ITEMS HAVING A TYPICAL RADIUS OF 3 TIMES THE NOMINAL PIPE DIAMETER SEE BEND, PIPE.',
            	'ind_definition' => 'SAMBUNGAN PIPA YANG MEMBENTUK SUDUT KURANG DARI 180 DERAJAT (3,141 RADIAN) DARI ALIRAN LURUS. KEDUA UJUNG MEMILIKI ATAU TIDAK MEMILIKI ULIR STANDAR DAN DIRANCANG UNTUK MENGAKOMODASI PIPA. SISI PADA PERMUKAAN UJUNG BISA DATAR ATAU MIRING. LIHAT JUGA ELBOW, TUBE; DAN CONNECTOR, MULTIPLE, FLUID PRESSURE LINE. KECUALI BEND, SOIL PIPE. UNTUK ITEM MEMILIKI JARI-JARI KHAS 3 KALI LEBIH BESAR DARI DIAMETER  NOMINAL PIPA LIHAT BEND, PIPE.',
            	'created_by' => 2,
            	'last_updated_by' => 2,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
                'inc' => '00014',
                'item_name' => 'BEARING,BALL,ANNULAR',
                'short_name' => 'BEARING,BALL',
                'sap_code' => '00014',
                'sap_char_id' => '00014',
                'eng_definition' => 'A CYLINDRICAL DEVICE IN WHICH THE INNER OR OUTER RING TURNS UPON A SINGLE OR DOUBLE ROW OF HARDENED BALLS WHICH ROLL EASILY BETWEEN THE TWO RINGS, THUS MINIMIZING FRICTION. FOR ITEM WITH FACES SPECIALLY GROUND FOR DUPLEX MOUNTING SEE BEARING, BALL, DUPLEX. EXCLUDES BEARING, BALL, AIRFRAME.',
                'ind_definition' => 'SEBUAH ALAT BERBENTUK BUNDAR YANG MEMILIKI RING DALAM ATAU RING LUAR YANG MENEMPEL PADA SATU ATAU DUA LAJUR BANTALAN BOLA-BOLA YANG KERAS YANG BERPUTAR DENGAN MUDAH ANTARA DUA RING, SEHINGGA MENGURANGI GESEKAN.',
                'created_by' => 4,
                'last_updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'inc' => 'F0220',
                'item_name' => 'END HOUSING,MECHANICAL ROTATING EQUIP',
                'short_name' => 'END HOUSING',
                'sap_code' => 'F0220',
                'sap_char_id' => 'F0220',
                'eng_definition' => 'AN ITEM DESIGNED TO SUPPORT AND POSITION A SHAFT OR ROTOR WHEN INSTALLED IN A PUMP, COMPRESSOR, OR SIMILAR MECHANICAL ROTATING EQUIPMENT. IT MAY INCLUDE BEARINGS, BUSHES, OILERS OR SEALS.',
                'ind_definition' => '',
                'created_by' => 4,
                'last_updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'inc' => '01010',
                'item_name' => 'INC BARUUUU',
                'short_name' => 'EMMM APA YA',
                'sap_code' => '01010',
                'sap_char_id' => '01010',
                'eng_definition' => 'AN ITEM DESIGNED TO SUPPORT AND POSITION A SHAFT OR ROTOR WHEN INSTALLED IN A PUMP, COMPRESSOR, OR SIMILAR MECHANICAL ROTATING EQUIPMENT. IT MAY INCLUDE BEARINGS, BUSHES, OILERS OR SEALS.',
                'ind_definition' => '',
                'created_by' => 4,
                'last_updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
