<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use DB;
use Datatables;
use Response;
use App\Models\CompanyCharacteristicSequence;
use App\Models\LinkIncCharacteristic;
use App\Models\LinkIncCharacteristicValue;
use App\Models\ShortDescriptionFormat;
use App\Models\TblBin;
use App\Models\TblShelf;
use App\Models\TblLocation;
use App\Models\TblPlant;
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
        $this->middleware('web');
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
        return TblHolding::select('id', 'holding')
            ->where('holding', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectCompany($holdingId, Request $request)
    {
        return TblCompany::select('id', 'company')
            ->where('tbl_holding_id', $holdingId)
            ->where('company', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectPlant($companyId, Request $request)
    {
        return TblPlant::select('id', 'plant')
            ->where('tbl_company_id', $companyId)
            ->where('plant', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectLocation($plantId, Request $request)
    {
        return TblLocation::select('id', 'location')
            ->where('tbl_plant_id', $plantId)
            ->where('location', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSHelf($locationId, Request $request)
    {
        return TblShelf::select('id', 'shelf')
            ->where('tbl_location_id', $locationId)
            ->where('shelf', 'like', '%'.$request->q.'%')
            ->get();
    }

    // GLOBAL CHARACTERISTICS
    public function getGlobalCharacteristics($incId)
    {
        return LinkIncCharacteristic::select('link_inc_characteristic.id', 'characteristic', 'sequence')
        ->join('tbl_characteristic', 'tbl_characteristic.id', '=', 'link_inc_characteristic.tbl_characteristic_id')
        ->where('tbl_inc_id', $incId)
        ->orderBy('sequence')
        ->get();
    }

    public function getGlobalCharacteristicsValues($linkIncCharacteristicId)
    {
        return LinkIncCharacteristicValue::select('value','abbrev','approved')
        ->where('link_inc_characteristic_id', $linkIncCharacteristicId)
        ->get();
    }

    public function updateGlobalCharOrder(Request $request)
    {
        $no = 1;
        foreach ($request->lic as $id) {
            $gcs = LinkIncCharacteristic::find($id);
            $gcs->sequence = $no++;
            $gcs->save();
        }
    }

    private function checkAddCharStatus($incId, $characteristicId)
    {
        return LinkIncCharacteristic::where('tbl_inc_id', $incId)
            ->where('tbl_characteristic_id', $characteristicId)
            ->first();
    }

    public function getCharsToBeAdded($incId)
    {
        $tbl = TblCharacteristic::select('id', 'characteristic')
            ->get();

        $arr = [];
        foreach ($tbl as $key => $value) {
            if (count($this->checkAddCharStatus($incId, $value->id)) > 0) {
                $status = 1;
            }else{
                $status = 0;
            }

            $values[] = array(
                'id' => $value->id,
                'characteristic' => $value->characteristic,
                'status' => $status,
            );
        }
        return Response::json($values);
    }
    // END GLOBAL CHARACTERISTICS

    // GLOBAL SHORT DESCRIPTION FORMAT
    public function getGlobalShortDescFormat($incId)
    {
        return ShortDescriptionFormat::select('short_description_format.id','characteristic','separator')
            ->join('link_inc_characteristic', 'link_inc_characteristic.id', '=', 'short_description_format.link_inc_characteristic_id')
            ->join('tbl_characteristic', 'tbl_characteristic.id', '=', 'link_inc_characteristic.tbl_characteristic_id')
            ->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_characteristic.tbl_inc_id')
            ->where('link_inc_characteristic.tbl_inc_id', $incId)
            ->orderBy('short_description_format.sequence')
            ->get();
    }

    public function updateGlobalShortOrder(Request $request)
    {
        $no = 1;
        foreach ($request->sid as $id) {
            $gss = ShortDescriptionFormat::find($id);
            $gss->sequence = $no++;
            $gss->save();
        }
    }
    // END GLOBAL SHORT DESCRIPTION FORMAT

    // COMPANY CHARACTERISTICS
    public function getCompanyCharacteristics($incId,$companyId)
    {
        return CompanyCharacteristicSequence::select('characteristic', 'link_inc_characteristic_id')
            ->join('link_inc_characteristic', 'link_inc_characteristic.id', '=', 'company_characteristic_sequence.link_inc_characteristic_id')
            ->join('tbl_characteristic', 'tbl_characteristic.id', '=', 'link_inc_characteristic.tbl_characteristic_id')
            ->where('tbl_inc_id', $incId)
            ->where('tbl_company_id', $companyId)
            ->orderBy('company_characteristic_sequence.sequence')
            ->get();
    } 

    public function updateCCharOrder(Request $request)
    {
        $no = 1;
        foreach ($request->lic as $id) {
            $ccs = CompanyCharacteristicSequence::where('link_inc_characteristic_id', $id)
                ->where('tbl_company_id', $request->company)
                ->first();

            $ccs->sequence = $no++;
            $ccs->save();
        }
    }
    // END COMPANY CHARACTERISTICS

    // CATALOG STATUS DataTables
    public function datatablesCatalogStatus()
    {   
        DB::statement(DB::raw('set @rownum=0'));
        $tblCatalogStatus = TblCatalogStatus::select(
            [DB::raw('@rownum  := @rownum  + 1 AS rownum'),'id','status','description','created_at']);
        return Datatables::of($tblCatalogStatus)
            ->addColumn('action', function ($tblCatalogStatus) {
                return '<span class="pull-right"><kbd class="kbd-primary cpointer edit-cs" data-id="'.$tblCatalogStatus->id.'">EDIT</kbd>&nbsp;&nbsp;<kbd class="kbd-danger cpointer delete-cs" data-id="'.$tblCatalogStatus->id.'">DELETE</kbd></span>';
            })
            ->setRowId('id')
            ->make(true);
    }

    public function addCatalogStatus(Request $request)
    {   
        $this->validate($request, [
            'status'      => 'required|max:20|unique:tbl_catalog_status,status',
            'description' => 'required|max:255'
        ]);

        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $tblCatalogStatus = TblCatalogStatus::create($request3);
        return Response::json($tblCatalogStatus);
    }

    public function updateCatalogStatus(Request $request, $id)
    {
        $this->validate($request, [
            'status'      => 'required|max:20|unique:tbl_catalog_status,status,'.$id.',id',
            'description' => 'required|max:255'
        ]);

        $tblCatalogStatus = TblCatalogStatus::where('id',$id)->firstOrFail();

        $tblCatalogStatus->status          = strtoupper($request->status);
        $tblCatalogStatus->description     = strtoupper($request->description);
        $tblCatalogStatus->last_updated_by = $request->last_updated_by;

        $tblCatalogStatus->save();
        return Response::json($tblCatalogStatus);
    }

    public function deleteCatalogStatus($id)
    {
        $tblCatalogStatus = TblCatalogStatus::where('id',$id)->delete();
        return Response::json($tblCatalogStatus);
    }

    // EQUIPMENT CODE DataTables
    public function datatablesEquipmentCode(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $tblEquipmentCode = TblEquipmentCode::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'tbl_equipment_code.id','tbl_equipment_code.equipment_code',
            'tbl_equipment_code.equipment_name','tbl_equipment_code.created_at'])

            ->join('tbl_plant', 'tbl_plant.id', '=', 'tbl_equipment_code.tbl_plant_id')
            ->join('tbl_company', 'tbl_company.id', '=', 'tbl_plant.tbl_company_id')
            ->join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')
            
            ->SearchHolding($request->holdingId)
            ->SearchCompany($request->companyId)
            ->SearchPlant($request->plantId);

        return Datatables::of($tblEquipmentCode)
            ->addColumn('action', function ($tblEquipmentCode) {
                return '<span class="pull-right"><kbd class="kbd-primary cpointer edit-eq" data-id="'.$tblEquipmentCode->id.'">EDIT</kbd>&nbsp;&nbsp;<kbd class="kbd-danger cpointer delete-eq" data-id="'.$tblEquipmentCode->id.'">DELETE</kbd></span>';
            })
            ->setRowId('id')
            ->make(true);
    }

    public function addEquipmentCode(Request $request)
    {        
        $this->validate($request, [            
            'equipment_code' => 'required|max:50|unique:tbl_equipment_code,equipment_code',
            'equipment_name' => 'required|max:255|unique:tbl_equipment_code,equipment_name',
            'tbl_plant_id'   => 'required'
        ]);

        $request1 = array_map("strtoupper", $request->except('created_by', 'last_updated_by'));
        $request2 = $request->only('created_by', 'last_updated_by');
        $request3 = array_merge($request1,$request2);

        $tblEquipmentCode = TblEquipmentCode::create($request3);
        return Response::json($tblEquipmentCode);
    }

    public function editEquipmentCode($id)
    {
        return TblEquipmentCode::select([
            'tbl_equipment_code.id',
            'tbl_holding.id as holdingId','tbl_holding.holding',
            'tbl_company.id as companyId','tbl_company.company',
            'tbl_plant.id as plantId','tbl_plant.plant',
            'tbl_equipment_code.equipment_code','tbl_equipment_code.equipment_name'])

            ->join('tbl_plant', 'tbl_plant.id', '=', 'tbl_equipment_code.tbl_plant_id')
            ->join('tbl_company', 'tbl_company.id', '=', 'tbl_plant.tbl_company_id')
            ->join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')            
            ->where('tbl_equipment_code.id', $id)->firstOrFail();
    }

    public function updateEquipmentCode(Request $request, $id)
    {
        $this->validate($request, [
            'equipment_code' => 'required|max:50|unique:tbl_equipment_code,equipment_code,'.$id.',id',
            'equipment_name' => 'required|max:255|unique:tbl_equipment_code,equipment_name,'.$id.',id',
            'tbl_plant_id'   => 'required',
        ]);

        $tblEquipmentCode = TblEquipmentCode::where('id',$id)->firstOrFail();
        
        $tblEquipmentCode->equipment_code  = strtoupper($request->equipment_code);
        $tblEquipmentCode->equipment_name  = strtoupper($request->equipment_name);
        $tblEquipmentCode->tbl_plant_id    = $request->tbl_plant_id;
        $tblEquipmentCode->last_updated_by = $request->last_updated_by;

        $tblEquipmentCode->save();
        return Response::json($tblEquipmentCode);
    }

    public function deleteEquipmentCode($id)
    {
        $tblEquipmentCode = TblEquipmentCode::where('id',$id)->delete();
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