<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Auth;
use DB;
use Datatables;
use Response;

use App\Models\CompanyCharacteristicSequence;
use App\Models\CompanyCheckShort;
use App\Models\LinkIncGroupClass;
use App\Models\LinkIncCharacteristic;
use App\Models\LinkIncCharacteristicValue;
use App\Models\Models\PartBinLocation;
use App\Models\PartCharacteristicValue;
use App\Models\PartColloquial;
use App\Models\PartEquipmentCode;
use App\Models\PartManufacturerCode;
use App\Models\PartMaster;
use App\Models\PartSourceDescription;
use App\Models\PartSourcePartNo;
use App\Models\TblCharacteristic;
use App\Models\TblCompany;
use App\Models\TblColloquial;
use App\Models\TblEquipmentCode;
use App\Models\TblInc;
use App\Models\TblGroupClass;
use App\Models\TblManufacturerCode;
use App\Models\TblSourceType;
use App\Models\TblPartManufacturerCodeType;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        return view('home');
    }

    public function getPartMaster()
    {
        $partMaster = PartMaster::join('tbl_holding', 'tbl_holding.id', '=', 'part_master.tbl_holding_id')
                ->join('tbl_unit_of_measurement', 'tbl_unit_of_measurement.id', '=', 'part_master.unit_issue')
                ->join('tbl_catalog_status', 'tbl_catalog_status.id', '=', 'part_master.tbl_catalog_status_id')
                ->join('link_inc_group_class', 'link_inc_group_class.id', '=', 'part_master.link_inc_group_class_id')
                ->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_group_class.tbl_inc_id')
                ->join('tbl_group_class', 'tbl_group_class.id', '=', 'link_inc_group_class.tbl_group_class_id')
                ->join('tbl_group', 'tbl_group.id', '=', 'tbl_group_class.tbl_group_id')
                ->join('tbl_unit_of_measurement as unit_issue', 'unit_issue.id', '=', 'part_master.unit_issue')
                ->join('tbl_item_type', 'tbl_item_type.id', '=', 'part_master.tbl_item_type_id')
                ->join('tbl_stock_type', 'tbl_stock_type.id', '=', 'part_master.tbl_stock_type_id')
                ->join('tbl_user_class', 'tbl_user_class.id', '=', 'part_master.tbl_user_class_id')
                ->join('tbl_weight_unit', 'tbl_weight_unit.id', '=', 'part_master.tbl_weight_unit_id')
                ->select([
                    'part_master.id',
                    'catalog_no',
                    'holding',
                    'holding_no',
                    'item_name',
                    'inc',
                    DB::raw('CONCAT(`group`, tbl_group_class.class) AS group_class'),
                    'unit_issue.unit4',                 
                    'catalog_type',
                    'tbl_catalog_status.status',

                    'tbl_item_type.type',
                    'tbl_stock_type.type',
                    'tbl_user_class.class',
                    'conversion',  

                    'weight_value',
                    'tbl_weight_unit.unit',
                    'average_unit_price',

                    'link_inc_group_class.id as inc_group_class_id'
                    ]);
        return Datatables::of($partMaster)
            ->setRowId('id')
            ->make(true);
    }

    public function selectAddCompany($partMasterId, Request $request)
    {
        return TblCompany::select('tbl_company.id', 'company')
            ->join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')
            ->join('part_master', 'part_master.tbl_holding_id', '=', 'tbl_holding.id')
            ->where('part_master.id', $partMasterId)
            ->where('company', 'like', '%'.$request->q.'%')            
            ->get();
    }

    public function addCompany(Request $request)
    {
        $this->validate($request, [
            'part_master_id' => 'required',
            'tbl_company_id' => 'required'
        ]);   

        $userId = Auth::user()->id;

        $data = [
            'part_master_id' => $request->part_master_id,
            'tbl_company_id' => $request->tbl_company_id,
            'created_by' => $userId,
            'last_updated_by' => $userId,
        ];           

        return PartBinLocation::create($data);
    }

    public function selectCompany($partMasterId){
        return TblCompany::select('tbl_company.id','company')
        ->join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')
        ->join('part_master', 'part_master.tbl_holding_id', '=', 'tbl_holding.id')
        ->where('part_master.id', $partMasterId)
        ->get();
    }

    public function getIncGroupClass($id)
    {
        return linkIncGroupClass::select('tbl_inc.id as inc_id', 'inc', 'item_name',
            'tbl_group_class.id as group_class_id', DB::raw('CONCAT(`group`, class) AS group_class'), 'tbl_group_class.name')
            ->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_group_class.tbl_inc_id')
            ->join('tbl_group_class', 'tbl_group_class.id', '=', 'link_inc_group_class.tbl_group_class_id')
            ->join('tbl_group', 'tbl_group.id', '=', 'tbl_group_class.tbl_group_id')
            ->where('link_inc_group_class.id', $id)
            ->first();
    }

    public function selectInc(Request $request)
    {
        return TblInc::select('id', 'inc', 'item_name')
            ->where('inc', 'like', '%'.$request->q.'%')
            ->orWhere('item_name', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function getGroupClass($incId)
    {
        return LinkIncGroupClass::select('tbl_group_class.id', DB::raw('CONCAT(`group`, class) AS group_class'), 'tbl_group_class.name')
            ->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_group_class.tbl_inc_id')
            ->join('tbl_group_class', 'tbl_group_class.id', '=', 'link_inc_group_class.tbl_group_class_id')
            ->join('tbl_group', 'tbl_group.id', '=', 'tbl_group_class.tbl_group_id')
            ->where('tbl_inc.id', $incId)
            ->get();
    }

    private function insertAbbrevAndShort($partMasterId, $companyId)
    {
        $sub_query_part_char_val = PartCharacteristicValue::select('company_abbrev.link_inc_characteristic_value_id')
            ->join('company_abbrev', 'company_abbrev.link_inc_characteristic_value_id', '=', 'part_characteristic_value.link_inc_characteristic_value_id')
            ->where('part_master_id', $partMasterId)
            ->where('tbl_company_id', $companyId)
            ->get()->toArray();

        $check_link_inc_char_val_id_not_in_company_abbrev = PartCharacteristicValue::select('link_inc_characteristic_value_id')
            ->where('part_master_id', $partMasterId)
            ->whereNotIn('link_inc_characteristic_value_id', $sub_query_part_char_val)
            ->first();

        // jika ada link_inc_characteristic_value_id belum masuk company_abbrev
        // dengan part_master_id dan company_id yang ditentukan
        if(count($check_link_inc_char_val_id_not_in_company_abbrev) > 0){
            $select = PartCharacteristicValue::select(array(DB::raw($companyId.' as tbl_company_id, link_inc_characteristic_value_id, "" as abbrev, 0 as approved, '. Auth::user()->id .' as created_by, '.Auth::user()->id . ' as last_updated_by, "'. date("Y-m-d H:i:s") .'" as created_at, "'. date("Y-m-d H:i:s") .'" as updated_at')))
                ->where('part_master_id', $partMasterId)
                ->whereNotIn('link_inc_characteristic_value_id', $sub_query_part_char_val);

            $bindings = $select->getBindings();

            $insertQuery = 'INSERT into company_abbrev (tbl_company_id,link_inc_characteristic_value_id,abbrev,approved,created_by,last_updated_by,created_at,updated_at) '
            . $select->toSql();

            DB::insert($insertQuery, $bindings);
        }

        $sub_query_part_char_val_2 = PartCharacteristicValue::select('company_check_short.part_characteristic_value_id')
            ->join('company_check_short', 'company_check_short.part_characteristic_value_id', '=', 'part_characteristic_value.id')
            ->where('part_master_id', $partMasterId)
            ->where('tbl_company_id', $companyId)
            ->get()->toArray();

        $check_part_char_val_id_not_in_company_check_short = PartCharacteristicValue::select('id')
            ->where('part_master_id', $partMasterId)
            ->whereNotIn('id', $sub_query_part_char_val_2)
            ->first();

        // jika ada part_characteristic_value_id belum masuk company_check_short
        // dengan part_master_id dan company_id yang ditentukan
        if(count($check_part_char_val_id_not_in_company_check_short) > 0){
            $select = PartCharacteristicValue::select(array(DB::raw($companyId.' as tbl_company_id, id, 0 as short, '. Auth::user()->id .' as created_by, '.Auth::user()->id . ' as last_updated_by, "'. date("Y-m-d H:i:s") .'" as created_at, "'. date("Y-m-d H:i:s") .'" as updated_at')))
                ->where('part_master_id', $partMasterId)
                ->whereNotIn('id', $sub_query_part_char_val_2);

            $bindings = $select->getBindings();

            $insertQuery = 'INSERT into company_check_short (tbl_company_id,part_characteristic_value_id,short,created_by,last_updated_by,created_at,updated_at) '
            . $select->toSql();

            DB::insert($insertQuery, $bindings);
        }
    }

    private function insertCharToCompany($companyId, $incId, $partMasterId)
    {

        $sub_query_comp_char_seq = CompanyCharacteristicSequence::select('link_inc_characteristic_id')
            ->where('tbl_company_id', $companyId)
            ->get()->toArray();

        // cek apakah company sudah punya inc_char_id
        $inc_char_id_in_company = LinkIncCharacteristic::select('id')
            ->whereIn('id', $sub_query_comp_char_seq)
            ->where('tbl_inc_id', $incId)
            ->first();

        // jika company sudah punya inc_char_id 
        if (count($inc_char_id_in_company) > 0) {

            // maka cek apakah ada inc_char_id yang belum masuk company
            $inc_char_not_in_company = LinkIncCharacteristic::select('id')
                ->whereNotIn('id', $sub_query_comp_char_seq)
                ->where('tbl_inc_id', $incId)
                ->first();

            // jika ada char yang belum masuk kedalam company
            if (count($inc_char_not_in_company) > 0) {

                // ambil inc_char_id yang belum masuk company TIDAK BESERTA sequence_nya
                // http://stackoverflow.com/questions/25533608/create-a-insert-select-statement-in-laravel
                $select = LinkIncCharacteristic::select(array(DB::raw($companyId.' as tbl_company_id, id as link_inc_characteristic_id, '. Auth::user()->id .' as created_by, '.Auth::user()->id . ' as last_updated_by, "'. date("Y-m-d H:i:s") .'" as created_at, "'. date("Y-m-d H:i:s") .'" as updated_at')))
                ->whereNotIn('id', $sub_query_comp_char_seq)
                ->where('tbl_inc_id', $incId);

                $bindings = $select->getBindings();

                $insertQuery = 'INSERT into company_characteristic_sequence (tbl_company_id,link_inc_characteristic_id,created_by,last_updated_by,created_at,updated_at) '
                . $select->toSql();

                if(DB::insert($insertQuery, $bindings)){

                    $this->insertAbbrevAndShort($partMasterId, $companyId);

                    $result = LinkIncCharacteristic::select('part_characteristic_value_id as id', 
                        'part_master_id', 'tbl_inc_id', 'characteristic', 'link_inc_characteristic_value_id', 
                        'link_inc_characteristic.id as link_inc_characteristic_id', 
                        'link_inc_characteristic.tbl_characteristic_id as char_id',
                        DB::raw('IFNULL(value, "") as value'), DB::raw('IFNULL(abbrev, "") as abbrev'), 'approved', 
                        'short', 'type', 'company_characteristic_sequence.sequence')
                        ->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_characteristic.tbl_inc_id')
                        ->join('tbl_characteristic', 'tbl_characteristic.id', '=', 'link_inc_characteristic.tbl_characteristic_id')
                        ->join('company_characteristic_sequence', 'link_inc_characteristic.id', '=', 'company_characteristic_sequence.link_inc_characteristic_id')
                        ->leftJoin(DB::raw('(select part_characteristic_value.id as part_characteristic_value_id, part_master_id, 
                            part_characteristic_value.link_inc_characteristic_value_id, 
                            link_inc_characteristic.id as link_inc_char_id, value, company_abbrev.abbrev,
                            company_abbrev.approved, company_check_short.short
                            
                            from part_characteristic_value
                            
                            join company_check_short on company_check_short.part_characteristic_value_id = part_characteristic_value.id
                            join part_master on part_master.id = part_characteristic_value.part_master_id
                            join link_inc_characteristic_value on link_inc_characteristic_value.id = part_characteristic_value.link_inc_characteristic_value_id
                            join company_abbrev on company_abbrev.link_inc_characteristic_value_id = link_inc_characteristic_value.id
                            join link_inc_characteristic on link_inc_characteristic.id = link_inc_characteristic_value.link_inc_characteristic_id
                            join tbl_characteristic on tbl_characteristic.id = link_inc_characteristic.tbl_characteristic_id
                            join tbl_inc on tbl_inc.id = link_inc_characteristic.tbl_inc_id
                            
                            where part_master.id = '.$partMasterId.' and company_abbrev.tbl_company_id = '.$companyId.' and company_check_short.tbl_company_id = '.$companyId.') master_table'), function($leftJoin)
                            {
                                $leftJoin->on('master_table.link_inc_char_id', '=', 'link_inc_characteristic.id');
                            })
                        ->where('tbl_inc.id', $incId)
                        ->where('tbl_company_id', $companyId)
                        ->orderByRaw('(CASE WHEN company_characteristic_sequence.sequence IS NULL then 1 ELSE 0 END), company_characteristic_sequence.sequence asc')->get();

                }else{
                    $result = [];
                }              

            // jika inc_char_id sudah masuk semua kedalam company maka tinggal panggil
            }else{

                $this->insertAbbrevAndShort($partMasterId, $companyId);

                $result = LinkIncCharacteristic::select('part_characteristic_value_id as id', 'part_master_id', 'tbl_inc_id', 'characteristic', 'link_inc_characteristic_value_id', 'link_inc_characteristic.id as link_inc_characteristic_id', 'link_inc_characteristic.tbl_characteristic_id as char_id',
                    DB::raw('IFNULL(value, "") as value'), DB::raw('IFNULL(abbrev, "") as abbrev'), 'approved', 'short', 'type', 'company_characteristic_sequence.sequence')
                    ->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_characteristic.tbl_inc_id')
                    ->join('tbl_characteristic', 'tbl_characteristic.id', '=', 'link_inc_characteristic.tbl_characteristic_id')
                    ->join('company_characteristic_sequence', 'link_inc_characteristic.id', '=', 'company_characteristic_sequence.link_inc_characteristic_id')
                    ->leftJoin(DB::raw('(select part_characteristic_value.id as part_characteristic_value_id, part_master_id, part_characteristic_value.link_inc_characteristic_value_id, 
                        link_inc_characteristic.id as link_inc_char_id, value, company_abbrev.abbrev,
                        company_abbrev.approved, company_check_short.short
                        
                        from part_characteristic_value
                        
                        join company_check_short on company_check_short.part_characteristic_value_id = part_characteristic_value.id
                        join part_master on part_master.id = part_characteristic_value.part_master_id
                        join link_inc_characteristic_value on link_inc_characteristic_value.id = part_characteristic_value.link_inc_characteristic_value_id
                        join company_abbrev on company_abbrev.link_inc_characteristic_value_id = link_inc_characteristic_value.id
                        join link_inc_characteristic on link_inc_characteristic.id = link_inc_characteristic_value.link_inc_characteristic_id
                        join tbl_characteristic on tbl_characteristic.id = link_inc_characteristic.tbl_characteristic_id
                        join tbl_inc on tbl_inc.id = link_inc_characteristic.tbl_inc_id
                        
                        where part_master.id = '.$partMasterId.' and company_abbrev.tbl_company_id = '.$companyId.' and company_check_short.tbl_company_id = '.$companyId.') master_table'), function($leftJoin)
                        {
                            $leftJoin->on('master_table.link_inc_char_id', '=', 'link_inc_characteristic.id');
                        })
                    ->where('tbl_inc.id', $incId)
                    ->where('tbl_company_id', $companyId)
                    ->orderByRaw('(CASE WHEN company_characteristic_sequence.sequence IS NULL then 1 ELSE 0 END), company_characteristic_sequence.sequence asc')->get();
            }

        // jika company belum memiliki inc_char_id
        }else{

            // ambil inc_char_id yang belum masuk company, BESERTA sequence_nya
            // http://stackoverflow.com/questions/25533608/create-a-insert-select-statement-in-laravel
            $select = LinkIncCharacteristic::select(array(DB::raw($companyId.' as tbl_company_id, id as link_inc_characteristic_id, sequence, '. Auth::user()->id .' as created_by, '.Auth::user()->id . ' as last_updated_by, "'. date("Y-m-d H:i:s") .'" as created_at, "'. date("Y-m-d H:i:s") .'" as updated_at')))
            ->whereNotIn('id', $sub_query_comp_char_seq)
            ->where('tbl_inc_id', $incId);

            $bindings = $select->getBindings();

            $insertQuery = 'INSERT into company_characteristic_sequence (tbl_company_id,link_inc_characteristic_id,sequence,created_by,last_updated_by,created_at,updated_at) '
            . $select->toSql();

            if(DB::insert($insertQuery, $bindings)){

                $this->insertAbbrevAndShort($partMasterId, $companyId);

                $result = LinkIncCharacteristic::select('part_characteristic_value_id as id', 
                    'part_master_id', 'tbl_inc_id', 'characteristic', 'link_inc_characteristic_value_id', 
                    'link_inc_characteristic.id as link_inc_characteristic_id', 
                    'link_inc_characteristic.tbl_characteristic_id as char_id',
                    DB::raw('IFNULL(value, "") as value'), DB::raw('IFNULL(abbrev, "") as abbrev'), 'approved', 
                    'short', 'type', 'company_characteristic_sequence.sequence')
                    ->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_characteristic.tbl_inc_id')
                    ->join('tbl_characteristic', 'tbl_characteristic.id', '=', 'link_inc_characteristic.tbl_characteristic_id')
                    ->join('company_characteristic_sequence', 'link_inc_characteristic.id', '=', 'company_characteristic_sequence.link_inc_characteristic_id')
                    ->leftJoin(DB::raw('(select part_characteristic_value.id as part_characteristic_value_id, part_master_id, 
                        part_characteristic_value.link_inc_characteristic_value_id, 
                        link_inc_characteristic.id as link_inc_char_id, value, company_abbrev.abbrev,
                        company_abbrev.approved, company_check_short.short
                        
                        from part_characteristic_value
                        
                        join company_check_short on company_check_short.part_characteristic_value_id = part_characteristic_value.id
                        join part_master on part_master.id = part_characteristic_value.part_master_id
                        join link_inc_characteristic_value on link_inc_characteristic_value.id = part_characteristic_value.link_inc_characteristic_value_id
                        join company_abbrev on company_abbrev.link_inc_characteristic_value_id = link_inc_characteristic_value.id
                        join link_inc_characteristic on link_inc_characteristic.id = link_inc_characteristic_value.link_inc_characteristic_id
                        join tbl_characteristic on tbl_characteristic.id = link_inc_characteristic.tbl_characteristic_id
                        join tbl_inc on tbl_inc.id = link_inc_characteristic.tbl_inc_id
                        
                        where part_master.id = '.$partMasterId.' and company_abbrev.tbl_company_id = '.$companyId.' and company_check_short.tbl_company_id = '.$companyId.') master_table'), function($leftJoin)
                        {
                            $leftJoin->on('master_table.link_inc_char_id', '=', 'link_inc_characteristic.id');
                        })
                    ->where('tbl_inc.id', $incId)
                    ->where('tbl_company_id', $companyId)
                    ->orderByRaw('(CASE WHEN company_characteristic_sequence.sequence IS NULL then 1 ELSE 0 END), company_characteristic_sequence.sequence asc')->get();

            }else{
                $result = [];
            }
        }

        return $result;

    }

    public function getCharacteristicValue($incId, $partMasterId, $companyId)
    {
        // apakah inc yang dimaksud telah memiliki characteristic
        $char_for_inc = LinkIncCharacteristic::select('id')
            ->where('tbl_inc_id', $incId)
            ->first();
        
        // jika inc telah memiliki characteristic             
        if (count($char_for_inc) > 0) {

            return $this->insertCharToCompany($companyId, $incId, $partMasterId);

        }else{

            // munculkan dialog pemberitahuan bahwa characteristic masih kosong
            return 1;

        }

    }

    public function clickRowPartMaster($id)
    {
        return PartMaster::select('link_inc_group_class_id')->find($id);
    }

    public function getIncCharValues($incCharId,$incId,$charId)
    {
        return LinkIncCharacteristicValue::join('link_inc_characteristic', 'link_inc_characteristic.id', '=', 'link_inc_characteristic_value.link_inc_characteristic_id')
                ->where('link_inc_characteristic_id', $incCharId)                
                ->where('tbl_inc_id', $incId)
                ->where('tbl_characteristic_id', $charId)
                ->select('link_inc_characteristic_id','link_inc_characteristic_value.id as link_inc_characteristic_value_id','value','abbrev','approved')
                ->get();
    }

    private function olahShort($data, $len)
    {

        $count = '';
        $abbrev = [];
        foreach ($data as $key => $value) {
            $count      .= $value->abbrev;
            $abbrev[]  .= $value->abbrev;
            if(strlen($count) > $len ){
                break;
            }
        }

        $count2 = '';
        $separator = [];
        foreach ($data as $key => $value) {
            $count2      .= $value->abbrev;
            $separator[] .= $value->separator;          
            if(strlen($count2) > $len ){
                break;
            }      
        }
        array_pop($separator);
        array_push($separator, '');

        $short_desc = array_combine($abbrev, $separator);
        $short = '';
        foreach ($short_desc as $key => $value) {
            $short .= $key.$value;
        }
        return $short;
    }

    public function getShortDescription($partMasterId, $companyId)
    {
        $data = PartCharacteristicValue::select('company_abbrev.abbrev', 'company_short_description_format.separator')
            ->join('company_check_short', 'company_check_short.part_characteristic_value_id', '=', 'part_characteristic_value.id')
            ->join('part_master', 'part_master.id', '=', 'part_characteristic_value.part_master_id')
            ->join('link_inc_characteristic_value', 'link_inc_characteristic_value.id', '=', 'part_characteristic_value.link_inc_characteristic_value_id')
            ->join('company_abbrev', 'company_abbrev.link_inc_characteristic_value_id', '=', 'link_inc_characteristic_value.id')
            ->join('link_inc_characteristic', 'link_inc_characteristic.id', '=', 'link_inc_characteristic_value.link_inc_characteristic_id')
            ->join('tbl_characteristic', 'tbl_characteristic.id', '=', 'link_inc_characteristic.tbl_characteristic_id')
            ->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_characteristic.tbl_inc_id')
            ->join('short_description_format', 'short_description_format.link_inc_characteristic_id', '=', 'link_inc_characteristic.id')
            ->join('company_short_description_format', 'company_short_description_format.short_description_format_id', '=', 'short_description_format.id')
            
            ->where('part_master.id', $partMasterId)
            ->where('company_abbrev.tbl_company_id', $companyId)
            ->where('company_check_short.tbl_company_id', $companyId)
            ->where('company_check_short.short', 1)
            ->where('company_abbrev.approved', 1)
            
            ->orderBy('company_short_description_format.sequence')

            ->get();

        if(count($data)>0){
            return $this->olahShort($data, 40);
        }
    }

    public function submitValues(Request $request)
    {   
        // validate array request
        $this->validate($request, [
            'insert_value.*' => 'max:30',
            'update_value.*' => 'max:30'
        ]);        

        // cek apakah catalog sudah punya company_id atau inc sudah punya characteristic
        $charValCheck = $this->getCharacteristicValue($request->inc_id, $request->part_master_id, $request->company_id);
        
        // jika status berupa int 0 atau 1 (catalog belum memiliki company_id atau inc belum memiliki characteristic)
        if(is_int($charValCheck)){

            if($charValCheck == 0){
                // muncul jendela add company
                return 0;
            }else{
                // muncul pemberitahuan bahwa inc belum memiliki characteristic
                return 1;
            }            
        // jika bukan int, maka simpan
        }else{

            $return = DB::transaction(function () use($request){

                // insert
                $_inc_char_id         = $request->insert_inc_char_id;
                $_char_id             = $request->insert_char_id;
                $_value               = $request->insert_value;
                $_short               = $request->insert_short;

                // update
                $__inc_char_id        = $request->update_inc_char_id;
                $__char_id            = $request->update_char_id;
                $__value              = $request->update_value;
                $__part_char_value_id = $request->update_part_char_value_id;
                $__short              = $request->update_short;

                // other variables
                $inc_id               = $request->inc_id;
                $group_class_id       = $request->group_class_id;
                $part_master_id       = $request->part_master_id;
                $created_by           = $request->created_by;
                $last_updated_by      = $request->last_updated_by;
                $company_id           = $request->company_id;

                // UPDATING
                if(!empty($__inc_char_id)){
                    // loop for array
                    foreach ($__inc_char_id as $i => $__values) {
                        
                        // jika value tidak kosong
                        if(!empty($__value[$i])){
                                
                            // yang diambil value
                            // ==================

                            // cek apakah value yang diambil ada dalam link_inc_characteristic_value
                            // dengan syarat inc_id, characteristic_id, dan link_inc_characteristic_id
                            $__checking_value = LinkIncCharacteristicValue::join('link_inc_characteristic', 'link_inc_characteristic.id', '=', 'link_inc_characteristic_value.link_inc_characteristic_id')
                            ->where('link_inc_characteristic_id', $__inc_char_id[$i])                
                            ->where('tbl_inc_id', $inc_id)
                            ->where('tbl_characteristic_id', $__char_id[$i])
                            ->where('value', $__value[$i])
                            ->select('link_inc_characteristic_id','link_inc_characteristic_value.id as link_inc_characteristic_value_id','value')
                            ->first();

                            // jika ada
                            if(count($__checking_value) > 0){
                                // cek apakah link_inc_characteristic_value_id tsb sudah masuk part_characteristic_value
                                // dengan syarat part_characteristic_value.id dan part_master_id
                                $__checking_pcv = PartCharacteristicValue::select('id','link_inc_characteristic_value_id','short')
                                ->where('id', $__part_char_value_id[$i])                
                                ->where('part_master_id', $part_master_id)
                                ->where('link_inc_characteristic_value_id', $__checking_value->link_inc_characteristic_value_id)
                                ->first();

                                // jika sudah masuk
                                if(count($__checking_pcv) > 0){
                                    // cek apakah short beda, dengan syarat company_id
                                    // dan part_characteristic_value_id
                                    $__current_short = CompanyCheckShort::where('part_characteristic_value_id', $__checking_pcv->id)
                                        ->where('tbl_company_id', $company_id)
                                        ->first();

                                    // jika short beda
                                    if($__short[$i] != $__current_short->short){
                                        // maka update short

                                        $__update_short = CompanyCheckShort::where('part_characteristic_value_id', $__checking_pcv->id)
                                            ->where('tbl_company_id', $company_id)
                                            ->first();

                                        $__update_short->short = $__short[$i];
                                        $__update_short->last_updated_by = $last_updated_by;
                                        $__update_short->save();
                                    }    
                                // jika belum masuk                
                                }else{

                                    // update dengan link_inc_characteristic_value yang sudah ada
                                    $__pcv = PartCharacteristicValue::where('id',$__part_char_value_id[$i])
                                    ->where('part_master_id', $part_master_id)
                                    ->first();

                                    $__pcv->link_inc_characteristic_value_id = $__checking_value->link_inc_characteristic_value_id;
                                    $__pcv->last_updated_by = $last_updated_by;
                                    $__pcv->save();

                                    // update short berdasarkan part_characteristic_value_id
                                    $__update_short = CompanyCheckShort::where('part_characteristic_value_id', $__part_char_value_id[$i])
                                        ->where('tbl_company_id', $company_id)
                                        ->first();

                                    $__update_short->short = $__short[$i];
                                    $__update_short->last_updated_by = $last_updated_by;
                                    $__update_short->save();

                                }          

                            // jika yang diinput adalah value baru (tidak ada) maka create dulu
                            }else{                   

                                $__licvData = [
                                    'link_inc_characteristic_id' => $__inc_char_id[$i],
                                    'value' => trim(strtoupper($__value[$i])),
                                    'created_by' => $created_by,
                                    'last_updated_by' => $last_updated_by,
                                ];           

                                if($__licv = LinkIncCharacteristicValue::create($__licvData)){
                                    // ambil id dan update part_characteristic_value
                                    $__pcv = PartCharacteristicValue::where('id',$__part_char_value_id[$i])
                                    ->where('part_master_id', $part_master_id)
                                    ->first();

                                    $__pcv->link_inc_characteristic_value_id = $__licv->id;
                                    $__pcv->last_updated_by = $last_updated_by;
                                    $__pcv->save();

                                    // update short berdasarkan part_characteristic_value_id
                                    $__update_short = CompanyCheckShort::where('part_characteristic_value_id', $__part_char_value_id[$i])
                                        ->where('tbl_company_id', $company_id)
                                        ->first();

                                    $__update_short->short = $__short[$i];
                                    $__update_short->last_updated_by = $last_updated_by;
                                    $__update_short->save();
                                }

                            }
                        
                        // jika value kosong 
                        }else{
                            // maka hapus dari part_characteristic_value
                            // dengan terlebih dahulu hapus record yang ber-relasi (CompanyCheckShort)
                            CompanyCheckShort::where('part_characteristic_value_id', $__part_char_value_id[$i])->delete();
                            PartCharacteristicValue::where('id',$__part_char_value_id[$i])->delete();
                        }

                    }
                }
                // END UPDATING


                // INSERTING
                if(!empty($_inc_char_id)){

                    // loop for array
                    foreach ($_inc_char_id as $i => $_values) {
                        
                        // check value
                        if(!empty($_value[$i])){
                                
                            // yang diambil value
                            // ==================

                            // cek apakah value yang diambil ada dalam link_inc_characteristic_value
                            // dengan syarat inc_id, characteristic_id, dan link_inc_characteristic_id
                            $_checking_value = LinkIncCharacteristicValue::join('link_inc_characteristic', 'link_inc_characteristic.id', '=', 'link_inc_characteristic_value.link_inc_characteristic_id')
                            ->where('link_inc_characteristic_id', $_inc_char_id[$i])                
                            ->where('tbl_inc_id', $inc_id)
                            ->where('tbl_characteristic_id', $_char_id[$i])
                            ->where('value', $_value[$i])
                            ->select('link_inc_characteristic_id','link_inc_characteristic_value.id as link_inc_characteristic_value_id','value')
                            ->first();

                            // jika ada
                            if (count($_checking_value) > 0) {

                                $_pcvData = [
                                    'part_master_id' => $part_master_id,
                                    'link_inc_characteristic_value_id' => $_checking_value->link_inc_characteristic_value_id,
                                    'created_by' => $created_by,
                                    'last_updated_by' => $last_updated_by,
                                ];            
                                // simpan dengan link_inc_characteristic_value_id yang sudah ada
                                if($_partCharacteristicValue = PartCharacteristicValue::create($_pcvData)){

                                    $_shortData = [
                                        'tbl_company_id' => $company_id,
                                        'part_characteristic_value_id' => $_partCharacteristicValue->id,
                                        'short' => $_short[$i],
                                        'created_by' => $created_by,
                                        'last_updated_by' => $last_updated_by,
                                    ];            
                                    // simpan dengan part_characteristic_valu_id yang baru saja dibuat
                                    $_companyCheckShort = CompanyCheckShort::create($_shortData);

                                }                                

                            // jika tidak ada
                            }else{                   
                                // maka buat value baru terlebih dahulu
                                $_licvData = [
                                    'link_inc_characteristic_id' => $_inc_char_id[$i],
                                    'value' => trim(strtoupper($_value[$i])),
                                    'created_by' => $created_by,
                                    'last_updated_by' => $last_updated_by,
                                ];            

                                // dan masukkan ke part_characteristic_value
                                if($_licv = LinkIncCharacteristicValue::create($_licvData)){
                                    $_pcvData = [
                                        'part_master_id' => $part_master_id,
                                        'link_inc_characteristic_value_id' => $_licv->id,
                                        'created_by' => $created_by,
                                        'last_updated_by' => $last_updated_by,
                                    ];            
                                    // simpan dengan $_licv->id yang baru saja dibuat 
                                    if($_partCharacteristicValue = PartCharacteristicValue::create($_pcvData)){

                                        $_shortData = [
                                            'tbl_company_id' => $company_id,
                                            'part_characteristic_value_id' => $_partCharacteristicValue->id,
                                            'short' => $_short[$i],
                                            'created_by' => $created_by,
                                            'last_updated_by' => $last_updated_by,
                                        ];            
                                        // simpan dengan part_characteristic_valu_id yang baru saja dibuat
                                        $_companyCheckShort = CompanyCheckShort::create($_shortData);

                                    }
                                }

                            }
                            
                        }

                    }
                }
                // END INSERTING

                // UPDATING PART MASTER INC_GROUP_CLASS_ID / jika inc atau group_class ganti
                // ambil data part master lama
                $old_part_master = PartMaster::select('link_inc_group_class_id','tbl_inc_id')
                    ->join('link_inc_group_class', 'link_inc_group_class.id', '=', 'part_master.link_inc_group_class_id')
                    ->where('part_master.id', $part_master_id)
                    ->first();

                // ambil link_inc_group_class_id baru
                $new_link_inc_group_class_id = LinkIncGroupClass::select('id')
                    ->where('tbl_inc_id', $inc_id)                
                    ->where('tbl_group_class_id', $group_class_id)
                    ->first();

                // jika tidak sama
                if($old_part_master->link_inc_group_class_id != $new_link_inc_group_class_id->id){
                    // jika inc beda
                    if($inc_id != $old_part_master->tbl_inc_id){

                        // ambil dulu id PartCharacteristicValue lama
                        $old_part_char_val_id = PartCharacteristicValue::select('id')
                        ->where('part_master_id', $part_master_id)
                        ->whereIn('link_inc_characteristic_value_id', function($query) use ($old_part_master){
                            $query->select('link_inc_characteristic_value.id')
                            ->from(with(new LinkIncCharacteristicValue)->getTable())
                            ->join('link_inc_characteristic', 'link_inc_characteristic.id', '=', 'link_inc_characteristic_value.link_inc_characteristic_id')
                            ->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_characteristic.tbl_inc_id')
                            ->where('tbl_inc_id', $old_part_master->tbl_inc_id);
                        })->get()->toArray();

                        // maka hapus short lama karena inc berbeda
                        CompanyCheckShort::whereIn('part_characteristic_value_id', $old_part_char_val_id)
                        ->delete();

                        // maka hapus value lama karena inc berbeda
                        PartCharacteristicValue::whereIn('id', $old_part_char_val_id)
                        ->delete();
                    }

                    // update dengan link_inc_group_class_id yang baru
                    $update_part_master = PartMaster::where('id', $part_master_id)
                    ->where('link_inc_group_class_id', $old_part_master->link_inc_group_class_id)
                    ->firstOrFail();

                    $update_part_master->link_inc_group_class_id = $new_link_inc_group_class_id->id;
                    $update_part_master->last_updated_by = $last_updated_by;
                    $update_part_master->save();
                }
                // END UPDATING PART MASTER INC_GROUP_CLASS_ID

                // ambil respones buat ngubah tabel
                $latest_part_master = PartMaster::select('item_name', 'inc', DB::raw('CONCAT(`group`, class) AS group_class'))
                ->join('link_inc_group_class', 'link_inc_group_class.id', '=', 'part_master.link_inc_group_class_id')
                ->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_group_class.tbl_inc_id')
                ->join('tbl_group_class', 'tbl_group_class.id', '=', 'link_inc_group_class.tbl_group_class_id')
                ->join('tbl_group', 'tbl_group.id', '=', 'tbl_group_class.tbl_group_id')
                ->where('part_master.id', $part_master_id)->first();

                return Response::json($latest_part_master);

            });
            
            // response
            return $return;

        }
        
    }

    public function getPartManufacturerCode($partMasterId){
        $partManufacturerCode = PartManufacturerCode::select('part_manufacturer_code.id','manufacturer_code','tbl_source_type.type AS source_type','manufacturer_ref','tbl_part_manufacturer_code_type.type')
        ->join('part_master', 'part_master.id', '=', 'part_manufacturer_code.part_master_id')
        ->join('tbl_manufacturer_code', 'tbl_manufacturer_code.id', '=', 'part_manufacturer_code.tbl_manufacturer_code_id')
        ->join('tbl_source_type', 'tbl_source_type.id', '=', 'part_manufacturer_code.tbl_source_type_id')
        ->join('tbl_part_manufacturer_code_type', 'tbl_part_manufacturer_code_type.id', '=', 'part_manufacturer_code.tbl_part_manufacturer_code_type_id')
        ->where('part_master_id', $partMasterId);

        return Datatables::of($partManufacturerCode)
            ->editColumn('type', '{{$type}} <span class="pull-right"><kbd data-id="{{$id}}" class="kbd-primary hover edit-pmc cpointer">EDIT</kbd> <kbd data-id="{{$id}}" class="kbd-danger hover delete-pmc cpointer">DELETE</kbd></span>')
            ->setRowId('id')
            ->make(true);
    }

    public function selectManufacturerCode(Request $request){
        return TblManufacturerCode::select('id','manufacturer_code','manufacturer_name')
        ->where('manufacturer_code', 'like', '%'.$request->q.'%')
        ->orWhere('manufacturer_name', 'like', '%'.$request->q.'%')
        ->get();
    }

    public function getSourceType(){
        return TblSourceType::select('id','type','description')->get();
    }

    public function getPartManufacturerCodeType(){
        return TblPartManufacturerCodeType::select('id','type','description')->get();
    }

    public function addPartManufacturerCode(Request $request)
    {
        $this->validate($request, [
            'part_master_id'                     => 'required',
            'tbl_manufacturer_code_id'           => 'required',
            'tbl_source_type_id'                 => 'required',
            'manufacturer_ref'                   => 'required|max:100',
            'tbl_part_manufacturer_code_type_id' => 'required'
        ]);

        $request = [
            'part_master_id' => $request->part_master_id,
            'tbl_manufacturer_code_id' => $request->tbl_manufacturer_code_id,
            'tbl_source_type_id' => $request->tbl_source_type_id,
            'manufacturer_ref' => strtoupper(trim($request->manufacturer_ref)),
            'tbl_part_manufacturer_code_type_id' => $request->tbl_part_manufacturer_code_type_id,
            'created_by' => $request->created_by,
            'last_updated_by' => $request->last_updated_by,
        ];  

        $partManufacturerCode = PartManufacturerCode::create($request);
        return Response::json($partManufacturerCode);
    }

    public function editPartManufacturerCode($id){
        return PartManufacturerCode::select('part_manufacturer_code.id as id','tbl_manufacturer_code_id','tbl_source_type_id','manufacturer_code','manufacturer_ref','tbl_part_manufacturer_code_type_id','manufacturer_name','tbl_source_type.type as source','tbl_part_manufacturer_code_type.type as type')
        ->join('tbl_manufacturer_code', 'tbl_manufacturer_code.id', '=', 'part_manufacturer_code.tbl_manufacturer_code_id')
        ->join('tbl_source_type', 'tbl_source_type.id', '=', 'part_manufacturer_code.tbl_source_type_id')
        ->join('tbl_part_manufacturer_code_type', 'tbl_part_manufacturer_code_type.id', '=', 'part_manufacturer_code.tbl_part_manufacturer_code_type_id')
        ->find($id);
    }

    public function updatePartManufacturerCode(Request $request)
    {
        $this->validate($request, [
            'part_master_id'                     => 'required',
            'tbl_manufacturer_code_id'           => 'required',
            'tbl_source_type_id'                 => 'required',
            'manufacturer_ref'                   => 'required|max:100',
            'tbl_part_manufacturer_code_type_id' => 'required'
        ]);

        $partManufacturerCode = PartManufacturerCode::find($request->id);

        $partManufacturerCode->part_master_id                        = $request->part_master_id;
        $partManufacturerCode->tbl_manufacturer_code_id              = $request->tbl_manufacturer_code_id;
        $partManufacturerCode->tbl_source_type_id                    = $request->tbl_source_type_id;
        $partManufacturerCode->manufacturer_ref                      = strtoupper(trim($request->manufacturer_ref));
        $partManufacturerCode->tbl_part_manufacturer_code_type_id    = $request->tbl_part_manufacturer_code_type_id;
        $partManufacturerCode->last_updated_by                       = $request->last_updated_by;

        $partManufacturerCode->save();
        return Response::json($partManufacturerCode);
    }

    public function deletePartManufacturerCode($id)
    {
        $partManufacturerCode = PartManufacturerCode::destroy($id);
        return Response::json($partManufacturerCode);
    }

    public function getPartColloquial($partMasterId){
        $partColloquial = PartColloquial::select('part_colloquial.id','colloquial')
        ->join('tbl_colloquial', 'tbl_colloquial.id', '=', 'part_colloquial.tbl_colloquial_id')
        ->where('part_master_id', $partMasterId);

        return Datatables::of($partColloquial)
            ->editColumn('colloquial', '<span class="colloquial">{{$colloquial}}</span> <span class="pull-right"><kbd data-id="{{$id}}" class="kbd-primary hover cpointer edit-pc">EDIT</kbd> <kbd data-id="{{$id}}" class="kbd-danger hover cpointer delete-pc">DELETE</kbd></span>')
            ->setRowId('id')
            ->make(true);
    }

    public function addPartColloquial(Request $request)
    {
        $this->validate($request, [
            'colloquial'     => 'required|max:255',
            'part_master_id' => 'required',
        ]);

        $check_colloquial = TblColloquial::where('colloquial', strtoupper(trim($request->colloquial)))
                        ->select('id')
                        ->first();

        $id = Auth::user()->id;
        if(count($check_colloquial) > 0){
            $insertRequest = [
                'tbl_colloquial_id' => 11,
                'part_master_id' => $request->part_master_id,                
                'created_by' => $id,
                'last_updated_by' => $id,
            ];  

            $partColloquial = PartColloquial::create($insertRequest);            
        }else{            
            $colloquial = [
                'colloquial' => strtoupper(trim($request->colloquial)),
                'created_by' => $id,
                'last_updated_by' => $id,
            ];  

            if($tblColloquial = TblColloquial::create($colloquial)){
                $insertRequest = [
                    'tbl_colloquial_id' => $tblColloquial->id,
                    'part_master_id' => $request->part_master_id,                
                    'created_by' => $request->created_by,
                    'last_updated_by' => $request->last_updated_by,
                ]; 

                $partColloquial = PartColloquial::create($insertRequest);
            }            
        }
        return Response::json($partColloquial);
    }

    public function updatePartColloquial(Request $request)
    {
        $this->validate($request, [
            'colloquial'     => 'required|max:255',
            'part_master_id' => 'required',
        ]);

        $check_colloquial = TblColloquial::where('colloquial', strtoupper(trim($request->colloquial)))
                        ->select('id')
                        ->first();

        $id = Auth::user()->id;
        if(count($check_colloquial) > 0){

            $partColloquial = PartColloquial::find($request->id);

            $partColloquial->part_master_id     = $request->part_master_id;
            $partColloquial->tbl_colloquial_id  = $check_colloquial->id;
            $partColloquial->last_updated_by    = $request->last_updated_by;

            $partColloquial->save();

        }else{

            $colloquial = [
                'colloquial' => strtoupper(trim($request->colloquial)),
                'created_by' => $id,
                'last_updated_by' => $id,
            ];  

            if($tblColloquial = TblColloquial::create($colloquial)){
                $partColloquial = PartColloquial::find($request->id);

                $partColloquial->part_master_id     = $request->part_master_id;
                $partColloquial->tbl_colloquial_id  = $tblColloquial->id;
                $partColloquial->last_updated_by    = $request->last_updated_by;

                $partColloquial->save();
            } 

            
        }

        return Response::json($partColloquial);
    }

    public function deletePartColloquial($id)
    {
        $partColloquial = PartColloquial::destroy($id);
        return Response::json($partColloquial);
    }

    public function getPartEquipmentCode($partMasterId){
        $partPartEquipmentCode = PartEquipmentCode::select('part_equipment_code.id','part_master_id','tbl_equipment_code_id','equipment_code','equipment_name','qty_install','doc_ref','dwg_ref','tbl_manufacturer_code_id','manufacturer_code')
        ->join('tbl_equipment_code', 'tbl_equipment_code.id', '=', 'part_equipment_code.tbl_equipment_code_id')
        ->join('tbl_manufacturer_code', 'tbl_manufacturer_code.id', '=', 'part_equipment_code.tbl_manufacturer_code_id')
        ->where('part_master_id', $partMasterId);

        return Datatables::of($partPartEquipmentCode)
            ->editColumn('dwg_ref', '<span class="dwg_ref">{{$dwg_ref}}</span> <span class="pull-right"><kbd data-id="{{$id}}" class="kbd-primary hover cpointer edit-pec">EDIT</kbd> <kbd data-id="{{$id}}" class="kbd-danger hover cpointer delete-pec">DELETE</kbd></span>')
            ->setRowId('id')
            ->make(true);
    }

    public function selectEquipmentCode(Request $request){
        return TblEquipmentCode::select('id','equipment_code','equipment_name')
        ->where('equipment_code', 'like', '%'.$request->q.'%')
        ->orWhere('equipment_name', 'like', '%'.$request->q.'%')
        ->get();
    }

    public function addPartEquipmentCode(Request $request)
    {        
        $this->validate($request, [
            'part_master_id'            => 'required',
            'tbl_equipment_code_id'     => 'required',
            'qty_install'               => 'required|numeric|max:9999',
            'tbl_manufacturer_code_id'  => 'required',
            'doc_ref'                   => 'required_without:dwg_ref|max:255',
            'dwg_ref'                   => 'required_without:doc_ref|max:255',
            'created_by'                => 'required',
            'last_updated_by'           => 'required',
        ]);

        $request = [
            'part_master_id'            => $request->part_master_id,
            'tbl_equipment_code_id'     => $request->tbl_equipment_code_id,
            'qty_install'               => trim($request->qty_install),
            'tbl_manufacturer_code_id'  => $request->tbl_manufacturer_code_id,
            'doc_ref'                   => strtoupper(trim($request->doc_ref)),
            'dwg_ref'                   => strtoupper(trim($request->dwg_ref)),
            'created_by'                => $request->created_by,
            'last_updated_by'           => $request->last_updated_by,
        ];  

        $partPartEquipmentCode = PartEquipmentCode::create($request);
        return Response::json($partPartEquipmentCode);
    }

    public function editPartEquipmentCode($id)
    {
        $partEquipmentCode = PartEquipmentCode::select('tbl_equipment_code_id', 'equipment_code', 'equipment_name', 'qty_install', 'doc_ref', 'dwg_ref', 'tbl_manufacturer_code_id',
            'manufacturer_code', 'manufacturer_name')
            ->join('tbl_equipment_code', 'tbl_equipment_code.id', '=', 'part_equipment_code.tbl_equipment_code_id')
            ->join('tbl_manufacturer_code', 'tbl_manufacturer_code.id', '=', 'part_equipment_code.tbl_manufacturer_code_id')
            ->find($id);
        return Response::json($partEquipmentCode);
    }

    public function updatePartEquipmentCode(Request $request)
    {
        $this->validate($request, [
            'tbl_equipment_code_id'     => 'required',
            'qty_install'               => 'required|numeric|max:9999',
            'tbl_manufacturer_code_id'  => 'required',
            'doc_ref'                   => 'required_without:dwg_ref|max:255',
            'dwg_ref'                   => 'required_without:doc_ref|max:255',
            'created_by'                => 'required',
            'last_updated_by'           => 'required',
        ]);

        $partEquipmentCode = PartEquipmentCode::find($request->id);

        $partEquipmentCode->tbl_equipment_code_id       = $request->tbl_equipment_code_id;
        $partEquipmentCode->qty_install                 = trim($request->qty_install);
        $partEquipmentCode->doc_ref                     = strtoupper(trim($request->doc_ref));
        $partEquipmentCode->dwg_ref                     = strtoupper(trim($request->dwg_ref));
        $partEquipmentCode->tbl_manufacturer_code_id    = $request->tbl_manufacturer_code_id;
        $partEquipmentCode->last_updated_by             = $request->last_updated_by;

        $partEquipmentCode->save();
        return Response::json($partEquipmentCode);
    }

    public function deletePartEquipmentCode($id)
    {
        $partEquipmentCode = PartEquipmentCode::destroy($id);
        return Response::json($partEquipmentCode);
    }

    public function inc($inc)
    {
        return TblInc::select('inc', 'item_name')
            ->where('inc', $inc)->first();
    }

    public function nsc($inc)
    {
        return LinkIncNsc::select('link_inc_nsc.nsc', 'title')
            ->join('tbl_nsc_group_class', 'tbl_nsc_group_class.nsc', '=', 'link_inc_nsc.nsc')
            ->where('inc', $inc)->get();
    }

    public function charval($inc)
    {
        return LinkIncChar::select('characteristic')
            ->where('inc', $inc)
            ->orderBy('sequence', 'asc')->get();
    }    

    public function selectManCode()
    {
        $JsonSelect = new JsonSelect();
        return $JsonSelect->jsonSource(url('home/man-code'), 'man_code');
    }

    public function getManName($hex)
    {
        $converters = new Converters();
        $manCode = $converters->Hex2String($hex);
        return TblManCode::select('company_name')->where('man_code', $manCode)->first()->company_name;
    }

    public function addPartManCode(Request $request)
    {
        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $partManCode = PartManCode::create($request3);
        return Response::json($partManCode);
    }

    public function updatePartManCode(Request $request, $partManCodeId)
    {
        $partManCode = PartManCode::find($partManCodeId);

        $partManCode->man_code          = strtoupper($request->man_code);
        $partManCode->source_type       = strtoupper($request->source_type);
        $partManCode->man_ref           = strtoupper($request->man_ref);
        $partManCode->spn               = strtoupper($request->spn);
        $partManCode->type              = strtoupper($request->type);
        $partManCode->last_updated_by   = $request->last_updated_by;

        $partManCode->save();

        return Response::json($partManCode);
    }

    public function deletePartManCode($partManCodeId)
    {
        $partManCode = PartManCode::destroy($partManCodeId);
        return Response::json($partManCode);
    }

    public function getCommodityInformation($catalogNo)
    {
        return PartMaster::select(
                    'catalog_type','stock_type','conversion',
                    'unit_issue','unit_purchase','weight_value',
                    'weight_unit','average_unit_price',
                    'stock_on_hand','stock_on_hand_unit','item_type'
                    )
        ->where('catalog_no', $catalogNo)->first();
    }

    public function selectItemType()
    {
        $JsonSelect = new JsonSelect();
        return $JsonSelect->jsonSource(url('home/item-type'), 'type');
    }

    public function getCommodityInformationDetail($catalogNo)
    {
        return PartMaster::select(
            'catalog_no','item_type','stock_type',
            'unit_issue','unit_purchase','weight_unit',
            'stock_on_hand_unit'
            )
            ->with('tblItemType')
            ->with('tblStockType')
            ->with('tblUnitMeasurementIssue')
            ->with('tblUnitMeasurementPurchase')
            ->with('tblUnitMeasurementSohUnit')
            ->where('catalog_no', $catalogNo)->first();
    }

    /*public function getPartColloquial($catalogNo)
    {
        return PartColloquial::where('catalog_no', $catalogNo)->get();
    }

    public function addPartColloquial(Request $request)
    {
        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $partColloquial = PartColloquial::create($request3);
        return Response::json($partColloquial);
    }

    public function updatePartColloquial(Request $request, $partColloquialId)
    {
        $partColloquial = PartColloquial::find($partColloquialId);

        $partColloquial->colloquial        = strtoupper($request->colloquial);
        $partColloquial->last_updated_by   = $request->last_updated_by;

        $partColloquial->save();

        return Response::json($partColloquial);
    }

    public function deletePartColloquial($partColloquialId)
    {
        $partColloquial = PartColloquial::destroy($partColloquialId);
        return Response::json($partColloquial);
    }*/

    public function getPartBinLocation($catalogNo)
    {
        return PartBinLocation::where('catalog_no', $catalogNo)->get();
    }

    public function selectPlantPbl($hexCompany)
    {
        $jsonSelect = new JsonSelect();
        return $jsonSelect->jsonSource(url('home/plant-pbl/' . $hexCompany), 'plant');
    }

    public function selectLocationPbl($hexPlant)
    {
        $jsonSelect = new JsonSelect();
        return $jsonSelect->jsonSource(url('home/location-pbl/' . $hexPlant), 'location');
    }

    public function selectShelfPbl($hexLocation)
    {
        $jsonSelect = new JsonSelect();
        return $jsonSelect->jsonSource(url('home/shelf-pbl/' . $hexLocation), 'shelf');
    }

    public function selectBinPbl($hexShelf)
    {
        $jsonSelect = new JsonSelect();
        return $jsonSelect->jsonSource(url('home/bin-pbl/' . $hexShelf), 'bin');
    }

    public function getPartBinLocationDescription($id)
    {
        return PartBinLocation::select('plant','location','shelf','bin')
            ->with('tblPlant')
            ->with('tblLocation')
            ->with('tblShelf')
            ->with('tblBin')
            ->where('id', $id)->first();
    }

    public function addPartBinLocation(Request $request)
    {
        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $partBinLocation = PartBinLocation::create($request3);
        return Response::json($partBinLocation);
    }

    public function updatePartBinLocation(Request $request, $partBinLocationId)
    {
        $partBinLocation = PartBinLocation::find($partBinLocationId);

        $partBinLocation->plant           = strtoupper($request->plant);
        $partBinLocation->location        = strtoupper($request->location);
        $partBinLocation->shelf           = strtoupper($request->shelf);
        $partBinLocation->bin             = strtoupper($request->bin);
        $partBinLocation->last_updated_by = $request->last_updated_by;

        $partBinLocation->save();

        return Response::json($partBinLocation);
    }

    public function deletePartBinLocation($partBinLocationId)
    {
        $partBinLocation = PartBinLocation::destroy($partBinLocationId);
        return Response::json($partBinLocation);
    }

    public function getPartSourceDescription($partMasterId)
    {
        return PartSourceDescription::select('catalog_no', 'inc', 'item_name', 'group_class', 'uom', 'source')
            ->join('part_master', 'part_master.id', '=', 'part_source_description.part_master_id')
            ->where('part_master_id', $partMasterId)->first();
    }

    public function getPartSourcePartNo($partMasterId)
    {
        return PartSourcePartNo::select('catalog_no', 'manufacturer_code', 'manufacturer', 'manufacturer_ref', 'ref_type')
            ->join('part_master', 'part_master.id', '=', 'part_source_part_no.part_master_id')
            ->where('part_master_id', $partMasterId)->get();
    }
}