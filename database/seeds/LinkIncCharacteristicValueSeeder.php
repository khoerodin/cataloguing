<?php

use Illuminate\Database\Seeder;

class LinkIncCharacteristicValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now();
        App\Models\LinkIncCharacteristicValue::insert([

        		// INC 00014

          [
          	'link_inc_characteristic_id' => 1,
            'value' => 'ANGULAR CONTACT',
            'abbrev' => 'AC',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 1,
            'value' => 'DEEP GROOVE',
            'abbrev' => 'DG',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 2,
            'value' => 'SINGLE ROW',
            'abbrev' => '1R',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 2,
            'value' => 'DOUBLE ROW',
            'abbrev' => '2R',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 3,
            'value' => '100MM',
            'abbrev' => '100',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 3,
            'value' => '105MM',
            'abbrev' => '105',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 4,
            'value' => '120MM',
            'abbrev' => '120',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 4,
            'value' => '130MM',
            'abbrev' => '130',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 5,
            'value' => '0.875IN',
            'abbrev' => '0.875IN',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 5,
            'value' => '12MM',
            'abbrev' => '12MM',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 6,
            'value' => '1 SEAL',
            'abbrev' => '1SEAL',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 6,
            'value' => '1 SHIELD',
            'abbrev' => '1SHLD',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 7,
            'value' => 'MACHINED BRASS CAGE',
            'abbrev' => '',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 7,
            'value' => 'PRESSED STEEL CAGE',
            'abbrev' => '',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 8,
            'value' => 'C3',
            'abbrev' => 'C3',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 8,
            'value' => 'C4',
            'abbrev' => 'C4',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 9,
            'value' => 'P5',
            'abbrev' => '',
            'approved' => 0,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 9,
            'value' => 'P6',
            'abbrev' => '',
            'approved' => 0,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 10,
            'value' => 'IBI-10477',
            'abbrev' => 'IBI-10477',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 10,
            'value' => 'JIS G4805 SUJ2',
            'abbrev' => '',
            'approved' => 0,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 11,
            'value' => 'FOUR POINT CONTACT',
            'abbrev' => '4PT',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 11,
            'value' => 'PAIR MOUNT',
            'abbrev' => '',
            'approved' => 0,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 12,
            'value' => 'INNER SPLIT RACE',
            'abbrev' => '',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 12,
            'value' => 'IN PAIRS',
            'abbrev' => '',
            'approved' => 0,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 13,
            'value' => 'BALLHEAD ASSEMBLY',
            'abbrev' => 'BALLHEAD',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 13,
            'value' => 'DRIVING SHAFT',
            'abbrev' => 'DRV SHAFT',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 14,
            'value' => 'AIR COMPRESSOR',
            'abbrev' => 'COMPR',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 14,
            'value' => 'DIESEL ENGINE',
            'abbrev' => 'ENGINE',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 15,
            'value' => 'LN100X9P11120FA-MA3152',
            'abbrev' => 'LN100X9P11120FA',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 15,
            'value' => 'KR-25/V-25/V-32',
            'abbrev' => 'KR-25/V-25',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 16,
            'value' => 'GOVERNOR DRIVING GEAR',
            'abbrev' => '',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 16,
            'value' => 'OIL PUMP',
            'abbrev' => '',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 17,
            'value' => '2354009',
            'abbrev' => '',
            'approved' => 0,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 17,
            'value' => '75T7707',
            'abbrev' => '',
            'approved' => 0,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 18,
            'value' => '300HP; 1000RPM',
            'abbrev' => '',
            'approved' => 0,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 19,
            'value' => 'EBARA CORPORATION',
            'abbrev' => 'EBARA',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 19,
            'value' => 'ATLAS COPCO',
            'abbrev' => 'ATLASCO',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 20,
            'value' => 'C/W CERTIFICATE OF ORIGIN',
            'abbrev' => '',
            'approved' => 0,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],

          // INC F0220

          [
          	'link_inc_characteristic_id' => 22,
            'value' => 'IMPELLER COVER',
            'abbrev' => 'IMPELLER',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 22,
            'value' => 'OIL PUMP COVER',
            'abbrev' => 'OIL PUMP',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 23,
            'value' => '280 X 35 X 385MM',
            'abbrev' => '',
            'approved' => 0,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 24,
            'value' => 'CAST IRON',
            'abbrev' => '',
            'approved' => 0,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 25,
            'value' => 'JIS G5501 GRADE FC25',
            'abbrev' => '',
            'approved' => 0,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 25,
            'value' => 'JIS G5501 GRADE FC250',
            'abbrev' => '',
            'approved' => 0,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 28,
            'value' => 'BAG SEWING MACHINE',
            'abbrev' => 'BAG SEWING',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 28,
            'value' => 'CENTRIFUGAL PUMP',
            'abbrev' => 'PUMP',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 29,
            'value' => '1-1/2-1BM-EO-R/L-5VR/VOR',
            'abbrev' => '1-1/2-1BM-EO-R/L',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 29,
            'value' => '1741-44-9720',
            'abbrev' => '1741-44-9720',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 30,
            'value' => 'CLUTCH DRIVING PARTS B',
            'abbrev' => '',
            'approved' => 0,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 31,
            'value' => '4-250-327+328',
            'abbrev' => '',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 31,
            'value' => 'D-06930',
            'abbrev' => '',
            'approved' => 0,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 32,
            'value' => '1144BHP; 3600RPM',
            'abbrev' => '',
            'approved' => 0,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 33,
            'value' => 'BIF PUMPS',
            'abbrev' => 'BIF',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 33,
            'value' => 'GALION',
            'abbrev' => 'GALION',
            'approved' => 1,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
          [
          	'link_inc_characteristic_id' => 34,
            'value' => 'C/W CERTIFICATE OF ORIGIN',
            'abbrev' => '',
            'approved' => 0,
          	'created_by' => 2,
          	'last_updated_by' => 4,
          	'created_at' => $now,
          	'updated_at' => $now
          ],
      ]);
    }
}
