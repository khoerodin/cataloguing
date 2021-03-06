<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Vinkla\Hashids\Facades\Hashids;

use DB;
use Datatables;
use Response;
use Auth;

use App\Models\CompanyValue;
use App\Models\CompanyCharacteristic;
use App\Models\CompanyShortDescriptionFormat;
use App\Models\LinkIncCharacteristic;
use App\Models\LinkIncCharacteristicValue;
use App\Models\ShortDescriptionFormat;
use App\Models\TblBin;
use App\Models\TblShelf;
use App\Models\TblLocation;
use App\Models\TblPlant;
use App\Models\TblPoStyle;
use App\Models\TblCharacteristic;
use App\Models\TblCompany;
use App\Models\TblHolding;
use App\Models\TblEquipmentCode;
use App\Models\TblCatalogStatus;
use App\Models\TblCatalogType;
use App\Models\TblHarmonizedCode;
use App\Models\TblHazardClass;
use App\Models\TblItemType;
use App\Models\TblSourceType;
use App\Models\TblStockType;
use App\Models\TblUnitOfMeasurement;
use App\Models\TblUserClass;
use App\Models\TblWeightUnit;

use MetaTag;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        MetaTag::set('title', 'SETTINGS &lsaquo; CATALOG Web App');
        MetaTag::set('description', 'Settings page');

        return view('settings');
    }

    // HOLDING - BIN Tab

    public function selectHolding(Request $request)
    {
        return TblHolding::select('id as tbl_holding_id', 'holding')
            ->where('holding', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectCompany($holdingId, Request $request)
    {
        return TblCompany::select('id as tbl_company_id', 'company')
            ->where('tbl_holding_id', Hashids::decode($holdingId)[0])
            ->where('company', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectPlant($companyId, Request $request)
    {
        return TblPlant::select('id as tbl_plant_id', 'plant')
            ->where('tbl_company_id', Hashids::decode($companyId)[0])
            ->where('plant', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectLocation($plantId, Request $request)
    {
        return TblLocation::select('id as tbl_location_id', 'location')
            ->where('tbl_plant_id', Hashids::decode($plantId)[0])
            ->where('location', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSHelf($locationId, Request $request)
    {
        return TblShelf::select('id as tbl_shelf_id', 'shelf')
            ->where('tbl_location_id', Hashids::decode($locationId)[0])
            ->where('shelf', 'like', '%'.$request->q.'%')
            ->get();
    }
    
    // CHARACTERISTICS VALUE
    public function getChar($incId,$companyId)
    {
        return CompanyCharacteristic::select('company_characteristic.id as company_characteristic_id', 'link_inc_characteristic_id', 'characteristic', 'custom_char_name', 'style_name', 'hidden')
            ->join('link_inc_characteristic', 'link_inc_characteristic.id', '=', 'company_characteristic.link_inc_characteristic_id')
            ->join('tbl_characteristic', 'tbl_characteristic.id', '=', 'link_inc_characteristic.tbl_characteristic_id')
            ->join('tbl_po_style', 'tbl_po_style.id', '=', 'company_characteristic.tbl_po_style_id')
            ->where('tbl_inc_id', Hashids::decode($incId)[0])
            ->where('tbl_company_id', Hashids::decode($companyId)[0])
            ->orderBy('company_characteristic.sequence')
            ->get();
    } 

    public function updateCharValOrder(Request $request)
    {
        $no = 1;
        $reponse = [];
        foreach ($request->id as $company_char_id) {
            $update = CompanyCharacteristic::find(Hashids::decode($company_char_id)[0]);

            $update->sequence = $no++;
            $update->last_updated_by  = Auth::user()->id;
            $reponse[] = $update->save();
        }
        return Response::json($reponse);
    }

    public function updateCharVisibility(Request $request)
    {
        $cc = CompanyCharacteristic::where('id', Hashids::decode($request->id)[0])
            ->select('hidden')
            ->first();

        $update = CompanyCharacteristic::find(Hashids::decode($request->id)[0]);
        if($cc->hidden == 0){            
            $update->hidden = 1;           
        }else{
            $update->hidden = 0;
        }
        $update->last_updated_by  = Auth::user()->id;

        return Response::json($update->save());
    }

    public function editCompanyChar($id)
    {
        return CompanyCharacteristic::where('company_characteristic.id', Hashids::decode($id)[0])
            ->join('tbl_po_style', 'tbl_po_style.id', '=', 'company_characteristic.tbl_po_style_id')
            ->select('company_characteristic.id as company_characteristic_id','custom_char_name','style_name','tbl_po_style_id')
            ->first();
    }

    public function getPoStyle()
    {
        return TblPoStyle::select('id as tbl_po_style_id','style_name')->get();
    }

    public function updateCompanyChar(Request $request)
    {
        $update = CompanyCharacteristic::find(Hashids::decode($request->id)[0]);
        $update->custom_char_name = trim(strtoupper($request->custom_name));
        $update->tbl_po_style_id = Hashids::decode($request->po_style)[0];
        $update->last_updated_by  = Auth::user()->id;

        return Response::json($update->save());
    }

    public function getCharValue($licId,$companyId)
    {
        return LinkIncCharacteristicValue::select('link_inc_characteristic_value.id as link_inc_characteristic_value_id', 'company_value.id as company_value_id', 'value','custom_value_name','company_value.abbrev','company_value.approved')
            ->join('company_value', 'company_value.link_inc_characteristic_value_id', '=', 'link_inc_characteristic_value.id')
            ->where('link_inc_characteristic_id', Hashids::decode($licId)[0])
            ->where('tbl_company_id', Hashids::decode($companyId)[0])
            ->orderBy('value')
            ->get();       
    }

    private function updateLicValue($licvId,$charValue)
    {
        $value = LinkIncCharacteristicValue::find($licvId);
        $value->value = trim(strtoupper($charValue));
        $value->last_updated_by  = Auth::user()->id;
        return $value->save();
    }

    private function updateCompanyValue($licvId,$companyId,$customValueName,$valueAbbrev,$approved)
    {
        $value = CompanyValue::where('link_inc_characteristic_value_id', $licvId)
            ->where('tbl_company_id', $companyId)->first();
        $value->custom_value_name = trim(strtoupper($customValueName));
        $value->abbrev = trim(strtoupper($valueAbbrev));
        $value->approved = $approved;
        $value->last_updated_by  = Auth::user()->id;
        return $value->save();
    }

    public function updateValue(Request $request)
    {
        $this->validate($request, [
            'charValue' => 'required',
            'approved' => 'integer|required',
        ]);  

        $reponse[] = $this->updateLicValue(Hashids::decode($request->licvId)[0],$request->charValue);
        $reponse[] = $this->updateCompanyValue(Hashids::decode($request->licvId)[0],Hashids::decode($request->companyId)[0],$request->customValueName,$request->valueAbbrev,$request->approved);

        if($request->valueAbbrev != NULL && $request->approved != NULL){
            $abbrev = LinkIncCharacteristicValue::where('id',Hashids::decode($request->licvId)[0])->first()->abbrev;
            $approved = LinkIncCharacteristicValue::where('id',Hashids::decode($request->licvId)[0])->first()->approved;
            if($abbrev == NULL OR $approved == NULL){
                $licv = LinkIncCharacteristicValue::find(Hashids::decode($request->licvId)[0]);
                $licv->abbrev = trim(strtoupper($request->valueAbbrev));
                $licv->approved = trim(strtoupper($request->approved));
                $licv->last_updated_by  = Auth::user()->id;
                $reponse[] = $licv->save();
            }
        }

        return Response::json($reponse);
    }

    public function deleteValue($cvid,$licvid)
    {
        $delete1 = CompanyValue::where('id',Hashids::decode($cvid)[0])->delete();
        if($delete1){
            $delete2 = LinkIncCharacteristicValue::where('id',Hashids::decode($licvid)[0])->delete();
            return Response::json($delete2);
        }      
    }

    public function addCharValue(Request $request)
    {
        $this->validate($request, [
            'char_value'    => 'required|max:30'
        ]);

        $licv = LinkIncCharacteristicValue::select('id')
            ->where('link_inc_characteristic_id', Hashids::decode($request->licId)[0])
            ->where('value', trim(strtoupper($request->char_value)))
            ->first();
        
        if(count($licv)>0){
            $licv = $licv;
        }else{

            $licv = [
                'link_inc_characteristic_id' => Hashids::decode($request->licId)[0],
                'value' => trim(strtoupper($request->char_value)),
                'abbrev' => trim(strtoupper($request->value_abbrev)),
                'approved' => $request->approved,
                'created_by' => Auth::user()->id,
                'last_updated_by' => Auth::user()->id,
            ];           

            $licv = LinkIncCharacteristicValue::create($licv);

        }

        $checkCv = CompanyValue::where('tbl_company_id', Hashids::decode($request->companyId)[0])
            ->where('link_inc_characteristic_value_id', $licv->id)
            ->first();        

        $cv = [
            'tbl_company_id' => Hashids::decode($request->companyId)[0],
            'link_inc_characteristic_value_id' => $licv->id,
            'custom_value_name' => trim(strtoupper($request->custom_value_name)),
            'abbrev' => trim(strtoupper($request->value_abbrev)),
            'approved' => $request->approved,
            'created_by' => Auth::user()->id,
            'last_updated_by' => Auth::user()->id,
        ];           

        if(count($checkCv)>0){
            return 'true';
        }else{
            return CompanyValue::create($cv);
        }
        
    }
    // END CHARACTERISTICS VALUE

    // SHORT DESCRIPTION FORMAT
    public function getShortDesc($incId,$companyId)
    {
        return CompanyShortDescriptionFormat::select('company_short_description_format.id as company_short_description_format_id','characteristic', 'company_short_description_format.short_separator','company_short_description_format.hidden')
            ->join('company_characteristic', 'company_characteristic.id', '=', 'company_short_description_format.company_characteristic_id')
            ->join('link_inc_characteristic', 'link_inc_characteristic.id', '=', 'company_characteristic.link_inc_characteristic_id')
            ->join('tbl_characteristic', 'tbl_characteristic.id', '=', 'link_inc_characteristic.tbl_characteristic_id')
            ->where('tbl_inc_id', Hashids::decode($incId)[0])
            ->where('tbl_company_id', Hashids::decode($companyId)[0])
            ->orderBy('company_short_description_format.sequence')
            ->get();
    }

    public function updateShortDescOrder(Request $request)
    {
        $no = 1;
        $response = [];
        foreach ($request->csid as $id) {
            $update = CompanyShortDescriptionFormat::find(Hashids::decode($id)[0]);
            $update->sequence = $no++;
            $update->last_updated_by  = Auth::user()->id;
            $response[] = $update->save();
        }
        return $response;
    }

    public function updateShortVisibility(Request $request)
    {
        $cc = CompanyShortDescriptionFormat::where('id', Hashids::decode($request->id)[0])
            ->select('hidden')
            ->first();

        $update = CompanyShortDescriptionFormat::find(Hashids::decode($request->id)[0]);
        if($cc->hidden == 0){            
            $update->hidden = 1;            
        }else{
            $update->hidden = 0;
        }
        $update->last_updated_by  = Auth::user()->id;

        return Response::json($update->save());
    }

    public function updateShortSeparator(Request $request)
    {
        $update = CompanyShortDescriptionFormat::find(Hashids::decode($request->id)[0]);

        $update->short_separator  = trim(strtoupper($request->separator));
        $update->last_updated_by  = Auth::user()->id;

        $update->save();
        return Response::json($update);
    }
    // END SHORT DESCRIPTION FORMAT

    // CATALOG STATUS DataTables
    public function datatablesCatalogStatus()
    {   
        DB::statement(DB::raw('set @rownum=0'));
        $tblCatalogStatus = TblCatalogStatus::select(
            [DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id as tbl_catalog_status_id','status','description','created_at']);
        
        return Datatables::of($tblCatalogStatus)
            ->editColumn('description', '<span class="description">{{$description}}</span><span style="right: 13px;position: absolute;"><kbd class="kbd-danger hover cpointer delete-cs" data-id="{{$tbl_catalog_status_id}}">DELETE</kbd> <kbd class="kbd-primary hover cpointer edit-cs" data-id="{{$tbl_catalog_status_id}}">EDIT</kbd></span>')
            ->setRowId('tbl_catalog_status_id')
            ->make(true);
    }

    public function addCatalogStatus(Request $request)
    {   
        $this->validate($request, [
            'status'      => 'required|max:20|unique:tbl_catalog_status,status',
            'description' => 'required|max:255'
        ]);

        $request = [
            'status' => trim($request->status),
            'description' => trim($request->description),
            'created_by' => Auth::user()->id,
            'last_updated_by' => Auth::user()->id,
        ];  

        TblCatalogStatus::create($request);
        return Response::json('ok');
    }

    public function updateCatalogStatus(Request $request, $id)
    {
        $this->validate($request, [
            'status'      => 'required|max:20|unique:tbl_catalog_status,status,'.Hashids::decode($id)[0].',id',
            'description' => 'required|max:255'
        ]);

        $tblCatalogStatus = TblCatalogStatus::find(Hashids::decode($id)[0]);

        $tblCatalogStatus->status          = strtoupper($request->status);
        $tblCatalogStatus->description     = strtoupper($request->description);
        $tblCatalogStatus->last_updated_by = Auth::user()->id;

        $tblCatalogStatus->save();
        return Response::json('ok');
    }

    public function deleteCatalogStatus($id)
    {
        $tblCatalogStatus = TblCatalogStatus::where('id', Hashids::decode($id)[0])->delete();
        return Response::json($tblCatalogStatus);
    }

    // EQUIPMENT CODE DataTables
    public function datatablesEquipmentCode(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $tblEquipmentCode = TblEquipmentCode::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'tbl_equipment_code.id as tbl_equipment_code_id','tbl_equipment_code.equipment_code',
            'tbl_equipment_code.equipment_name','tbl_equipment_code.created_at'])

            ->join('tbl_company', 'tbl_company.id', '=', 'tbl_equipment_code.tbl_company_id')
            ->join('tbl_plant', 'tbl_plant.id', '=', 'tbl_equipment_code.tbl_plant_id')
            ->join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')
            
            ->SearchHolding($request->holdingId)
            ->SearchCompany($request->companyId)
            ->SearchPlant($request->plantId);

        return Datatables::of($tblEquipmentCode)
            ->editColumn('equipment_name', '<span class="equipment_name">{{$equipment_name}}</span><span style="right: 13px;position: absolute;"><kbd class="kbd-danger hover cpointer delete-eq" data-id="{{$tbl_equipment_code_id}}">DELETE</kbd> <kbd class="kbd-primary hover cpointer edit-eq" data-id="{{$tbl_equipment_code_id}}">EDIT</kbd></span>')
            ->setRowId('tbl_equipment_code_id')
            ->make(true);
    }

    public function addEquipmentCode(Request $request)
    {        
        $this->validate($request, [            
            'equipment_code' => 'required|max:50|unique:tbl_equipment_code,equipment_code',
            'equipment_name' => 'required|max:255|unique:tbl_equipment_code,equipment_name',
            'tbl_company_id'   => 'required',
            'tbl_plant_id'   => 'required'
        ]);

        $request = [
            'equipment_code' => strtoupper(trim($request->equipment_code)),
            'equipment_name' => strtoupper(trim($request->equipment_name)),
            'tbl_company_id' => Hashids::decode($request->tbl_company_id)[0],
            'tbl_plant_id' => Hashids::decode($request->tbl_plant_id)[0],
            'created_by' => Auth::user()->id,
            'last_updated_by' => Auth::user()->id,
        ];  

        TblEquipmentCode::create($request);
        return Response::json('ok');
    }

    public function editEquipmentCode($id)
    {
        return TblEquipmentCode::select([
            // 'tbl_equipment_code.id as tbl_equipment_code_id',
            'tbl_holding.id as tbl_holding_id','tbl_holding.holding',
            'tbl_company.id as tbl_company_id','tbl_company.company',
            'tbl_plant.id as tbl_plant_id','tbl_plant.plant',
            'tbl_equipment_code.equipment_code','tbl_equipment_code.equipment_name'])

            ->join('tbl_plant', 'tbl_plant.id', '=', 'tbl_equipment_code.tbl_plant_id')
            ->join('tbl_company', 'tbl_company.id', '=', 'tbl_plant.tbl_company_id')
            ->join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')            
            ->where('tbl_equipment_code.id', Hashids::decode($id)[0])->first();
    }

    public function updateEquipmentCode(Request $request, $id)
    {
        $id = Hashids::decode($id)[0];
        $this->validate($request, [
            'equipment_code' => 'required|max:50|unique:tbl_equipment_code,equipment_code,'.$id.',id',
            'equipment_name' => 'required|max:255|unique:tbl_equipment_code,equipment_name,'.$id.',id',
            'tbl_company_id'   => 'required',
            'tbl_plant_id'   => 'required',
        ]);

        $tblEquipmentCode = TblEquipmentCode::find($id);
        
        $tblEquipmentCode->equipment_code  = strtoupper($request->equipment_code);
        $tblEquipmentCode->equipment_name  = strtoupper($request->equipment_name);
        $tblEquipmentCode->tbl_company_id    = Hashids::decode($request->tbl_company_id)[0];
        $tblEquipmentCode->tbl_plant_id    = Hashids::decode($request->tbl_plant_id)[0];
        $tblEquipmentCode->last_updated_by = Auth::user()->id;

        $tblEquipmentCode->save();
        return Response::json('ok');
    }

    public function deleteEquipmentCode($id)
    {
        $tblEquipmentCode = TblEquipmentCode::where('id', Hashids::decode($id)[0])->delete();
        return Response::json($tblEquipmentCode);
    }

    // HARMONIZED CODE DataTables
    public function datatablesHarmonizedCode()
    {   
        DB::statement(DB::raw('set @rownum=0'));
        $tblHarmonizedCode = TblHarmonizedCode::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id','code','description','created_at']);
        return Datatables::of($tblHarmonizedCode)
            ->addColumn('action', function ($tblHarmonizedCode) {
                return '<span class="pull-right"><kbd class="kbd-primary cpointer edit-hrc" data-id="'.$tblHarmonizedCode->id.'">EDIT</kbd>&nbsp;&nbsp;<kbd class="kbd-danger cpointer delete-hrc" data-id="'.$tblHarmonizedCode->id.'">DELETE</kbd></span>';
            })
            ->setRowId('id')
            ->make(true);
    }

    public function addHarmonizedCode(Request $request)
    {        
        $this->validate($request, [
            'code'          => 'required|max:50|unique:tbl_harmonized_code,code',
            'description'   => 'required|max:255',
        ]);

        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $tblHarmonizedCode = TblHarmonizedCode::create($request3);
        return Response::json($tblHarmonizedCode);
    }

    public function updateHarmonizedCode(Request $request, $id)
    {
        $this->validate($request, [
            'code'          => 'required|max:50|unique:tbl_harmonized_code,code,'.$id.',id',
            'description'   => 'required|max:255',
        ]);

        $tblHarmonizedCode = TblHarmonizedCode::where('id',$id)->firstOrFail();

        $tblHarmonizedCode->code            = strtoupper($request->code);
        $tblHarmonizedCode->description     = strtoupper($request->description);
        $tblHarmonizedCode->last_updated_by = $request->last_updated_by;

        $tblHarmonizedCode->save();
        return Response::json($tblHarmonizedCode);
    }

    public function deleteHarmonizedCode($id)
    {
        $tblHarmonizedCode = TblHarmonizedCode::where('id',$id)->delete();
        return Response::json($tblHarmonizedCode);
    }

    // HAZARD CLASS DataTables
    public function datatablesHazardClass()
    {   
        DB::statement(DB::raw('set @rownum=0'));
        $tblHazardClass = TblHazardClass::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id','class','description','created_at']);
        return Datatables::of($tblHazardClass)
            ->addColumn('action', function ($tblHazardClass) {
                return '<span class="pull-right"><kbd class="kbd-primary cpointer edit-hzc" data-id="'.$tblHazardClass->id.'">EDIT</kbd>&nbsp;&nbsp;<kbd class="kbd-danger cpointer delete-hzc" data-id="'.$tblHazardClass->id.'">DELETE</kbd></span>';
            })
            ->setRowId('id')
            ->make(true);
    }

    public function addHazardClass(Request $request)
    {        
        $this->validate($request, [
            'class'         => 'required|max:50|unique:tbl_hazard_class,class',
            'description'   => 'required|max:255',
        ]);

        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $tblHazardClass = TblHazardClass::create($request3);
        return Response::json($tblHazardClass);
    }

    public function updateHazardClass(Request $request, $id)
    {
        $this->validate($request, [
            'class'         => 'required|max:50|unique:tbl_hazard_class,class,'.$id.',id',
            'description'   => 'required|max:255',
        ]);

        $tblHazardClass = TblHazardClass::where('id',$id)->firstOrFail();

        $tblHazardClass->class           = strtoupper($request->class);
        $tblHazardClass->description     = strtoupper($request->description);
        $tblHazardClass->last_updated_by = $request->last_updated_by;

        $tblHazardClass->save();
        return Response::json($tblHazardClass);
    }

    public function deleteHazardClass($id)
    {
        $tblHazardClass = TblHazardClass::where('id',$id)->delete();
        return Response::json($tblHazardClass);
    }           

    // HOLDING DataTables
    public function datatablesHolding(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $tblHolding = TblHolding::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tbl_holding.id',
            'tbl_holding.holding','tbl_holding.description','created_at']);

        return Datatables::of($tblHolding)
            ->addColumn('action', function ($tblHolding) {
                return '<span class="pull-right"><kbd class="kbd-primary cpointer edit-hol" data-id="'.$tblHolding->id.'">EDIT</kbd>&nbsp;&nbsp;<kbd class="kbd-danger cpointer delete-hol" data-id="'.$tblHolding->id.'">DELETE</kbd></span>';
            })
            ->setRowId('id')
            ->make(true);
    }

    public function addHolding(Request $request)
    {        
        $this->validate($request, [
            'holding'      => 'required|max:50|unique:tbl_holding,holding',
            'description'  => 'required|max:255'
        ]);

        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $tblHolding = TblHolding::create($request3);
        return Response::json($tblHolding);
    }

    public function updateHolding(Request $request, $id)
    {
        $this->validate($request, [
            'holding'      => 'required|max:50|unique:tbl_holding,holding,'.$id.',id',
            'description'  => 'required|max:255'
        ]);

        $tblHolding = TblHolding::find($id);

        $tblHolding->holding         = strtoupper($request->holding);
        $tblHolding->description     = strtoupper($request->description);
        $tblHolding->last_updated_by = $request->last_updated_by;

        $tblHolding->save();
        return Response::json($tblHolding);
    }

    public function deleteHolding($id)
    {
        $tblHolding = TblHolding::destroy($id);
        return Response::json($tblHolding);
    }

    // COMPANY DataTables
    public function datatablesCompany(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $tblCompany = TblCompany::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tbl_company.id',
            'tbl_company.company','tbl_company.description','tbl_company.created_at'])

            ->join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')            
            ->SearchHolding($request->holdingId);

        return Datatables::of($tblCompany)
            ->addColumn('action', function ($tblCompany) {
                return '<span class="pull-right"><kbd class="kbd-primary cpointer edit-cp" data-id="'.$tblCompany->id.'">EDIT</kbd>&nbsp;&nbsp;<kbd class="kbd-danger cpointer delete-cp" data-id="'.$tblCompany->id.'">DELETE</kbd></span>';
            })
            ->setRowId('id')
            ->make(true);
    }

    public function addCompany(Request $request)
    {        
        $this->validate($request, [
            'company'        => 'required|max:50|unique:tbl_company,company',
            'description'    => 'required|max:255',
            'tbl_holding_id' => 'required',
        ]);

        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $tblCompany = TblCompany::create($request3);
        return Response::json($tblCompany);
    }

    public function editCompany($id)
    {
        return TblCompany::select([
            'tbl_company.id as companyId','tbl_company.company',
            'tbl_company.description','tbl_holding.id as holdingId',
            'tbl_holding.holding'])

            ->join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')            
            ->where('tbl_company.id', $id)->firstOrFail();
    }

    public function updateCompany(Request $request, $id)
    {
        $this->validate($request, [
            'company'        => 'required|max:50|unique:tbl_company,company,'.$id.',id',            
            'description'    => 'required|max:255',
            'tbl_holding_id' => 'required'
        ]);

        $tblCompany = TblCompany::find($id);

        $tblCompany->company         = strtoupper($request->company);
        $tblCompany->description     = strtoupper($request->description);
        $tblCompany->tbl_holding_id  = $request->tbl_holding_id;
        $tblCompany->last_updated_by = $request->last_updated_by;

        $tblCompany->save();
        return Response::json($tblCompany);
    }

    public function deleteCompany($id)
    {
        $tblCompany = TblCompany::destroy($id);
        return Response::json($tblCompany);
    }

    // PLANT DataTables
    public function datatablesPlant(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $tblPlant = TblPlant::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tbl_plant.id',
            'tbl_plant.plant','tbl_plant.description','tbl_plant.created_at'])

            ->join('tbl_company', 'tbl_company.id', '=', 'tbl_plant.tbl_company_id')
            ->join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')

            ->SearchHolding($request->holdingId)
            ->SearchCompany($request->companyId);

        return Datatables::of($tblPlant)
            ->addColumn('action', function ($tblPlant) {
                return '<span class="pull-right"><kbd class="kbd-primary cpointer edit-pl" data-id="'.$tblPlant->id.'">EDIT</kbd>&nbsp;&nbsp;<kbd class="kbd-danger cpointer delete-pl" data-id="'.$tblPlant->id.'">DELETE</kbd></span>';
            })
            ->setRowId('id')
            ->make(true);
    }

    public function addPlant(Request $request)
    {        
        $this->validate($request, [
            'plant'          => 'required|max:50|unique:tbl_plant,plant',            
            'description'    => 'required|max:255',
            'tbl_company_id' => 'required',
        ]);

        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $tblPlant = TblPlant::create($request3);
        return Response::json($tblPlant);
    }

    public function editPlant($id)
    {
        return TblPlant::select([
            'tbl_plant.id',
            'tbl_holding.id as holdingId','tbl_holding.holding',
            'tbl_company.id as companyId','tbl_company.company',
            'tbl_plant.plant','tbl_plant.description'])

            ->join('tbl_company', 'tbl_company.id', '=', 'tbl_plant.tbl_company_id')
            ->join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')            
            ->where('tbl_plant.id', $id)->firstOrFail();
    }

    public function updatePlant(Request $request, $id)
    {
        $this->validate($request, [
            'plant'          => 'required|max:50|unique:tbl_plant,plant,'.$id.',id',            
            'description'    => 'required|max:255',
            'tbl_company_id' => 'required',
        ]);

        $tblPlant = TblPlant::find($id);
        
        $tblPlant->plant           = strtoupper($request->plant);
        $tblPlant->description     = strtoupper($request->description);
        $tblPlant->tbl_company_id  = $request->tbl_company_id;
        $tblPlant->last_updated_by = $request->last_updated_by;

        $tblPlant->save();
        return Response::json($tblPlant);
    }

    public function deletePlant($id)
    {
        $tblPlant = TblPlant::destroy($id);
        return Response::json($tblPlant);
    }

    // LOCATION DataTables
    public function datatablesLocation(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $tblLocation = TblLocation::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tbl_location.id',
            'tbl_location.location','tbl_location.description','tbl_location.created_at'])

            ->join('tbl_plant', 'tbl_plant.id', '=', 'tbl_location.tbl_plant_id')
            ->join('tbl_company', 'tbl_company.id', '=', 'tbl_plant.tbl_company_id')
            ->join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')
            
            ->SearchHolding($request->holdingId)
            ->SearchCompany($request->companyId)
            ->SearchPlant($request->plantId);

        return Datatables::of($tblLocation)
            ->addColumn('action', function ($tblLocation) {
                return '<span class="pull-right"><kbd class="kbd-primary cpointer edit-loc" data-id="'.$tblLocation->id.'">EDIT</kbd>&nbsp;&nbsp;<kbd class="kbd-danger cpointer delete-loc" data-id="'.$tblLocation->id.'">DELETE</kbd></span>';
            })
            ->setRowId('id')
            ->make(true);
    }

    public function addLocation(Request $request)
    {        
        $this->validate($request, [
            'location'     => 'required|max:50|unique:tbl_location,location',        
            'description'  => 'required|max:255',
            'tbl_plant_id' => 'required',
        ]);

        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $tblLocation = TblLocation::create($request3);
        return Response::json($tblLocation);
    }

    public function editLocation($id)
    {
        return TblLocation::select([
            'tbl_location.id',
            'tbl_holding.id as holdingId','tbl_holding.holding',
            'tbl_company.company as companyId','tbl_company.company',
            'tbl_plant.id as plantId','tbl_plant.plant',
            'tbl_location.location','tbl_location.description'])

            ->join('tbl_plant', 'tbl_plant.id', '=', 'tbl_location.tbl_plant_id')
            ->join('tbl_company', 'tbl_company.id', '=', 'tbl_plant.tbl_company_id')
            ->join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')            
            ->where('tbl_location.id', $id)->firstOrFail();
    }

    public function updateLocation(Request $request, $id)
    {
        $this->validate($request, [
            'location'     => 'required|max:50|unique:tbl_location,location,'.$id.',id',
            'description'  => 'required|max:255',
            'tbl_plant_id' => 'required',
        ]);

        $tblLocation = TblLocation::find($id);
        
        $tblLocation->location        = strtoupper($request->location);
        $tblLocation->description     = strtoupper($request->description);
        $tblLocation->tbl_plant_id    = $request->tbl_plant_id;
        $tblLocation->last_updated_by = $request->last_updated_by;

        $tblLocation->save();
        return Response::json($tblLocation);
    }

    public function deleteLocation($id)
    {
        $tblLocation = TblLocation::destroy($id);
        return Response::json($tblLocation);
    }

    // SHELF DataTables
    public function datatablesShelf(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $tblShelf = TblShelf::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tbl_shelf.id',
            'tbl_shelf.shelf','tbl_shelf.description','tbl_shelf.created_at'])

            ->join('tbl_location', 'tbl_location.id', '=', 'tbl_shelf.tbl_location_id')
            ->join('tbl_plant', 'tbl_plant.id', '=', 'tbl_location.tbl_plant_id')
            ->join('tbl_company', 'tbl_company.id', '=', 'tbl_plant.tbl_company_id')
            ->join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')
            
            ->SearchHolding($request->holdingId)
            ->SearchCompany($request->companyId)
            ->SearchPlant($request->plantId)
            ->SearchLocation($request->locationId);

        return Datatables::of($tblShelf)
            ->addColumn('action', function ($tblShelf) {
                return '<span class="pull-right"><kbd class="kbd-primary cpointer edit-sh" data-id="'.$tblShelf->id.'">EDIT</kbd>&nbsp;&nbsp;<kbd class="kbd-danger cpointer delete-sh" data-id="'.$tblShelf->id.'">DELETE</kbd></span>';
            })
            ->setRowId('id')
            ->make(true);
    }

    public function addShelf(Request $request)
    {        
        $this->validate($request, [
            'shelf'           => 'required|max:50|unique:tbl_shelf,shelf',            
            'description'     => 'required|max:255',
            'tbl_location_id' => 'required',
        ]);

        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $tblShelf = TblShelf::create($request3);
        return Response::json($tblShelf);
    }

    public function editShelf($id)
    {
        return TblShelf::select([
            'tbl_shelf.id',
            'tbl_holding.id as holdingId','tbl_holding.holding',
            'tbl_company.id as companyId','tbl_company.company',
            'tbl_plant.id as plantId','tbl_plant.plant',
            'tbl_location.id as locationId','tbl_location.location',
            'tbl_shelf.shelf','tbl_shelf.description'])

            ->join('tbl_location', 'tbl_location.id', '=', 'tbl_shelf.tbl_location_id')
            ->join('tbl_plant', 'tbl_plant.id', '=', 'tbl_location.tbl_plant_id')
            ->join('tbl_company', 'tbl_company.id', '=', 'tbl_plant.tbl_company_id')
            ->join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')            
            ->where('tbl_shelf.id', $id)->firstOrFail();
    }

    public function updateShelf(Request $request, $id)
    {
        $this->validate($request, [
            'shelf'           => 'required|max:50|unique:tbl_shelf,shelf,'.$id.',id',            
            'description'     => 'required|max:255',
            'tbl_location_id' => 'required',
        ]);

        $tblShelf = TblShelf::find($id);
        
        $tblShelf->shelf           = strtoupper($request->shelf);
        $tblShelf->description     = strtoupper($request->description);
        $tblShelf->tbl_location_id = $request->tbl_location_id;
        $tblShelf->last_updated_by = $request->last_updated_by;

        $tblShelf->save();
        return Response::json($tblShelf);
    }

    public function deleteShelf($id)
    {
        $tblShelf = TblShelf::destroy($id);
        return Response::json($tblShelf);
    }

    // BIN DataTables
    public function datatablesBin(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $tblBin = TblBin::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),'tbl_bin.id',
            'tbl_bin.bin','tbl_bin.description','tbl_bin.created_at'])

            ->join('tbl_shelf', 'tbl_shelf.id', '=', 'tbl_bin.tbl_shelf_id')
            ->join('tbl_location', 'tbl_location.id', '=', 'tbl_shelf.tbl_location_id')
            ->join('tbl_plant', 'tbl_plant.id', '=', 'tbl_location.tbl_plant_id')
            ->join('tbl_company', 'tbl_company.id', '=', 'tbl_plant.tbl_company_id')
            ->join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')
            
            ->SearchHolding($request->holdingId)
            ->SearchCompany($request->companyId)
            ->SearchPlant($request->plantId)
            ->SearchLocation($request->locationId)
            ->SearchShelf($request->shelfId);

        return Datatables::of($tblBin)
            ->addColumn('action', function ($tblBin) {
                return '<span class="pull-right"><kbd class="kbd-primary cpointer edit-bn" data-id="'.$tblBin->id.'">EDIT</kbd>&nbsp;&nbsp;<kbd class="kbd-danger cpointer delete-bn" data-id="'.$tblBin->id.'">DELETE</kbd></span>';
            })
            ->setRowId('id')
            ->make(true);
    }

    public function addBin(Request $request)
    {        
        $this->validate($request, [
            'bin'          => 'required|max:50|unique:tbl_bin,bin',            
            'description'  => 'required|max:255',
            'tbl_shelf_id' => 'required',
        ]);

        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $tblBIn = TblBin::create($request3);
        return Response::json($tblBIn);
    }

    public function editBin($id)
    {
        return TblBin::select([
            'tbl_bin.id',
            'tbl_holding.id as holdingId','tbl_holding.holding',
            'tbl_company.id as companyId','tbl_company.company',
            'tbl_plant.id as plantId','tbl_plant.plant',
            'tbl_location.id as locationId','tbl_location.location',
            'tbl_shelf.id as shelfId','tbl_shelf.shelf',
            'tbl_bin.bin','tbl_bin.description'])

            ->join('tbl_shelf', 'tbl_shelf.id', '=', 'tbl_bin.tbl_shelf_id')
            ->join('tbl_location', 'tbl_location.id', '=', 'tbl_shelf.tbl_location_id')
            ->join('tbl_plant', 'tbl_plant.id', '=', 'tbl_location.tbl_plant_id')
            ->join('tbl_company', 'tbl_company.id', '=', 'tbl_plant.tbl_company_id')
            ->join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')            
            ->where('tbl_bin.id', $id)->firstOrFail();
    }    

    public function updateBin(Request $request, $id)
    {
        $this->validate($request, [
            'bin'          => 'required|max:50|unique:tbl_bin,bin,'.$id.',id',            
            'description'  => 'required|max:255',
            'tbl_shelf_id' => 'required',
        ]);

        $tblBin                  = TblBin::find($id);
        
        $tblBin->bin             = strtoupper($request->bin);
        $tblBin->description     = strtoupper($request->description);
        $tblBin->tbl_shelf_id    = $request->tbl_shelf_id;
        $tblBin->last_updated_by = $request->last_updated_by;

        $tblBin->save();
        return Response::json($tblBin);
    }

    public function deleteBin($id)
    {
        $tblBin = TblBin::destroy($id);
        return Response::json($tblBin);
    }

    // ITEM TYPE DataTables
    public function datatablesItemType()
    {   
        DB::statement(DB::raw('set @rownum=0'));
        $tblItemType = TblItemType::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id','type','description','created_at']);
        return Datatables::of($tblItemType)
            ->addColumn('action', function ($tblItemType) {
                return '<span class="pull-right"><kbd class="kbd-primary cpointer edit-it" data-id="'.$tblItemType->id.'">EDIT</kbd>&nbsp;&nbsp;<kbd class="kbd-danger cpointer delete-it" data-id="'.$tblItemType->id.'">DELETE</kbd></span>';
            })
            ->setRowId('id')
            ->make(true);
    }

    public function addItemType(Request $request)
    {        
        $this->validate($request, [
            'type'        => 'required|max:50|unique:tbl_item_type,type',
            'description' => 'required|max:255'
        ]);

        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $tblItemType = TblItemType::create($request3);
        return Response::json($tblItemType);
    }

    public function updateItemType(Request $request, $id)
    {
        $this->validate($request, [
            'type'        => 'required|max:50|unique:tbl_item_type,type,'.$id.',id',
            'description' => 'required|max:255'
        ]);

        $tblItemType = TblItemType::where('id',$id)->firstOrFail();

        $tblItemType->type            = strtoupper($request->type);
        $tblItemType->description     = strtoupper($request->description);
        $tblItemType->last_updated_by = $request->last_updated_by;

        $tblItemType->save();
        return Response::json($tblItemType);
    }

    public function deleteItemType($id)
    {
        $tblItemType = TblItemType::where('id',$id)->delete();
        return Response::json($tblItemType);
    }

    // SOURCE TYPE DataTables
    public function datatablesSourceType()
    {   
        DB::statement(DB::raw('set @rownum=0'));
        $tblSourceType = TblSourceType::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id','type','description','created_at']);
        return Datatables::of($tblSourceType)
            ->addColumn('action', function ($tblSourceType) {
                return '<span class="pull-right"><kbd class="kbd-primary cpointer edit-sot" data-id="'.$tblSourceType->id.'">EDIT</kbd>&nbsp;&nbsp;<kbd class="kbd-danger cpointer delete-sot" data-id="'.$tblSourceType->id.'">DELETE</kbd></span>';
            })
            ->setRowId('id')
            ->make(true);
    }

    public function addSourceType(Request $request)
    {        
        $this->validate($request, [
            'type'        => 'required|max:15|unique:tbl_source_type,type',
            'description' => 'required|max:255'
        ]);

        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $tblSourceType = TblSourceType::create($request3);
        return Response::json($tblSourceType);
    }

    public function updateSourceType(Request $request, $id)
    {
        $this->validate($request, [
            'type'        => 'required|max:15|unique:tbl_source_type,type,'.$id.',id',
            'description' => 'required|max:255'
        ]);

        $tblSourceType = TblSourceType::where('id',$id)->firstOrFail();

        $tblSourceType->type            = strtoupper($request->type);
        $tblSourceType->description     = strtoupper($request->description);
        $tblSourceType->last_updated_by = $request->last_updated_by;

        $tblSourceType->save();
        return Response::json($tblSourceType);
    }

    public function deleteSourceType($id)
    {
        $tblSourceType = TblSourceType::where('id',$id)->delete();
        return Response::json($tblSourceType);
    }

    // STOCK TYPE DataTables
    public function datatablesStockType()
    {   
        DB::statement(DB::raw('set @rownum=0'));
        $tblStockType = TblStockType::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id','type','description','created_at']);
        return Datatables::of($tblStockType)
            ->addColumn('action', function ($tblStockType) {
                return '<span class="pull-right"><kbd class="kbd-primary cpointer edit-stt" data-id="'.$tblStockType->id.'">EDIT</kbd>&nbsp;&nbsp;<kbd class="kbd-danger cpointer delete-stt" data-id="'.$tblStockType->id.'">DELETE</kbd></span>';
            })
            ->setRowId('id')
            ->make(true);
    }

    public function addStockType(Request $request)
    {        
        $this->validate($request, [
            'type'        => 'required|max:50|unique:tbl_stock_type,type',
            'description' => 'required|max:255'
        ]);

        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $tblStockType = TblStockType::create($request3);
        return Response::json($tblStockType);
    }

    public function updateStockType(Request $request, $id)
    {
        $this->validate($request, [
            'type'        => 'required|max:50|unique:tbl_stock_type,type,'.$id.',id',
            'description' => 'required|max:255'
        ]);

        $tblStockType = TblStockType::where('id',$id)->firstOrFail();

        $tblStockType->type            = strtoupper($request->type);
        $tblStockType->description     = strtoupper($request->description);
        $tblStockType->last_updated_by = $request->last_updated_by;

        $tblStockType->save();
        return Response::json($tblStockType);
    }

    public function deleteStockType($id)
    {
        $tblStockType = TblStockType::where('id',$id)->delete();
        return Response::json($tblStockType);
    }

    // UNITS OF MESUREMENT DataTables
    public function datatablesUnitOfMeasurement()
    {   
        DB::statement(DB::raw('set @rownum=0'));
        $tblUnitOfMeasurement = TblUnitOfMeasurement::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id','unit4','unit3','unit2','description','eng_definition','ind_definition','created_at']);
        return Datatables::of($tblUnitOfMeasurement)
            ->addColumn('action', function ($tblUnitOfMeasurement) {
                return '<span class="pull-right"><kbd class="kbd-primary cpointer edit-uom" data-id="'.$tblUnitOfMeasurement->id.'">EDIT</kbd>&nbsp;&nbsp;<kbd class="kbd-danger cpointer delete-uom" data-id="'.$tblUnitOfMeasurement->id.'">DELETE</kbd></span>';
            })
            ->setRowId('id')
            ->make(true);
    }

    public function addUnitOfMeasurement(Request $request)
    {        
        $this->validate($request, [
            'unit4'          => 'required|max:4|unique:tbl_unit_of_measurement,unit4',
            'unit3'          => 'required|max:3|unique:tbl_unit_of_measurement,unit3',
            'unit2'          => 'required|max:2|unique:tbl_unit_of_measurement,unit2',
            'description'    => 'required|max:255',
            'eng_definition' => 'required',
            'ind_definition' => 'required'
        ]);

        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $tblUnitOfMeasurement = TblUnitOfMeasurement::create($request3);
        return Response::json($tblUnitOfMeasurement);
    }

    public function editUnitOfMeasurement($id)
    {
        return TblUnitOfMeasurement::select(['unit4','unit3','unit2','description','eng_definition','ind_definition'])        
            ->where('id', $id)->firstOrFail();
    }

    public function updateUnitOfMeasurement(Request $request, $id)
    {
        $this->validate($request, [
            'unit4'          => 'required|max:4|unique:tbl_unit_of_measurement,unit4,'.$id.',id',
            'unit3'          => 'required|max:3|unique:tbl_unit_of_measurement,unit3,'.$id.',id',
            'unit2'          => 'required|max:2|unique:tbl_unit_of_measurement,unit2,'.$id.',id',
            'description'    => 'required|max:255',
            'eng_definition' => 'required',
            'ind_definition' => 'required'
        ]);

        $tblUnitOfMeasurement = TblUnitOfMeasurement::where('id',$id)->firstOrFail();

        $tblUnitOfMeasurement->unit4            = strtoupper($request->unit4);
        $tblUnitOfMeasurement->unit3            = strtoupper($request->unit3);
        $tblUnitOfMeasurement->unit2            = strtoupper($request->unit2);
        $tblUnitOfMeasurement->description      = strtoupper($request->description);
        $tblUnitOfMeasurement->eng_definition   = strtoupper($request->eng_definition);
        $tblUnitOfMeasurement->ind_definition   = strtoupper($request->ind_definition);
        $tblUnitOfMeasurement->last_updated_by  = $request->last_updated_by;

        $tblUnitOfMeasurement->save();
        return Response::json($tblUnitOfMeasurement);
    }

    public function deleteUnitOfMeasurement($id)
    {
        $tblUnitOfMeasurement = TblUnitOfMeasurement::where('id',$id)->delete();
        return Response::json($tblUnitOfMeasurement);
    }

    // USER CLASS DataTables
    public function datatablesUserClass()
    {   
        DB::statement(DB::raw('set @rownum=0'));
        $tblUserClass = TblUserClass::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id','class','description','created_at']);
        return Datatables::of($tblUserClass)
            ->addColumn('action', function ($tblUserClass) {
                return '<span class="pull-right"><kbd class="kbd-primary cpointer edit-uc" data-id="'.$tblUserClass->id.'">EDIT</kbd>&nbsp;&nbsp;<kbd class="kbd-danger cpointer delete-uc" data-id="'.$tblUserClass->id.'">DELETE</kbd></span>';
            })
            ->setRowId('id')
            ->make(true);
    }

    public function addUserClass(Request $request)
    {        
        $this->validate($request, [
            'class'        => 'required|max:50|unique:tbl_user_class,class',
            'description'  => 'required|max:255'
        ]);

        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $tblUserClass = TblUserClass::create($request3);
        return Response::json($tblUserClass);
    }

    public function updateUserClass(Request $request, $id)
    {
        $this->validate($request, [
            'class'        => 'required|max:50|unique:tbl_user_class,class,'.$id.',id',
            'description'  => 'required|max:255'
        ]);

        $tblUserClass = TblUserClass::where('id',$id)->firstOrFail();

        $tblUserClass->class           = strtoupper($request->class);
        $tblUserClass->description     = strtoupper($request->description);
        $tblUserClass->last_updated_by = $request->last_updated_by;

        $tblUserClass->save();
        return Response::json($tblUserClass);
    }

    public function deleteUserClass($id)
    {
        $tblUserClass = TblUserClass::where('id',$id)->delete();
        return Response::json($tblUserClass);
    }

    // WEIGHT UNIT DataTables
    public function datatablesWeightUnit()
    {   
        DB::statement(DB::raw('set @rownum=0'));
        $tblWeightUnit = TblWeightUnit::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id','unit','description','created_at']);
        return Datatables::of($tblWeightUnit)
            ->addColumn('action', function ($tblWeightUnit) {
                return '<span class="pull-right"><kbd class="kbd-primary cpointer edit-wu" data-id="'.$tblWeightUnit->id.'">EDIT</kbd>&nbsp;&nbsp;<kbd class="kbd-danger cpointer delete-wu" data-id="'.$tblWeightUnit->id.'">DELETE</kbd></span>';
            })
            ->setRowId('id')
            ->make(true);
    }

    public function addWeightUnit(Request $request)
    {        
        $this->validate($request, [
            'unit'        => 'required|max:15|unique:tbl_weight_unit,unit',
            'description' => 'required|max:255'
        ]);

        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $tblWeightUnit = TblWeightUnit::create($request3);
        return Response::json($tblWeightUnit);
    }

    public function updateWeightUnit(Request $request, $id)
    {
        $this->validate($request, [
            'unit'        => 'required|max:15|unique:tbl_weight_unit,unit,'.$id.',id',
            'description' => 'required|max:255'
        ]);

        $tblWeightUnit = TblWeightUnit::where('id',$id)->firstOrFail();

        $tblWeightUnit->unit            = strtoupper($request->unit);
        $tblWeightUnit->description     = strtoupper($request->description);
        $tblWeightUnit->last_updated_by = $request->last_updated_by;

        $tblWeightUnit->save();
        return Response::json($tblWeightUnit);
    }

    public function deleteWeightUnit($id)
    {
        $tblWeightUnit = TblWeightUnit::where('id',$id)->delete();
        return Response::json($tblWeightUnit);
    }
}