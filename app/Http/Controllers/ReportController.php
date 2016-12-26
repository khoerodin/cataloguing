<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyCatalog;
use App\Models\PartBinLocation;
use App\Models\PartMaster;
use App\Models\PartCharacteristicValue;
use App\Models\PartEquipmentCode;
use App\Models\PartManufacturerCode;
use App\Models\PartSourceDescription;
use App\Models\PartSourceEqCode;
use App\Models\PartSourcePartNo;
use App\Models\TblCompany;
use Vinkla\Hashids\Facades\Hashids;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function coba($key)
    {
    	return  \Helper::searchMaster($key);
    }

    private function fixedReport($key, $current, $generate, $companyId)
	{
		if($current == 1){
			$partMasterId = $key;
			$data = PartMaster::select('part_master.id as master_id', 'tbl_company.id as company_id', 'company', 'uom_type')
				->join('company_catalog', 'company_catalog.part_master_id', 'part_master.id')
				->join('tbl_company', 'tbl_company.id', 'company_catalog.tbl_company_id')
				->where('part_master.id', $partMasterId)
				->where('tbl_company.id', $companyId)
				->first();
			$data = array((object)array(
						'part_master_id' => Hashids::encode($data->master_id),
						'tbl_company_id' => Hashids::encode($data->company_id),
						'company' => $data->company,
						'uom_type' => $data->uom_type,
					));
		}else{
			$key = Hashids::encode($key);
			$data = \Helper::searchMaster($key);
		}		

		$jml = count($data);

		$html = '<style>
			body {
				font-family: arial;	
				text-transform: uppercase;
				font-size: 12px;				
			}
			h1 {
				font-size: 18px; 
				font-weight: bold;
				line-height: 0.5em;
			}
			h2 {
				font-size: 14px; 
				font-weight: bold;
				line-height: 0.5em;
			}
			table {
			    border: 1px solid black;
			    font-size: 13px;
			    border-collapse: collapse; 
			}
			table, tr, td, th {
				border: 1px solid black; 
			}
			tr.no-border td {
				border: 0;
				color: transparent;
			}
			.bg-grey {
				background-color: #e6e6e6;
			}
			table th {
				font-size: 14px;
				text-align: left;
			}
			.pre {
			    /*white-space: pre;*/
			    /*font-family: monospace;*/
			}
			div.page-break {
				page-break-after: always;
			}
			</style>

			<body>';

		$indeks = 1;
		foreach ($data as $masterValue) {
			$part_master_id = Hashids::decode($masterValue->part_master_id)[0];
			$tbl_company_id = Hashids::decode($masterValue->tbl_company_id)[0];

			// old data
			$old_source = PartSourceDescription::select('catalog_no', 'inc', 'item_name',  'group_class', 'part_source_description.unit_issue', 'short', 'source')
				->join('part_master', 'part_master.id', '=', 'part_source_description.part_master_id')
				->where('part_master_id', $part_master_id)
				->first();

			$old_part_number = PartSourcePartNo::select('manufacturer_code', 'manufacturer', 'manufacturer_ref')
				->where('part_master_id', $part_master_id)
				->get();

			$old_equipment = PartSourceEqCode::select('equipment_code', 'manufacturer_name', 'qty_install')
				->where('part_master_id', $part_master_id)
				->get();

			// ==============================================================

			// new data
			$new_master = PartMaster::select('catalog_no', 'inc', 'item_name',  \DB::raw('CONCAT(`group`, tbl_group_class.class) AS group_class'), 'unit2', 'unit3', 'unit4')
				->join('link_inc_group_class', 'link_inc_group_class.id', '=', 'part_master.link_inc_group_class_id')
				->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_group_class.tbl_inc_id')
				->join('tbl_group_class', 'tbl_group_class.id', '=', 'link_inc_group_class.tbl_group_class_id')
				->join('tbl_group', 'tbl_group.id', '=', 'tbl_group_class.tbl_group_id')
				->join('tbl_unit_of_measurement', 'tbl_unit_of_measurement.id', '=', 'part_master.unit_issue')
				->where('part_master.id', $part_master_id)
				->first();

			$new_short = \Helper::shortDesc($part_master_id, $tbl_company_id, 1);

			$charVal = PartCharacteristicValue::select('characteristic', 'company_characteristic.custom_char_name', 'link_inc_characteristic_value.value', 'company_value.custom_value_name')
				->join('link_inc_characteristic_value', 'link_inc_characteristic_value.id', '=', 'part_characteristic_value.link_inc_characteristic_value_id')
				->join('company_characteristic', 'company_characteristic.link_inc_characteristic_id', '=', 'link_inc_characteristic_value.link_inc_characteristic_id')
				->join('company_value', 'company_value.link_inc_characteristic_value_id', '=', 'link_inc_characteristic_value.id')
				->join('link_inc_characteristic', 'link_inc_characteristic.id', '=', 'link_inc_characteristic_value.link_inc_characteristic_id')
				->join('tbl_characteristic', 'tbl_characteristic.id', '=', 'link_inc_characteristic.tbl_characteristic_id')
				->where('company_characteristic.tbl_company_id', $tbl_company_id)
				->where('company_value.tbl_company_id', $tbl_company_id)
				->where('part_characteristic_value.part_master_id', $part_master_id)
				->orderBy('company_characteristic.sequence')
				->get();

			$new_man_code = PartManufacturerCode::select('manufacturer_code', 'manufacturer_name', 'manufacturer_ref')
				->join('tbl_manufacturer_code', 'tbl_manufacturer_code.id', 'part_manufacturer_code.tbl_manufacturer_code_id')
				->where('part_master_id', $part_master_id)
				->get();

			$new_eq_code = PartEquipmentCode::select('equipment_code', 'manufacturer_name', 'qty_install')
				->join('tbl_equipment_code', 'tbl_equipment_code.id', 'part_equipment_code.tbl_equipment_code_id')
				->join('tbl_manufacturer_code', 'tbl_manufacturer_code.id', 'part_equipment_code.tbl_manufacturer_code_id')
				->join('company_catalog', function($q)
	            {
	                $q->on('company_catalog.part_master_id', '=', 'part_equipment_code.part_master_id')
	                ->on('company_catalog.tbl_company_id', '=', 'tbl_equipment_code.tbl_company_id');
	            })
				->where('part_equipment_code.part_master_id', $part_master_id)
				->where('tbl_equipment_code.tbl_company_id', $tbl_company_id)
				->get();

			$list = '';
			
			if( count($charVal) > 15 ){
				$kkurangan = count($charVal) - 15;
				$list .= '<li>CHARACTERISTICS pada HASIL PEKERJAAN masih terdapat '.$kkurangan.' item lagi yang tidak ditampilkan</li>';

				$charVal = $charVal->slice(0, 15);
				$warn_char = 1;
			}else{
				$warn_char = 0;
			}

			if((count($old_part_number) + count($old_equipment)) > 10 ){
				if(count($old_part_number) > 5 && count($old_equipment) > 5){
					$list .= '<li>MAN CODE pada DATA AWAL, masih terdapat '.(count($old_part_number) - count($old_part_number->slice(0, 5))).' item lagi yang tidak ditampilkan.</li>';			
					$list .= '<li>EQUIPMENT CODE pada DATA AWAL, masih terdapat '.(count($old_equipment) - count($old_equipment->slice(0, 5))).' item lagi yang tidak ditampilkan.</li>';	

					$old_part_number = $old_part_number->slice(0, 5);
					$old_equipment = $old_equipment->slice(0, 5);							
				}elseif(count($old_part_number) <= 5 && count($old_equipment) > 5){
					$list .= '<li>EQUIPMENT CODE pada DATA AWAL, masih terdapat '.(count($old_equipment) - count($old_equipment->slice(0, 10 - count($old_part_number)))).' item lagi yang tidak ditampilkan.</li>';

					$old_part_number = $old_part_number;
					$old_equipment = $old_equipment->slice(0, 10 - count($old_part_number));
				}elseif(count($old_part_number) > 5 && count($old_equipment) <= 5){
					$list .= '<li>MAN CODE pada DATA AWAL, masih terdapat '.(count($old_part_number) - count($old_part_number->slice(0, 10 - count($old_equipment)))).' item lagi yang tidak ditampilkan.</li>';

					$old_part_number = $old_part_number->slice(0, 10 - count($old_equipment));
					$old_equipment = $old_equipment;
				}

				$warn_old = 1;
			}elseif((count($old_part_number) + count($old_equipment)) <= 10){
				$old_part_number = $old_part_number;
				$old_equipment = $old_equipment;

				$list .= '';
				$warn_old = 0;
			}

			if((count($new_man_code) + count($new_eq_code)) > 10 ){
				if(count($new_man_code) > 5 && count($new_eq_code) > 5){
					$list .= '<li>MAN CODE pada HASIL PEKERJAAN, masih terdapat '.(count($new_man_code) - count($new_man_code->slice(0, 5))).' item lagi yang tidak ditampilkan.</li>';			
					$list .= '<li>EQUIPMENT CODE pada HASIL PEKERJAAN, masih terdapat '.(count($new_eq_code) - count($new_eq_code->slice(0, 5))).' item lagi yang tidak ditampilkan.</li>';	

					$new_man_code = $new_man_code->slice(0, 5);
					$new_eq_code = $new_eq_code->slice(0, 5);							
				}elseif(count($new_man_code) <= 5 && count($new_eq_code) > 5){
					$list .= '<li>EQUIPMENT CODE pada HASIL PEKERJAAN, masih terdapat '.(count($new_eq_code) - count($new_eq_code->slice(0, 10 - count($new_man_code)))).' item lagi yang tidak ditampilkan.</li>';

					$new_man_code = $new_man_code;
					$new_eq_code = $new_eq_code->slice(0, 10 - count($new_man_code));
				}elseif(count($new_man_code) > 5 && count($new_eq_code) <= 5){
					$list .= '<li>MAN CODE pada HASIL PEKERJAAN, masih terdapat '.(count($new_man_code) - count($new_man_code->slice(0, 10 - count($new_eq_code)))).' item lagi yang tidak ditampilkan.</li>';

					$new_man_code = $new_man_code->slice(0, 10 - count($new_eq_code));
					$new_eq_code = $new_eq_code;
				}

				$warn_new = 1;
			}elseif((count($new_man_code) + count($new_eq_code)) <= 10){
				$new_man_code = $new_man_code;
				$new_eq_code = $new_eq_code;

				$list .= '';
				$warn_new = 0;
			}

			if($warn_old == 1 OR $warn_new == 1 OR $warn_char == 1){
				$warn = 1;
			}else{
				$warn = 0;
			}

			if(count($old_source)>0){
				$source_catalog_no = $old_source->catalog_no;
				$source_inc = $old_source->inc;
				$source_item_name = $old_source->item_name;
				$source_group_class = $old_source->group_class;
				$source_unit_issue = $old_source->unit_issue;
				$source_short = $old_source->short;
				$source_source = $old_source->source;
			}else{
				$source_catalog_no = '';
				$source_inc = '';
				$source_item_name = '';
				$source_group_class = '';
				$source_unit_issue = '';
				$source_short = '';
				$source_source = '';
			}

			if(count($old_part_number)>0){
				$urut = 1;
				$old_pn = '<table cellpadding="3" cellspacing="0" width="100%" style="margin-bottom: 15px;">';
				foreach ($old_part_number as $value) {
					if($urut++ == 1){
						$old_pn .= '<tr>
								<th width="20%">MAN CODE</th>
								<th width="44%">MANUFACTURER</th>
								<th width="36%">PART NUMBER</th>
							</tr>	
							<tr>
								<td>'.$value->manufacturer_code.'</td>
								<td>'.$value->manufacturer.'</td>
								<td>'.$value->manufacturer_ref.'</td>
							</tr>';
					}else{
						$old_pn .= '<tr>
								<td>'.$value->manufacturer_code.'</td>
								<td>'.$value->manufacturer.'</td>
								<td>'.$value->manufacturer_ref.'</td>
							</tr>';
					}			
				}
				$old_pn .= '</table>';
			}else{
				$old_pn = '<table style="visibility:hidden;"><tr><td></td></tr></table>';
			}

			if(count($old_equipment)>0){
				$ke = 1;
				$old_eq = '<table cellpadding="3" cellspacing="0" width="100%" style="margin-bottom: 10px;">';
				foreach ($old_equipment as $value) {
					if($ke++ == 1){
						$old_eq .= '<tr>
								<th width="20%">EQUIPMENT CODE</th>
								<th width="60%">MANUFACTURER</th>
								<th width="20%">QUANTITY INSTALL</th>
							</tr>	
							<tr>
								<td>'.$value->equipment_code.'</td>
								<td>'.$value->manufacturer_name.'</td>
								<td>'.$value->qty_install.'</td>
							</tr>';
					}else{
						$old_eq .= '<tr>
								<td>'.$value->equipment_code.'</td>
								<td>'.$value->manufacturer_name.'</td>
								<td>'.$value->qty_install.'</td>
							</tr>';
					}			
				}
				$old_eq .= '</table>';
			}else{
				$old_eq = '<table style="visibility:hidden;"><tr><td></td></tr></table>';
			}	

			if(count($new_master)>0){
				$result_catalog_no = $new_master->catalog_no;
				$result_inc = $new_master->inc;
				$result_item_name = $new_master->item_name;
				$result_group_class = $new_master->group_class;			
			}else{
				$result_catalog_no = '';
				$result_inc = '';
				$result_item_name = '';
				$result_group_class = '';
			}

			$uom_type = $masterValue->uom_type;

			if($uom_type == 2){
				$unit_issue = $new_master->unit2;
			}elseif($uom_type == 3){
				$unit_issue = $new_master->unit3;
			}elseif($uom_type == 4){
				$unit_issue = $new_master->unit4;
			}else{
				$unit_issue = '';
			}

			$i = 1;
			$cv = '';
			foreach ($charVal as $value) {
				if($value->custom_char_name){
					$char = $value->custom_char_name;
				}else{
					$char = $value->characteristic;			
				}

				if($value->custom_value_name){
					$val = $value->custom_value_name;
				}else{
					$val = $value->value;			
				}

				if($i++ == 1){
					$cv .= '<tr>
						<td width="35%">'.$char.'</td>
						<td>'.$val.'</td>
					</tr>';
				}else{
					$cv .= '<tr>
						<td>'.$char.'</td>
						<td>'.$val.'</td>
					</tr>';
				}
			}

			$emptyTrCount = 15 - count($charVal);
				$cv .= str_repeat('<tr><td width="35%" style="color:transparent;">*</td><td></td></tr>', $emptyTrCount);

			if(count($new_man_code)>0){
				$urutan = 1;
				$new_mc = '<table cellpadding="3" cellspacing="0" width="100%" style="margin-bottom: 15px;">';
				foreach ($new_man_code as $value) {
					if($urutan++ == 1){
						$new_mc .= '<tr>
								<th width="20%">MAN CODE</th>
								<th width="44%">MANUFACTURER</th>
								<th width="36%">PART NUMBER</th>
							</tr>	
							<tr>
								<td>'.$value->manufacturer_code.'</td>
								<td>'.str_limit($value->manufacturer_name, 36).'</td>
								<td>'.$value->manufacturer_ref.'</td>
							</tr>';
					}else{
						$new_mc .= '<tr>
								<td>'.$value->manufacturer_code.'</td>
								<td>'.str_limit($value->manufacturer_name, 36).'</td>
								<td>'.$value->manufacturer_ref.'</td>
							</tr>';
					}			
				}
				$new_mc .= '</table>';
			}else{
				$new_mc = '<table style="visibility:hidden;"><tr><td></td></tr></table>';
			}

			if(count($new_eq_code)>0){
				$seq = 1;
				$new_eq = '<table cellpadding="3" cellspacing="0" width="100%" style="margin-bottom: 10px;">';
				foreach ($new_eq_code as $value) {
					if($seq++ == 1){
						$new_eq .= '<tr>
								<th width="20%">EQUIPMENT CODE</th>
								<th width="60%">MANUFACTURER</th>
								<th width="20%">QUANTITY INSTALL</th>
							</tr>	
							<tr>
								<td>'.$value->equipment_code.'</td>
								<td>'.$value->manufacturer_name.'</td>
								<td>'.$value->qty_install.'</td>
							</tr>';
					}else{
						$new_eq .= '<tr>
								<td>'.$value->equipment_code.'</td>
								<td>'.$value->manufacturer_name.'</td>
								<td>'.$value->qty_install.'</td>
							</tr>';
					}			
				}
				$new_eq .= '</table>';
			}else{
				$new_eq = '<table style="visibility:hidden;"><tr><td></td></tr></table>';
			}

			if($warn == 1){
				$warn = '- Karena terbatasnya tempat, berikut data yang tidak ditampilkan secara legkap dalam lembar laporan ini:';
			}else{
				$warn = '';
			}

			$html .= '<div style="position: relative; height: 1000px;"><h2><center>LAPORAN HARIAN</center></h2> 
				<h2><center>HASIL PEKERJAAN CLEAN UP SPARE PART CATALOGUING</center></h2>
				<h1><center>'.$masterValue->company.'</center></h1>
				<br>

				<span style="float:left; width: 49.5%;">
					<table cellpadding="3" cellspacing="0" width="100%" style="margin-bottom: 15px;">
						<tr>
							<th class="bg-grey" colspan="2">DATA AWAL</th>
						</tr>
					</table>

					<table cellpadding="3" cellspacing="0" width="100%" style="margin-bottom: 15px;">
						<tr>
							<td width="35%">STOCK NUMBER</td>
							<td>'.$source_catalog_no.'</td>
						</tr>
						<tr>
							<td>INC</td>
							<td>'.$source_inc.'</td>
						</tr>
						<tr>
							<td>ITEM NAME</td>
							<td>'.$source_item_name.'</td>
						</tr>
						<tr>
							<td>GROUP CLASS</td>
							<td>'.$source_group_class.'</td>
						</tr>
						<tr>
							<td>UNIT OF ISSUE</td>
							<td>'.$source_unit_issue.'</td>
						</tr>
					<table>

					<table cellpadding="3" cellspacing="0" width="100%" style="margin-bottom: 15px;">
						<tr>
							<td width="35%">SHORT DESCRIPTION</td>
							<td>'.$source_short.'</td>
						</tr>
					</table>

					<table cellpadding="1" cellspacing="0" width="100%" style="margin-bottom: 15px;">
						<tr>
							<th colspan="2">SOURCE DATA</th>
						</tr>
						<tr>
							<td><div style="height: 268px; overflow:hidden;">'.nl2br($source_source).'</div></td>
						</tr>
					<table>
					'.$old_pn.'
					'.$old_eq.'
				</span>

				<span style="float:right; width: 49.5%;">
					<table cellpadding="3" cellspacing="0" width="100%" style="margin-bottom: 15px;">
						<tr>
							<th class="bg-grey" colspan="2">HASIL PEKERJAAN</th>
						</tr>
					</table>
	
					<table cellpadding="3" cellspacing="0" width="100%" style="margin-bottom: 15px;">
						<tr>
							<td width="35%">STOCK NUMBER</td>
							<td>'.$result_catalog_no.'</td>
						</tr>
						<tr>
							<td>INC</td>
							<td>'.$result_inc.'</td>
						</tr>
						<tr>
							<td>ITEM NAME</td>
							<td>'.$result_item_name.'</td>
						</tr>
						<tr>
							<td>GROUP CLASS</td>
							<td>'.$result_group_class.'</td>
						</tr>
						<tr>
							<td>UNIT OF ISSUE</td>
							<td>'.$unit_issue.'</td>
						</tr>
					<table>

					<table cellpadding="3" cellspacing="0" width="100%" style="margin-bottom: 15px;">
						<tr>
							<td width="35%">SHORT DESCRIPTION</td>
							<td>'.$new_short.'</td>
						</tr>
					</table>

					<table cellpadding="1" cellspacing="0" width="100%" style="margin-bottom: 15px;">
						<tr>
							<th colspan="2">CHARACTERISTICS</th>
						</tr>
						'.$cv.'
					<table>
					'.$new_mc.'				
					'.$new_eq.'
				</span>	
				
				<div style="position: absolute; left: 0; bottom: 0; font-size: 13px; text-transform: initial; font-style: italic; width: 49.5%;">
					'.$warn.' 
					<ul>
						'.$list.'
					</ul>

					<!-- - Status : QA by Agus Nasrudin, printed on 18-NOV-2016 : 13:59 //-->
				</div>
				
				<div style="position: absolute; right: 0; bottom: 0;" width: 49.5%;">

					<div>
						<strong>TELAH DIPERIKSA</strong>
					</div>
					<div>
						PADA TANGGAL : .....................................
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						PADA TANGGAL : ......................................
					</div>

					<div style="margin-bottom: 61px;">
						Counter Part Catalog
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						Kordinator Counter Part Catalog
					</div>

					<div>
						(.......................................................................)
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						(.......................................................................)
					</div>

				</div>

			</div>';

			if($indeks++ != $jml){
				$html .= '<div style="page-break-after: always;"></div>';
			}
		}

		$html .= '</body>';

		return $this->generate($html, $generate);
	}

	private function generate($html, $generate)
	{
		$title = 'CATALOG REPORT';
		$pdf = \PDF::loadHTML($html)
			->setPaper('a3')
			->setOption('title', $title)
			->setOrientation('landscape');
		
		if($generate == 1){
			return $pdf->inline(snake_case('catalogReport_'.\Carbon\Carbon::now('GMT+7')).'.pdf');
		}else{
			return $pdf->download(snake_case('catalogReport_'.\Carbon\Carbon::now('GMT+7')).'.pdf');
		}
	}

	public function report($keys)
	{
		$decoded = Hashids::decode($keys);

		$key = $decoded[0];
		$current = $decoded[1];
		$type = $decoded[2];
		$generate = $decoded[3];
		$companyId = $decoded[4];

		if($type == 1){
			return $this->fixedReport($key, $current, $generate, $companyId);
		}else{
			return $this->fullReport($key, $current, $generate, $companyId);
		}
	}

}
