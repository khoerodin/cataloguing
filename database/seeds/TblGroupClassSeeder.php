<?php

use Illuminate\Database\Seeder;

class TblGroupClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$now = Carbon\Carbon::now();
        App\Models\TblGroupClass::insert([
            [
            	'tbl_group_id' => 1,
                'class' => '35',
            	'name' => 'FUZING AND FIRING DEVICES, NUCLEAR ORDNANCE',
            	'eng_definition' => 'INCLUDES SUCH ITEMS AS FUZES, POWER SUPPLIES, FIRING SETS, X-UNITS, CABLES, SAFING DEVICES, ADAPTION KITS, AND RE-ENTRY VEHICLE NUCLEAR ORDNANCE ARMING AND FUZING SYSTEMS.',
            	'ind_definition' => '',
            	'created_by' => 1,
            	'last_updated_by' => 1,
            	'created_at' => $now,
            	'updated_at' => $now
            ],
            [
                'tbl_group_id' => 2,
                'class' => '86',
                'name' => 'UNDERWATER USE EXPLOSIVE ORDNANCE DISPOSAL & SWIMMER WEAPON SYST TOOLS & EQUIP',
                'eng_definition' => 'NOTE: THIS CLASS INCLUDES ONLY SPECIALIZED TOOLS AND EQUIPMENT DEVELOPED FOR AND USED BY QUALIFIED EXPLOSIVE ORDNANCE DISPOSAL (EOD) PERSONNEL, UNDERWATER DEMOLITION TEAMS (UDT), AND/OR SEA-AIR- LAND (SEAL) PERSONNEL. EXCLUDES NONSPECIALIZED OR COMMON TOOLS NOT DEVELOPED EXCLUSIVELY FOR USE BY QUALIFIED EOD, UDT, AND/OR SEAL PERSONNEL; SPECIALIZED DEMOLITION MATERIAL; EXPLOSIVE LOADED SHAPED CHARGES.',
                'ind_definition' => '',
                'created_by' => 1,
                'last_updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'tbl_group_id' => 4,
                'class' => '10',
                'name' => 'BEARINGS, ANTIFRICTION, UNMOUNTED',
                'eng_definition' => 'THIS CLASS INCLUDES BEARINGS THAT GENERALLY HAVE ROLLERS OR BALLS CONFINED BY AN INNER AND OUTER RING TO RELIEVE FRICTION IN/ON/AROUND A ROTATING AND/OR MOVING MECHANISM. INCLUDES: BALL BEARINGS; ROLLER BEARINGS; BALLS; RACES. EXCLUDES PLAIN BEARINGS (CLASS 3120); JEWEL BEARINGS (CLASS 3120).',
                'ind_definition' => '',
                'created_by' => 1,
                'last_updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'tbl_group_id' => 3,
                'class' => '10',
                'name' => 'TORQUE CONVERTERS AND SPEED CHANGERS',
                'eng_definition' => 'INCLUDES: FLUID COUPLINGS; NONVEHICULAR CLUTCHES AND COUPLINGS; HORIZONTAL RIGHT ANGLE DRIVE GEAR UNITS. EXCLUDES: AUTOMOTIVE TORQUE CONVERTERS; VEHICULAR POWER TRANSMISSION COMPONENTS; ROTARY AIRCRAFT TRANSMISSION GEAR UNITS.',
                'ind_definition' => '',
                'created_by' => 1,
                'last_updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'tbl_group_id' => 5,
                'class' => '10',
                'name' => 'COMPRESSORS AND VACUUM PUMPS',
                'eng_definition' => 'INCLUDES: TRUCK MOUNTED AND TRAILER MOUNTED COMPRESSORS. EXCLUDES: REFRIGERATION COMPRESSORS.',
                'ind_definition' => '',
                'created_by' => 1,
                'last_updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'tbl_group_id' => 5,
                'class' => '20',
                'name' => 'POWER AND HAND PUMPS',
                'eng_definition' => 'EXCLUDES: LABORATORY JET PUMPS.',
                'ind_definition' => '',
                'created_by' => 1,
                'last_updated_by' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
