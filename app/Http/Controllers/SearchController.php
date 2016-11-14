<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Vinkla\Hashids\Facades\Hashids;

use Response;
use DB;

use App\Models\PartManufacturerCode;
use App\Models\PartMaster;
use App\Models\TblBin;
use App\Models\TblCatalogStatus;
use App\Models\TblColloquial;
use App\Models\TblCompany;
use App\Models\TblEquipmentCode;
use App\Models\TblGroupClass;
use App\Models\TblHolding;
use App\Models\TblInc;
use App\Models\TblItemType;
use App\Models\TblLocation;
use App\Models\TblManufacturerCode;
use App\Models\TblPlant;
use App\Models\TblSearch;
use App\Models\TblShelf;
use App\User;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $catalogNo = $request->catalogNo;
        if(empty($catalogNo)){
            $catalogNo = null;
        }

        $holdingNo = $request->holdingNo;
        if(empty($holdingNo)){
            $holdingNo = null;
        }

        $incId = @Hashids::decode($request->incId)[0];
        if(empty($incId)){
            $incId = null;
        }

        $colloquialId = @Hashids::decode($request->colloquialId)[0];
        if(empty($colloquialId)){
            $colloquialId = null;
        }

        $groupClassId = @Hashids::decode($request->groupClassId)[0];
        if(empty($groupClassId)){
            $groupClassId = null;
        }
        
        $catalogStatusId = @Hashids::decode($request->catalogStatusId)[0];
        if(empty($catalogStatusId)){
            $catalogStatusId = null;
        }

        $catalogType = @Hashids::decode($request->catalogType)[0];
        if(empty($catalogType)){
            $catalogType = null;
        }elseif($catalogType == 1){
            $catalogType = 'oem';
        }elseif($catalogType == 2){
            $catalogType = 'gen';
        }else{
            $catalogType = null;
        }

        $itemTypeId = @Hashids::decode($request->itemTypeId)[0];
        if(empty($itemTypeId)){
            $itemTypeId = null;
        }

        $manCodeId = @Hashids::decode($request->manCodeId)[0];
        if(empty($manCodeId)){
            $manCodeId = null;
        }

        $partNumber = $request->partNumber;
        if(empty($partNumber)){
            $partNumber = null;
        }

        $equipmentCodeId = @Hashids::decode($request->equipmentCodeId)[0];
        if(empty($equipmentCodeId)){
            $equipmentCodeId = null;
        }

        $holdingId = @Hashids::decode($request->holdingId)[0];
        if(empty($holdingId)){
            $holdingId = null;
        }

        $companyId = @Hashids::decode($request->companyId)[0];
        if(empty($companyId)){
            $companyId = null;
        }

        $plantId = @Hashids::decode($request->plantId)[0];
        if(empty($plantId)){
            $plantId = null;
        }

        $locationId = @Hashids::decode($request->locationId)[0];
        if(empty($locationId)){
            $locationId = null;
        }

        $shelfId = @Hashids::decode($request->shelfId)[0];
        if(empty($shelfId)){
            $shelfId = null;
        }

        $binId = @Hashids::decode($request->binId)[0];
        if(empty($binId)){
            $binId = null;
        }

        $id = TblSearch::select('id')
            ->SearchCatalogNo($catalogNo)
            ->SearchHoldingNo($holdingNo)
            ->SearchIncId($incId)
            ->SearchColloquialId($colloquialId)
            ->SearchGroupClassId($groupClassId)
            ->SearchCatalogStatusId($catalogStatusId)
            ->SearchCatalogType($catalogType)
            ->SearchItemTypeId($itemTypeId)
            ->SearchManCodeId($manCodeId)
            ->SearchPartNumber($partNumber)
            ->SearchEquipmentCodeId($equipmentCodeId)
            ->SearchHoldingId($holdingId)
            ->SearchCompanyId($companyId)
            ->SearchPlantId($plantId)
            ->SearchLocationId($locationId)
            ->SearchShelfId($shelfId)
            ->SearchBinId($binId)
            ->first();

        if(count($id)>0){
            $id = Hashids::encode($id->id);
        }else{
            $data = [
                'catalog_no' => $catalogNo,
                'holding_no' => $holdingNo,
                'inc_id' => $incId,
                'colloquial_id' => $colloquialId,
                'group_class_id' => $groupClassId,
                'catalog_status_id' => $catalogStatusId,
                'catalog_type' => $catalogType,
                'item_type_id' => $itemTypeId,
                'man_code_id' => $manCodeId,
                'part_number' => $partNumber,
                'equipment_code_id' => $equipmentCodeId,
                'holding_id' => $holdingId,
                'company_id' => $companyId,
                'plant_id' => $plantId,
                'location_id' => $locationId,
                'shelf_id' => $shelfId,
                'bin_id' => $binId,
            ];           

            $id = TblSearch::create($data);
            $id = Hashids::encode($id->id);
        }

        return $id;
    }

    public function selectSearchCatalogNo(Request $request)
    {
        return PartMaster::select('catalog_no')
            ->where('catalog_no', 'like', '%'.$request->q.'%')
            ->distinct()->get();
    }

    public function selectSearchHoldingNo(Request $request)
    {
        return PartMaster::select('holding_no')
            ->where('holding_no', 'like', '%'.$request->q.'%')
            ->distinct()->get();
    }

    public function selectSearchIncItemName(Request $request)
    {
        return TblInc::select('id as tbl_inc_id', 'inc', 'item_name')
            ->where('inc', 'like', '%'.$request->q.'%')
            ->orWhere('item_name', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchColloquial(Request $request)
    {
        return TblColloquial::select('id as tbl_colloquial_id', 'colloquial')
            ->where('colloquial', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchGroupClass(Request $request)
    {
        return TblGroupClass::select('tbl_group_class.id as tbl_group_class_id', DB::raw('CONCAT(`group`, class) AS group_class'), 'tbl_group_class.name')
            ->join('tbl_group', 'tbl_group.id', '=', 'tbl_group_class.tbl_group_id')
            ->where(DB::raw('CONCAT(`group`, class)'), 'like', '%'.$request->q.'%')
            ->orWhere('tbl_group_class.name', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchCatalogStatus(Request $request)
    {
        return TblCatalogStatus::select('tbl_catalog_status.id as tbl_catalog_status_id', 'status')
            ->join('part_master', 'part_master.tbl_catalog_status_id', '=', 'tbl_catalog_status.id')
            ->where('status', 'like', '%'.$request->q.'%')
            ->distinct()->get();
    }

    public function selectSearchItemType(Request $request)
    {
        return TblItemType::select('id as tbl_item_type_id', 'type')
            ->where('type', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchManufacturer(Request $request)
    {
        return TblManufacturerCode::select('id as tbl_manufacturer_code_id', 'manufacturer_code', 'manufacturer_name')
            ->where('manufacturer_code', 'like', '%'.$request->q.'%')
            ->orWhere('manufacturer_name', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchPartNumber(Request $request)
    {
        return PartManufacturerCode::select('manufacturer_ref as part_number')
            ->where(DB::raw('REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
            	REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
            	REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
            	REPLACE(REPLACE(REPLACE(manufacturer_ref, \'"\', \'\'),\' \', \'\'),\'.\', \'\'),\'?\', \'\'),\'`\', \'\'),
            	\'<\', \'\'),\'=\', \'\'),\'{\', \'\'),\'}\', \'\'),\'[\', \'\'),\']\', \'\'),
            	\'|\', \'\'),'.DB::getPdo()->quote('\'').', \'\'),\':\', \'\'),\';\', \'\'),
            	\'~\', \'\'),\'!\', \'\'),\'@\', \'\'),\'#\', \'\'),\'$\', \'\'),\'%\', \'\'),
            	\'^\', \'\'),\'&\', \'\'),\'*\', \'\'),\'_\', \'\'),\'+\', \'\'),\',\', \'\'),
            	\'/\', \'\'),\'(\', \'\'),\')\', \'\'),\'-\', \'\'),\'>\', \'\')'), 
                'like', '%'.$request->q.'%')
            ->orWhere('manufacturer_ref', 'like', '%'.$request->q.'%')
            ->distinct()->get();
    }

    public function selectSearchEquipment(Request $request)
    {
        return TblEquipmentCode::select('id as tbl_equipment_code_id', 'equipment_code', 'equipment_name')
            ->where('equipment_code', 'like', '%'.$request->q.'%')
            ->orWhere('equipment_name', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchHolding(Request $request)
    {
        return TblHolding::select('id as tbl_holding_id', 'holding')
            ->where('holding', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchCompany(Request $request)
    {
        return TblCompany::select('id as tbl_company_id', 'company')
            ->where('company', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchPlant(Request $request)
    {
        return TblPlant::select('id as tbl_plant_id', 'plant')
            ->where('plant', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchLocation(Request $request)
    {
        return TblLocation::select('id as tbl_location_id', 'location')
            ->where('location', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchShelf(Request $request)
    {
        return TblShelf::select('id as tbl_shelf_id', 'shelf')
            ->where('shelf', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchBin(Request $request)
    {
        return TblBin::select('id as tbl_bin_id', 'bin')
            ->where('bin', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchUser(Request $request)
    {
        return User::select('id as tbl_user_id', 'username', 'name')
            ->where('username', 'like', '%'.$request->q.'%')
            ->orWhere('name', 'like', '%'.$request->q.'%')
            ->get();
    }

}