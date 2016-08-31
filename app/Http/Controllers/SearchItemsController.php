<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

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
use App\Models\TblShelf;
use App\User;

class SearchItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('web');
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
        return TblInc::select('id', 'inc', 'item_name')
            ->where('inc', 'like', '%'.$request->q.'%')
            ->orWhere('item_name', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchColloquial(Request $request)
    {
        return TblColloquial::select('id', 'colloquial')
            ->where('colloquial', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchGroupClass(Request $request)
    {
        return TblGroupClass::select('tbl_group_class.id', DB::raw('CONCAT(`group`, class) AS group_class'), 'tbl_group_class.name')
            ->join('tbl_group', 'tbl_group.id', '=', 'tbl_group_class.tbl_group_id')
            ->where(DB::raw('CONCAT(`group`, class)'), 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchCatalogStatus(Request $request)
    {
        return TblCatalogStatus::select('tbl_catalog_status.id', 'status')
            ->join('part_master', 'part_master.tbl_catalog_status_id', '=', 'tbl_catalog_status.id')
            ->where('status', 'like', '%'.$request->q.'%')
            ->distinct()->get();
    }

    public function selectSearchItemType(Request $request)
    {
        return TblItemType::select('id', 'type')
            ->where('type', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchManufacturer(Request $request)
    {
        return TblManufacturerCode::select('id', 'manufacturer_code', 'manufacturer_name')
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
            	REPLACE(REPLACE(manufacturer_ref, \'"\', \'\'),\'.\', \'\'),\'?\', \'\'),\'`\', \'\'),
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
        return TblEquipmentCode::select('id', 'equipment_code', 'equipment_name')
            ->where('equipment_code', 'like', '%'.$request->q.'%')
            ->orWhere('equipment_name', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchHolding(Request $request)
    {
        return TblHolding::select('id', 'holding')
            ->where('holding', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchCompany(Request $request)
    {
        return TblCompany::select('id', 'company')
            ->where('company', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchPlant(Request $request)
    {
        return TblPlant::select('id', 'plant')
            ->where('plant', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchLocation(Request $request)
    {
        return TblLocation::select('id', 'location')
            ->where('location', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchShelf(Request $request)
    {
        return TblShelf::select('id', 'shelf')
            ->where('shelf', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchBin(Request $request)
    {
        return TblBin::select('id', 'bin')
            ->where('bin', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectSearchUser(Request $request)
    {
        return User::select('id', 'username', 'name')
            ->where('username', 'like', '%'.$request->q.'%')
            ->orWhere('name', 'like', '%'.$request->q.'%')
            ->get();
    }

}