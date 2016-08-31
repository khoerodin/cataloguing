<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use DB;
use Datatables;
use Response;
use MetaTag;

use App\Models\LinkIncColloquial;
use App\Models\TblCharacteristic;
use App\Models\TblColloquial;
use App\Models\TblGroup;
use App\Models\TblGroupClass;
use App\Models\TblInc;

class DictionaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('web');
    }

    public function index(){
    	MetaTag::set('title', 'DICTIONARY &lsaquo; CATALOG Web App');
        MetaTag::set('description', 'Dictionary page');
    	return view('dictionary');
    }

    // ITEM NAME TAB
    // ===========================================================================================
    // ===========================================================================================
    public function getItemName(Request $request)
    {
        $tblInc = TblInc::select(['tbl_inc.id', 'inc', 'item_name', 'short_name', 'sap_code', 'sap_char_id', 'tbl_inc.eng_definition', 'tbl_inc.ind_definition'])

        ->leftJoin('link_inc_group_class', 'link_inc_group_class.tbl_inc_id', '=', 'tbl_inc.id')
        ->leftJoin('tbl_group_class', 'tbl_group_class.id', '=', 'link_inc_group_class.tbl_group_class_id')
        ->leftJoin('tbl_group', 'tbl_group.id', '=', 'tbl_group_class.tbl_group_id')        
        ->distinct('inc')

        ->SearchInc($request->inc)
        ->SearchItemName($request->item_name)
        ->SearchColloquial($request->colloquial)
        ->SearchGroup($request->group)
        ->SearchClass($request->class)
        ->SearchCharacteristic($request->characteristic);

        return Datatables::of($tblInc)->setRowId('id')
        ->editColumn('sap_char_id', '{{$sap_char_id}} <span class="pull-right"><kbd onclick="editItemName({{$id}})" class="kbd-primary cpointer">EDIT</kbd> <kbd onclick="deleteItemName({{$id}})" class="kbd-danger cpointer">DELETE</kbd></span>')
        ->make(true);
    }

    public function selectColloquial(Request $request)
    {
        return TblColloquial::select('id', 'colloquial')
            ->where('colloquial', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectGroup(Request $request)
    {
        return TblGroup::select('id', 'group', 'name')
            ->where('group', 'like', '%'.$request->q.'%')
            ->orWhere('name', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectClass(Request $request)
    {
        return TblGroupClass::select('id', 'class', 'name')
            ->where('class', 'like', '%'.$request->q.'%')
            ->orWhere('name', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function selectCharacteristic(Request $request)
    {
        return TblCharacteristic::select('id', 'characteristic')
            ->where('characteristic', 'like', '%'.$request->q.'%')
            ->get();
    }

    public function getColloquial($tblIncId)
    {
        $linkIncColloquial = LinkIncColloquial::select('tbl_colloquial.id','colloquial')
            ->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_colloquial.tbl_inc_id')
            ->join('tbl_colloquial', 'tbl_colloquial.id', '=', 'link_inc_colloquial.tbl_colloquial_id')
            ->where('tbl_inc.id', $tblIncId);

        return Datatables::of($linkIncColloquial)->setRowId('id')
        ->editColumn('colloquial', '{{$colloquial}} <span class="pull-right"><kbd onclick="editColloquial({{$id}})" class="kbd-primary cpointer">EDIT</kbd> <kbd onclick="deleteColloquial({{$id}})" class="kbd-danger cpointer">DELETE</kbd></span>')
        ->make(true);
    }
}