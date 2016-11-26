<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\CompanyCharacteristicSequence;
use App\Models\LinkIncCharacteristicValue;

use MetaTag;

class CharacteristicsSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        MetaTag::set('title', 'CHARACTERISTICS SETTINGS');
        MetaTag::set('description', 'All about this detail page');

        return view('characteristics-settings');
    }

    public function getCharacteristics($incId,$companyId)
    {
        return CompanyCharacteristicSequence::select('characteristic', 'link_inc_characteristic_id')
            ->join('link_inc_characteristic', 'link_inc_characteristic.id', '=', 'company_characteristic_sequence.link_inc_characteristic_id')
            ->join('tbl_characteristic', 'tbl_characteristic.id', '=', 'link_inc_characteristic.tbl_characteristic_id')
            ->where('tbl_inc_id', $incId)
            ->where('tbl_company_id', $companyId)
            ->orderBy('company_characteristic_sequence.sequence')
            ->get();
    }

    public function getValues($linkIncCharacteristicId)
    {
        return LinkIncCharacteristicValue::select('value','abbrev','approved')
        ->where('link_inc_characteristic_id', $linkIncCharacteristicId)
        ->get();
    }
}
