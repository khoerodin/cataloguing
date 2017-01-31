<?php
namespace App\Classes;
use App\Models\PartCharacteristicValue;
use App\Models\PartMaster;
use App\Models\TblSearch;
use Vinkla\Hashids\Facades\Hashids;

class Helper {

    public function shortDesc($partMasterId, $companyId, $decode = null)
    {
        if(is_null($decode)){
            $partMasterId = Hashids::decode($partMasterId)[0];
            $companyId = Hashids::decode($companyId)[0];
        }

        $itemName = PartMaster::select(\DB::raw('short_name as abbrev, ":" as short_separator'))
            ->join('link_inc_group_class', 'link_inc_group_class.id', 'part_master.link_inc_group_class_id')
            ->join('tbl_inc', 'tbl_inc.id', 'link_inc_group_class.tbl_inc_id')
            ->where('part_master.id', $partMasterId)
            ->get();

        $data = PartCharacteristicValue::select('company_value.abbrev', 'company_short_description_format.short_separator')

            ->join('company_check_short', 'company_check_short.part_characteristic_value_id', '=', 'part_characteristic_value.id')

            ->join('part_master', 'part_master.id', '=', 'part_characteristic_value.part_master_id')
            
            ->join('link_inc_characteristic_value', 'link_inc_characteristic_value.id', '=', 'part_characteristic_value.link_inc_characteristic_value_id')
            
            ->join('company_value', 'company_value.link_inc_characteristic_value_id', '=', 'link_inc_characteristic_value.id')
            
            ->join('link_inc_characteristic', 'link_inc_characteristic.id', '=', 'link_inc_characteristic_value.link_inc_characteristic_id')
            
            ->join('tbl_characteristic', 'tbl_characteristic.id', '=', 'link_inc_characteristic.tbl_characteristic_id')
            
            ->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_characteristic.tbl_inc_id')

            ->join('company_characteristic', 'company_characteristic.link_inc_characteristic_id', '=', 'link_inc_characteristic.id')
            
            ->join('company_short_description_format', 'company_short_description_format.company_characteristic_id', '=', 'company_characteristic.id')
            
            ->where('part_master.id', $partMasterId)
            ->where('company_value.tbl_company_id', $companyId)
            ->where('company_check_short.tbl_company_id', $companyId)
            ->where('company_characteristic.tbl_company_id', $companyId)
            ->where('company_characteristic.hidden', 0)
            ->where('company_check_short.short', 1)
            ->where('company_value.abbrev', '!=', '')
            // ->where('company_value.approved', 1)
            ->where('company_short_description_format.hidden', 0)
            
            ->orderBy('company_short_description_format.sequence')

            ->get();
        $data_arr = [];
        foreach ($itemName as $key => $value) {
            $data_arr[] = [
                'abbrev' => $value->abbrev,
                'short_separator' => $value->short_separator,
            ];
        }
        foreach ($data as $key => $value) {
            $data_arr[] = [
                'abbrev' => $value->abbrev,
                'short_separator' => $value->short_separator,
            ];
        }
        $data = json_decode(json_encode($data_arr), false);
        $len = 40;
        $approved = '';
        foreach ($data as $key => $value) {
            $approved .= $value->abbrev . $value->short_separator;
        }

        if(strlen(trim($approved)) <= $len+1){
            return $this->shortLesEqual($data);
        }elseif(strlen(trim($approved)) > $len){
            return $this->shortMoreThan($data,$len);
        }else{
            return 'ERROR';
        }
    }

    private function shortLesEqual($data)
    {   
        $short = '';
        $jml = count($data);
        $i = 1;
        foreach ($data as $key => $value) {
            $short .= $value->abbrev;
            if($jml == $i++){
                $short .= '';
            }else{
                $short .= $value->short_separator;
            }            
        }
        return $short;
    }

    private function shortMoreThan($data,$len)
    {   
        $short   = '';
        $shortAr = [];
        foreach ($data as $key => $value) {
            $short     .= $value->abbrev;
            $shortAr[] = $value->abbrev;
            if(strlen(substr($short, 0,$len)) == $len){
                $final = '';
                for ($i=0; $i < count($shortAr)-1-1; $i++) { //dikurangi 1 krn mulain dr 0, dikurangi 1 lg krn seapartor teakhir tidak terpakai 
                    $final .= $shortAr[$i];
                }
                // hentikan loop
                break;
            }else{
                // tetap ambil separator jika belum nyampe $len
                $short     .= $value->short_separator;
                $shortAr[] = $value->short_separator;
            }
        }
        return $final;
    }

    public function searchMaster($key)
    {
        $id = Hashids::decode($key)[0];
        $search = TblSearch::find($id);

        return PartMaster::join('tbl_holding', 'tbl_holding.id', 'part_master.tbl_holding_id')
                ->join('part_company', 'part_company.part_master_id', 'part_master.id')
                ->join('tbl_company', 'tbl_company.id', 'part_company.tbl_company_id')
                ->join('tbl_catalog_status', 'tbl_catalog_status.id', 'part_company.tbl_catalog_status_id')
                ->join('link_inc_group_class', 'link_inc_group_class.id', 'part_master.link_inc_group_class_id')
                ->join('tbl_inc', 'tbl_inc.id', 'link_inc_group_class.tbl_inc_id')
                ->join('tbl_group_class', 'tbl_group_class.id', 'link_inc_group_class.tbl_group_class_id')
                ->join('tbl_group', 'tbl_group.id', 'tbl_group_class.tbl_group_id')
                ->join('tbl_unit_of_measurement as unit_issue', 'unit_issue.id', 'part_master.unit_issue')
                
                // PART MASTER
                ->SearchCatalogNo($search->catalog_no)
                ->SearchHoldingNo($search->holding_no)
                ->SearchIncId($search->inc_id)
                ->SearchGroupClassId($search->group_class_id)
                ->SearchCatalogType($search->catalog_type)
                ->SearchCatalogStatusId($search->catalog_status_id)
                ->SearchColloquialId($search->colloquial_id)
                ->SearchItemTypeId($search->item_type_id)
                ->SearchManCodeId($search->man_code_id)
                ->SearchPartNumber($search->part_number)
                ->SearchEquipmentCodeId($search->equipment_code_id)

                ->SearchHoldingId($search->holding_id)
                ->SearchCompanyId($search->company_id)
                ->SearchPlantId($search->plant_id)
                ->SearchLocationId($search->location_id)
                ->SearchShelfId($search->shelf_id)
                ->SearchBinId($search->bin_id)

                ->select([
                    'part_master.id as part_master_id',
                    'catalog_no',
                    'holding',
                    'company',
                    \DB::raw('(CASE
                        WHEN holding_no = "" THEN "NOT AVAILABLE"
                        WHEN holding_no IS NULL THEN "NOT AVAILABLE"
                        ELSE holding_no
                    END
                    ) as holding_no'),
                    'item_name',
                    'inc',
                    \DB::raw('CONCAT(`group`, tbl_group_class.class) AS group_class'),
                    \DB::raw('(CASE 
                        WHEN uom_type = "2" THEN unit_issue.unit2
                        WHEN uom_type = "3" THEN unit_issue.unit3
                        WHEN uom_type = "4" THEN unit_issue.unit4
                    END
                    ) as unit_issue'),           
                    'catalog_type',
                    'tbl_catalog_status.status',
                    'link_inc_group_class.id as link_inc_group_class_id',
                    'tbl_catalog_status.id as tbl_catalog_status_id',
                    'tbl_company_id',
                    ]);
    }

    public function okeh()
    {
        $a = \Auth::user()->id;
        return $a;
    }
}