<?php
namespace App\Classes;
use App\Models\PartCharacteristicValue;
use Vinkla\Hashids\Facades\Hashids;

class Helper {

    public function shortDesc($partMasterId, $companyId)
    {
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
            
            ->where('part_master.id', Hashids::decode($partMasterId)[0])
            ->where('company_value.tbl_company_id', Hashids::decode($companyId)[0])
            ->where('company_check_short.tbl_company_id', Hashids::decode($companyId)[0])
            ->where('company_characteristic.tbl_company_id', Hashids::decode($companyId)[0])
            ->where('company_characteristic.hidden', 0)
            ->where('company_check_short.short', 1)
            ->where('company_value.approved', 1)
            ->where('company_short_description_format.hidden', 0)
            
            ->orderBy('company_short_description_format.sequence')

            ->get();

        $len = 40;
        $approved = '';
        foreach ($data as $key => $value) {
            $approved .= $value->abbrev . $value->short_separator;
        }

        if(strlen(trim($approved)) <= $len){
            return $this->shortLesEqual($data);
        }elseif(strlen(trim($approved)) > $len){
            return $this->shortMoreThan($data,$len);
        }else{
            return '*';
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
}