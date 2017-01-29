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
            ->limit(7)->distinct()->get();
    }

    public function selectSearchHoldingNo(Request $request)
    {
        return PartMaster::select('holding_no')
            ->where('holding_no', 'like', '%'.$request->q.'%')
            ->limit(7)->distinct()->get();
    }

    public function selectSearchIncItemName(Request $request)
    {
        $searchQueries = preg_split('/\s+/', $request->q, -1, PREG_SPLIT_NO_EMPTY);
        return TblInc::select('tbl_inc.id as tbl_inc_id', 'inc', 'item_name')
            ->join('link_inc_group_class', 'link_inc_group_class.tbl_inc_id', 'tbl_inc.id')
            ->join('part_master', 'part_master.link_inc_group_class_id', 'link_inc_group_class.id')
            ->where(function ($q) use ($searchQueries) {
                foreach ($searchQueries as $value) {
                    $q->orWhere('inc', 'like', '%'.$value.'%')
                    ->orWhere('item_name', 'like', '%'.$value.'%');
                }
            })->limit(7)->distinct()->get();
    }

    public function selectSearchColloquial(Request $request)
    {
        $searchQueries = preg_split('/\s+/', $request->q, -1, PREG_SPLIT_NO_EMPTY);
        return TblColloquial::select('tbl_colloquial.id as tbl_colloquial_id', 'colloquial')
            ->join('part_colloquial', 'part_colloquial.tbl_colloquial_id', 'tbl_colloquial.id')
            ->where(function ($q) use ($searchQueries) {
                foreach ($searchQueries as $value) {
                    $q->orWhere('colloquial', 'like', '%'.$value.'%');
                }
            })->limit(7)->distinct()->get();
    }

    public function selectSearchGroupClass(Request $request)
    {
        $searchQueries = preg_split('/\s+/', $request->q, -1, PREG_SPLIT_NO_EMPTY);
        return TblGroupClass::select('tbl_group_class.id as tbl_group_class_id', DB::raw('CONCAT(`group`, class) AS group_class'), 'tbl_group_class.name')
            ->join('tbl_group', 'tbl_group.id', 'tbl_group_class.tbl_group_id')
            ->join('link_inc_group_class', 'link_inc_group_class.tbl_group_class_id', 'tbl_group_class.id')
            ->join('part_master', 'part_master.link_inc_group_class_id', 'link_inc_group_class.id')
            ->where(function ($q) use ($searchQueries) {
                foreach ($searchQueries as $value) {
                    $q->orWhere(DB::raw('CONCAT(`group`, class)'), 'like', '%'.$value.'%')
                    ->orWhere('tbl_group_class.name', 'like', '%'.$value.'%');
                }
            })->limit(7)->distinct()->get();
    }

    public function selectSearchCatalogStatus(Request $request)
    {
        $searchQueries = preg_split('/\s+/', $request->q, -1, PREG_SPLIT_NO_EMPTY);
        return TblCatalogStatus::select('tbl_catalog_status.id as tbl_catalog_status_id', 'status')
            ->join('part_company', 'part_company.tbl_catalog_status_id', '=', 'tbl_catalog_status.id')
            ->join('part_master', 'part_master.id', '=', 'part_company.part_master_id')
            ->where('status', 'like', '%'.$request->q.'%')
            ->where(function ($q) use ($searchQueries) {
                foreach ($searchQueries as $value) {
                    $q->orWhere('status', 'like', '%'.$value.'%');
                }
            })->limit(7)->distinct()->get();
    }

    public function selectSearchItemType(Request $request)
    {
        $searchQueries = preg_split('/\s+/', $request->q, -1, PREG_SPLIT_NO_EMPTY);
        return TblItemType::select('tbl_item_type.id as tbl_item_type_id', 'type')
            ->join('part_master', 'part_master.tbl_item_type_id', 'tbl_item_type.id')
            ->where(function ($q) use ($searchQueries) {
                foreach ($searchQueries as $value) {
                    $q->orWhere('type', 'like', '%'.$value.'%');
                }
            })->limit(7)->distinct()->get();
    }

    public function selectSearchManufacturer(Request $request)
    {
        $searchQueries = preg_split('/\s+/', $request->q, -1, PREG_SPLIT_NO_EMPTY);
        return TblManufacturerCode::select('tbl_manufacturer_code.id as tbl_manufacturer_code_id', 'manufacturer_code', 'manufacturer_name')
            ->join('part_manufacturer_code', 'part_manufacturer_code.tbl_manufacturer_code_id', 'tbl_manufacturer_code.id')
            ->where(function ($q) use ($searchQueries) {
                foreach ($searchQueries as $value) {
                    $q->orWhere('manufacturer_code', 'like', '%'.$value.'%')
                    ->orWhere('manufacturer_name', 'like', '%'.$value.'%');
                }
            })->limit(7)->distinct()->get();
    }

    private function clean($string) {
        // source http://stackoverflow.com/questions/14114411/remove-all-special-characters-from-a-string
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        $string = preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
        $string = str_replace('-', '', $string);

        return $string;
    }

    public function selectSearchPartNumber(Request $request)
    {
        $searchQueries = preg_split('/\s+/', $request->q, -1, PREG_SPLIT_NO_EMPTY);
        return PartManufacturerCode::select('manufacturer_ref as part_number')
            ->where(function ($q) use ($searchQueries) {
                foreach ($searchQueries as $value) {
                    $q->orWhere(DB::raw('REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
                    REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
                    REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(
                    REPLACE(REPLACE(REPLACE(manufacturer_ref, \'"\', \'\'),\' \', \'\'),\'.\', \'\'),\'?\', \'\'),\'`\', \'\'),
                    \'<\', \'\'),\'=\', \'\'),\'{\', \'\'),\'}\', \'\'),\'[\', \'\'),\']\', \'\'),
                    \'|\', \'\'),'.DB::getPdo()->quote('\'').', \'\'),\':\', \'\'),\';\', \'\'),
                    \'~\', \'\'),\'!\', \'\'),\'@\', \'\'),\'#\', \'\'),\'$\', \'\'),\'%\', \'\'),
                    \'^\', \'\'),\'&\', \'\'),\'*\', \'\'),\'_\', \'\'),\'+\', \'\'),\',\', \'\'),
                    \'/\', \'\'),\'(\', \'\'),\')\', \'\'),\'-\', \'\'),\'>\', \'\')'), 
                    'like', '%'.$this->clean($value).'%');
                }
            })->limit(7)->distinct()->get();
    }

    public function selectSearchEquipment(Request $request)
    {
        $searchQueries = preg_split('/\s+/', $request->q, -1, PREG_SPLIT_NO_EMPTY);
        return TblEquipmentCode::select('tbl_equipment_code.id as tbl_equipment_code_id', 'equipment_code', 'equipment_name')
            ->join('part_equipment_code', 'part_equipment_code.tbl_equipment_code_id', 'tbl_equipment_code.id')
            ->where(function ($q) use ($searchQueries) {
                foreach ($searchQueries as $value) {
                    $q->orWhere('equipment_code', 'like', '%'.$value.'%')
                    ->orWhere('equipment_name', 'like', '%'.$value.'%');
                }
            })->limit(7)->distinct()->get();
    }

    public function selectSearchHolding(Request $request)
    {
        $searchQueries = preg_split('/\s+/', $request->q, -1, PREG_SPLIT_NO_EMPTY);
        return TblHolding::select('tbl_holding.id as tbl_holding_id', 'holding')
            ->join('part_master', 'part_master.tbl_holding_id', 'tbl_holding.id')
            ->where(function ($q) use ($searchQueries) {
                foreach ($searchQueries as $value) {
                    $q->orWhere('holding', 'like', '%'.$value.'%');
                }
            })->limit(7)->distinct()->get();
    }

    public function selectSearchCompany(Request $request)
    {
        $searchQueries = preg_split('/\s+/', $request->q, -1, PREG_SPLIT_NO_EMPTY);
        return TblCompany::select('tbl_company.id as tbl_company_id', 'company')
            ->join('part_company', 'part_company.tbl_company_id', 'tbl_company.id')
            ->join('part_master', 'part_master.id', 'part_company.part_master_id')
            ->where(function ($q) use ($searchQueries) {
                foreach ($searchQueries as $value) {
                    $q->orWhere('company', 'like', '%'.$value.'%');
                }
            })->limit(7)->distinct()->get();
    }

    public function selectSearchPlant(Request $request)
    {
        $searchQueries = preg_split('/\s+/', $request->q, -1, PREG_SPLIT_NO_EMPTY);
        return TblPlant::select('tbl_plant.id as tbl_plant_id', 'plant')
            ->join('part_bin_location', 'part_bin_location.tbl_plant_id', 'tbl_plant.id')
            ->where(function ($q) use ($searchQueries) {
                foreach ($searchQueries as $value) {
                    $q->orWhere('plant', 'like', '%'.$value.'%');
                }
            })->limit(7)->distinct()->get();
    }

    public function selectSearchLocation(Request $request)
    {
        $searchQueries = preg_split('/\s+/', $request->q, -1, PREG_SPLIT_NO_EMPTY);
        return TblLocation::select('tbl_location.id as tbl_location_id', 'location')
            ->join('part_bin_location', 'part_bin_location.tbl_location_id', 'tbl_location.id')
            ->where(function ($q) use ($searchQueries) {
                foreach ($searchQueries as $value) {
                    $q->orWhere('location', 'like', '%'.$value.'%');
                }
            })->limit(7)->distinct()->get();
    }

    public function selectSearchShelf(Request $request)
    {
        $searchQueries = preg_split('/\s+/', $request->q, -1, PREG_SPLIT_NO_EMPTY);
        return TblShelf::select('tbl_shelf.id as tbl_shelf_id', 'shelf')
            ->join('part_bin_location', 'part_bin_location.tbl_shelf_id', 'tbl_shelf.id')
            ->where(function ($q) use ($searchQueries) {
                foreach ($searchQueries as $value) {
                    $q->orWhere('shelf', 'like', '%'.$value.'%');
                }
            })->limit(7)->distinct()->get();
    }

    public function selectSearchBin(Request $request)
    {
        $searchQueries = preg_split('/\s+/', $request->q, -1, PREG_SPLIT_NO_EMPTY);
        return TblBin::select('tbl_bin.id as tbl_bin_id', 'bin')
            ->join('part_bin_location', 'part_bin_location.tbl_bin_id', 'tbl_bin.id')
            ->where(function ($q) use ($searchQueries) {
                foreach ($searchQueries as $value) {
                    $q->orWhere('bin', 'like', '%'.$value.'%');
                }
            })->limit(7)->distinct()->get();
    }

    public function selectSearchUser(Request $request)
    {
        return User::select('id as tbl_user_id', 'username', 'name')
            ->where('username', 'like', '%'.$request->q.'%')
            ->orWhere('name', 'like', '%'.$request->q.'%')
            ->get();
    }
}