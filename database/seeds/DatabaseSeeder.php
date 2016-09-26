<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaratrustSeeder::class);

        $this->call(TblHoldingSeeder::class);
        $this->call(TblCompanySeeder::class);
        $this->call(TblPlantSeeder::class);
        $this->call(TblLocationSeeder::class);
        $this->call(TblIncSeeder::class);

        $this->call(TblGroupSeeder::class);
        $this->call(TblGroupClassSeeder::class);
        $this->call(TblUnitOfMeasurementSeeder::class);
        $this->call(TblCatalogStatusSeeder::class);
        $this->call(TblUserClassSeeder::class);

        $this->call(TblHarmonizedCodeSeeder::class);
        $this->call(TblHazardClassSeeder::class);
        $this->call(TblWeightUnitSeeder::class);
        $this->call(TblStockTypeSeeder::class);
        $this->call(TblItemTypeSeeder::class);

        $this->call(LinkIncGroupClassSeeder::class);
        $this->call(PartMasterSeeder::class);
        $this->call(TblSourceTypeSeeder::class);
        $this->call(TblManufacturerCodeSeeder::class);
        $this->call(TblPartManufacturerCodeTypeSeeder::class);

        $this->call(PartManufacturerCodeSeeder::class);        
        $this->call(TblEquipmentCodeSeeder::class);        
        $this->call(PartEquipmentCodeSeeder::class);
        $this->call(TblColloquialSeeder::class);
        $this->call(PartColloquialSeeder::class);
        
        $this->call(TblShelfSeeder::class);
        $this->call(TblBinSeeder::class);
        $this->call(PartBinLocationSeeder::class);        
        $this->call(TblCharacteristicSeeder::class);        
        $this->call(LinkIncCharacteristicSeeder::class); 

        $this->call(LinkIncCharacteristicValueSeeder::class);  
        $this->call(PartCharacteristicValueSeeder::class);
        $this->call(LinkIncColloquialSeeder::class);        
        $this->call(PartSourceDescriptionSeeder::class);        
        $this->call(PartSourcePartNoSeeder::class);
            
        $this->call(TblPoStyleSeeder::class);        
        $this->call(CompanyCharacteristicSeeder::class);        
    }
}
