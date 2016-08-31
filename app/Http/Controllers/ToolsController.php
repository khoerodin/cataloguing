<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use DB;
use Response;
use Validator;
use Auth;

use App\Models\Models\LinkIncCharacteristic;
use App\Models\LinkIncCharacteristicValue;
use App\Models\LinkIncGroupClass;

use App\Models\PartMaster;
use App\Models\Models\PartManufacturerCode;
use App\Models\PartEquipmentCode;

use App\Models\TblAbbrev;
use App\Models\TblBin;
use App\Models\Models\TblCatalogStatus;
use App\Models\TblCharacteristic;
use App\Models\TblEquipmentCode;
use App\Models\TblUserClass;
use App\Models\TblGroup;
use App\Models\TblGroupClass;
use App\Models\TblInc;
use App\Models\TblItemType;
use App\Models\TblHarmonizedCode;
use App\Models\TblHazardClass;
use App\Models\TblHolding;
use App\Models\TblCompany;
use App\Models\TblPlant;
use App\Models\TblLocation;
use App\Models\TblShelf;
use App\Models\TblSourceType;
use App\Models\TblStockType;
use App\Models\TblUnitOfMeasurement;
use App\Models\TblManufacturerCode;
use App\Models\TblPartManufacturerCodeType;
use App\Models\TblWeightUnit;


class ToolsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('web');
    }

    public function index(){
    	$tables = DB::select('show tables from smartcat;');
        return view('tools', ['tables' => $tables]);
    }

    public function dest_table($table){
    	$data = DB::select('DESCRIBE '.$table.';');
    	return Response::json($data);
    }

    public function upload(Request $request)    {

        $validator = Validator::make($request->all(), [
            'document' => 'required|mimes:xls,xlsx,ods'
        ]);

        $validator->after(function($validator) {
        	$file_max = ini_get('upload_max_filesize');
		    $file_max_str_leng = strlen($file_max);
		    $file_max_meassure_unit = substr($file_max,$file_max_str_leng - 1,1);
		    $file_max_meassure_unit = $file_max_meassure_unit == 'K' ? 'kb' : ($file_max_meassure_unit == 'M' ? 'mb' : ($file_max_meassure_unit == 'G' ? 'gb' : 'unidades'));
		    $file_max = substr($file_max,0,$file_max_str_leng - 1);
		    $file_max = intval($file_max);

		    if ($this->cekSize() == false) {
		        $validator->errors()->add('document', 'The document may not be greater than '.$file_max.' '.$file_max_meassure_unit.'.');
		    }

		});

        if ($validator->fails()) {

            if($request->ajax())
            {
                return response()->json(
                    $validator->getMessageBag()->toArray()
                , 422);
            }

            $this->throwValidationException(

                $request, $validator

            );

        }

         $file = $request->file('document');

    	if ($request->file('document')->isValid()) {
		    $manager = UploadManager::getInstance();
	        $upload = $manager->upload($file);	               

	        if($upload)
	        {
	            $upload->save();
	            $path = explode("/", $upload->path);
		        return array(
			        'file' => $path[1]
			    );
	        }
		}        
    }

    public function readSource($filename){
		$ext = pathinfo($filename, PATHINFO_EXTENSION);

    	if(strtolower($ext == 'ods')){
        	$reader = ReaderFactory::create(Type::ODS);
        }else{
        	$reader = ReaderFactory::create(Type::XLSX);
        }

        $reader->open(storage_path('app/uploads/' . $filename)); 
		foreach ($reader->getSheetIterator() as $sheet) {
			$i = -1;
			$table_name ='';
			foreach ($sheet->getRowIterator() as $rows) {
				$i++;
				if($i == 0){
					$table_name = strtoupper(trim($rows[0]));
				}
			}
		}

		if($table_name == 'TBL_ABBREV'){
			$status = array();
			echo "<table class='table table-striped table-bordered'>";
			echo "<tr><th>SOURCE COLUMN</th><th>DESTINATION COLUMN</th></tr>";
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = -1;
				foreach ($sheet->getRowIterator() as $rows) {
					$i++;
					if($i == 1){
						if(strtoupper(trim($rows[0])) == 'ABBREV'){
							echo "<tr><td>".strtoupper(trim($rows[0]))."</td><td>ABBREV</td></tr>";
							$status[] = 1;
						}else{
							echo "<tr><td class='text-danger'>".strtoupper(trim($rows[0]))."</td><td class=''>ABBREV</td></tr>";
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'FULL_TEXT'){
							echo "<tr><td>".strtoupper(trim($rows[1]))."</td><td>FULL_TEXT</td></tr>";
							$status[] = 1;
						}else{
							echo "<tr><td class='text-danger'>".strtoupper(trim($rows[1])).
							"</td><td class=''>FULL_TEXT</td></tr>";
							$status[] = 0;
						}
					}
				}				
			}			
			echo "</table>";
			
			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>Table column didn't match</span>";
			}else{
				echo "<hr/>";
				echo "<table class='table table-striped table-bordered'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = -1;
					$first = true;
					$abbrev = array();
					foreach ($sheet->getRowIterator() as $rows) {

						$i++;
						if($i > 0){
							if($first){
								echo "<tr><th>".strtoupper(trim($rows[0]))."</th>";
								echo "<th>".strtoupper(trim($rows[1]))."</th></tr>";
								$first = false;
							}else{
								echo "<tr><td>".strtoupper(trim($rows[0]))."</td>";
								echo "<td>".strtoupper(trim($rows[1]))."</td></tr>";
								$abbrev[] = strtoupper(trim($rows[0]));
							}							
						}					
						
					}					
					
				}
				echo "</table>";

				echo "validating...<br/>";

				$dupl = '';
				foreach (array_count_values($abbrev) as $key => $value) {
					if($value > 1){
						echo "<p class='text-danger'>duplicate ABBREV: $key : $value</p>";
						$dupl .= $key;
					}						
				}

				if(empty($dupl)){
					echo "validation complete.<br/>";
					echo "inserting to database...<br/>";

					/*foreach ($reader->getSheetIterator() as $sheet) {
						$i = -1;
						$first = true;
						foreach ($sheet->getRowIterator() as $rows) {
							$i++;
							if($i > 0){
								if($first){
									$first = false;
								}else{

									if (Auth::check()) {
									    $id = Auth::user()->id;

									    $data = [
								            'abbrev' => strtoupper(trim($rows[0])),
								            'full_text' => strtoupper(trim($rows[1])),
								            'created_by' => $id,
								            'last_updated_by' => $id,
								        ];
								        TblAbbrev::create($data);
									}
									
								}							
							}
							
							
						}
					}*/
					echo "Finish...";
				}

			}

		}elseif($table_name == 'INC_CHARACTERISTIC'){
			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = -1;
				foreach ($sheet->getRowIterator() as $rows) {
					$i++;
					if($i == 1){
						if(strtoupper(trim($rows[0])) == 'INC'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'CHARACTERISTIC'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'SEQUENCE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}			
			echo "</table>";
			
			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>Table column didn't match</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				echo "<div class='table-responsive'>";
				echo "<span><strong>INC CHARACTERISTIC</strong></span>";
				echo "<table class='table table-striped table-bordered'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = -1;
					$first = true;
					$no1 = 1;
					$no2 = 1;
					$no3 = 1;
					$urut = 1;
					foreach ($sheet->getRowIterator() as $rows) {
						$i++;
						if($i > 0){
							if($first){
								echo "<tr><th>NO</th>";
								echo "<th>".strtoupper(trim($rows[0]))."</th>";
								echo "<th>".strtoupper(trim($rows[1]))."</th>";
								echo "<th>".strtoupper(trim($rows[2]))."</th></tr>";
								$first = false;
							}else{

								$tbl_inc = TblInc::where('inc', strtoupper(trim($rows[0])))->first();
								if (is_null($tbl_inc)) {
									$inc_id = 'NA';
									$cek_id[] = 0;
								}else{
									$inc_id = $tbl_inc->id;
									$cek_id[] = 1;
								}

								$tbl_characteristic = TblCharacteristic::where('characteristic', strtoupper(trim($rows[1])))->first();
								if (is_null($tbl_characteristic)) {
									$characteristic_id = 'NA';
									$cek_id[] = 0;
								}else{
									$characteristic_id = $tbl_characteristic->id;
									$cek_id[] = 1;
								}

								echo "<tr><td>".$urut++."</td>";

								if(preg_match("/[a-zA-Z]/i", $inc_id)){
									echo "<td><span class='text-danger'><b>";
									echo strtoupper(trim($rows[0]));
									echo "</b></span'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[0]))." <input type='hidden' class='tbl_inc_id' name='tbl_inc_id[".$no1++."]' value='".$inc_id."'></td>";
								}

								if(preg_match("/[a-zA-Z]/i", $characteristic_id)){
									echo "<td><span class='text-danger'><b>";
									echo strtoupper(trim($rows[1]));
									echo "</b></span'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[1]))." <input type='hidden' class='tbl_characteristic_id' name='tbl_characteristic_id[".$no2++."]' value='".$characteristic_id."'></td>";
								}

								echo "<td>".strtoupper(trim($rows[2]))." <input type='hidden' class='sequence' name='sequence[".$no3++."]' value='".strtoupper(trim($rows[2]))."'></td></tr>";
							}							
						}
					}
				}
				echo in_array(0, $cek_id) ? "<p class='text-danger'>Oops, please correct your table.</p>" : "<input id='insertToDB' type='button' class='btn btn-sm btn-primary' value='IMPORT INC CHARACTERISTIC' onclick='upload_ic()'>";
				echo "</table>";
				echo "</div>";
				echo "</div>";
			}
		}elseif($table_name == 'INC_CHARACTERISTIC_VALUE'){
			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = -1;
				foreach ($sheet->getRowIterator() as $rows) {
					$i++;
					if($i == 1){
						if(strtoupper(trim($rows[0])) == 'INC'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'CHARACTERISTIC'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'VALUE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'ABBREV'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[4])) == 'APPROVED'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}			
			echo "</table>";
			
			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>Table column didn't match</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				echo "<div class='table-responsive'>";
				echo "<span><strong>GROUP CLASS</strong></span>";
				echo "<table class='table table-striped table-bordered'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = -1;
					$first = true;
					$no1 = 1;
					$no2 = 1;
					$no3 = 1;
					$no4 = 1;
					$urut = 1;
					foreach ($sheet->getRowIterator() as $rows) {
						$i++;
						if($i > 0){
							if($first){
								echo "<tr><th>NO</th>";
								echo "<th>".strtoupper(trim($rows[0]))."</th>";
								echo "<th>".strtoupper(trim($rows[1]))."</th>";
								echo "<th>INC + CHARACTERISTIC</th>";
								echo "<th>".strtoupper(trim($rows[2]))."</th>";
								echo "<th>".strtoupper(trim($rows[3]))."</th>";
								echo "<th>".strtoupper(trim($rows[4]))."</th></tr>";
								$first = false;
							}else{

								$tbl_inc = TblInc::where('inc', strtoupper(trim($rows[0])))->first();
								if (is_null($tbl_inc)) {
									$inc_id = 'NA';
									$cek_id[] = 0;	    
								}else{
									$inc_id = $tbl_inc->id;
									$cek_id[] = 1;
								}

								$tbl_char = TblCharacteristic::where('characteristic', strtoupper(trim($rows[1])))->first();
								if (is_null($tbl_char)) {
									$char_id = 'NA';
									$cek_id[] = 0;		    
								}else{
									$char_id = $tbl_char->id;
									$cek_id[] = 1;
								}

								if(!empty($inc_id) && !empty($char_id)){
									$link_inc_char = LinkIncCharacteristic::select('id')
									->where('tbl_inc_id', $inc_id)
									->where('tbl_characteristic_id', $char_id)
									->first();

									if (is_null($link_inc_char)) {
										$link_inc_char_id = 'NOT MATCH';
										$link_inc_char_idOK = '';
										$cek_id[] = 0;
									}else{
										$link_inc_char_id = 'MATCH';
										$link_inc_char_idOK = $link_inc_char->id;
										$cek_id[] = 1;
									}
									
								}else{
									$link_inc_char_id = 'NOT MATCH';
									$cek_id[] = 0;
								}			

								echo "<tr><td>".$urut++."</td>";

								if(preg_match("/[a-zA-Z]/i", $inc_id)){
									echo "<td bgcolor='red'><font color='white'><b>";
									echo strtoupper(trim($rows[0]));
									echo "</b></font'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[0]))."</td>";
								}

								if(preg_match("/[a-zA-Z]/i", $char_id)){
									echo "<td bgcolor='red'><font color='white'><b>";
									echo strtoupper(trim($rows[1]));
									echo "</b></font'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[1]))."</td>";
								}

								if($link_inc_char_id == 'MATCH'){
									echo "<td>".$link_inc_char_id." <input type='hidden' class='link_inc_characteristic_id' name='link_inc_characteristic_id[".$no1++."]' value='".$link_inc_char_idOK."'></td>";
									$cek_id[] = 1;
								}else{
									echo "<td bgcolor='red'><font color='white'><b>";
									echo $link_inc_char_id;
									$cek_id[] = 0;
									echo "</b></font'></td>";
								}

								echo "<td>".strtoupper(trim($rows[2]))." <input type='hidden' class='value' name='value[".$no2++."]' value='".strtoupper(trim($rows[2]))."'></td>";	

								echo "<td>".strtoupper(trim($rows[3]))." <input type='hidden' class='abbrev' name='abbrev[".$no3++."]' value='".strtoupper(trim($rows[3]))."'></td>";
								
								if(trim($rows[4]) == 0 || trim($rows[4]) == 1){
									echo "<td>".strtoupper(trim($rows[4]))." <input type='hidden' class='approved' name='approved[".$no4++."]' value='".strtoupper(trim($rows[4]))."'></td>";
									$cek_id[] = 1;
								}else{
									echo "<td bgcolor='red'><font color='white'><b>";
									echo strtoupper(trim($rows[4]));
									$cek_id[] = 0;
									echo "</b></font'></td>";									
								}

								echo "</tr>";
								
							}							
						}
						
						
					}					
					
				}
				echo in_array(0, $cek_id) ? "<p class='text-danger'>Oops, please correct your table.</p>" : "<input id='insertToDB' type='button' class='btn btn-sm btn-primary' value='IMPORT INC CHARACTERISTIC VALUE' onclick='upload_icv()'>";
				echo "</table>";
				echo "</div>";
				echo "</div>";
			}
		}elseif($table_name == 'LINK_INC_COLLOQUIAL'){
			$status = array();
			echo "<table class='table table-striped table-bordered'>";
			echo "<tr><th>SOURCE COLUMN</th><th>DESTINATION COLUMN</th></tr>";
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = -1;
				foreach ($sheet->getRowIterator() as $rows) {
					$i++;
					if($i == 1){
						if(strtoupper(trim($rows[0])) == 'INC'){
							echo "<tr><td>".strtoupper(trim($rows[0]))."</td><td>INC</td></tr>";
							$status[] = 1;
						}else{
							echo "<tr><td class='text-danger'>".strtoupper(trim($rows[0]))."</td><td class=''>INC</td></tr>";
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'COLLOQUIAL'){
							echo "<tr><td>".strtoupper(trim($rows[1]))."</td><td>COLLOQUIAL</td></tr>";
							$status[] = 1;
						}else{
							echo "<tr><td class='text-danger'>".strtoupper(trim($rows[1]))."</td><td class=''>COLLOQUIAL</td></tr>";
							$status[] = 0;
						}
					}
				}				
			}			
			echo "</table>";
			
			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>Table column didn't match</span>";
			}else{
				echo "<hr/>";
				echo "<table class='table table-striped table-bordered'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = -1;
					$first = true;
					foreach ($sheet->getRowIterator() as $rows) {
						$i++;
						if($i > 0){
							if($first){
								echo "<tr><th>".strtoupper(trim($rows[0]))."</th>";
								echo "<th>inc_id</th>";
								echo "<th>".strtoupper(trim($rows[1]))."</th></tr>";
								$first = false;
							}else{

								$inc_id = TblInc::where('inc', strtoupper(trim($rows[0])))->first();
								if (is_null($inc_id)) {
									$inc_id = '<span class="text-danger"><b>N/A</b></span>';
								}else{
									$inc_id = $inc_id->id;
								}		

								echo "<tr><td>".strtoupper(trim($rows[0]))."</td>";
								echo "<td>$inc_id</td>";
								echo "<td>".strtoupper(trim($rows[1]))."</td></tr>";
								
							}							
						}
						
						
					}					
					
				}
				echo "</table>";
			}
		}elseif($table_name == 'INC_GROUP_CLASS'){
			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = -1;
				foreach ($sheet->getRowIterator() as $rows) {
					$i++;
					if($i == 1){
						if(strtoupper(trim($rows[0])) == 'INC'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'GROUP'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'CLASS'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}			
			
			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>Table column didn't match</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				echo "<div class='table-responsive'>";
				echo "<span><strong>INC GROUP CLASS</strong></span>";
				echo "<table class='table table-striped table-bordered'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = -1;
					$first = true;
					$no1 = 1;
					$no2 = 1;
					$no3 = 1;
					$urut = 1;
					foreach ($sheet->getRowIterator() as $rows) {
						$i++;
						if($i > 0){
							if($first){
								echo "<tr><th width='5%'>NO</th>";
								echo "<th width='10%'>".strtoupper(trim($rows[0]))."</th>";
								echo "<th width='10%'>".strtoupper(trim($rows[1]))."</th>";
								echo "<th width='75%'>".strtoupper(trim($rows[2]))."</th></tr>";
								$first = false;
							}else{

								$tbl_inc = TblInc::where('inc', strtoupper(trim($rows[0])))->first();
								if (is_null($tbl_inc)) {
									$inc_id = 'NA';
									$cek_id[] = 0;
								}else{
									$inc_id = $tbl_inc->id;
									$cek_id[] = 1;
								}

								$tbl_group = TblGroup::where('group', strtoupper(trim($rows[1])))->first();
								if (is_null($tbl_group)) {
									$group_id = 'NA';
									$cek_id[] = 0;
								}else{
									$group_id = $tbl_group->id;
									$cek_id[] = 1;
								}

								if(preg_match("/[a-zA-Z]/i", $group_id)){
									$tbl_group_class_id = 'NA';
									$cek_id[] = 0;
								}else{
									$tbl_group_class = TblGroupClass::where('tbl_group_id', $group_id)
										->where('class', strtoupper(trim($rows[2])))->first();

									if (is_null($tbl_group_class)) {
										$tbl_group_class_id = 'NA';
										$cek_id[] = 0;
									}else{
										$tbl_group_class_id = $tbl_group_class->id;
										$cek_id[] = 1;
									}
								}

								echo "<tr><td>".$urut++."</td>";
								
								if(preg_match("/[a-zA-Z]/i", $inc_id)){
									echo "<td><span class='text-danger'><b>";
									echo strtoupper(trim($rows[0]));
									echo "</b></span'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[0]))." <input type='hidden' class='tbl_inc_id' name='tbl_inc_id[".$no1++."]' value='".$inc_id."'></td>";
								}

								if(preg_match("/[a-zA-Z]/i", $group_id)){
									echo "<td><span class='text-danger'><b>";
									echo strtoupper(trim($rows[1]));
									echo "</b></span'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[1]))." <input type='hidden' class='tbl_group_id' name='tbl_group_id[".$no2++."]' value='".$group_id."'></td>";
								}
								
								if(preg_match("/[a-zA-Z]/i", $tbl_group_class_id)){
									echo "<td><span class='text-danger'><b>";
									echo strtoupper(trim($rows[2]));
									echo "</b></span'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[2]))." <input type='hidden' class='tbl_group_class_id' name='tbl_group_class_id[".$no3++."]' value='".$tbl_group_class_id."'></td></tr>";	
								}							
							}							
						}						
					}					
					
				}
				echo in_array(0, $cek_id) ? "<p class='text-danger'>Oops, please correct your table.</p>" : "<input id='insertToDB' type='button' class='btn btn-sm btn-primary' value='IMPORT INC GROUP CLASS' onclick='upload_igc()'>";
				echo "</table>";
				echo "</div>";
				echo "</div>";
			}
		}elseif($table_name == 'PART_BIN_LOCATION'){
			$status = array();
			// echo "<table class='table table-striped table-bordered'>";
			// echo "<tr><th>SOURCE COLUMN</th><th>DESTINATION COLUMN</th></tr>";
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = -1;
				foreach ($sheet->getRowIterator() as $rows) {
					$i++;
					if($i == 1){
						if(strtoupper(trim($rows[0])) == 'PART_MASTER'){
							// echo "<tr><td>$rows[0]</td><td>PART_MASTER</td></tr>";
							$status[] = 1;
						}else{
							// echo "<tr><td class='text-danger'>$rows[0]</td><td class=''>PART_MASTER</td></tr>";
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'COMPANY'){
							// echo "<tr><td>$rows[1]</td><td>COMPANY</td></tr>";
							$status[] = 1;
						}else{
							// echo "<tr><td class='text-danger'>$rows[1]</td><td class=''>COMPANY</td></tr>";
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'PLANT'){
							// echo "<tr><td>$rows[2]</td><td>PLANT</td></tr>";
							$status[] = 1;
						}else{
							// echo "<tr><td class='text-danger'>$rows[2]</td><td class=''>PLANT</td></tr>";
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'LOCATION'){
							// echo "<tr><td>$rows[3]</td><td>LOCATION</td></tr>";
							$status[] = 1;
						}else{
							// echo "<tr><td class='text-danger'>$rows[3]</td><td class=''>LOCATION</td></tr>";
							$status[] = 0;
						}

						if(strtoupper(trim($rows[4])) == 'SHELF'){
							// echo "<tr><td>$rows[4]</td><td>SHELF</td></tr>";
							$status[] = 1;
						}else{
							// echo "<tr><td class='text-danger'>$rows[4]</td><td class=''>SHELF</td></tr>";
							$status[] = 0;
						}

						if(strtoupper(trim($rows[5])) == 'BIN'){
							// echo "<tr><td>$rows[5]</td><td>BIN</td></tr>";
							$status[] = 1;
						}else{
							// echo "<tr><td class='text-danger'>$rows[5]</td><td class=''>BIN</td></tr>";
							$status[] = 0;
						}

						if(strtoupper(trim($rows[6])) == 'SOH'){
							// echo "<tr><td>$rows[6]</td><td>STOCK_ON_HAND</td></tr>";
							$status[] = 1;
						}else{
							// echo "<tr><td class='text-danger'>$rows[6]</td><td class=''>STOCK_ON_HAND</td></tr>";
							$status[] = 0;
						}

						if(strtoupper(trim(substr($rows[7],0,3))) == 'UOM'){
							// echo "<tr><td>$rows[7]</td><td>UOM</td></tr>";
							$status[] = 1;
						}else{
							// echo "<tr><td class='text-danger'>$rows[7]</td><td class=''>UOM</td></tr>";
							$status[] = 0;
						}
					}
				}				
			}			
			// echo "</table>";
			
			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>Table column didn't match</span>";
			}else{
				echo "<hr/>";
				echo "<table class='table table-striped table-bordered'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = -1;
					$first = true;
					foreach ($sheet->getRowIterator() as $rows) {
						$i++;
						if($i > 0){
							if($first){
								echo "<tr><th>".strtoupper(trim($rows[0]))." / ID</th>";
								echo "<th>".strtoupper(trim($rows[1]))." / ID</th>";
								echo "<th>".strtoupper(trim($rows[2]))." / ID</th>";
								echo "<th>".strtoupper(trim($rows[3]))." / ID</th>";
								echo "<th>".strtoupper(trim($rows[4]))." / ID</th>";
								echo "<th>".strtoupper(trim($rows[5]))." / ID</th>";
								echo "<th>".strtoupper(trim($rows[6]))."</th>";
								echo "<th>".strtoupper(trim($rows[7]))." / ID</th></tr>";
								$uom = strtoupper(trim($rows[7]));
								$first = false;
							}else{

								$part_master = PartMaster::where('catalog_no', strtoupper(trim($rows[0])))
									->select('id','tbl_holding_id')
									->first();

								if(is_null($part_master)){
									$part_master_id = "N/A";
								}else{
									$part_master_id = $part_master->id;
								}

								$tbl_company = TblCompany::join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')
									->where('company', strtoupper(trim($rows[1])))
									->select('tbl_company.id','tbl_holding_id')
									->first();

								if(is_null($tbl_company)){
									$company_id = '<span class="text-danger"><b>N/A</b></span>';
								}else{
									$comp_hol_id = $tbl_company->tbl_holding_id;
									$master_hol_id = $part_master->tbl_holding_id;

									if($comp_hol_id == $master_hol_id){
										$company_id = $tbl_company->id;
									}else{
										$company_id = '<span class="text-danger"><b>NOT MATCH WITH CATALOG NO</b></span>';
									}
									
								}

								$tbl_plant = TblPlant::join('tbl_company', 'tbl_company.id', '=', 'tbl_plant.tbl_company_id')
									->where('plant', strtoupper(trim($rows[2])))
									->select('tbl_plant.id','tbl_company_id')
									->first();

								if(is_null($tbl_plant)){
									$plant_id = '<span class="text-danger"><b>N/A</b></span>';
								}else{
									$plant_comp_id = $tbl_plant->tbl_company_id;

									if($plant_comp_id == $company_id){
										$plant_id = $tbl_plant->id;
									}else{
										$plant_id = '<span class="text-danger"><b>NOT MATCH WITH COMPANY</b></span>';
									}									
								}

								$tbl_location = TblLocation::join('tbl_plant', 'tbl_plant.id', '=', 'tbl_location.tbl_plant_id')
									->where('location', strtoupper(trim($rows[3])))
									->select('tbl_location.id','tbl_plant_id')
									->first();

								if(is_null($tbl_location)){
									$location_id = '<span class="text-danger"><b>N/A</b></span>';
								}else{
									$loc_plant_id = $tbl_location->tbl_plant_id;

									if($loc_plant_id == $plant_id){
										$location_id = $tbl_location->id;
									}else{
										$location_id = '<span class="text-danger"><b>NOT MATCH WITH PLANT</b></span>';
									}									
								}

								$tbl_shelf = TblShelf::join('tbl_location', 'tbl_location.id', '=', 'tbl_shelf.tbl_location_id')
									->where('shelf', strtoupper(trim($rows[4])))
									->select('tbl_shelf.id','tbl_location_id')
									->first();

								if(is_null($tbl_shelf)){
									$shelf_id = '<span class="text-danger"><b>N/A</b></span>';
								}else{
									$shl_location_id = $tbl_shelf->tbl_location_id;

									if($shl_location_id == $location_id){
										$shelf_id = $tbl_shelf->id;
									}else{
										$shelf_id = '<span class="text-danger"><b>NOT MATCH WITH LOCATION</b></span>';
									}									
								}

								$tbl_bin = TblBin::join('tbl_shelf', 'tbl_shelf.id', '=', 'tbl_bin.tbl_shelf_id')
									->where('bin', strtoupper(trim($rows[5])))
									->select('tbl_bin.id','tbl_shelf_id')
									->first();

								if(is_null($tbl_bin)){
									$bin_id = '<span class="text-danger"><b>N/A</b></span>';
								}else{
									$bin_shelf_id = $tbl_bin->tbl_shelf_id;

									if($bin_shelf_id == $shelf_id){
										$bin_id = $tbl_bin->id;
									}else{
										$bin_id = '<span class="text-danger"><b>NOT MATCH WITH SHELF</b></span>';
									}									
								}

								$digit = substr($uom, -1);

								switch ($digit) {
								    case 2:
								        $digit = 'unit2';
								        break;
								    case 3:
								        $digit = 'unit3';
								        break;
								    case 4:
								        $digit = 'unit4';
								        break;
								    default:
								        $digit = 'unit3';
								}

								$tbl_unit_of_measurement = TblUnitOfMeasurement::where($digit, strtoupper(trim($rows[7])))
									->select('id')
									->first();

								if(is_null($tbl_unit_of_measurement)){
									$unit_id = '<span class="text-danger"><b>N/A</b></span>';
								}else{
									$unit_id = $tbl_unit_of_measurement->id;				
								}

								echo "<tr><td>".strtoupper(trim($rows[0]))." / ".$part_master_id."</td>";
								echo "<td>".strtoupper(trim($rows[1]))." / ".$company_id."</td>";
								echo "<td>".strtoupper(trim($rows[2]))." / ".$plant_id."</td>";
								echo "<td>".strtoupper(trim($rows[3]))." / ".$location_id."</td>";
								echo "<td>".strtoupper(trim($rows[4]))." / ".$shelf_id."</td>";
								echo "<td>".strtoupper(trim($rows[5]))." / ".$bin_id."</td>";
								echo "<td>".strtoupper(trim($rows[6]))."</td>";
								echo "<td>".strtoupper(trim($rows[7]))." / ".$unit_id."</td></tr>";
								
							}							
						}
						
						
					}					
					
				}
				echo "</table>";
			}
		}elseif($table_name == 'PART_MANUFACTURER_CODE'){
			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = -1;
				foreach ($sheet->getRowIterator() as $rows) {
					$i++;
					if($i == 1){
						if(strtoupper(trim($rows[0])) == 'PART_MASTER'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'HOLDING'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'MANUFACTURER_CODE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'SOURCE_TYPE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[4])) == 'MANUFACTURER_REF'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[5])) == 'TYPE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}
			
			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>Table column didn't match</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				echo "<div class='table-responsive'>";
				echo "<span><strong>PART MANUFACTURER CODE</strong></span>";				
				echo "<table class='table table-striped table-bordered'>";
				$cek_id = array();
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = -1;
					$first = true;
					$no1 = 1;
					$no2 = 1;
					$no3 = 1;
					$no4 = 1;
					$no5 = 1;
					$urut = 1;
					foreach ($sheet->getRowIterator() as $rows) {
						$i++;
						if($i > 0){
							if($first){
								echo "<tr><th>NO</th>";
								echo "<th>".strtoupper(trim($rows[0]))."</th>";
								echo "<th>ID</th>";
								echo "<th>".strtoupper(trim($rows[1]))."</th>";
								echo "<th>ID</th>";
								echo "<th>".strtoupper(trim($rows[2]))."</th>";
								echo "<th>ID</th>";
								echo "<th>".strtoupper(trim($rows[3]))."</th>";
								echo "<th>ID</th>";
								echo "<th>".strtoupper(trim($rows[4]))."</th>";
								echo "<th>".strtoupper(trim($rows[5]))."</th>";
								echo "<th>ID</th></tr>";
								$first = false;
							}else{

								$part_master = PartMaster::where('catalog_no', strtoupper(trim($rows[0])))
									->select('id')
									->first();

								$tbl_holding = TblHolding::where('holding', strtoupper(trim($rows[1])))
									->select('id')
									->first();

								$tbl_man_code = TblManufacturerCode::where('manufacturer_code', strtoupper(trim($rows[2])))
									->select('id')
									->first();

								$tbl_source_type = TblSourceType::where('type', strtoupper(trim($rows[3])))
									->select('id')
									->first();

								$tbl_type = TblPartManufacturerCodeType::where('type', strtoupper(trim($rows[5])))
									->select('id')
									->first();

								if(is_null($part_master)){
									$master_id = '<span class="text-danger"><b>N/A</b></span>';
									$cek_id[] = 0;
								}else{
									$master_id = $part_master->id;
									$cek_id[] = 1;
								}

								if(is_null($tbl_holding)){
									$holding_id = '<span class="text-danger"><b>N/A</b></span>';
									$cek_id[] = 0;
								}else{
									$holding_id = $tbl_holding->id;
									$cek_id[] = 1;
								}

								if(!is_null($part_master) && !is_null($tbl_holding)){
									$part_master_ok = PartMaster::where('id', $master_id)
									->where('tbl_holding_id', $holding_id)
									->select('id')
									->first();

									if(is_null($part_master_ok)){
										$part_master_id = '<span class="text-danger"><b>N/A</b></span>';
										$cek_id[] = 0;
									}else{
										$part_master_id = $part_master_ok->id;
										$cek_id[] = 1;
									}

								}else{
									$part_master_id = '<span class="text-danger"><b>N/A</b></span>';
										$cek_id[] = 0;
								}

								if(is_null($tbl_man_code)){
									$mancode_id = '<span class="text-danger"><b>N/A</b></span>';
									$cek_id[] = 0;
								}else{
									$mancode_id = $tbl_man_code->id;
									$cek_id[] = 1;
								}

								if(is_null($tbl_source_type)){
									$source_type_id = '<span class="text-danger"><b>N/A</b></span>';
									$cek_id[] = 0;
								}else{
									$source_type_id = $tbl_source_type->id;
									$cek_id[] = 1;
								}

								if(is_null($tbl_type)){
									$type_id = '<span class="text-danger"><b>N/A</b></span>';
									$cek_id[] = 0;
								}else{
									$type_id = $tbl_type->id;
									$cek_id[] = 1;
								}

								$ins_master_id = preg_match("/[a-zA-Z]/i", $part_master_id) ? "NA" : $part_master_id;
								$ins_holding_id = preg_match("/[a-zA-Z]/i", $holding_id) ? "NA" : $holding_id;
								$ins_mancode_id = preg_match("/[a-zA-Z]/i", $mancode_id) ? "NA" : $mancode_id;
								$ins_source_type_id = preg_match("/[a-zA-Z]/i", $source_type_id) ? "NA" : $source_type_id;
								$ins_type_id = preg_match("/[a-zA-Z]/i", $type_id) ? "NA" : $type_id;

								echo "<tr><td>".$urut++."</td>";
								echo "<td>".strtoupper(trim($rows[0]))."</td>";
								echo "<td>$part_master_id <input type='hidden' class='part_master_id' name='part_master_id[".$no1++."]' value='".$ins_master_id."'></td>";

								echo "<td>".strtoupper(trim($rows[1]))."</td>";

								echo "<td>$holding_id <input type='hidden' value='".$ins_holding_id."'></td>";
								echo "<td>".strtoupper(trim($rows[2]))."</td>";

								echo "<td>$mancode_id <input type='hidden' class='tbl_manufacturer_code_id' name='tbl_manufacturer_code_id[".$no2++."]' value='".$ins_mancode_id."'></td>";

								echo "<td>".strtoupper(trim($rows[3]))."</td>";

								echo "<td>$source_type_id <input type='hidden' class='tbl_source_type_id' name='tbl_source_type_id[".$no3++."]' value='".$ins_source_type_id."'></td>";

								echo "<td>".strtoupper(trim($rows[4]))."<input type='hidden' class='manufacturer_ref' name='manufacturer_ref[".$no4++."]' value='".strtoupper(trim($rows[4]))."'> </td>";

								echo "<td>".strtoupper(trim($rows[5]))."</td>";

								echo "<td>$type_id <input type='hidden' class='tbl_part_manufacturer_code_type_id' name='tbl_part_manufacturer_code_type_id[".$no5++."]' value='".$ins_type_id."'></td></tr>";
								
							}							
						}						
					}					
					
				}
				echo in_array(0, $cek_id) ? "<p class='text-danger'>Make sure the N/A cell has been filled correctly</p>" : "<input id='insertToDB' type='button' class='btn btn-sm btn-primary' value='UPLOAD TO DATABASE' onclick='upload_pmc()''>";
				echo "</table>";
				echo "</div>";
				echo "</div>";


			}
		}elseif($table_name == 'PART_EQUIPMENT_CODE'){
			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = -1;
				foreach ($sheet->getRowIterator() as $rows) {
					$i++;
					if($i == 1){
						if(strtoupper(trim($rows[0])) == 'CATALOG_NO'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'HOLDING'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'EQUIPMENT_CODE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'QTY_INSTALL'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[4])) == 'MANUFACTURER_CODE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[5])) == 'DOC_REF'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[6])) == 'DWG_REF'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}
			
			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>Table column didn't match</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				echo "<div class='table-responsive'>";
				echo "<span><strong>PART EQUIPMENT CODE</strong></span>";
				echo "<table class='table table-striped table-bordered'>";
				$cek_id = array();
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = -1;
					$first = true;
					$no1 = 1;
					$no2 = 1;
					$no3 = 1;
					$no4 = 1;
					$no5 = 1;
					$no6 = 1;
					$urut = 1;
					foreach ($sheet->getRowIterator() as $rows) {
						$i++;
						if($i > 0){
							if($first){
								echo "<tr><th>".strtoupper(trim($rows[0]))."</th>";
								echo "<th>".strtoupper(trim($rows[1]))."</th>";
								echo "<th>".strtoupper(trim($rows[2]))."</th>";
								echo "<th>".strtoupper(trim($rows[3]))."</th>";
								echo "<th>".strtoupper(trim($rows[4]))."</th>";
								echo "<th>".strtoupper(trim($rows[5]))."</th>";
								echo "<th>".strtoupper(trim($rows[6]))."</th></tr>";
								$first = false;
							}else{

								$part_master = PartMaster::where('catalog_no', strtoupper(trim($rows[0])))
									->select('id')
									->first();

								$tbl_holding = TblHolding::where('holding', strtoupper(trim($rows[1])))
									->select('id')
									->first();

								$part_eq_code = TblEquipmentCode::where('equipment_code', strtoupper(trim($rows[2])))
									->select('id')
									->first();

								$tbl_man_code = TblManufacturerCode::where('manufacturer_code', strtoupper(trim($rows[4])))
									->select('id')
									->first();

								if(is_null($part_master)){
									$master_id = '<span class="text-danger"><b>N/A</b></span>';
									$cek_id[] = 0;
								}else{
									$master_id = $part_master->id;
									$cek_id[] = 1;
								}

								if(is_null($tbl_holding)){
									$holding_id = '<span class="text-danger"><b>N/A</b></span>';
									$cek_id[] = 0;
								}else{
									$holding_id = $tbl_holding->id;
									$cek_id[] = 1;
								}

								if(!is_null($part_master) && !is_null($tbl_holding)){
									$part_master_ok = PartMaster::where('id', $master_id)
									->where('tbl_holding_id', $holding_id)
									->select('id')
									->first();

									if(is_null($part_master_ok)){
										$part_master_id = '<span class="text-danger"><b>N/A</b></span>';
										$cek_id[] = 0;
									}else{
										$part_master_id = $part_master_ok->id;
										$cek_id[] = 1;
									}

								}else{
									$part_master_id = '<span class="text-danger"><b>N/A</b></span>';
										$cek_id[] = 0;
								}

								if(is_null($part_eq_code)){
									$eq_code_id = '<span class="text-danger"><b>N/A</b></span>';
									$cek_id[] = 0;
								}else{
									$eq_code_id = $part_eq_code->id;
									$cek_id[] = 1;
								}

								if(is_null($tbl_man_code)){
									$mancode_id = '<span class="text-danger"><b>N/A</b></span>';
									$cek_id[] = 0;
								}else{
									$mancode_id = $tbl_man_code->id;
									$cek_id[] = 1;
								}

								echo "<tr><td>";
								if(preg_match("/[a-zA-Z]/i", $part_master_id)){
									echo "<span class='text-danger'><b>";
									echo strtoupper(trim($rows[0]));
									echo "</b></span'></td>";

									echo "<td><span class='text-danger'><b>";
									echo strtoupper(trim($rows[1]));
									echo "</b></span'></td>";
								}else{
									echo strtoupper(trim($rows[0]))."</td>";
									echo "<td>".strtoupper(trim($rows[1]))." 
									<input type='hidden' class='part_master_id' name='part_master_id[".$no1++."]' value='".$part_master_id."'></td>";
								}

								if(preg_match("/[a-zA-Z]/i", $eq_code_id)){
									echo "<td><span class='text-danger'><b>";
									echo strtoupper(trim($rows[2]));
									echo "</b></span'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[2]))."  <input type='hidden' class='tbl_equipment_code_id' name='tbl_equipment_code_id[".$no2++."]' value='".$eq_code_id."'></td>";
								}

								echo "<td>".strtoupper(trim($rows[3]))." <input type='hidden' class='qty_install' name='qty_install[".$no3++."]' value='".strtoupper(trim($rows[3]))."'></td>";

								if(preg_match("/[a-zA-Z]/i", $mancode_id)){
									echo "<td><span class='text-danger'><b>";
									echo strtoupper(trim($rows[4]));
									echo "</b></span'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[4]))." <input type='hidden' class='tbl_manufacturer_code_id' name='tbl_manufacturer_code_id[".$no4++."]' value='".$mancode_id."'></td>";
								}

								echo "<td>".strtoupper(trim($rows[5]))." <input type='hidden' class='doc_ref' name='doc_ref[".$no5++."]' value='".strtoupper(trim($rows[5]))."'></td>";

								echo "<td>".strtoupper(trim($rows[6]))." <input type='hidden' class='dwg_ref' name='dwg_ref[".$no6++."]' value='".strtoupper(trim($rows[6]))."'></td></tr>";
								
							}							
						}						
					}					
					
				}
				echo in_array(0, $cek_id) ? "<p class='text-danger'>Oops, please correct your table.</p>" : "<input id='insertToDB' type='button' class='btn btn-sm btn-primary' value='IMPORT PART EQUIPMENT CODE' onclick='upload_pec()''>";
				echo "</table>";
				echo "</div>";
				echo "</div>";
			}
		}elseif($table_name == 'GROUP_CLASS'){
			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = -1;
				foreach ($sheet->getRowIterator() as $rows) {
					$i++;
					if($i == 1){
						if(strtoupper(trim($rows[0])) == 'GROUP'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'CLASS'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'CLASS_NAME'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'ENG_DEFINITION'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[4])) == 'IND_DEFINITION'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}
			
			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>Table column didn't match</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				echo "<div class='table-responsive'>";
				echo "<span><strong>GROUP CLASS</strong></span>";
				echo "<table class='table table-striped table-bordered'>";
				$cek_id = array();
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = -1;
					$first = true;
					$no1 = 1;
					$no2 = 1;
					$no3 = 1;
					$no4 = 1;
					$no5 = 1;
					$urut = 1;
					foreach ($sheet->getRowIterator() as $rows) {
						$i++;
						if($i > 0){
							if($first){
								echo "<tr><th>NO</th>";
								echo "<th>".strtoupper(trim($rows[0]))."</th>";
								echo "<th>".strtoupper(trim($rows[1]))."</th>";
								echo "<th>".strtoupper(trim($rows[2]))."</th>";
								echo "<th>".strtoupper(trim($rows[3]))."</th>";
								echo "<th>".strtoupper(trim($rows[4]))."</th></tr>";
								$first = false;
							}else{

								$tbl_group = TblGroup::where('group', strtoupper(trim($rows[0])))
									->select('id')
									->first();

								if(is_null($tbl_group)){
									$group_id = '<span class="text-danger"><b>N/A</b></span>';
									$cek_id[] = 0;
								}else{
									$group_id = $tbl_group->id;
									$cek_id[] = 1;
								}

								echo "<tr><td>".$urut++."</td>";
								echo "<td>";
								if(preg_match("/[a-zA-Z]/i", $group_id)){
									echo "<span class='text-danger'><b>";
									echo strtoupper(trim($rows[0]));
									echo "</b></span'></td>";
								}else{
									echo strtoupper(trim($rows[0]))." <input type='hidden' class='tbl_group_id' name='tbl_group_id[".$no1++."]' value='".$group_id."'></td>";
								}

								echo "<td>".strtoupper(trim($rows[1]))." <input type='hidden' class='class' name='class[".$no2++."]' value='".strtoupper(trim($rows[1]))."'></td>";

								echo "<td>".strtoupper(trim($rows[2]))." <input type='hidden' class='name' name='name[".$no3++."]' value='".strtoupper(trim($rows[2]))."'></td>";

								echo "<td>".strtoupper(trim($rows[3]))." <input type='hidden' class='eng_definition' name='eng_definition[".$no4++."]' value='".strtoupper(trim($rows[3]))."'></td>";

								echo "<td>".strtoupper(trim($rows[4]))." <input type='hidden' class='ind_definition' name='ind_definition[".$no5++."]' value='".strtoupper(trim($rows[4]))."'></td></tr>";
								
							}							
						}						
					}					
					
				}
				echo in_array(0, $cek_id) ? "<p class='text-danger'>Oops, please correct your table.</p>" : "<input id='insertToDB' type='button' class='btn btn-sm btn-primary' value='IMPORT GROUP CLASS' onclick='upload_tgc()'>";
				echo "</table>";
				echo "</div>";
				echo "</div>";
			}
		}elseif($table_name == 'MASTER'){
			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = -1;
				foreach ($sheet->getRowIterator() as $rows) {
					$i++;
					if($i == 1){
						if(strtoupper(trim($rows[0])) == 'CATALOG_NO'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'HOLDING'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'HOLDING_NO'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'REF_NO'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[4])) == 'INC'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[5])) == 'GROUP'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[6])) == 'CLASS'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[7])) == 'CATALOG_TYPE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[8])) == 'UNIT_ISSUE2' || strtoupper(trim($rows[8])) == 'UNIT_ISSUE3' || strtoupper(trim($rows[8])) == 'UNIT_ISSUE4'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[9])) == 'UNIT_PURCHASE2' || strtoupper(trim($rows[9])) == 'UNIT_PURCHASE3' || strtoupper(trim($rows[9])) == 'UNIT_PURCHASE4'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[10])) == 'CATALOG_STATUS'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[11])) == 'CONVERSION'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[12])) == 'USER_CLASS'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[13])) == 'ITEM_TYPE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[14])) == 'HARMONIZED_CODE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[15])) == 'HAZARD_CLASS'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[16])) == 'WEIGHT_VALUE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[17])) == 'WEIGH_UNIT'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[18])) == 'STOCK_TYPE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[19])) == 'AVERAGE_UNIT_PRICE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
	
						if(strtoupper(trim($rows[20])) == 'MEMO'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}	
					}
				}				
			}
			
			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>Table column didn't match</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				echo "<div class='table-responsive'>";
				echo "<span><strong>MASTER</strong></span>";
				echo "<table class='table table-striped table-bordered'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = -1;
					$first = true;
					$no1 = 1;
					$no2 = 1;
					$no3 = 1;
					$no4 = 1;
					$no5 = 1;
					$no6 = 1;
					$no7 = 1;
					$no8 = 1;
					$no9 = 1;
					$no10 = 1;
					$no11 = 1;
					$no12 = 1;
					$no13 = 1;
					$no14 = 1;
					$no15 = 1;
					$no16 = 1;
					$no17 = 1;
					$no18 = 1;
					$no19 = 1;
					$no20 = 1;
					$urut = 1;
					foreach ($sheet->getRowIterator() as $rows) {
						$i++;
						if($i > 0){
							if($first){
								echo "<tr><th>NO</th>";
								echo "<th>".strtoupper(trim($rows[0]))."</th>";
								echo "<th>".strtoupper(trim($rows[1]))."</th>";
								echo "<th>".strtoupper(trim($rows[2]))."</th>";
								echo "<th>".strtoupper(trim($rows[3]))."</th>";
								echo "<th>".strtoupper(trim($rows[4]))."</th>";
								echo "<th>".strtoupper(trim($rows[5]))."</th>";								
								echo "<th>".strtoupper(trim($rows[6]))."</th>";
								echo "<th>GROUP+CLASS</th>";
								echo "<th>INC+GROUP+CLASS</th>";
								echo "<th>".strtoupper(trim($rows[7]))."</th>";								
								echo "<th>".strtoupper(trim($rows[8]))."</th>";
								echo "<th>".strtoupper(trim($rows[9]))."</th>";
								echo "<th>".strtoupper(trim($rows[10]))."</th>";
								echo "<th>".strtoupper(trim($rows[11]))."</th>";
								echo "<th>".strtoupper(trim($rows[12]))."</th>";
								echo "<th>".strtoupper(trim($rows[13]))."</th>";
								echo "<th>".strtoupper(trim($rows[14]))."</th>";
								echo "<th>".strtoupper(trim($rows[15]))."</th>";
								echo "<th>".strtoupper(trim($rows[16]))."</th>";
								echo "<th>".strtoupper(trim($rows[17]))."</th>";
								echo "<th>".strtoupper(trim($rows[18]))."</th>";
								echo "<th>".strtoupper(trim($rows[19]))."</th>";
								echo "<th>".strtoupper(trim($rows[20]))."</th></tr>";

								$uom = strtoupper(trim($rows[8]));
								$uop = strtoupper(trim($rows[9]));
								$first = false;
							}else{

								$tbl_holding = TblHolding::where('holding', strtoupper(trim($rows[1])))
									->select('id')
									->first();

								if(is_null($tbl_holding)){
									$holding_id = 'NA';
									$cek_id[] = 0;
								}else{
									$holding_id = $tbl_holding->id;
									$cek_id[] = 1;
								}

								$tbl_inc = TblInc::where('inc', strtoupper(trim($rows[4])))
									->select('id')
									->first();

								if(is_null($tbl_inc)){
									$inc_id = 'NA';
									$cek_id[] = 0;
								}else{
									$inc_id = $tbl_inc->id;
									$cek_id[] = 1;
								}

								$tbl_group = TblGroup::where('group', strtoupper(trim($rows[5])))
									->select('id')
									->first();

								if(is_null($tbl_group)){
									$group_id = 'NA';
									$cek_id[] = 0;
								}else{
									$group_id = $tbl_group->id;
									$cek_id[] = 1;
								}

								if($group_id != 'NA'){
									$tbl_group_class = TblGroupClass::where('class', strtoupper(trim($rows[6])))
										->where('tbl_group_id', $group_id)
										->select('id')
										->first();

									if(is_null($tbl_group_class)){
										$class_id = 'NA';
										$cek_id[] = 0;
									}else{
										$class_id = $tbl_group_class->id;
										$cek_id[] = 1;
									}

								}else{
									$class_id = 'NA';
									$cek_id[] = 0;
								}

								if($group_id != 'NA' AND $class_id != 'NA'){
									
									$tbl_group_class2 = TblGroupClass::where('class', strtoupper(trim($rows[6])))
									->where('tbl_group_id', $group_id)
									->select('id')
									->first();

									if(is_null($tbl_group_class2)){
										$group_class_id = 'NA';
										$cek_id[] = 0;
									}else{
										$group_class_id = $tbl_group_class->id;
										$cek_id[] = 1;
									}

								}else{
									$cek_id[] = 0;
									$group_class_id = 'NA';
								}								

								if($group_class_id != 'NA' && $inc_id != 'NA'){
									$link_inc_group_class = LinkIncGroupClass::where('tbl_group_class_id', $group_class_id)
									->where('tbl_inc_id', $inc_id)
									->select('id')
									->first();
									
									if(is_null($link_inc_group_class)){
										$inc_group_class_id = 'NA';
										$cek_id[] = 0;
									}else{
										$inc_group_class_id = $link_inc_group_class->id;
										$cek_id[] = 1;
									}
								}else{
									$inc_group_class_id = 'NA';									
									$cek_id[] = 0;
								}								

								$unit_issue = substr($uom, -1);

								switch ($unit_issue) {
								    case 2:
								        $unit_issue = 'unit2';
								        break;
								    case 3:
								        $unit_issue = 'unit3';
								        break;
								    case 4:
								        $unit_issue = 'unit4';
								        break;
								    default:
								        $unit_issue = 'unit3';
								}

								$tbl_unit_issue = TblUnitOfMeasurement::where($unit_issue, strtoupper(trim($rows[8])))
									->select('id')
									->first();

								if(is_null($tbl_unit_issue)){
									$uom_id = 'NA';
									$cek_id[] = 0;
								}else{
									$uom_id = $tbl_unit_issue->id;
									$cek_id[] = 1;
								}

								$unit_purchase = substr($uop, -1);

								switch ($unit_purchase) {
								    case 2:
								        $unit_purchase = 'unit2';
								        break;
								    case 3:
								        $unit_purchase = 'unit3';
								        break;
								    case 4:
								        $unit_purchase = 'unit4';
								        break;
								    default:
								        $unit_purchase = 'unit3';
								}

								$tbl_unit_purchase = TblUnitOfMeasurement::where($unit_purchase, strtoupper(trim($rows[9])))
									->select('id')
									->first();

								if(is_null($tbl_unit_purchase)){
									$uop_id = 'NA';
									$cek_id[] = 0;
								}else{
									$uop_id = $tbl_unit_purchase->id;
									$cek_id[] = 1;
								}

								$tbl_catalog_status = TblCatalogStatus::where('status', strtoupper(trim($rows[10])))
									->select('id')
									->first();

								if(is_null($tbl_catalog_status)){
									$cat_status_id = 'NA';
									$cek_id[] = 0;
								}else{
									$cat_status_id = $tbl_catalog_status->id;
									$cek_id[] = 1;
								}

								$tbl_user_class = TblUserClass::where('class', strtoupper(trim($rows[12])))
									->select('id')
									->first();

								if(is_null($tbl_user_class)){
									$user_class_id = 'NA';
									$cek_id[] = 0;
								}else{
									$user_class_id = $tbl_user_class->id;
									$cek_id[] = 1;
								}

								$tbl_item_type = TblItemType::where('type', strtoupper(trim($rows[13])))
									->select('id')
									->first();

								if(is_null($tbl_item_type)){
									$item_type_id = 'NA';
									$cek_id[] = 0;
								}else{
									$item_type_id = $tbl_item_type->id;
									$cek_id[] = 1;
								}

								$tbl_harmonized_code = TblHarmonizedCode::where('code', strtoupper(trim($rows[14])))
									->select('id')
									->first();

								if(is_null($tbl_harmonized_code)){
									$harmonized_code_id = 'NA';
									$cek_id[] = 0;
								}else{
									$harmonized_code_id = $tbl_harmonized_code->id;
									$cek_id[] = 1;
								}

								$tbl_hazard_class = TblHazardClass::where('class', strtoupper(trim($rows[15])))
									->select('id')
									->first();

								if(is_null($tbl_hazard_class)){
									$hazard_class_id = 'NA';
									$cek_id[] = 0;
								}else{
									$hazard_class_id = $tbl_hazard_class->id;
									$cek_id[] = 1;
								}

								$tbl_weight_unit = TblWeightUnit::where('unit', strtoupper(trim($rows[17])))
									->select('id')
									->first();

								if(is_null($tbl_weight_unit)){
									$weight_unit_id = 'NA';
									$cek_id[] = 0;
								}else{
									$weight_unit_id = $tbl_weight_unit->id;
									$cek_id[] = 1;
								}

								$tbl_stock_type = TblStockType::where('type', strtoupper(trim($rows[18])))
									->select('id')
									->first();	

								if(is_null($tbl_stock_type)){
									$stock_type_id = 'NA';
									$cek_id[] = 0;
								}else{
									$stock_type_id = $tbl_stock_type->id;
									$cek_id[] = 1;
								}							

								echo "<tr><td>".$urut++."</td>";
								echo "<td>".strtoupper(trim($rows[0]))." <input type='hidden' class='catalog_no' name='catalog_no[".$no1++."]' value='".strtoupper(trim($rows[0]))."'></td>";
								
								if(preg_match("/[a-zA-Z]/i", $holding_id)){
									echo "<td bgcolor='red'><font color='white'><b>";
									echo strtoupper(trim($rows[1]));
									echo "</b></font'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[1]))." <input type='hidden' class='tbl_holding_id' name='tbl_holding_id[".$no2++."]' value='".$holding_id."'></td>";
								}

								echo "<td>".strtoupper(trim($rows[2]))." <input type='hidden' class='holding_no' name='holding_no[".$no3++."]' value='".strtoupper(trim($rows[2]))."'></td>";

								echo "<td>".strtoupper(trim($rows[3]))." <input type='hidden' class='reference_no' name='reference_no[".$no4++."]' value='".strtoupper(trim($rows[3]))."'></td>";

								if(preg_match("/[a-zA-Z]/i", $inc_id)){
									echo "<td bgcolor='red'><font color='white'><b>";
									echo strtoupper(trim($rows[4]));
									echo "</b></font'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[4]))."</td>";
								}

								if(preg_match("/[a-zA-Z]/i", $group_id)){
									echo "<td bgcolor='red'><font color='white'><b>";
									echo strtoupper(trim($rows[5]));
									echo "</b></font'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[5]))."</td>";
								}

								if(preg_match("/[a-zA-Z]/i", $class_id)){
									echo "<td bgcolor='red'><font color='white'><b>";
									echo strtoupper(trim($rows[6]));
									echo "</b></font'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[6]))."</td>";
								}

								if(preg_match("/[a-zA-Z]/i", $group_class_id)){
									echo "<td bgcolor='red'><font color='white'><b>";
									echo "NOT MATCH";
									echo "</b></font'></td>";
								}else{
									echo "<td>MATCH</td>";
								}

								if(preg_match("/[a-zA-Z]/i", $inc_group_class_id)){
									echo "<td bgcolor='red'><font color='white'><b>";
									echo "NOT MATCH";
									echo "</b></font'></td>";
								}else{
									echo "<td>MATCH <input type='hidden' class='link_inc_group_class_id' name='link_inc_group_class_id[".$no5++."]' value='".$inc_group_class_id."'></td>";
								}

								if(strtoupper(trim($rows[7])) == 'OEM' OR strtoupper(trim($rows[7])) == 'GEN'){
									echo "<td>".strtoupper(trim($rows[7]))." <input type='hidden' class='catalog_type' name='catalog_type[".$no6++."]' value='".strtoupper(trim($rows[7]))."'></td>";
								}else{
									echo "<td bgcolor='red'><font color='white'><b>";
									echo strtoupper(trim($rows[7]));
									echo "</b></font'></td>";
								}

								if(preg_match("/[a-zA-Z]/i", $uom_id)){
									echo "<td bgcolor='red'><font color='white'><b>";
									echo strtoupper(trim($rows[8]));
									echo "</b></font'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[8]))." <input type='hidden' class='unit_issue' name='unit_issue[".$no7++."]' value='".$uom_id."'></td>";
								}

								if(preg_match("/[a-zA-Z]/i", $uop_id)){
									echo "<td bgcolor='red'><font color='white'><b>";
									echo strtoupper(trim($rows[9]));
									echo "</b></font'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[9]))." <input type='hidden' class='unit_purchase' name='unit_purchase[".$no8++."]' value='".$uop_id."'></td>";
								}

								if(preg_match("/[a-zA-Z]/i", $cat_status_id)){
									echo "<td bgcolor='red'><font color='white'><b>";
									echo strtoupper(trim($rows[10]));
									echo "</b></font'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[10]))." <input type='hidden' class='tbl_catalog_status_id' name='tbl_catalog_status_id[".$no9++."]' value='".$cat_status_id."'></td>";
								}

								echo "<td>".strtoupper(trim($rows[11]))." <input type='hidden' class='conversion' name='conversion[".$no10++."]' value='".strtoupper(trim($rows[11]))."'></td>";
								
								if(preg_match("/[a-zA-Z]/i", $user_class_id)){
									echo "<td bgcolor='red'><font color='white'><b>";
									echo strtoupper(trim($rows[12]));
									echo "</b></font'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[12]))." <input type='hidden' class='tbl_user_class_id' name='tbl_user_class_id[".$no11++."]' value='".$user_class_id."'></td>";
								}

								if(preg_match("/[a-zA-Z]/i", $item_type_id)){
									echo "<td bgcolor='red'><font color='white'><b>";
									echo strtoupper(trim($rows[13]));
									echo "</b></font'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[13]))." <input type='hidden' class='tbl_item_type_id' name='tbl_item_type_id[".$no12++."]' value='".$item_type_id."'></td>";
								}

								if(preg_match("/[a-zA-Z]/i", $harmonized_code_id)){
									echo "<td bgcolor='red'><font color='white'><b>";
									echo strtoupper(trim($rows[14]));
									echo "</b></font'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[14]))." <input type='hidden' class='tbl_harmonized_code_id' name='tbl_harmonized_code_id[".$no13++."]' value='".$harmonized_code_id."'></td>";
								}

								if(preg_match("/[a-zA-Z]/i", $hazard_class_id)){
									echo "<td bgcolor='red'><font color='white'><b>";
									echo strtoupper(trim($rows[15]));
									echo "</b></font'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[15]))." <input type='hidden' class='tbl_hazard_class_id' name='tbl_hazard_class_id[".$no14++."]' value='".$hazard_class_id."'></td>";
								}

								echo "<td>".strtoupper(trim($rows[16]))." <input type='hidden' class='weight_value' name='weight_value[".$no15++."]' value='".strtoupper(trim($rows[16]))."'></td>";

								if(preg_match("/[a-zA-Z]/i", $weight_unit_id)){
									echo "<td bgcolor='red'><font color='white'><b>";
									echo strtoupper(trim($rows[17]));
									echo "</b></font'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[17]))." <input type='hidden' class='tbl_weight_unit_id' name='tbl_weight_unit_id[".$no16++."]' value='".$weight_unit_id."'></td>";
								}

								if(preg_match("/[a-zA-Z]/i", $stock_type_id)){
									echo "<td bgcolor='red'><font color='white'><b>";
									echo strtoupper(trim($rows[18]));
									echo "</b></font'></td>";
								}else{
									echo "<td>".strtoupper(trim($rows[18]))." <input type='hidden' class='tbl_stock_type_id' name='tbl_stock_type_id[".$no17++."]' value='".$stock_type_id."'></td>";
								}

								echo "<td>".strtoupper(trim($rows[19]))." <input type='hidden' class='average_unit_price' name='average_unit_price[".$no18++."]' value='".strtoupper(trim($rows[19]))."'></td>";
								
								echo "<td>".strtoupper(trim($rows[20]))." <input type='hidden' class='memo' name='memo[".$no19++."]' value='".strtoupper(trim($rows[20]))."'></td></tr>";
								
							}							
						}						
					}
				}
				echo in_array(0, $cek_id) ? "<p class='text-danger'>Oops, please correct your table.</p>" : "<input id='insertToDB' type='button' class='btn btn-sm btn-primary' value='IMPORT MASTER' onclick='upload_m()'>";
				echo "</table>";
				echo "</div>";
				echo "</div>";
			}
		}else{
			echo "Ehem.";
		}

		
		$reader->close();
    }

    private function cekSize(){
    	$file_max = ini_get('upload_max_filesize');
	    $file_max_str_leng = strlen($file_max);
	    $file_max_meassure_unit = substr($file_max,$file_max_str_leng - 1,1);
	    $file_max_meassure_unit = $file_max_meassure_unit == 'K' ? 'kb' : ($file_max_meassure_unit == 'M' ? 'mb' : ($file_max_meassure_unit == 'G' ? 'gb' : 'unidades'));
	    $file_max = substr($file_max,0,$file_max_str_leng - 1);
	    $file_max = intval($file_max);

	    //handle second case
	    if((empty($_FILES) && empty($_POST) && isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) == 'post'))
	    {
	    	return false;
	    }
	    return true;
    }

    public function insertPmc(Request $request){
    	$this->validate($request, [
            'part_master_id.*' 						=> 'required|integer',
            'tbl_manufacturer_code_id.*' 			=> 'required|integer',
            'tbl_source_type_id.*' 					=> 'required|integer',
            'manufacturer_ref.*' 					=> 'required|max:100',
            'tbl_part_manufacturer_code_type_id.*' 	=> 'required|integer'
        ]);   

    	$part_master_id 					= $request->part_master_id;
    	$tbl_manufacturer_code_id 			= $request->tbl_manufacturer_code_id;
    	$tbl_source_type_id 				= $request->tbl_source_type_id;
    	$manufacturer_ref 					= $request->manufacturer_ref;
    	$tbl_part_manufacturer_code_type_id = $request->tbl_part_manufacturer_code_type_id;

		if (Auth::check()) {
		    $id = Auth::user()->id;

		    $dataSet = [];
			foreach ($part_master_id as $key => $value) {
			    $dataSet[] = [
			        'part_master_id'  					=> $part_master_id[$key],
			        'tbl_manufacturer_code_id'          => $tbl_manufacturer_code_id[$key],
			        'tbl_source_type_id'       			=> $tbl_source_type_id[$key],
			        'manufacturer_ref'       			=> $manufacturer_ref[$key],
			        'tbl_part_manufacturer_code_type_id'=> $tbl_part_manufacturer_code_type_id[$key],
			        'created_by' 						=> $id,
			        'last_updated_by' 					=> $id,
			        'created_at'						=> date('Y-m-d H:i:s'),
         			'updated_at'						=> date('Y-m-d H:i:s')
			    ];
			}

			PartManufacturerCode::insert($dataSet);
			return count($part_master_id);
		}
    }

    public function insertPec(Request $request){
    	$this->validate($request, [
            'part_master_id.*'            => 'required|integer',
            'tbl_equipment_code_id.*'     => 'required|integer',
            'qty_install.*'               => 'required|numeric|min:1|max:9999',
            'tbl_manufacturer_code_id.*'  => 'required|integer',
            'doc_ref.*'                   => 'required_without:dwg_ref.*|max:255',
            'dwg_ref.*'                   => 'required_without:doc_ref.*|max:255'
        ]);   

    	$part_master_id 				= $request->part_master_id;
    	$tbl_equipment_code_id 			= $request->tbl_equipment_code_id;
    	$qty_install 					= $request->qty_install;
    	$tbl_manufacturer_code_id 		= $request->tbl_manufacturer_code_id;
    	$doc_ref 						= $request->doc_ref;
    	$dwg_ref 						= $request->dwg_ref;

		if (Auth::check()) {
		    $id = Auth::user()->id;

		    $dataSet = [];
			foreach ($part_master_id as $key => $value) {
			    $dataSet[] = [
			        'part_master_id'  			=> $part_master_id[$key],
			        'tbl_equipment_code_id'     => $tbl_equipment_code_id[$key],
			        'qty_install'       		=> $qty_install[$key],
			        'tbl_manufacturer_code_id'  => $tbl_manufacturer_code_id[$key],
			        'doc_ref'       			=> $doc_ref[$key],
			        'dwg_ref'       			=> $dwg_ref[$key],
			        'created_by' 				=> $id,
			        'last_updated_by' 			=> $id,
			        'created_at'				=> date('Y-m-d H:i:s'),
         			'updated_at'				=> date('Y-m-d H:i:s')
			    ];
			}

			PartEquipmentCode::insert($dataSet);
			return count($part_master_id);
		}
    }

    public function insertTgc(Request $request){
    	$this->validate($request, [
            'tbl_group_id.*'    => 'required|integer',
            'class.*'     		=> 'required|numeric',
            'name.*'      		=> 'required|max:255',
            'eng_definition.*'  => 'required',
            'ind_definition.*'  => 'required'
        ]);   

    	$tbl_group_id 	= $request->tbl_group_id;
    	$class 			= $request->class;
    	$name 			= $request->name;
    	$eng_definition = $request->eng_definition;
    	$ind_definition = $request->ind_definition;

		if (Auth::check()) {
		    $id = Auth::user()->id;

		    $dataSet = [];
			foreach ($tbl_group_id as $key => $value) {
			    $dataSet[] = [
			        'tbl_group_id'  	=> $tbl_group_id[$key],
			        'class'     		=> $class[$key],
			        'name'     			=> $name[$key],
			        'eng_definition'	=> $eng_definition[$key],
			        'ind_definition'	=> $ind_definition[$key],
			        'created_by' 		=> $id,
			        'last_updated_by' 	=> $id,
			        'created_at'		=> date('Y-m-d H:i:s'),
         			'updated_at'		=> date('Y-m-d H:i:s')
			    ];
			}

			TblGroupClass::insert($dataSet);
			return count($tbl_group_id);
		}
    }

    public function insertIgc(Request $request){
    	$this->validate($request, [
            'tbl_inc_id.*'    		=> 'required|integer',
            'tbl_group_class_id.*'	=> 'required|integer',
        ]);   

    	$tbl_inc_id 		= $request->tbl_inc_id;
    	$tbl_group_class_id = $request->tbl_group_class_id;

		if (Auth::check()) {
		    $id = Auth::user()->id;

		    $dataSet = [];
			foreach ($tbl_inc_id as $key => $value) {
			    $dataSet[] = [
			        'tbl_inc_id'  			=> $tbl_inc_id[$key],
			        'tbl_group_class_id'    => $tbl_group_class_id[$key],
			        'created_by' 			=> $id,
			        'last_updated_by' 		=> $id,
			        'created_at'			=> date('Y-m-d H:i:s'),
         			'updated_at'			=> date('Y-m-d H:i:s')
			    ];
			}

			LinkIncGroupClass::insert($dataSet);
			return count($tbl_inc_id);
		}
    }

    public function insertIc(Request $request){
    	$this->validate($request, [
            'tbl_inc_id.*'    			=> 'required|integer',
            'tbl_characteristic_id.*'	=> 'required|integer',
            'sequence.*'				=> 'required|integer',
        ]);   

    	$tbl_inc_id 			= $request->tbl_inc_id;
    	$tbl_characteristic_id 	= $request->tbl_characteristic_id;
    	$sequence 				= $request->sequence;

		if (Auth::check()) {
		    $id = Auth::user()->id;

		    $dataSet = [];
			foreach ($tbl_inc_id as $key => $value) {
			    $dataSet[] = [
			        'tbl_inc_id'  			=> $tbl_inc_id[$key],
			        'tbl_characteristic_id' => $tbl_characteristic_id[$key],
			        'sequence' 				=> $sequence[$key],
			        'created_by' 			=> $id,
			        'last_updated_by' 		=> $id,
			        'created_at'			=> date('Y-m-d H:i:s'),
         			'updated_at'			=> date('Y-m-d H:i:s')
			    ];
			}

			LinkIncCharacteristic::insert($dataSet);
			return count($tbl_inc_id);
		}
    }

    public function insertIcv(Request $request){
    	$this->validate($request, [
            'link_inc_characteristic_id.*'	=> 'required|integer',
            'value.*'						=> 'required|max:30',
            'abbrev.*'						=> 'required|max:30',
            'approved.*'					=> 'required|digits_between:0,1',
        ]);   

    	$link_inc_characteristic_id = $request->link_inc_characteristic_id;
    	$value 						= $request->value;
    	$abbrev 					= $request->abbrev;
    	$approved 					= $request->approved;

		if (Auth::check()) {
		    $id = Auth::user()->id;

		    $dataSet = [];
			foreach ($link_inc_characteristic_id as $key => $val) {
			    $dataSet[] = [
			        'link_inc_characteristic_id'=> $link_inc_characteristic_id[$key],
			        'value' 					=> $value[$key],
			        'abbrev' 					=> $abbrev[$key],
			        'approved' 					=> $approved[$key],
			        'created_by' 				=> $id,
			        'last_updated_by' 			=> $id,
			        'created_at'				=> date('Y-m-d H:i:s'),
         			'updated_at'				=> date('Y-m-d H:i:s')
			    ];
			}

			LinkIncCharacteristicValue::insert($dataSet);
			return count($link_inc_characteristic_id);
		}
    }

    public function insertM(Request $request){
    	$this->validate($request, [
            'catalog_no.*'				=> 'required|max:30',
            'tbl_holding_id.*'			=> 'required|integer',
            'holding_no.*'				=> 'max:255',
            'reference_no.*'			=> 'max:255',
            'link_inc_group_class_id.*'	=> 'required|integer',
            'catalog_type.*'			=> 'required|in:gen,oem,GEN,OEM',
            'unit_issue.*'				=> 'integer',
            'unit_purchase.*'			=> 'integer',
            'tbl_catalog_status_id.*'	=> 'required|integer',
            'conversion.*'				=> 'string|max:30',
            'tbl_user_class_id.*'		=> 'integer',
            'tbl_item_type_id.*'		=> 'integer',
            'tbl_harmonized_code_id.*'	=> 'integer',
            'tbl_hazard_class_id.*'		=> 'integer',
            'weight_value.*'			=> 'regex:/^\d*(\.\d{2})?$/',
            'tbl_weight_unit_id.*'		=> 'integer',
            'tbl_stock_type_id.*'		=> 'integer',
            'average_unit_price.*'		=> 'regex:/^\d*(\.\d{2})?$/',
            'memo.*'					=> 'required|string',
        ]);   

    	$catalog_no 				= $request->catalog_no;
    	$tbl_holding_id 			= $request->tbl_holding_id;
    	$holding_no 				= $request->holding_no;
    	$reference_no 				= $request->reference_no;
    	$link_inc_group_class_id 	= $request->link_inc_group_class_id;
    	$catalog_type 				= $request->catalog_type;
    	$unit_issue 				= $request->unit_issue;
    	$unit_purchase 				= $request->unit_purchase;
    	$tbl_catalog_status_id 		= $request->tbl_catalog_status_id;
    	$conversion 				= $request->conversion;
    	$tbl_user_class_id 			= $request->tbl_user_class_id;
    	$tbl_item_type_id 			= $request->tbl_item_type_id;
    	$tbl_harmonized_code_id 	= $request->tbl_harmonized_code_id;
    	$tbl_hazard_class_id 		= $request->tbl_hazard_class_id;
    	$weight_value 				= $request->weight_value;
    	$tbl_weight_unit_id 		= $request->tbl_weight_unit_id;
    	$tbl_stock_type_id 			= $request->tbl_stock_type_id;
    	$average_unit_price 		= $request->average_unit_price;
    	$memo 						= $request->memo;

		if (Auth::check()) {
		    $id = Auth::user()->id;

		    $dataSet = [];
			foreach ($catalog_no as $key => $val) {
			    $dataSet[] = [
			        'catalog_no'				=> $catalog_no[$key],
			        'tbl_holding_id' 			=> $tbl_holding_id[$key],
			        'holding_no' 				=> $holding_no[$key],
			        'reference_no' 				=> $reference_no[$key],
			        'link_inc_group_class_id' 	=> $link_inc_group_class_id[$key],
			        'catalog_type' 			  	=> strtolower($catalog_type[$key]),
			        'unit_issue' 				=> $unit_issue[$key],
			        'unit_purchase' 			=> $unit_purchase[$key],
			        'tbl_catalog_status_id' 	=> $tbl_catalog_status_id[$key],
			        'conversion' 				=> $conversion[$key],
			        'tbl_user_class_id' 		=> $tbl_user_class_id[$key],
			        'tbl_item_type_id' 			=> $tbl_item_type_id[$key],
			        'tbl_harmonized_code_id' 	=> $tbl_harmonized_code_id[$key],
			        'tbl_hazard_class_id' 		=> $tbl_hazard_class_id[$key],
			        'weight_value' 				=> $weight_value[$key],
			        'tbl_weight_unit_id' 		=> $tbl_weight_unit_id[$key],
			        'tbl_stock_type_id' 		=> $tbl_stock_type_id[$key],
			        'average_unit_price' 		=> $average_unit_price[$key],
			        'memo' 						=> $memo[$key],
			        'created_by' 				=> $id,
			        'last_updated_by' 			=> $id,
			        'created_at'				=> date('Y-m-d H:i:s'),
         			'updated_at'				=> date('Y-m-d H:i:s')
			    ];
			}

			PartMaster::insert($dataSet);
			return count($catalog_no);
		}
    }
}