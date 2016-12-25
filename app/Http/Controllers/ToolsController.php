<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use zgldh\UploadManager\UploadManager;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

use App\Models\LinkIncCharacteristic;
use App\Models\LinkIncCharacteristicValue;
use App\Models\LinkIncGroupClass;

use App\Models\PartMaster;
use App\Models\PartManufacturerCode;
use App\Models\PartEquipmentCode;

use App\Models\TblAbbrev;
use App\Models\TblBin;
use App\Models\TblCatalogStatus;
use App\Models\TblCharacteristic;
use App\Models\TblEquipmentCode;
use App\Models\TblEquipmentPlant;
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
    }

    public function index(){
    	\MetaTag::set('title', 'TOOLS &lsaquo; CATALOG Web App');
       \MetaTag::set('description', 'Tools page');

    	$tables = \DB::select('show tables from '.\Config::get('database.connections.mysql.database').';');
        return view('tools', ['tables' => $tables]);
    }

    public function dest_table($table){
    	$data = \DB::select('DESCRIBE '.$table.';');
    	return \Response::json($data);
    }

    public function upload(Request $request)    {

        $validator = \Validator::make($request->all(), [
            'document' => 'required|mimes:xlsx,ods'
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

    private function readSpreadSheet($filename){
    	$ext = pathinfo($filename, PATHINFO_EXTENSION);

    	if(strtolower($ext == 'ods')){
        	$reader = ReaderFactory::create(Type::ODS);
        }else{
        	$reader = ReaderFactory::create(Type::XLSX);
        }

        $reader->open(storage_path('app/uploads/' . $filename));
		return $reader;
    }

    public function readSource2($filename){
		
    	$reader = $this->readSpreadSheet($filename);

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
				echo "<span><strong>INC CHARACTERISTIC VALUE</strong></span>";
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

		if (\Auth::check()) {
		    $id = \Auth::user()->id;

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

		if (\Auth::check()) {
		    $id = \Auth::user()->id;

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

		if (\Auth::check()) {
		    $id = \Auth::user()->id;

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

		if (\Auth::check()) {
		    $id = \Auth::user()->id;

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

		if (\Auth::check()) {
		    $id = \Auth::user()->id;

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

		if (\Auth::check()) {
		    $id = \Auth::user()->id;

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

		if (\Auth::check()) {
		    $id = \Auth::user()->id;

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

    public function readSource($filename){		
    	$reader = $this->readSpreadSheet($filename);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$table_name ='';
			foreach ($sheet->getRowIterator() as $rows) {
				if($i++ == 1){
					$table_name = strtoupper(trim($rows[0]));
				}
			}
		}

		if($table_name == 'INC'){
			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'INC'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'ITEM NAME'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'SHORT NAME'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'ENG DEFINITION'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[4])) == 'IND DEFINITION'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}
			
			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>TABLE COLUMN DIDN'T MATCH</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF INC</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_duplicate_inc = [];
					$check_duplicate_item_name = [];
					$check_duplicate_short_name = [];

					$check_empty_inc = [];
					$check_empty_item_name = [];
					$check_empty_short_name = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='5%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='30%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "<th width='20%'>".strtoupper(trim($rows[2]))."</th>";
								$table .= "<th width='20%'>".strtoupper(trim($rows[3]))."</th>";
								$table .= "<th width='15%'>".strtoupper(trim($rows[4]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// VALIDATION
								// ===============================================
								$inc_column = TblInc::where('inc', trim($rows[0]))
									->select('inc')
									->first();

								if(count($inc_column)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = '<b>INC:</b> '.strtoupper(trim($rows[0]));
								}else{
									$cek_already_in_db[] = 1;
								}

								if(strlen(trim($rows[0])) > 5){
									$max_str[] = 0;
									$warn_max_str[] = '<b>INC</b> "'.strtoupper(trim($rows[0])).'" LENGTH MAY NOT BE GREATER THAN 5';
								}else{
									$max_str[] = 1;
								}

								$item_name_column = TblInc::where('item_name', trim($rows[1]))
									->select('item_name')
									->first();

								if(count($item_name_column)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = '<b>ITEM NAME:</b> '.strtoupper(trim($rows[1]));
								}else{
									$cek_already_in_db[] = 1;
								}

								if(strlen(trim($rows[1])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = '<b>ITEM NAME</b> "'.strtoupper(trim($rows[1])).'" LENGTH MAY NOT BE GREATHER THAN 255';
								}else{
									$max_str[] = 1;
								}

								$short_name_column = TblInc::where('short_name', trim($rows[2]))
									->select('short_name')
									->first();

								if(count($short_name_column)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = '<b>SHORT NAME:</b> '.strtoupper(trim($rows[2]));
								}else{
									$cek_already_in_db[] = 1;
								}

								if(strlen(trim($rows[2])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = '<b>SHORT NAME</b> "'.strtoupper(trim($rows[2])).'" LENGTH MAY NOT BE GREATHER THAN 255';
								}else{
									$max_str[] = 1;
								}							
							
								$check_duplicate_inc[] .= $rows[0];	
								$check_duplicate_item_name[] .= $rows[1];	
								$check_duplicate_short_name[] .= $rows[2];

								$check_empty_inc[] .= $rows[0];
								$check_empty_item_name[] .= $rows[1];
								$check_empty_short_name[] .= $rows[2];

								// TABLE
								// ====================================================
								$table .= "<tr><td>".$urut++."</td>";
								$table .= "<td>".strtoupper(trim($rows[0]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[1]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[2]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[3]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[4]))."</td></tr>";

								$data_counter[] = 1;
							}							
						}						
					}					
					
				}
				$table .= "</tbody></table>";

				// hitung jml inc
				$inc_check_duplicate = array_count_values($check_duplicate_inc);
				// jika inc lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_inc = array();
				foreach ($inc_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_inc[] = 0;
					}else{
						$chek_dupl_inc[] = 1;
					}
				}

				// hitung jml item name
				$item_name_check_duplicate = array_count_values($check_duplicate_item_name);
				// jika item name lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_item_name = array();
				foreach ($item_name_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_item_name[] = 0;
					}else{
						$chek_dupl_item_name[] = 1;
					}
				}

				// hitung jml short name
				$short_name_check_duplicate = array_count_values($check_duplicate_short_name);
				// jika short name lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_short_name = array();
				foreach ($short_name_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_short_name[] = 0;
					}else{
						$chek_dupl_short_name[] = 1;
					}
				}			

				$empty_inc = array();
				foreach ($check_empty_inc as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_inc[] = 0;
					 }else{
					 	$empty_inc[] = 1;
					 }
				}

				$empty_item_name = array();
				foreach ($check_empty_item_name as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_item_name[] = 0;
					 }else{
					 	$empty_item_name[] = 1;
					 }
				}

				$empty_short_name = array();
				foreach ($check_empty_short_name as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_short_name[] = 0;
					 }else{
					 	$empty_short_name[] = 1;
					 }
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY INC DATA</span>';
				}elseif(
					// cek apakah terdapat item yang sudah ada dalam database
					in_array(0, $cek_already_in_db) || 
					// cek apakah terdapat item yang melebihi maksimum string
					in_array(0, $max_str) || 
					// cek apakah terdapat inc yang duplikat
					in_array(0, $chek_dupl_inc) ||
					// cek apakah terdapat item name yang duplikat
					in_array(0, $chek_dupl_item_name) ||
					// cek apakah terdapat short name yang duplikat
					in_array(0, $chek_dupl_short_name) ||
					// cek apakah terdapat inc yang kosong
					in_array(0, $empty_inc) ||
					// cek apakah terdapat item name yang kosong
					in_array(0, $empty_item_name) ||
					// cek apakah terdapat short name yang kosong
					in_array(0, $empty_short_name)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR INC SPREADSHEET</strong></span>";
					
					$already = '';
					if(in_array(0, $cek_already_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>ALREADY IN DATABASE:</u> </strong>";
						foreach ($warn_already_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$already = $validasi;
					}

					$max_length = '';
					if(in_array(0, $max_str)){
						$validasi = "<br><br><strong class='text-danger'><u>CHARACTER LENGTH MORE THAN ALLOWED:</u> </strong>";
						foreach ($warn_max_str as $value) {
							$validasi .= '<br/>'.$value;
						}
						$max_length = $validasi;
					}

					$dupl_inc_ = '';
					$dupl_inc = '';
					if(in_array(0, $chek_dupl_inc)){
						$validasi = '';
						// count inc to get duplicate (> 1)
						$check_duplicate_inc_again = array_count_values($check_duplicate_inc);

						// remove empty inc
						foreach($check_duplicate_inc_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_inc_again[$key]);
						}

						// get only > 1 inc
						$ada = array();
						foreach ($check_duplicate_inc_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$validasi .= "</span>";
						$dupl_inc_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_inc .= "<br><br><strong class='text-danger'><u>DUPLICATE INC:</u> </strong> ";
							$dupl_inc .= $dupl_inc_;
						}else{
							$dupl_inc .= '';
						}
					}

					$dupl_item_name_ = '';
					$dupl_item_name = '';
					if(in_array(0, $chek_dupl_item_name)){
						$validasi = '';
						
						// count item name to get duplicate (> 1)
						$check_duplicate_item_name_again = array_count_values($check_duplicate_item_name);

						// remove empty item name
						foreach($check_duplicate_item_name_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_item_name_again[$key]);
						}

						// get only > 1 item name
						$ada = array();
						foreach ($check_duplicate_item_name_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_item_name_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_item_name  = "<br><br><strong class='text-danger'><u>DUPLICATE ITEM NAME:</u></strong> ";
							$dupl_item_name .= $dupl_item_name_;
						}else{
							$dupl_item_name = '';
						}
					}

					$dupl_short_name_ = '';
					$dupl_short_name = '';
					if(in_array(0, $chek_dupl_short_name)){
						$validasi = '';
						
						// count short name to get duplicate (> 1)
						$check_duplicate_short_name_again = array_count_values($check_duplicate_short_name);

						// remove empty short name
						foreach($check_duplicate_short_name_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_short_name_again[$key]);
						}

						// get only > 1 short name
						$ada = array();
						foreach ($check_duplicate_short_name_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_short_name_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_short_name  = "<br><br><strong class='text-danger'><u>DUPLICATE SHORT NAME:</u></strong> ";
							$dupl_short_name .= $dupl_short_name_;
						}else{
							$dupl_short_name = '';
						}
					}

					$inc_empty = '';
					if(in_array(0, $empty_inc)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY INC:</u> </strong> ";
						$i = 3;
						foreach ($check_empty_inc as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.';
							 }else{
							 	$i++;
							 }
						}
						$inc_empty = $validasi;
					}

					$item_name_empty = '';
					if(in_array(0, $empty_item_name)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY ITEM NAME:</u> </strong> ";
						$i = 3;
						foreach ($check_empty_item_name as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.';
							 }else{
							 	$i++;
							 }
						}
						$item_name_empty = $validasi;
					}

					$short_name_empty = '';
					if(in_array(0, $empty_short_name)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY SHORT NAME:</u> </strong> ";
						$i = 3;
						foreach ($check_empty_short_name as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.';
							 }else{
							 	$i++;
							 }
						}
						$short_name_empty = $validasi;
					}			

					echo $already;
					echo $max_length;
					echo $dupl_inc;
					echo $dupl_item_name;
					echo $dupl_short_name;
					echo $inc_empty;
					echo $item_name_empty;
					echo $short_name_empty;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_inc btn btn-sm btn-primary' value='IMPORT INC DATA'>";
					echo $table;
				}
				echo "</div>";
			}
		}elseif($table_name == 'CHARACTERISTIC'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'CHARACTERISTIC'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'LABEL'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'POSITION'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'ADD SPACE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[4])) == 'TYPE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}

			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>TABLE COLUMN DIDN'T MATCH</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF CHARACTERISTIC</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;
					$urut2 = 3;

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_duplicate_characteristic = [];
					$check_duplicate_label = [];

					$check_empty_characteristic = [];
					$check_empty_label = [];

					$cek_wrong_value = [];
					$warn_wrong_value = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='37%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='30%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "<th width='10%'>".strtoupper(trim($rows[2]))."</th>";
								$table .= "<th width='10%'>".strtoupper(trim($rows[3]))."</th>";
								$table .= "<th width='10%'>".strtoupper(trim($rows[4]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// VALIDATION
								// ===============================================
								
								// CEK ALREADY IN DB
								$characteristic_column = TblCharacteristic::where('characteristic', trim($rows[0]))
									->select('characteristic')
									->first();

								if(count($characteristic_column)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = '<b>CHARACTERISTIC:</b> '.strtoupper(trim($rows[0]));
								}else{
									$cek_already_in_db[] = 1;
								}

								$label_column = TblCharacteristic::where('label', trim($rows[1]))
									->select('label')
									->first();

								if(count($label_column)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = '<b>LABEL:</b> '.strtoupper(trim($rows[1]));
								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[0])) > 30){
									$max_str[] = 0;
									$warn_max_str[] = '<b>CHARACTERISTIC</b> "'.strtoupper(trim($rows[0])).'" LENGTH MAY NOT BE GREATER THAN 30';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[1])) > 30){
									$max_str[] = 0;
									$warn_max_str[] = '<b>LABEL</b> "'.strtoupper(trim($rows[1])).'" LENGTH MAY NOT BE GREATER THAN 30';
								}else{
									$max_str[] = 1;
								}

								$check_duplicate_characteristic[] .= $rows[0];	
								$check_duplicate_label[] .= $rows[1];

								$check_empty_characteristic[] .= $rows[0];
								$check_empty_label[] .= $rows[1];

								// CEK WRONG VALUE
								$urutan = $urut2++;
								if(
									strtoupper(trim($rows[2])) != 'BEFORE' &&
									strtoupper(trim($rows[2])) != 'AFTER'
								){
									$cek_wrong_value[] = 0;
									$warn_wrong_value[] = '<b>POSITION</b> COLUMN ON LINE <b>#'.$urutan.'</b> MUST BE FILLED WITH "BEFORE" OR "AFTER"';
								}else{
									$cek_wrong_value[] = 1;
								}

								if(
									strtoupper(trim($rows[3])) != 'YES' &&
									strtoupper(trim($rows[3])) != 'NO'
								){
									$cek_wrong_value[] = 0;
									$warn_wrong_value[] = '<b>ADD SPACE</b> COLUMN ON LINE <b>#'.$urutan.'</b> MUST BE FILLED WITH "YES" OR "NO"';
								}else{
									$cek_wrong_value[] = 1;
								}

								if(
									strtoupper(trim($rows[4])) != 'OEM' &&
									strtoupper(trim($rows[4])) != 'GEN'
								){
									$cek_wrong_value[] = 0;
									$warn_wrong_value[] = '<b>TYPE</b> COLUMN ON LINE <b>#'.$urutan.'</b> MUST BE FILLED WITH "OEM" OR "GEN"';
								}else{
									$cek_wrong_value[] = 1;
								}

								// TABLE
								// ====================================================
								$table .= "<tr><td>".$urut++."</td>";
								$table .= "<td>".strtoupper(trim($rows[0]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[1]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[2]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[3]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[4]))."</td></tr>";

								$data_counter[] = 1;								
							}							
						}						
					}					
					
				}
				$table .= "</tbody></table>";

				// hitung jml characteristic
				$characteristic_check_duplicate = array_count_values($check_duplicate_characteristic);
				// jika characteristic lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_characteristic = array();
				foreach ($characteristic_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_characteristic[] = 0;
					}else{
						$chek_dupl_characteristic[] = 1;
					}
				}

				// hitung jml label
				$label_check_duplicate = array_count_values($check_duplicate_label);
				// jika label lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_label = array();
				foreach ($label_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_label[] = 0;
					}else{
						$chek_dupl_label[] = 1;
					}
				}

				$empty_characteristic = array();
				foreach ($check_empty_characteristic as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_characteristic[] = 0;
					 }else{
					 	$empty_characteristic[] = 1;
					 }
				}

				$empty_label = array();
				foreach ($check_empty_label as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_label[] = 0;
					 }else{
					 	$empty_label[] = 1;
					 }
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY CHARACTERISTIC DATA.</span>';
				}elseif(
					// cek apakah terdapat item yang sudah ada dalam database
					in_array(0, $cek_already_in_db) ||
					// cek apakah terdapat item yang melebihi maksimum string
					in_array(0, $max_str) ||
					// cek apakah terdapat characteristic yang duplikat
					in_array(0, $chek_dupl_characteristic) ||
					// cek apakah terdapat label yang duplikat
					in_array(0, $chek_dupl_label) ||
					// cek apakah terdapat characteristic yang kosong
					in_array(0, $empty_characteristic) ||
					// cek apakah terdapat label yang kosong
					in_array(0, $empty_label) ||
					// cek apakan kolom position atau add space atau type mempunyai value yg benar
					in_array(0, $cek_wrong_value)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR CHARACTERISTIC SPREADSHEET</strong></span>";
					
					$already = '';
					if(in_array(0, $cek_already_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>ALREADY IN DATABASE:</u> </strong>";
						foreach ($warn_already_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$already = $validasi;
					}

					$max_length = '';
					if(in_array(0, $max_str)){
						$validasi = "<br><br><strong class='text-danger'><u>CHARACTER LENGTH MORE THAN ALLOWED:</u></strong>";
						foreach ($warn_max_str as $value) {
							$validasi .= '<br/>'.$value;
						}
						$max_length = $validasi;
					}

					$dupl_characteristic_ = '';
					$dupl_characteristic = '';
					if(in_array(0, $chek_dupl_characteristic)){
						$validasi = '';
						// count characteristic to get duplicate (> 1)
						$check_duplicate_characteristic_again = array_count_values($check_duplicate_characteristic);

						// remove empty characteristic
						foreach($check_duplicate_characteristic_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_characteristic_again[$key]);
						}

						// get only > 1 characteristic
						$ada = array();
						foreach ($check_duplicate_characteristic_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_characteristic_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_characteristic .= "<br><br><strong class='text-danger'><u>DUPLICATE CHARACTERISTIC:</u> </strong> ";
							$dupl_characteristic .= $dupl_characteristic_;
						}else{
							$dupl_characteristic .= '';
						}
					}

					$dupl_label_ = '';
					$dupl_label = '';
					if(in_array(0, $chek_dupl_label)){
						$validasi = '';
						// count label to get duplicate (> 1)
						$check_duplicate_label_again = array_count_values($check_duplicate_label);

						// remove empty label
						foreach($check_duplicate_label_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_label_again[$key]);
						}

						// get only > 1 label
						$ada = array();
						foreach ($check_duplicate_label_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_label_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_label .= "<br><br><strong class='text-danger'><u>DUPLICATE LABEL:</u></strong> ";
							$dupl_label .= $dupl_label_;
						}else{
							$dupl_label .= '';
						}
					}

					$characteristic_empty = '';
					if(in_array(0, $empty_characteristic)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY CHARACTERISTIC:</u> </strong> ";
						$i = 3;
						foreach ($check_empty_characteristic as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$characteristic_empty = $validasi;
					}

					$label_empty = '';
					if(in_array(0, $empty_label)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY LABEL:</u> </strong> ";
						$i = 3;
						foreach ($check_empty_label as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$label_empty = $validasi;
					}

					$wrong_value = '';
					if(in_array(0, $cek_wrong_value)){
						$validasi = "<br><br><strong class='text-danger'><u>COLUMN HAVE WRONG VALUE:</u> </strong>";
						foreach ($warn_wrong_value as $value) {
							$validasi .= '<br/>'.$value;
						}
						$wrong_value = $validasi;
					}

					echo $already;
					echo $max_length;
					echo $dupl_characteristic;
					echo $dupl_label;
					echo $characteristic_empty;
					echo $label_empty;
					echo $wrong_value;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_char btn btn-sm btn-primary' value='IMPORT CHARACTERISTIC DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'INC CHARACTERISTIC'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
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

						if(strtoupper(trim($rows[2])) == 'DEFAULT SHORT SEPARATOR'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'SEQUENCE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}

			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>TABLE COLUMN DIDN'T MATCH</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF INC CHARACTERISTIC</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_exist_in_db = [];
					$warn_exist_in_db = [];

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$cek_numerical = [];

					$check_empty_inc = [];
					$check_empty_characteristic = [];
					$check_empty_sequence = [];

					$check_duplicate_inc_char = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='10%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='47%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "<th width='20%'>".strtoupper(trim($rows[2]))."</th>";
								$table .= "<th width='10%'>".strtoupper(trim($rows[3]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// VALIDATION
								// ===============================================
								
								// CHEK EXIST IN DB DB?
								if($rows[0] <> '' && $rows[0] <> null){

									$inc_column = TblInc::where('inc', trim($rows[0]))
										->select('inc')
										->first();

									if(count($inc_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = '<b>INC:</b> '.strtoupper(trim($rows[0]));
									}

								}else{
									$cek_exist_in_db[] = 1;
								}
								
								if($rows[1] <> '' && $rows[1] <> null){

									$characterisic_column = TblCharacteristic::where('characteristic', trim($rows[1]))
										->select('characteristic')
										->first();

									if(count($characterisic_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = '<b>CHARACTERISTIC:</b> '.strtoupper(trim($rows[1]));
									}

								}else{
									$cek_exist_in_db[] = 1;
								}
								

								// CEK ALREADY IN DB
								$check_already_in_db_column = LinkIncCharacteristic::join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_characteristic.tbl_inc_id')
									->join('tbl_characteristic', 'tbl_characteristic.id', '=', 'link_inc_characteristic.tbl_characteristic_id')
									->where('inc', trim($rows[0]))
									->where('characteristic', trim($rows[1]))
									->select('link_inc_characteristic.id')
									->first();

								if(count($check_already_in_db_column)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = 'INC <b>'.strtoupper(trim($rows[0])).'</b> WITH CHARACTERISTIC <b>'.strtoupper(trim($rows[1])).'</b>';
								}else{
									$cek_already_in_db[] = 1;
								}

								// sqnc harus number

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[2])) > 10){
									$max_str[] = 0;
									$warn_max_str[] = '<b>DEFAULT SHORT SEPARATOR</b> "'.strtoupper(trim($rows[2])).'" LENGTH MAY NOT BE GREATER THAN 10';
								}else{
									$max_str[] = 1;
								}

								$check_empty_inc[] .= $rows[0];
								$check_empty_characteristic[] .= $rows[1];
								$check_empty_sequence[] .= $rows[3];
								$cek_numerical[] .= $rows[3];

								if(is_null($rows[0]) || $rows[0] == '' || is_null($rows[1]) || $rows[1] == ''){
									$check_duplicate_inc_char[] .= '';
								}else{
									$check_duplicate_inc_char[] .= 'INC <b>'.$rows[0].'</b> WITH CHARACTERISTIC <b>'.$rows[1].'</b>';
								}
								

								// TABLE
								// ====================================================
								$table .= "<tr><td>".$urut++."</td>";
								$table .= "<td>".strtoupper(trim($rows[0]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[1]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[2]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[3]))."</td></tr>";

								$data_counter[] = 1;								
							}							
						}						
					}					
					
				}
				$table .= "</tbody></table>";

				$empty_inc = array();
				foreach ($check_empty_inc as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_inc[] = 0;
					 }else{
					 	$empty_inc[] = 1;
					 }
				}

				$empty_characteristic = array();
				foreach ($check_empty_characteristic as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_characteristic[] = 0;
					 }else{
					 	$empty_characteristic[] = 1;
					 }
				}

				$empty_sequence = array();
				foreach ($check_empty_sequence as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_sequence[] = 0;
					 }else{
					 	$empty_sequence[] = 1;
					 }
				}

				$is_numerical = array();
				foreach ($cek_numerical as $value) {
					 if($value <> null && $value <> ''){
					 	if(ctype_digit($value) == true){
					 		$is_numerical[] = 1;
					 	}else{
					 		$is_numerical[] = 0;
					 	}					 	
					 }else{
					 	$is_numerical[] = 1;
					 }
				}

				// hitung jml
				$inc_char_check_duplicate = array_count_values($check_duplicate_inc_char);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_inc_char = array();
				foreach ($inc_char_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_inc_char[] = 0;
					}else{
						$chek_dupl_inc_char[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY INC CHARACTERISTIC DATA.</span>';
				}elseif(
					// cek apakah inc dan characteristic uniqe
					in_array(0, $cek_exist_in_db) ||
					// cek apakah ada item yg ada dlm database
					in_array(0, $cek_already_in_db) ||
					// cek apakah terdapat item yang melebihi maksimum string
					in_array(0, $max_str) ||
					// cek apakah terdapat inc yang kosong
					in_array(0, $empty_inc) ||
					// cek apakah terdapat characteristic yang kosong
					in_array(0, $empty_characteristic) ||
					// cek apakah terdapat sequence yang kosong
					in_array(0, $empty_sequence) ||
					// cek apakah value berupa numeric
					in_array(0, $is_numerical) ||
					// cek apakah ada duplicate inc-char dalam spreadsheet
					in_array(0, $chek_dupl_inc_char)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR INC CHARACTERISTIC SPREADSHEET</strong></span>";
					
					$exist = '';
					if(in_array(0, $cek_exist_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>NOT FOUND RECORD IN DATABASE:</u></strong>";
						foreach ($warn_exist_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$exist = $validasi;
					}

					$already = '';
					if(in_array(0, $cek_already_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>ALREADY IN DATABASE:</u></strong>";
						foreach ($warn_already_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$already = $validasi;
					}

					$max_length = '';
					if(in_array(0, $max_str)){
						$validasi = "<br><br><strong class='text-danger'><u>CHARACTER LENGTH MORE THAN ALLOWED:</u> </strong>";
						foreach ($warn_max_str as $value) {
							$validasi .= '<br/>'.$value;
						}
						$max_length = $validasi;
					}

					$inc_empty = '';
					if(in_array(0, $empty_inc)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY INC:</u></strong>";
						$i = 3;
						foreach ($check_empty_inc as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$inc_empty = $validasi;
					}

					$characteristic_empty = '';
					if(in_array(0, $empty_characteristic)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY CHARACTERISTIC:</u></strong>";
						$i = 3;
						foreach ($check_empty_characteristic as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$characteristic_empty = $validasi;
					}

					$sequence_empty = '';
					if(in_array(0, $empty_sequence)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY SEQUENCE:</u> </strong> ";
						$i = 3;
						foreach ($check_empty_sequence as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$sequence_empty = $validasi;
					}

					$is_numeric = '';
					if(in_array(0, $is_numerical)){
						$validasi = "<br><br><strong class='text-danger'><u>SEQUENCE MUST NUMERIC:</u></strong> ";
						$i = 3;
						foreach ($cek_numerical as $value) {
							if($value <> null && $value <> ''){
								if(ctype_digit($value) != true){
									$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
								}else{
									$i++;
								}
							}else{
								$i++;
							}							
						}
						$is_numeric = $validasi;
					}

					$dupl_inc_char_ = '';
					$dupl_inc_char = '';
					if(in_array(0, $chek_dupl_inc_char)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_inc_char_again = array_count_values($check_duplicate_inc_char);

						// remove empty
						foreach($check_duplicate_inc_char_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_inc_char_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_inc_char_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_inc_char_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_inc_char .= "<br><br><strong class='text-danger'><u>DUPLICATE INC - CHARACTERISTIC:</u> </strong> ";
							$dupl_inc_char .= $dupl_inc_char_;
						}else{
							$dupl_inc_char .= '';
						}
					}

					echo $exist;
					echo $already;
					echo $max_length;
					echo $inc_empty;
					echo $characteristic_empty;
					echo $sequence_empty;
					echo $is_numeric;
					echo $dupl_inc_char;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_inc_char btn btn-sm btn-primary' value='IMPORT INC CHARACTERISTIC DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'GROUP'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'GROUP'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'NAME'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'ENG DEFINITION'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'IND DEFINITION'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}

			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>TABLE COLUMN DIDN'T MATCH</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF GROUP</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_group = [];
					$check_empty_name = [];

					$cek_numerical = [];

					$check_duplicate_group = [];
					$check_duplicate_name = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='10%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='31%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "<th width='28%'>".strtoupper(trim($rows[2]))."</th>";
								$table .= "<th width='28%'>".strtoupper(trim($rows[3]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// VALIDATION
								// ===============================================
								
								// CHEK ALREADY IN DB DB?
								if($rows[0] <> '' && $rows[0] <> null){

									$group_column = TblGroup::where('group', $rows[0])
										->select('group')
										->first();

									if(count($group_column)>0){
										$cek_already_in_db[] = 0;
										$warn_already_in_db[] = '<b>GROUP:</b> '.strtoupper(trim($rows[0]));
									}else{
										$cek_already_in_db[] = 1;
									}

								}else{
									$cek_already_in_db[] = 1;
								}
								
								if($rows[1] <> '' && $rows[1] <> null){

									$name_column = TblGroup::where('name', $rows[1])
										->select('name')
										->first();

									if(count($name_column)>0){
										$cek_already_in_db[] = 0;
										$warn_already_in_db[] = '<b>NAME:</b> '.strtoupper(trim($rows[1]));
									}else{
										$cek_already_in_db[] = 1;
									}

								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[0])) > 2){
									$max_str[] = 0;
									$warn_max_str[] = '<b>GROUP</b> "'.strtoupper(trim($rows[0])).'" LENGTH MAY NOT BE GREATER THAN 2';
								}else{
									$max_str[] = 1;
								}

								$check_empty_group[] .= $rows[0];
								$check_empty_name[] .= $rows[1];
								$cek_numerical[] .= $rows[0];

								if(is_null($rows[0]) || $rows[0] == ''){
									$check_duplicate_group[] .= '';
								}else{
									$check_duplicate_group[] .= $rows[0];
								}

								if(is_null($rows[1]) || $rows[1] == ''){
									$check_duplicate_name[] .= '';
								}else{
									$check_duplicate_name[] .= $rows[1];
								}								

								// TABLE
								// ====================================================
								$table .= "<tr><td>".$urut++."</td>";
								$table .= "<td>".strtoupper(trim($rows[0]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[1]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[2]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[3]))."</td></tr>";

								$data_counter[] = 1;								
							}							
						}						
					}					
					
				}
				$table .= "</tbody></table>";

				$empty_group = array();
				foreach ($check_empty_group as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_group[] = 0;
					 }else{
					 	$empty_group[] = 1;
					 }
				}

				$empty_name = array();
				foreach ($check_empty_name as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_name[] = 0;
					 }else{
					 	$empty_name[] = 1;
					 }
				}

				$is_numerical = array();
				foreach ($cek_numerical as $value) {
					 if($value <> null && $value <> ''){
					 	if(ctype_digit($value) == true){
					 		$is_numerical[] = 1;
					 	}else{
					 		$is_numerical[] = 0;
					 	}					 	
					 }else{
					 	$is_numerical[] = 1;
					 }
				}

				// hitung jml
				$group_check_duplicate = array_count_values($check_duplicate_group);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_group = array();
				foreach ($group_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_group[] = 0;
					}else{
						$chek_dupl_group[] = 1;
					}
				}

				// hitung jml
				$name_check_duplicate = array_count_values($check_duplicate_name);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_name = array();
				foreach ($name_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_name[] = 0;
					}else{
						$chek_dupl_name[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY GROUP DATA.</span>';
				}elseif(
					// cek apakah ada item yg ada dlm database
					in_array(0, $cek_already_in_db) ||
					// cek apakah terdapat item yang melebihi maksimum string
					in_array(0, $max_str) ||
					// cek apakah terdapat group yang kosong
					in_array(0, $empty_group) ||
					// cek apakah terdapat name yang kosong
					in_array(0, $empty_name) ||
					// cek apakah value berupa numeric
					in_array(0, $is_numerical) ||
					// cek apakah ada duplicate dalam spreadsheet
					in_array(0, $chek_dupl_group) ||
					in_array(0, $chek_dupl_name)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR GROUP SPREADSHEET</strong></span>";
					
					$already = '';
					if(in_array(0, $cek_already_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>ALREADY IN DATABASE:</u></strong>";
						foreach ($warn_already_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$already = $validasi;
					}

					$max_length = '';
					if(in_array(0, $max_str)){
						$validasi = "<br><br><strong class='text-danger'><u>CHARACTER LENGTH MORE THAN ALLOWED:</u> </strong>";
						foreach ($warn_max_str as $value) {
							$validasi .= '<br/>'.$value;
						}
						$max_length = $validasi;
					}

					$group_empty = '';
					if(in_array(0, $empty_group)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY GROUP:</u></strong>";
						$i = 3;
						foreach ($check_empty_groupc as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$group_empty = $validasi;
					}

					$name_empty = '';
					if(in_array(0, $empty_name)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY NAME:</u></strong>";
						$i = 3;
						foreach ($check_empty_name as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$name_empty = $validasi;
					}

					$is_numeric = '';
					if(in_array(0, $is_numerical)){
						$validasi = "<br><br><strong class='text-danger'><u>GROUP MUST NUMERIC:</u></strong> ";
						$i = 3;
						foreach ($cek_numerical as $value) {
							if($value <> null && $value <> ''){
								if(ctype_digit($value) != true){
									$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
								}else{
									$i++;
								}
							}else{
								$i++;
							}							
						}
						$is_numeric = $validasi;
					}

					$dupl_group_ = '';
					$dupl_group = '';
					if(in_array(0, $chek_dupl_group)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_group_again = array_count_values($check_duplicate_group);

						// remove empty
						foreach($check_duplicate_group_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_group_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_group_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_group_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_group .= "<br><br><strong class='text-danger'><u>DUPLICATE GROUP:</u> </strong> ";
							$dupl_group .= $dupl_group_;
						}else{
							$dupl_group .= '';
						}
					}

					$dupl_name_ = '';
					$dupl_name = '';
					if(in_array(0, $chek_dupl_name)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_name_again = array_count_values($check_duplicate_name);

						// remove empty
						foreach($check_duplicate_name_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_name_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_name_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_name_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_name .= "<br><br><strong class='text-danger'><u>DUPLICATE NAME:</u> </strong> ";
							$dupl_name .= $dupl_name_;
						}else{
							$dupl_name .= '';
						}
					}

					echo $already;
					echo $max_length;
					echo $group_empty;
					echo $name_empty;
					echo $is_numeric;
					echo $dupl_group;
					echo $dupl_name;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_group btn btn-sm btn-primary' value='IMPORT GROUP DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'GROUP CLASS'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
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

						if(strtoupper(trim($rows[2])) == 'NAME'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'ENG DEFINITION'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[4])) == 'IND DEFINITION'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}

			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>TABLE COLUMN DIDN'T MATCH</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF GROUP CLASS</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_exist_in_db = [];
					$warn_exist_in_db = [];

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_group = [];
					$check_empty_class = [];
					$check_empty_name = [];

					$cek_numerical = [];

					$check_duplicate_group_class = [];
					$check_duplicate_name = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='10%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='10%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "<th width='31%'>".strtoupper(trim($rows[2]))."</th>";
								$table .= "<th width='23%'>".strtoupper(trim($rows[3]))."</th>";
								$table .= "<th width='23%'>".strtoupper(trim($rows[4]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// VALIDATION
								// ===============================================
								
								// CHEK EXIST IN DB DB?
								if($rows[0] <> '' && $rows[0] <> null){

									$group_column = TblGroup::where('group', trim($rows[0]))
										->select('group')
										->first();

									if(count($group_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = '<b>GROUP:</b> '.strtoupper(trim($rows[0]));
									}

								}else{
									$cek_exist_in_db[] = 1;
								}

								// CHEK ALREADY IN DB DB?
								$check_already_in_db_column = TblGroupClass::join('tbl_group', 'tbl_group.id', '=', 'tbl_group_class.tbl_group_id')
									->where('group', trim($rows[0]))
									->where('class', trim($rows[1]))
									->select('tbl_group_class.id')
									->first();

								if(count($check_already_in_db_column)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = 'GROUP <b>'.strtoupper(trim($rows[0])).'</b> WITH CLASS <b>'.strtoupper(trim($rows[1])).'</b>';
								}else{
									$cek_already_in_db[] = 1;
								}

								if($rows[2] <> '' && $rows[2] <> null){

									$name_column = TblGroupClass::where('name', $rows[2])
										->select('name')
										->first();

									if(count($name_column)>0){
										$cek_already_in_db[] = 0;
										$warn_already_in_db[] = '<b>NAME:</b> '.strtoupper(trim($rows[1]));
									}else{
										$cek_already_in_db[] = 1;
									}

								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[1])) > 2){
									$max_str[] = 0;
									$warn_max_str[] = '<b>CLASS</b> "'.strtoupper(trim($rows[1])).'" LENGTH MAY NOT BE GREATER THAN 2';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[2])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = '<b>NAME</b> "'.strtoupper(trim($rows[2])).'" LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}


								$check_empty_group[] .= $rows[0];
								$check_empty_class[] .= $rows[1];
								$check_empty_name[] .= $rows[2];
								$cek_numerical[] .= $rows[2];

								if(is_null($rows[0]) || $rows[0] == '' || is_null($rows[1]) || $rows[1] == ''){
									$check_duplicate_group_class[] .= '';
								}else{
									$check_duplicate_group_class[] .= 'GROUP <b>'.$rows[0].'</b> WITH CLASS <b>'.$rows[1].'</b>';
								}
								

								if(is_null($rows[2]) || $rows[2] == ''){
									$check_duplicate_name[] .= '';
								}else{
									$check_duplicate_name[] .= strtoupper(trim($rows[2]));
								}								

								// TABLE
								// ====================================================
								$table .= "<tr><td>".$urut++."</td>";
								$table .= "<td>".strtoupper(trim($rows[0]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[1]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[2]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[3]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[4]))."</td></tr>";

								$data_counter[] = 1;								
							}							
						}						
					}					
					
				}
				$table .= "</tbody></table>";

				$empty_group = array();
				foreach ($check_empty_group as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_group[] = 0;
					 }else{
					 	$empty_group[] = 1;
					 }
				}

				$empty_class = array();
				foreach ($check_empty_class as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_class[] = 0;
					 }else{
					 	$empty_class[] = 1;
					 }
				}

				$empty_name = array();
				foreach ($check_empty_name as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_name[] = 0;
					 }else{
					 	$empty_name[] = 1;
					 }
				}

				$is_numerical = array();
				foreach ($cek_numerical as $value) {
					 if($value <> null && $value <> ''){
					 	if(ctype_digit(sprintf('%08d', $value)) == true){
					 		$is_numerical[] = 1;
					 	}else{
					 		$is_numerical[] = 0;
					 	}					 	
					 }else{
					 	$is_numerical[] = 1;
					 }
				}

				// hitung jml
				$group_class_check_duplicate = array_count_values($check_duplicate_group_class);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_group_class = array();
				foreach ($group_class_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_group_class[] = 0;
					}else{
						$chek_dupl_group_class[] = 1;
					}
				}

				// hitung jml
				$name_check_duplicate = array_count_values($check_duplicate_name);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_name = array();
				foreach ($name_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_name[] = 0;
					}else{
						$chek_dupl_name[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY GROUP CLASS DATA.</span>';
				}elseif(			
					// 
					in_array(0, $cek_exist_in_db) ||
					// cek apakah ada item yg ada dlm database
					in_array(0, $cek_already_in_db) ||
					// cek apakah terdapat item yang melebihi maksimum string
					in_array(0, $max_str) ||
					// cek apakah terdapat group yang kosong
					in_array(0, $empty_group) ||
					// cek apakah terdapat name yang kosong
					in_array(0, $empty_class) ||
					// 
					in_array(0, $empty_name) ||
					// cek apakah value berupa numeric
					in_array(0, $is_numerical) ||
					// cek apakah ada duplicate dalam spreadsheet
					in_array(0, $chek_dupl_group_class) ||
					in_array(0, $chek_dupl_name)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR GROUP CLASS SPREADSHEET</strong></span>";
					
					$exist = '';
					if(in_array(0, $cek_exist_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>NOT FOUND RECORD IN DATABASE:</u></strong>";
						foreach ($warn_exist_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$exist = $validasi;
					}

					$already = '';
					if(in_array(0, $cek_already_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>ALREADY IN DATABASE:</u></strong>";
						foreach ($warn_already_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$already = $validasi;
					}

					$max_length = '';
					if(in_array(0, $max_str)){
						$validasi = "<br><br><strong class='text-danger'><u>CHARACTER LENGTH MORE THAN ALLOWED:</u> </strong>";
						foreach ($warn_max_str as $value) {
							$validasi .= '<br/>'.$value;
						}
						$max_length = $validasi;
					}

					$group_empty = '';
					if(in_array(0, $empty_group)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY GROUP:</u></strong>";
						$i = 3;
						foreach ($check_empty_group as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$group_empty = $validasi;
					}

					$class_empty = '';
					if(in_array(0, $empty_class)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY CLASS:</u></strong>";
						$i = 3;
						foreach ($check_empty_class as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$class_empty = $validasi;
					}

					$name_empty = '';
					if(in_array(0, $empty_name)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY NAME:</u></strong>";
						$i = 3;
						foreach ($check_empty_name as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$name_empty = $validasi;
					}

					$is_numeric = '';
					if(in_array(0, $is_numerical)){
						$validasi = "<br><br><strong class='text-danger'><u>CLASS MUST NUMERIC:</u></strong> ";
						$i = 3;
						foreach ($cek_numerical as $value) {
							if($value <> null && $value <> ''){
								if(ctype_digit($value) != true){
									$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
								}else{
									$i++;
								}
							}else{
								$i++;
							}							
						}
						$is_numeric = $validasi;
					}

					$dupl_group_class_ = '';
					$dupl_group_class = '';
					if(in_array(0, $chek_dupl_group_class)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_group_class_again = array_count_values($check_duplicate_group_class);

						// remove empty
						foreach($check_duplicate_group_class_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_group_class_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_group_class_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_group_class_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_group_class .= "<br><br><strong class='text-danger'><u>DUPLICATE GROUP - CLASS:</u> </strong> ";
							$dupl_group_class .= $dupl_group_class_;
						}else{
							$dupl_group_class .= '';
						}
					}

					$dupl_name_ = '';
					$dupl_name = '';
					if(in_array(0, $chek_dupl_name)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_name_again = array_count_values($check_duplicate_name);

						// remove empty
						foreach($check_duplicate_name_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_name_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_name_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_name_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_name .= "<br><br><strong class='text-danger'><u>DUPLICATE NAME:</u> </strong> ";
							$dupl_name .= $dupl_name_;
						}else{
							$dupl_name .= '';
						}
					}

					echo $exist;
					echo $already;
					echo $max_length;
					echo $group_empty;
					echo $class_empty;
					echo $name_empty;
					echo $is_numeric;
					echo $dupl_group_class;
					echo $dupl_name;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_group_class btn btn-sm btn-primary' value='IMPORT GROUP CLASS DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'INC GROUP CLASS'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'INC'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'GROUP CLASS'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}

			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>TABLE COLUMN DIDN'T MATCH</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF INC GROUP CLASS</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_exist_in_db = [];
					$warn_exist_in_db = [];

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_inc = [];
					$check_empty_group_class = [];

					$check_duplicate_inc_group_class = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='17%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='80%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// VALIDATION
								// ===============================================
								
								// CHEK EXIST IN DB DB?
								if($rows[0] <> '' && $rows[0] <> null){

									$inc_column = TblInc::where('inc', trim($rows[0]))
										->select('inc')
										->first();

									if(count($inc_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = '<b>INC:</b> '.strtoupper(trim($rows[0]));
									}

								}else{
									$cek_exist_in_db[] = 1;
								}

								if($rows[1] <> '' && $rows[1] <> null){

									$group_class_column = TblGroupClass::select('tbl_group_class.id')
										->join('tbl_group', 'tbl_group.id', '=', 'tbl_group_class.tbl_group_id')
										->where('group', trim(substr($rows[1], 0, 2)))
										->where('class', trim(substr($rows[1], 2, 2)))
										->first();

									if(count($group_class_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = '<b>GROUP CLASS:</b> '.strtoupper(trim($rows[1]));
									}

								}else{
									$cek_exist_in_db[] = 1;
								}


								// CHEK ALREADY IN DB DB?
								$check_already_in_db_column = LinkIncGroupClass::select('link_inc_group_class.id')
									->join('tbl_group_class', 'tbl_group_class.id', '=', 'link_inc_group_class.tbl_group_class_id')
									->join('tbl_group', 'tbl_group.id', '=', 'tbl_group_class.tbl_group_id')
									->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_group_class.tbl_inc_id')
									->where('inc', trim($rows[0]))
									->where('group', substr(trim($rows[0]),0,2))
									->where('class', substr(trim($rows[0]),2,2))
									->first();

								if(count($check_already_in_db_column)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = 'INC <b>'.strtoupper(trim($rows[0])).'</b> WITH GROUP CLASS <b>'.strtoupper(trim($rows[1])).'</b>';
								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[0])) > 5){
									$max_str[] = 0;
									$warn_max_str[] = '<b>INC</b> "'.strtoupper(trim($rows[0])).'" LENGTH MAY NOT BE GREATER THAN 5';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[1])) > 4){
									$max_str[] = 0;
									$warn_max_str[] = '<b>GROUP CLASS</b> "'.strtoupper(trim($rows[1])).'" LENGTH MAY NOT BE GREATER THAN 5';
								}else{
									$max_str[] = 1;
								}


								$check_empty_inc[] .= $rows[0];
								$check_empty_group_class[] .= $rows[1];

								if(is_null($rows[0]) || $rows[0] == '' || is_null($rows[1]) || $rows[1] == ''){
									$check_duplicate_inc_group_class[] .= '';
								}else{
									$check_duplicate_inc_group_class[] .= 'INC <b>'.$rows[0].'</b> WITH GROUP CLASS <b>'.$rows[1].'</b>';
								}							

								// TABLE
								// ====================================================
								$table .= "<tr><td>".$urut++."</td>";
								$table .= "<td>".strtoupper(trim($rows[0]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[1]))."</td></tr>";

								$data_counter[] = 1;								
							}							
						}						
					}					
					
				}
				$table .= "</tbody></table>";

				$empty_inc = array();
				foreach ($check_empty_inc as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_inc[] = 0;
					 }else{
					 	$empty_inc[] = 1;
					 }
				}

				$empty_group_class = array();
				foreach ($check_empty_group_class as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_group_class[] = 0;
					 }else{
					 	$empty_group_class[] = 1;
					 }
				}

				// hitung jml
				$inc_group_class_check_duplicate = array_count_values($check_duplicate_inc_group_class);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_inc_group_class = array();
				foreach ($inc_group_class_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_inc_group_class[] = 0;
					}else{
						$chek_dupl_inc_group_class[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY INC GROUP CLASS DATA.</span>';
				}elseif(			
					// 
					in_array(0, $cek_exist_in_db) ||
					// cek apakah ada item yg ada dlm database
					in_array(0, $cek_already_in_db) ||
					// cek apakah terdapat item yang melebihi maksimum string
					in_array(0, $max_str) ||
					// cek apakah terdapat yang kosong
					in_array(0, $empty_inc) ||
					in_array(0, $empty_group_class) ||
					// cek apakah ada duplicate dalam spreadsheet
					in_array(0, $chek_dupl_inc_group_class)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR INC GROUP CLASS SPREADSHEET</strong></span>";
					
					$exist = '';
					if(in_array(0, $cek_exist_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>NOT FOUND RECORD IN DATABASE:</u></strong>";
						foreach ($warn_exist_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$exist = $validasi;
					}

					$already = '';
					if(in_array(0, $cek_already_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>ALREADY IN DATABASE:</u></strong>";
						foreach ($warn_already_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$already = $validasi;
					}

					$max_length = '';
					if(in_array(0, $max_str)){
						$validasi = "<br><br><strong class='text-danger'><u>CHARACTER LENGTH MORE THAN ALLOWED:</u> </strong>";
						foreach ($warn_max_str as $value) {
							$validasi .= '<br/>'.$value;
						}
						$max_length = $validasi;
					}

					$inc_empty = '';
					if(in_array(0, $empty_inc)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY INC:</u></strong>";
						$i = 3;
						foreach ($check_empty_inc as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$inc_empty = $validasi;
					}

					$group_class_empty = '';
					if(in_array(0, $empty_group_class)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY GROUP CLASS:</u></strong>";
						$i = 3;
						foreach ($check_empty_group_class as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$group_class_empty = $validasi;
					}

					$dupl_inc_group_class_ = '';
					$dupl_inc_group_class = '';
					if(in_array(0, $check_duplicate_inc_group_class)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_inc_group_class_again = array_count_values($check_duplicate_inc_group_class);

						// remove empty
						foreach($check_duplicate_inc_group_class_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_inc_group_class_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_inc_group_class_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_inc_group_class_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_inc_group_class .= "<br><br><strong class='text-danger'><u>DUPLICATE INC - GROUP CLASS:</u> </strong> ";
							$dupl_inc_group_class .= $dupl_inc_group_class_;
						}else{
							$dupl_inc_group_class .= '';
						}
					}

					echo $exist;
					echo $already;
					echo $max_length;
					echo $inc_empty;
					echo $group_class_empty;
					echo $dupl_inc_group_class;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_inc_group_class btn btn-sm btn-primary' value='IMPORT INC GROUP CLASS DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'INC CHARACTERISTIC VALUE'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
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

			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>TABLE COLUMN DIDN'T MATCH</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF INC CHARACTERISTIC VALUE</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;
					$urutan = 3;

					$cek_exist_in_db = [];
					$warn_exist_in_db = [];

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_inc = [];
					$check_empty_characteristic = [];
					$check_empty_value = [];

					$check_duplicate_inc_char_value = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='7%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='40%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "<th width='25%'>".strtoupper(trim($rows[2]))."</th>";
								$table .= "<th width='20%'>".strtoupper(trim($rows[3]))."</th>";
								$table .= "<th width='5%'>".strtoupper(trim($rows[4]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// VALIDATION
								// ===============================================
								
								// CHEK EXIST IN DB DB?
								if($rows[0] <> '' && $rows[0] <> null || $rows[1] <> '' && $rows[1] <> null){

									$inc_char_column = LinkIncCharacteristic::select('link_inc_characteristic.id')
										->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_characteristic.tbl_inc_id')
										->join('tbl_characteristic', 'tbl_characteristic.id', '=', 'link_inc_characteristic.tbl_characteristic_id')
										->where('inc', trim($rows[0]))
										->where('characteristic', trim($rows[1]))
										->first();

									if(count($inc_char_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'INC <b>'.strtoupper(trim($rows[0])).'</b> WITH CHARACTERISTIC <b>'.strtoupper(trim($rows[1])).'</b>';
									}

								}else{
									$cek_exist_in_db[] = 1;
								}

								// CHEK ALREADY IN DB DB?
								$check_already_in_db_column = LinkIncCharacteristicValue::select('link_inc_characteristic_value.id')
									->join('link_inc_characteristic', 'link_inc_characteristic.id', '=', 'link_inc_characteristic_value.link_inc_characteristic_id')
									->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_characteristic.tbl_inc_id')
									->join('tbl_characteristic', 'tbl_characteristic.id', '=', 'link_inc_characteristic.tbl_characteristic_id')
									->where('inc', trim($rows[0]))
									->where('characteristic', trim($rows[1]))
									->where('value', trim($rows[2]))
									->first();

								if(count($check_already_in_db_column)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = 'INC <b>'.strtoupper(trim($rows[0])).'</b> AND CHARACTERISTIC '.strtoupper(trim($rows[1])).' WITH VALUE <b>'.strtoupper(trim($rows[2])).'</b>';
								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[2])) > 30){
									$max_str[] = 0;
									$warn_max_str[] = '<b>VALUE</b> "'.strtoupper(trim($rows[2])).'" LENGTH MAY NOT BE GREATER THAN 30';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[3])) > 30){
									$max_str[] = 0;
									$warn_max_str[] = '<b>ABBREV</b> "'.strtoupper(trim($rows[3])).'" LENGTH MAY NOT BE GREATER THAN 30';
								}else{
									$max_str[] = 1;
								}


								$check_empty_inc[] .= $rows[0];
								$check_empty_characteristic[] .= $rows[1];
								$check_empty_value[] .= $rows[2];

								if(
									is_null($rows[0]) || $rows[0] == '' || 
									is_null($rows[1]) || $rows[1] == '' ||
									is_null($rows[2]) || $rows[2] == ''
									){
									$check_duplicate_inc_char_value[] .= '';
								}else{
									$check_duplicate_inc_char_value[] .= 'INC <b>'.$rows[0].'</b> AND CHARACTERISTIC <b>'.$rows[1].'</b> WITH VALUE <b>'.$rows[2].'</b>';
								}

								if(
									strtoupper(trim($rows[4])) != 'YES' &&
									strtoupper(trim($rows[4])) != 'NO'
								){
									$cek_wrong_value[] = 0;
									$warn_wrong_value[] = '<b>APPROVED</b> COLUMN ON LINE <b>#'.$urutan++.'</b> MUST BE FILLED WITH "YES" OR "NO"';
								}else{
									$cek_wrong_value[] = 1;
								}					

								// TABLE
								// ====================================================
								$table .= "<tr><td>".$urut++."</td>";
								$table .= "<td>".strtoupper(trim($rows[0]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[1]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[2]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[3]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[4]))."</td></tr>";

								$data_counter[] = 1;								
							}							
						}						
					}					
					
				}
				$table .= "</tbody></table>";

				$empty_inc = array();
				foreach ($check_empty_inc as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_inc[] = 0;
					 }else{
					 	$empty_inc[] = 1;
					 }
				}

				$empty_characteristic = array();
				foreach ($check_empty_characteristic as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_characteristic[] = 0;
					 }else{
					 	$empty_characteristic[] = 1;
					 }
				}

				$empty_value = array();
				foreach ($check_empty_value as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_value[] = 0;
					 }else{
					 	$empty_value[] = 1;
					 }
				}

				// hitung jml
				$inc_char_value_check_duplicate = array_count_values($check_duplicate_inc_char_value);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_inc_char_value = array();
				foreach ($inc_char_value_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_inc_char_value[] = 0;
					}else{
						$chek_dupl_inc_char_value[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY INC CHARACTERISTIC VALUE DATA.</span>';
				}elseif(			
					// 
					in_array(0, $cek_exist_in_db) ||
					// cek apakah ada item yg ada dlm database
					in_array(0, $cek_already_in_db) ||
					// cek apakah terdapat item yang melebihi maksimum string
					in_array(0, $max_str) ||
					// cek apakah terdapat yang kosong
					in_array(0, $empty_inc) ||
					in_array(0, $empty_characteristic) ||
					in_array(0, $empty_value) ||
					// cek apakah ada duplicate dalam spreadsheet
					in_array(0, $chek_dupl_inc_char_value) ||
					// cek apakah wrong value
					in_array(0, $cek_wrong_value)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR INC CHARACTERISTIC VALUE SPREADSHEET</strong></span>";
					
					$exist = '';
					if(in_array(0, $cek_exist_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>NOT FOUND RECORD IN DATABASE:</u></strong>";
						foreach ($warn_exist_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$exist = $validasi;
					}

					$already = '';
					if(in_array(0, $cek_already_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>ALREADY IN DATABASE:</u></strong>";
						foreach ($warn_already_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$already = $validasi;
					}

					$max_length = '';
					if(in_array(0, $max_str)){
						$validasi = "<br><br><strong class='text-danger'><u>CHARACTER LENGTH MORE THAN ALLOWED:</u> </strong>";
						foreach ($warn_max_str as $value) {
							$validasi .= '<br/>'.$value;
						}
						$max_length = $validasi;
					}

					$inc_empty = '';
					if(in_array(0, $empty_inc)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY INC:</u></strong>";
						$i = 3;
						foreach ($check_empty_inc as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$inc_empty = $validasi;
					}

					$characteristic_empty = '';
					if(in_array(0, $empty_characteristic)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY CHARACTERISTIC:</u></strong>";
						$i = 3;
						foreach ($check_empty_characteristic as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$characteristic_empty = $validasi;
					}

					$value_empty = '';
					if(in_array(0, $empty_value)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY VALUE:</u></strong>";
						$i = 3;
						foreach ($check_empty_value as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$value_empty = $validasi;
					}

					$dupl_inc_char_value_ = '';
					$dupl_inc_char_value = '';
					if(in_array(0, $chek_dupl_inc_char_value)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_inc_char_value_again = array_count_values($check_duplicate_inc_char_value);

						// remove empty
						foreach($check_duplicate_inc_char_value_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_inc_char_value_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_inc_char_value_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_inc_char_value_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_inc_char_value .= "<br><br><strong class='text-danger'><u>DUPLICATE INC - CHARACTERISTIC - VALUE:</u> </strong> ";
							$dupl_inc_char_value .= $dupl_inc_char_value_;
						}else{
							$dupl_inc_char_value .= '';
						}
					}

					$wrong_value = '';
					if(in_array(0, $cek_wrong_value)){
						$validasi = "<br><br><strong class='text-danger'><u>COLUMN HAVE WRONG VALUE:</u> </strong>";
						foreach ($warn_wrong_value as $value) {
							$validasi .= '<br/>'.$value;
						}
						$wrong_value = $validasi;
					}

					echo $exist;
					echo $already;
					echo $max_length;
					echo $inc_empty;
					echo $characteristic_empty;
					echo $value_empty;
					echo $dupl_inc_char_value;
					echo $wrong_value;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_inc_char_value btn btn-sm btn-primary' value='IMPORT INC CHARACTERISTIC VALUE DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'MANUFACTURER CODE'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'MANUFACTURER CODE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'MANUFACTURER NAME'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'ADDRESS'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}

			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>TABLE COLUMN DIDN'T MATCH</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF MANUFACTURER CODE</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_manufacturer_code = [];
					$check_empty_manufacturer_name = [];

					$check_duplicate_manufacturer_code = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='25%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='30%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "<th width='42%'>".strtoupper(trim($rows[2]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// VALIDATION
								// ===============================================
								
								// CHEK ALREADY IN DB DB?
								$check_already_in_db_column = TblManufacturerCode::select('id')
									->where('manufacturer_code', trim($rows[0]))->first();

								if(count($check_already_in_db_column)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = 'MANUFACTURER CODE <b>'.strtoupper(trim($rows[0])).'</b>';
								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[0])) > 10){
									$max_str[] = 0;
									$warn_max_str[] = 'MANUFACTURER CODE <b>"'.strtoupper(trim($rows[1])).'"</b> LENGTH MAY NOT BE GREATER THAN 10';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[1])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = 'MANUFACTURER NAME <b>"'.strtoupper(trim($rows[1])).'"</b> LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								$check_empty_manufacturer_code[] .= $rows[0];
								$check_empty_manufacturer_name[] .= $rows[1];

								if(is_null($rows[0]) || $rows[0] == ''){
									$check_duplicate_manufacturer_code[] .= '';
								}else{
									$check_duplicate_manufacturer_code[] .= 'MANUFACTURER CODE <b>'.$rows[0].'</b>';
								}			

								// TABLE
								// ====================================================
								$table .= "<tr><td>".$urut++."</td>";
								$table .= "<td>".strtoupper(trim($rows[0]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[1]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[2]))."</td></tr>";

								$data_counter[] = 1;								
							}							
						}						
					}					
					
				}
				$table .= "</tbody></table>";

				$empty_manufacturer_code = array();
				foreach ($check_empty_manufacturer_code as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_manufacturer_code[] = 0;
					 }else{
					 	$empty_manufacturer_code[] = 1;
					 }
				}

				$empty_manufacturer_name = array();
				foreach ($check_empty_manufacturer_name as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_manufacturer_name[] = 0;
					 }else{
					 	$empty_manufacturer_name[] = 1;
					 }
				}

				// hitung jml
				$manufacturer_code_check_duplicate = array_count_values($check_duplicate_manufacturer_code);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_manufacturer_code = array();
				foreach ($manufacturer_code_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_manufacturer_code[] = 0;
					}else{
						$chek_dupl_manufacturer_code[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY MANUFACTURER CODE DATA.</span>';
				}elseif(			
					// cek apakah ada item yg ada dlm database
					in_array(0, $cek_already_in_db) ||
					// cek apakah terdapat item yang melebihi maksimum string
					in_array(0, $max_str) ||
					// cek apakah terdapat yang kosong
					in_array(0, $empty_manufacturer_code) ||
					in_array(0, $empty_manufacturer_name) ||
					// cek apakah ada duplicate dalam spreadsheet
					in_array(0, $chek_dupl_manufacturer_code)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR MANUFACTURER CODE SPREADSHEET</strong></span>";

					$already = '';
					if(in_array(0, $cek_already_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>ALREADY IN DATABASE:</u></strong>";
						foreach ($warn_already_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$already = $validasi;
					}

					$max_length = '';
					if(in_array(0, $max_str)){
						$validasi = "<br><br><strong class='text-danger'><u>CHARACTER LENGTH MORE THAN ALLOWED:</u> </strong>";
						foreach ($warn_max_str as $value) {
							$validasi .= '<br/>'.$value;
						}
						$max_length = $validasi;
					}

					$manufacturer_code_empty = '';
					if(in_array(0, $empty_manufacturer_code)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY MANUFACTURER CODE:</u></strong>";
						$i = 3;
						foreach ($check_empty_manufacturer_code as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$manufacturer_code_empty = $validasi;
					}

					$manufacturer_name_empty = '';
					if(in_array(0, $empty_manufacturer_name)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY MANUFACTURER NAME:</u></strong>";
						$i = 3;
						foreach ($check_empty_manufacturer_name as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$manufacturer_name_empty = $validasi;
					}

					$dupl_manufacturer_code_ = '';
					$dupl_manufacturer_code = '';
					if(in_array(0, $chek_dupl_manufacturer_code)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_manufacturer_code_again = array_count_values($check_duplicate_manufacturer_code);

						// remove empty
						foreach($check_duplicate_manufacturer_code_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_manufacturer_code_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_manufacturer_code_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_manufacturer_code_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_manufacturer_code .= "<br><br><strong class='text-danger'><u>DUPLICATE MANUFACTURER CODE:</u> </strong> ";
							$dupl_manufacturer_code .= $dupl_manufacturer_code_;
						}else{
							$dupl_manufacturer_code .= '';
						}
					}

					echo $already;
					echo $max_length;
					echo $manufacturer_code_empty;
					echo $manufacturer_name_empty;
					echo $dupl_manufacturer_code;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_manufacturer_code btn btn-sm btn-primary' value='IMPORT MANUFACTURER CODE DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'SOURCE TYPE'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'TYPE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'DESCRIPTION'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}

			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>TABLE COLUMN DIDN'T MATCH</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF SOURCE TYPE</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_type = [];

					$check_duplicate_type = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='10%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='87%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// VALIDATION
								// ===============================================
								
								// CHEK ALREADY IN DB DB?
								$check_already_in_db_column = TblSourceType::select('id')
									->where('type', trim($rows[0]))->first();

								if(count($check_already_in_db_column)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = 'TYPE <b>'.strtoupper(trim($rows[0])).'</b>';
								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[0])) > 15){
									$max_str[] = 0;
									$warn_max_str[] = 'TYPE <b>"'.strtoupper(trim($rows[0])).'"</b> LENGTH MAY NOT BE GREATER THAN 15';
								}else{
									$max_str[] = 1;
								}

								$check_empty_type[] .= $rows[0];

								if(is_null($rows[0]) || $rows[0] == ''){
									$check_duplicate_type[] .= '';
								}else{
									$check_duplicate_type[] .= 'TYPE <b>'.$rows[0].'</b>';
								}			

								// TABLE
								// ====================================================
								$table .= "<tr><td>".$urut++."</td>";
								$table .= "<td>".strtoupper(trim($rows[0]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[1]))."</td></tr>";

								$data_counter[] = 1;								
							}							
						}						
					}					
					
				}
				$table .= "</tbody></table>";

				$empty_type = array();
				foreach ($check_empty_type as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_type[] = 0;
					 }else{
					 	$empty_type[] = 1;
					 }
				}

				// hitung jml
				$type_check_duplicate = array_count_values($check_duplicate_type);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_type = array();
				foreach ($type_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_type[] = 0;
					}else{
						$chek_dupl_type[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY SOURCE TYPE DATA.</span>';
				}elseif(			
					// cek apakah ada item yg ada dlm database
					in_array(0, $cek_already_in_db) ||
					// cek apakah terdapat item yang melebihi maksimum string
					in_array(0, $max_str) ||
					// cek apakah terdapat yang kosong
					in_array(0, $empty_type) ||
					// cek apakah ada duplicate dalam spreadsheet
					in_array(0, $chek_dupl_type)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR SOURCE TYPE SPREADSHEET</strong></span>";

					$already = '';
					if(in_array(0, $cek_already_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>ALREADY IN DATABASE:</u></strong>";
						foreach ($warn_already_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$already = $validasi;
					}

					$max_length = '';
					if(in_array(0, $max_str)){
						$validasi = "<br><br><strong class='text-danger'><u>CHARACTER LENGTH MORE THAN ALLOWED:</u> </strong>";
						foreach ($warn_max_str as $value) {
							$validasi .= '<br/>'.$value;
						}
						$max_length = $validasi;
					}

					$type_empty = '';
					if(in_array(0, $empty_type)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY TYPE:</u></strong>";
						$i = 3;
						foreach ($check_empty_type as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$type_empty = $validasi;
					}

					$dupl_type_ = '';
					$dupl_type = '';
					if(in_array(0, $chek_dupl_type)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_type_again = array_count_values($check_duplicate_type);

						// remove empty
						foreach($check_duplicate_type_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_type_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_type_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_type_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_type .= "<br><br><strong class='text-danger'><u>DUPLICATE TYPE:</u> </strong> ";
							$dupl_type .= $dupl_type_;
						}else{
							$dupl_type .= '';
						}
					}

					echo $already;
					echo $max_length;
					echo $type_empty;
					echo $dupl_type;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_source_type btn btn-sm btn-primary' value='IMPORT SOURCE TYPE DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'PART MANUFACTURER CODE TYPE'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'TYPE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'DESCRIPTION'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}

			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>TABLE COLUMN DIDN'T MATCH</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF PART MANUFACTURER CODE TYPE</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_type = [];

					$check_duplicate_type = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='10%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='87%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// VALIDATION
								// ===============================================
								
								// CHEK ALREADY IN DB DB?
								$check_already_in_db_column = TblPartManufacturerCodeType::select('id')
									->where('type', trim($rows[0]))->first();

								if(count($check_already_in_db_column)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = 'TYPE <b>'.strtoupper(trim($rows[0])).'</b>';
								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[0])) > 15){
									$max_str[] = 0;
									$warn_max_str[] = 'TYPE <b>"'.strtoupper(trim($rows[0])).'"</b> LENGTH MAY NOT BE GREATER THAN 15';
								}else{
									$max_str[] = 1;
								}

								$check_empty_type[] .= $rows[0];

								if(is_null($rows[0]) || $rows[0] == ''){
									$check_duplicate_type[] .= '';
								}else{
									$check_duplicate_type[] .= 'TYPE <b>'.$rows[0].'</b>';
								}			

								// TABLE
								// ====================================================
								$table .= "<tr><td>".$urut++."</td>";
								$table .= "<td>".strtoupper(trim($rows[0]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[1]))."</td></tr>";

								$data_counter[] = 1;								
							}							
						}						
					}					
					
				}
				$table .= "</tbody></table>";

				$empty_type = array();
				foreach ($check_empty_type as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_type[] = 0;
					 }else{
					 	$empty_type[] = 1;
					 }
				}

				// hitung jml
				$type_check_duplicate = array_count_values($check_duplicate_type);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_type = array();
				foreach ($type_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_type[] = 0;
					}else{
						$chek_dupl_type[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY PART MANUFACTURER CODE TYPE DATA.</span>';
				}elseif(			
					// cek apakah ada item yg ada dlm database
					in_array(0, $cek_already_in_db) ||
					// cek apakah terdapat item yang melebihi maksimum string
					in_array(0, $max_str) ||
					// cek apakah terdapat yang kosong
					in_array(0, $empty_type) ||
					// cek apakah ada duplicate dalam spreadsheet
					in_array(0, $chek_dupl_type)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR PART MANUFACTURER CODE TYPE SPREADSHEET</strong></span>";

					$already = '';
					if(in_array(0, $cek_already_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>ALREADY IN DATABASE:</u></strong>";
						foreach ($warn_already_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$already = $validasi;
					}

					$max_length = '';
					if(in_array(0, $max_str)){
						$validasi = "<br><br><strong class='text-danger'><u>CHARACTER LENGTH MORE THAN ALLOWED:</u> </strong>";
						foreach ($warn_max_str as $value) {
							$validasi .= '<br/>'.$value;
						}
						$max_length = $validasi;
					}

					$type_empty = '';
					if(in_array(0, $empty_type)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY TYPE:</u></strong>";
						$i = 3;
						foreach ($check_empty_type as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$type_empty = $validasi;
					}

					$dupl_type_ = '';
					$dupl_type = '';
					if(in_array(0, $chek_dupl_type)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_type_again = array_count_values($check_duplicate_type);

						// remove empty
						foreach($check_duplicate_type_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_type_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_type_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_type_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_type .= "<br><br><strong class='text-danger'><u>DUPLICATE TYPE:</u> </strong> ";
							$dupl_type .= $dupl_type_;
						}else{
							$dupl_type .= '';
						}
					}

					echo $already;
					echo $max_length;
					echo $type_empty;
					echo $dupl_type;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_part_man_code_type btn btn-sm btn-primary' value='IMPORT PART MANUFACTURER CODE TYPE DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'EQUIPMENT CODE'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'EQUIPMENT CODE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'EQUIPMENT NAME'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}

			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>TABLE COLUMN DIDN'T MATCH</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF EQUIPMENT CODE</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_equipment_code = [];
					$check_empty_equipment_name = [];

					$check_duplicate_code_name = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='15%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='87%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// VALIDATION
								// ===============================================
								
								// CHEK ALREADY IN DB DB?
								$check_already_in_db_column = TblEquipmentCode::select('id')
									->where('equipment_code', trim($rows[0]))
									->where('equipment_name', trim($rows[1]))
									->first();

								if(count($check_already_in_db_column)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = 'EQUIPMENT CODE <b>'.strtoupper(trim($rows[0])).'</b> WITH EQUIPMENT NAME <b>'.strtoupper(trim($rows[0])).'</b>';
								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[0])) > 50){
									$max_str[] = 0;
									$warn_max_str[] = 'EQUIPMENT CODE <b>"'.strtoupper(trim($rows[0])).'"</b> LENGTH MAY NOT BE GREATER THAN 50';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[1])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = 'EQUIPMENT NAME <b>"'.strtoupper(trim($rows[1])).'"</b> LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								$check_empty_equipment_name[] .= $rows[0];
								$check_empty_equipment_code[] .= $rows[1];

								if(is_null($rows[0]) || $rows[0] == '' || is_null($rows[1]) || $rows[1] == ''){
									$check_duplicate_code_name[] .= '';
								}else{
									$check_duplicate_code_name[] .= 'EQUIPMENT CODE <b>'.strtoupper(trim($rows[0])).'</b> WITH EQUIPMENT NAME <b>'.strtoupper(trim($rows[1])).'</b>';
								}			

								// TABLE
								// ====================================================
								$table .= "<tr><td>".$urut++."</td>";
								$table .= "<td>".strtoupper(trim($rows[0]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[1]))."</td></tr>";

								$data_counter[] = 1;								
							}							
						}						
					}					
					
				}
				$table .= "</tbody></table>";

				$empty_equipment_code = array();
				foreach ($check_empty_equipment_code as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_equipment_code[] = 0;
					 }else{
					 	$empty_equipment_code[] = 1;
					 }
				}

				$empty_equipment_name = array();
				foreach ($check_empty_equipment_name as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_equipment_name[] = 0;
					 }else{
					 	$empty_equipment_name[] = 1;
					 }
				}

				// hitung jml
				$code_name_check_duplicate = array_count_values($check_duplicate_code_name);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$check_dupl_code_name = array();
				foreach ($code_name_check_duplicate as $key => $value) {
					if($value > 1) {
						$check_dupl_code_name[] = 0;
					}else{
						$check_dupl_code_name[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY EQUIPMENT CODE DATA.</span>';
				}elseif(			
					// cek apakah ada item yg ada dlm database
					in_array(0, $cek_already_in_db) ||
					// cek apakah terdapat item yang melebihi maksimum string
					in_array(0, $max_str) ||
					// cek apakah terdapat yang kosong
					in_array(0, $empty_equipment_code) ||
					in_array(0, $empty_equipment_name) ||
					// cek apakah ada duplicate dalam spreadsheet
					in_array(0, $check_dupl_code_name)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR EQUIPMENT CODE SPREADSHEET</strong></span>";

					$already = '';
					if(in_array(0, $cek_already_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>ALREADY IN DATABASE:</u></strong>";
						foreach ($warn_already_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$already = $validasi;
					}

					$max_length = '';
					if(in_array(0, $max_str)){
						$validasi = "<br><br><strong class='text-danger'><u>CHARACTER LENGTH MORE THAN ALLOWED:</u> </strong>";
						foreach ($warn_max_str as $value) {
							$validasi .= '<br/>'.$value;
						}
						$max_length = $validasi;
					}

					$equipment_code_empty = '';
					if(in_array(0, $empty_equipment_code)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY EQUIPMENT CODE:</u></strong>";
						$i = 3;
						foreach ($check_empty_equipment_code as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$equipment_code_empty = $validasi;
					}

					$equipment_name_empty = '';
					if(in_array(0, $empty_equipment_name)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY EQUIPMENT NAME:</u></strong>";
						$i = 3;
						foreach ($check_empty_equipment_name as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$equipment_name_empty = $validasi;
					}

					$dupl_code_name_ = '';
					$dupl_code_name = '';
					if(in_array(0, $check_dupl_code_name)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_code_name_again = array_count_values($check_duplicate_code_name);

						// remove empty
						foreach($check_duplicate_code_name_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_code_name_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_code_name_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_code_name_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_code_name .= "<br><br><strong class='text-danger'><u>DUPLICATE EQUIPMENT CODE AND EQUIPMENT NAME:</u> </strong> ";
							$dupl_code_name .= $dupl_code_name_;
						}else{
							$dupl_code_name .= '';
						}
					}

					echo $already;
					echo $max_length;
					echo $equipment_code_empty;
					echo $equipment_name_empty;
					echo $dupl_code_name;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_eq_code btn btn-sm btn-primary' value='IMPORT EQUIPMENT CODE DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'EQUIPMENT PLANT'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'EQUIPMENT CODE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'HOLDING'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'COMPANY'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'PLANT'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}

			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>TABLE COLUMN DIDN'T MATCH</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF EQUIPMENT PLANT</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_exist_in_db = [];
					$warn_exist_in_db = [];

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$check_empty_equipment_code = [];
					$check_empty_holding = [];
					$check_empty_company = [];
					$check_empty_plant = [];

					$check_duplicate = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='17%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='20%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "<th width='20%'>".strtoupper(trim($rows[2]))."</th>";
								$table .= "<th width='20%'>".strtoupper(trim($rows[3]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// CHEK EXIST IN DB DB?
								if($rows[0] == '' || $rows[0] == null || 
									$rows[1] == '' || $rows[1] == null || 
									$rows[2] == '' || $rows[2] == null || 
									$rows[3] == '' || $rows[3] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblPlant::select('tbl_plant.id')
										->join('tbl_company', 'tbl_company.id', '=', 'tbl_plant.tbl_company_id')
										->join('tbl_holding', 'tbl_holding.id', '=', 'tbl_company.tbl_holding_id')
										->where('holding', trim($rows[1]))
										->where('company', trim($rows[2]))
										->where('plant', trim($rows[3]))
										->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'PLANT <b>'.strtoupper(trim($rows[3])).'</b> WITH HOLDING <b>'.strtoupper(trim($rows[1])).'</b> AND COMPANY <b>'.strtoupper(trim($rows[2])).'</b>';
									}
								}
								
								// CHEK ALREADY IN DB DB?
								$check_already_in_db_column = TblEquipmentPlant::select('tbl_equipment_plant.id')
									->join('tbl_plant', 'tbl_plant.id', 'tbl_equipment_plant.tbl_plant_id')
									->join('tbl_company', 'tbl_company.id', 'tbl_plant.tbl_company_id')
									->join('tbl_holding', 'tbl_holding.id', 'tbl_company.tbl_holding_id')
									->where('holding', trim($rows[1]))
									->where('company', trim($rows[2]))
									->where('plant', trim($rows[3]))
									->first();

								if(count($check_already_in_db_column)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = 'EQUIPMENT CODE <b>'.strtoupper(trim($rows[0])).'</b> WITH <b>'.strtoupper(trim($rows[1])).' '.strtoupper(trim($rows[2])).' '.strtoupper(trim($rows[3])).'</b>';
								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK EMPTY
								$check_empty_equipment_code[] .= $rows[0];
								$check_empty_holding[] .= $rows[1];
								$check_empty_company[] .= $rows[2];
								$check_empty_plant[] .= $rows[3];

								// CEK DUPLICATE
								if(
									is_null($rows[0]) || $rows[0] == '' || 
									is_null($rows[1]) || $rows[1] == '' ||
									is_null($rows[2]) || $rows[2] == '' ||
									is_null($rows[3]) || $rows[3] == ''
								){
									$check_duplicate[] .= '';
								}else{
									$check_duplicate[] .= 'EQUIPMENT CODE <b>'.strtoupper(trim($rows[0])).'</b> WITH HOLDING <b>'.strtoupper(trim($rows[1])).'</b>, COMPANY <b>'.strtoupper(trim($rows[2])).'</b> AND PLANT <b>'.strtoupper(trim($rows[3])).'</b>';
								}			

								// TABLE
								// ====================================================
								$table .= "<tr><td>".$urut++."</td>";
								$table .= "<td>".strtoupper(trim($rows[0]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[1]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[2]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[3]))."</td></tr>";

								$data_counter[] = 1;								
							}							
						}						
					}					
					
				}
				$table .= "</tbody></table>";

				$empty_equipment_code = array();
				foreach ($check_empty_equipment_code as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_equipment_code[] = 0;
					 }else{
					 	$empty_equipment_code[] = 1;
					 }
				}

				$empty_holding = array();
				foreach ($check_empty_holding as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_holding[] = 0;
					 }else{
					 	$empty_holding[] = 1;
					 }
				}

				$empty_company = array();
				foreach ($check_empty_company as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_company[] = 0;
					 }else{
					 	$empty_company[] = 1;
					 }
				}

				$empty_plant = array();
				foreach ($check_empty_plant as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_plant[] = 0;
					 }else{
					 	$empty_plant[] = 1;
					 }
				}

				// hitung jml
				$equip_plant_check_duplicate = array_count_values($check_duplicate);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$check_dupl_equip_plant = array();
				foreach ($equip_plant_check_duplicate as $key => $value) {
					if($value > 1) {
						$check_dupl_equip_plant[] = 0;
					}else{
						$check_dupl_equip_plant[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY EQUIPMENT PLANT DATA.</span>';
				}elseif(
					in_array(0, $cek_exist_in_db) ||		
					// cek apakah ada item yg ada dlm database
					in_array(0, $cek_already_in_db) ||
					// cek apakah terdapat yang kosong
					in_array(0, $empty_equipment_code) ||
					in_array(0, $empty_holding) ||
					in_array(0, $empty_company) ||
					in_array(0, $empty_plant) ||
					// cek apakah ada duplicate dalam spreadsheet
					in_array(0, $check_dupl_equip_plant)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR EQUIPMENT CODE SPREADSHEET</strong></span>";

					$exist = '';
					if(in_array(0, $cek_exist_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>NOT FOUND RECORD IN DATABASE:</u></strong>";
						foreach ($warn_exist_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$exist = $validasi;
					}

					$already = '';
					if(in_array(0, $cek_already_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>ALREADY IN DATABASE:</u></strong>";
						foreach ($warn_already_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$already = $validasi;
					}

					$equipment_code_empty = '';
					if(in_array(0, $empty_equipment_code)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY EQUIPMENT CODE:</u></strong>";
						$i = 3;
						foreach ($check_empty_equipment_code as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$equipment_code_empty = $validasi;
					}

					$holding_empty = '';
					if(in_array(0, $empty_holding)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY HOLDING:</u></strong>";
						$i = 3;
						foreach ($check_empty_holding as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$holding_empty = $validasi;
					}

					$company_empty = '';
					if(in_array(0, $empty_company)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY COMPANY:</u></strong>";
						$i = 3;
						foreach ($check_empty_company as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$company_empty = $validasi;
					}

					$plant_empty = '';
					if(in_array(0, $empty_plant)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY PLANT:</u></strong>";
						$i = 3;
						foreach ($check_empty_plant as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$plant_empty = $validasi;
					}

					$dupl_equip_plant_ = '';
					$dupl_equip_plant = '';
					if(in_array(0, $check_dupl_equip_plant)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_equip_plant_again = array_count_values($check_duplicate);

						// remove empty
						foreach($check_duplicate_equip_plant_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_equip_plant_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_equip_plant_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_equip_plant_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_equip_plant .= "<br><br><strong class='text-danger'><u>DUPLICATE DATA:</u> </strong> ";
							$dupl_equip_plant .= $dupl_equip_plant_;
						}else{
							$dupl_equip_plant .= '';
						}
					}

					echo $exist;
					echo $already;
					echo $equipment_code_empty;
					echo $holding_empty;
					echo $company_empty;
					echo $plant_empty;
					echo $dupl_equip_plant;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_eq_plant btn btn-sm btn-primary' value='IMPORT EQUIPMENT PLANT DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'PART MASTER'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'CATALOG NO'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'HOLDING'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'HOLDING NO'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'REFERENCE NO'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[4])) == 'INC'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[5])) == 'GROUP CLASS'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[6])) == 'CATALOG TYPE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(
							strtoupper(trim($rows[7])) == 'UNIT ISSUE2' ||
							strtoupper(trim($rows[7])) == 'UNIT ISSUE3' ||
							strtoupper(trim($rows[7])) == 'UNIT ISSUE4'
						){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(
							strtoupper(trim($rows[8])) == 'UNIT PURCHASE2' ||
							strtoupper(trim($rows[8])) == 'UNIT PURCHASE3' ||
							strtoupper(trim($rows[8])) == 'UNIT PURCHASE4'
						){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[9])) == 'CATALOG STATUS'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[10])) == 'CONVERSION'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[11])) == 'USER CLASS'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[12])) == 'ITEM TYPE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[13])) == 'HARMONIZED CODE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[14])) == 'HAZARD CLASS'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[15])) == 'WEIGHT VALUE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[16])) == 'WIGHT UNIT'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[17])) == 'STOCK TYPE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[18])) == 'AVG UNIT PRICE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[19])) == 'MEMO'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}

			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>TABLE COLUMN DIDN'T MATCH</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF PART MASTER</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;
					$urut2 = 3;

					$cek_exist_in_db = [];
					$warn_exist_in_db = [];

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_catalog_no = [];
					$check_empty_holding = [];
					$check_empty_catalog_type = [];
					$check_empty_catalog_status = [];

					$check_duplicate = [];

					$cek_wrong_value = [];
					$warn_wrong_value = [];

					$cek_numerical_wv = [];
					$cek_numerical_aup = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[2]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[3]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[4]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[5]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[6]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[7]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[8]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[9]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[10]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[11]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[12]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[13]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[14]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[15]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[16]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[17]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[18]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[19]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
								$unit_issue = strtoupper(trim($rows[7]));
								$unit_purchase = strtoupper(trim($rows[8]));
							}else{

								// CHEK EXIST IN DB DB?
								if($rows[1] == '' || $rows[1] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblHolding::select('id')
										->where('holding', trim($rows[1]))->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'HOLDING <b>'.strtoupper(trim($rows[1])).'</b>';
									}
								}

								if(
									$rows[4] == '' || $rows[4] == null || 
									$rows[5] == '' || $rows[5] == null ||
									strlen(trim($rows[4])) > 5 ||
									strlen(trim($rows[5])) > 4
								){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = LinkIncGroupClass::select('link_inc_group_class.id')
										->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_group_class.tbl_inc_id')
										->join('tbl_group_class', 'tbl_group_class.id', '=', 'link_inc_group_class.tbl_group_class_id')
										->join('tbl_group', 'tbl_group.id', '=', 'tbl_group_class.tbl_group_id')
										->where('inc', trim($rows[4]))
										->where('group', substr(trim($rows[5]),0,2))
										->where('class', substr(trim($rows[5]),2,2))
										->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'INC <b>'.strtoupper(trim($rows[4])).'</b> WITH GROUP CLASS <b>'.strtoupper(trim($rows[5])).'</b>';
									}
								}

								if(
									$rows[7] == '' || $rows[7] == null
								){

									$cek_exist_in_db[] = 1;
								
								}else{
									if($unit_issue == 'UNIT ISSUE2'){
										$exist_column = TblUnitOfMeasurement::select('id')
										->where('unit2', trim($rows[7]))->first();
									}elseif($unit_issue == 'UNIT ISSUE3'){
										$exist_column = TblUnitOfMeasurement::select('id')
										->where('unit3', trim($rows[7]))->first();
									}elseif($unit_issue == 'UNIT ISSUE4'){
										$exist_column = TblUnitOfMeasurement::select('id')
										->where('unit4', trim($rows[7]))->first();
									}									

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'UNIT ISSUE <b>'.strtoupper(trim($rows[7])).'</b>';
									}
								}

								if(
									$rows[8] == '' || $rows[8] == null
								){

									$cek_exist_in_db[] = 1;
								
								}else{
									if($unit_purchase == 'UNIT PURCHASE2'){
										$exist_column = TblUnitOfMeasurement::select('id')
										->where('unit2', trim($rows[8]))->first();
									}elseif($unit_purchase == 'UNIT PURCHASE3'){
										$exist_column = TblUnitOfMeasurement::select('id')
										->where('unit3', trim($rows[8]))->first();
									}elseif($unit_purchase == 'UNIT PURCHASE4'){
										$exist_column = TblUnitOfMeasurement::select('id')
										->where('unit4', trim($rows[8]))->first();
									}									

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'UNIT PURCHASE <b>'.strtoupper(trim($rows[8])).'</b>';
									}
								}

								if($rows[9] == '' || $rows[9] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblCatalogStatus::select('id')
										->where('status', trim($rows[9]))->first();								

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'CATALOG STATUS <b>'.strtoupper(trim($rows[9])).'</b>';
									}
								}

								if($rows[11] == '' || $rows[11] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblUserClass::select('id')
										->where('class', trim($rows[11]))->first();								

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'USER CLASS <b>'.strtoupper(trim($rows[11])).'</b>';
									}
								}

								if($rows[12] == '' || $rows[12] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblItemType::select('id')
										->where('type', trim($rows[12]))->first();								

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'ITEM TYPE <b>'.strtoupper(trim($rows[12])).'</b>';
									}
								}

								if($rows[13] == '' || $rows[13] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblHarmonizedCode::select('id')
										->where('code', trim($rows[13]))->first();								

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'HARMONIZED CODE <b>'.strtoupper(trim($rows[13])).'</b>';
									}
								}

								if($rows[14] == '' || $rows[14] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblHazardClass::select('id')
										->where('class', trim($rows[14]))->first();								

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'HAZARD CLASS <b>'.strtoupper(trim($rows[14])).'</b>';
									}
								}

								if($rows[16] == '' || $rows[16] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblWeightUnit::select('id')
										->where('unit', trim($rows[16]))->first();								

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'WEIGHT UNIT <b>'.strtoupper(trim($rows[16])).'</b>';
									}
								}

								if($rows[17] == '' || $rows[17] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblStockType::select('id')
										->where('type', trim($rows[17]))->first();								

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'STOCK TYPE <b>'.strtoupper(trim($rows[17])).'</b>';
									}
								}

								// CEK EMPTY
								$check_empty_catalog_no[] .= $rows[0];
								$check_empty_holding[] .= $rows[1];
								$check_empty_catalog_type[] .= $rows[6];
								$check_empty_catalog_status[] .= $rows[9];

								// MAX STR
								if(strlen(trim($rows[0])) > 30){
									$max_str[] = 0;
									$warn_max_str[] = 'CATALOG NO <b>"'.strtoupper(trim($rows[0])).'"</b> LENGTH MAY NOT BE GREATER THAN 30';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[2])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = 'HOLDING NO <b>"'.strtoupper(trim($rows[2])).'"</b> LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								if($rows[3] <> '' && $rows[3] <> null){
									if(strlen(trim($rows[3])) > 255){
										$max_str[] = 0;
										$warn_max_str[] = 'REFERENCE NO <b>"'.strtoupper(trim($rows[3])).'"</b> LENGTH MAY NOT BE GREATER THAN 255';
									}else{
										$max_str[] = 1;
									}
								}else{
									$max_str[] = 1;
								}								

								if($rows[4] <> '' && $rows[4] <> null){
									if(strlen(trim($rows[4])) > 5){
										$max_str[] = 0;
										$warn_max_str[] = 'INC <b>"'.strtoupper(trim($rows[4])).'"</b> LENGTH MAY NOT BE GREATER THAN 5';
									}else{
										$max_str[] = 1;
									}
								}else{
									$max_str[] = 1;
								}

								if($rows[5] <> '' && $rows[5] <> null){
									if(strlen(trim($rows[5])) > 4){
										$max_str[] = 0;
										$warn_max_str[] = 'GROUP CLASS <b>"'.strtoupper(trim($rows[5])).'"</b> LENGTH MAY NOT BE GREATER THAN 4';
									}else{
										$max_str[] = 1;
									}
								}else{
									$max_str[] = 1;
								}

								// CEK DUPLICATE
								if(
									is_null($rows[0]) || $rows[0] == '' || 
									is_null($rows[1]) || $rows[1] == ''
								){
									$check_duplicate[] .= '';
								}else{
									$check_duplicate[] .= 'CATALOG NO <b>'.strtoupper(trim($rows[0])).'</b> WITH HOLDING <b>'.strtoupper(trim($rows[1])).'</b>';
								}

								if(
									is_null($rows[1]) || $rows[1] == '' || 
									is_null($rows[2]) || $rows[2] == ''
								){
									$check_duplicate[] .= '';
								}else{
									$check_duplicate[] .= 'HOLDING <b>'.strtoupper(trim($rows[1])).'</b> WITH HOLDING NO <b>'.strtoupper(trim($rows[2])).'</b>';
								}

								// CHEK ALREADY IN DB DB?
								$check_already_in_db_cat_hol = PartMaster::select('part_master.id')
									->join('tbl_holding', 'tbl_holding.id', 'part_master.tbl_holding_id')
									->where('catalog_no', trim($rows[0]))
									->where('holding', trim($rows[1]))
									->first();

								if(count($check_already_in_db_cat_hol)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = 'CATALOG NO <b>'.strtoupper(trim($rows[0])).'</b> WITH HOLDING <b>'.strtoupper(trim($rows[1])).'</b>';
								}else{
									$cek_already_in_db[] = 1;
								}

								$check_already_in_db_hol_no_hol = PartMaster::select('part_master.id')
									->join('tbl_holding', 'tbl_holding.id', 'part_master.tbl_holding_id')
									->where('holding', trim($rows[1]))
									->where('holding_no', trim($rows[2]))
									->first();

								if(count($check_already_in_db_hol_no_hol)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = 'HOLDING <b>'.strtoupper(trim($rows[1])).'</b> WITH HOLDING NO <b>'.strtoupper(trim($rows[2])).'</b>';
								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK WRONG VALUE
								$urutan = $urut2++;
								if(
									strtoupper(trim($rows[6])) != 'GEN' &&
									strtoupper(trim($rows[6])) != 'OEM'
								){
									$cek_wrong_value[] = 0;
									$warn_wrong_value[] = '<b>CATALOG TYPE</b> COLUMN ON LINE <b>#'.$urutan.'</b> MUST BE FILLED WITH "GEN" OR "OEM"';
								}else{
									$cek_wrong_value[] = 1;
								}

								$cek_numerical_wv[] .= $rows[15];
								$cek_numerical_aup[] .= $rows[18];

								// TABLE
								// ====================================================
								$table .= "<tr><td>".$urut++."</td>";
								$table .= "<td>".strtoupper(trim($rows[0]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[1]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[2]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[3]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[4]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[5]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[6]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[7]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[8]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[9]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[10]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[11]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[12]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[13]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[14]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[15]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[16]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[17]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[18]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[19]))."</td></tr>";

								$data_counter[] = 1;								
							}							
						}						
					}					
					
				}
				$table .= "</tbody></table>";

				$empty_catalog_no = array();
				foreach ($check_empty_catalog_no as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_catalog_no[] = 0;
					 }else{
					 	$empty_catalog_no[] = 1;
					 }
				}

				$empty_holding = array();
				foreach ($check_empty_holding as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_holding[] = 0;
					 }else{
					 	$empty_holding[] = 1;
					 }
				}

				$empty_catalog_type = array();
				foreach ($check_empty_catalog_type as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_catalog_type[] = 0;
					 }else{
					 	$empty_catalog_type[] = 1;
					 }
				}

				$empty_catalog_status = array();
				foreach ($check_empty_catalog_status as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_catalog_status[] = 0;
					 }else{
					 	$empty_catalog_status[] = 1;
					 }
				}

				// hitung jml
				$check_duplicate_ = array_count_values($check_duplicate);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$check_dupl = array();
				foreach ($check_duplicate_ as $key => $value) {
					if($value > 1) {
						$check_dupl[] = 0;
					}else{
						$check_dupl[] = 1;
					}
				}

				// CEK NUMERIK
				$is_numerical_wv = array();
				foreach ($cek_numerical_wv as $value) {
					 if($value <> null && $value <> ''){
					 	if(is_numeric($value) == true){
					 		$is_numerical_wv[] = 1;
					 	}else{
					 		$is_numerical_wv[] = 0;
					 	}					 	
					 }else{
					 	$is_numerical_wv[] = 1;
					 }
				}

				$is_numerical_aup = array();
				foreach ($cek_numerical_aup as $value) {
					 if($value <> null && $value <> ''){
					 	if(is_numeric($value) == true){
					 		$is_numerical_aup[] = 1;
					 	}else{
					 		$is_numerical_aup[] = 0;
					 	}					 	
					 }else{
					 	$is_numerical_aup[] = 1;
					 }
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY PART MASTER DATA.</span>';
				}elseif(
					in_array(0, $cek_exist_in_db) ||
					// cek apakah terdapat item yang melebihi maksimum string
					in_array(0, $max_str) ||	
					// cek apakah ada item yg ada dlm database
					in_array(0, $cek_already_in_db) ||
					// cek apakah terdapat yang kosong
					in_array(0, $empty_catalog_no) ||
					in_array(0, $empty_holding) ||
					in_array(0, $empty_catalog_type) ||
					in_array(0, $empty_catalog_status) ||
					// cek apakah ada duplicate dalam spreadsheet
					in_array(0, $check_dupl) ||
					// cek apakan kolom mempunyai value yg benar
					in_array(0, $cek_wrong_value) ||
					// cek apakah value berupa numeric
					in_array(0, $is_numerical_wv) ||
					in_array(0, $is_numerical_aup)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR PART MASTER SPREADSHEET</strong></span>";

					$exist = '';
					if(in_array(0, $cek_exist_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>NOT FOUND RECORD IN DATABASE:</u></strong>";
						foreach ($warn_exist_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$exist = $validasi;
					}

					$max_length = '';
					if(in_array(0, $max_str)){
						$validasi = "<br><br><strong class='text-danger'><u>CHARACTER LENGTH MORE THAN ALLOWED:</u> </strong>";
						foreach ($warn_max_str as $value) {
							$validasi .= '<br/>'.$value;
						}
						$max_length = $validasi;
					}


					$already = '';
					if(in_array(0, $cek_already_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>ALREADY IN DATABASE:</u></strong>";
						foreach ($warn_already_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$already = $validasi;
					}

					$catalog_no_empty = '';
					if(in_array(0, $empty_catalog_no)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY CATALOG NO:</u></strong>";
						$i = 3;
						foreach ($check_empty_catalog_no as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$catalog_no_empty = $validasi;
					}

					$holding_empty = '';
					if(in_array(0, $empty_holding)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY HOLDING:</u></strong>";
						$i = 3;
						foreach ($check_empty_holding as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$holding_empty = $validasi;
					}

					$catalog_type_empty = '';
					if(in_array(0, $empty_catalog_type)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY CATALOG TYPE:</u></strong>";
						$i = 3;
						foreach ($check_empty_catalog_type as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$catalog_type_empty = $validasi;
					}

					$catalog_status_empty = '';
					if(in_array(0, $empty_catalog_status)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY CATALOG STATUS:</u></strong>";
						$i = 3;
						foreach ($check_empty_catalog_status as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$catalog_status_empty = $validasi;
					}

					$dupl_ = '';
					$dupl = '';
					if(in_array(0, $check_dupl)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_again = array_count_values($check_duplicate);

						// remove empty
						foreach($check_duplicate_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_ = $validasi;

						if(in_array(1, $ada)){
							$dupl .= "<br><br><strong class='text-danger'><u>DUPLICATE DATA:</u> </strong> ";
							$dupl .= $dupl_;
						}else{
							$dupl .= '';
						}
					}

					$wrong_value = '';
					if(in_array(0, $cek_wrong_value)){
						$validasi = "<br><br><strong class='text-danger'><u>COLUMN HAVE WRONG VALUE:</u> </strong>";
						foreach ($warn_wrong_value as $value) {
							$validasi .= '<br/>'.$value;
						}
						$wrong_value = $validasi;
					}

					$is_numeric_wv = '';
					if(in_array(0, $is_numerical_wv)){
						$validasi = "<br><br><strong class='text-danger'><u>WEIGHT VALUE MUST NUMERIC:</u></strong> ";
						$i = 3;
						foreach ($cek_numerical_wv as $value) {
							if($value <> null && $value <> ''){
								if(ctype_digit($value) != true){
									$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
								}else{
									$i++;
								}
							}else{
								$i++;
							}							
						}
						$is_numeric_wv = $validasi;
					}

					$is_numeric_aup = '';
					if(in_array(0, $is_numerical_aup)){
						$validasi = "<br><br><strong class='text-danger'><u>AVG UNIT PRICE MUST NUMERIC:</u></strong> ";
						$i = 3;
						foreach ($cek_numerical_aup as $value) {
							if($value <> null && $value <> ''){
								if(ctype_digit($value) != true){
									$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
								}else{
									$i++;
								}
							}else{
								$i++;
							}							
						}
						$is_numeric_aup = $validasi;
					}

					echo $exist;
					echo $already;
					echo $max_length;
					echo $catalog_no_empty;
					echo $holding_empty;
					echo $catalog_type_empty;
					echo $catalog_status_empty;
					echo $dupl;
					echo $wrong_value;
					echo $is_numeric_wv;
					echo $is_numeric_aup;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_part_master btn btn-sm btn-primary' value='IMPORT PART MASTER DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'PART MANUFACTURER CODE'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'CATALOG NO'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'MANUFACTURER CODE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'SOURCE TYPE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'MANUFACTURER REF'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[4])) == 'TYPE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}

			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>TABLE COLUMN DIDN'T MATCH</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF PART MANUFACTURER CODE</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_exist_in_db = [];
					$warn_exist_in_db = [];

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_catalog_no = [];
					$check_empty_manufacturer_code = [];
					$check_empty_source_type = [];
					$check_empty_man_ref = [];
					$check_empty_type = [];

					$check_duplicate = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[2]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[3]))."</th>";
								$table .= "<th width='%'>".strtoupper(trim($rows[4]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// CHEK EXIST IN DB DB?
								if($rows[0] == '' || $rows[0] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = PartMaster::select('id')
										->where('catalog_no', trim($rows[0]))->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'CATALOG NO <b>'.strtoupper(trim($rows[0])).'</b>';
									}
								}

								if($rows[1] == '' || $rows[1] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblManufacturerCode::select('id')
										->where('manufacturer_code', trim($rows[1]))->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'MANUFACTURER CODE <b>'.strtoupper(trim($rows[1])).'</b>';
									}
								}

								if($rows[2] == '' || $rows[2] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblSourceType::select('id')
										->where('type', trim($rows[2]))->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'SOURCE TYPE <b>'.strtoupper(trim($rows[2])).'</b>';
									}
								}

								if($rows[4] == '' || $rows[4] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblPartManufacturerCodeType::select('id')
										->where('type', trim($rows[4]))->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'TYPE <b>'.strtoupper(trim($rows[4])).'</b>';
									}
								}

								// CHEK ALREADY IN DB DB?
								$check_already_in_db = PartManufacturerCode::select('part_manufacturer_code.id')
									->join('part_master', 'part_master.id', 'part_manufacturer_code.part_master_id')
									->join('tbl_manufacturer_code', 'tbl_manufacturer_code.id', 'part_manufacturer_code.tbl_manufacturer_code_id')
									->join('tbl_source_type', 'tbl_source_type.id', 'part_manufacturer_code.tbl_source_type_id')
									->where('catalog_no', trim($rows[0]))
									->where('manufacturer_code', trim($rows[1]))
									->where('type', trim($rows[2]))
									->where('manufacturer_ref', trim($rows[3]))
									->first();

								if(count($check_already_in_db)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = 'CATALOG NO <b>'.strtoupper(trim($rows[0])).'</b> WITH MANUFACTURER CODE <b>'.strtoupper(trim($rows[1])).'</b> AND SOURCE TYPE <b>'.strtoupper(trim($rows[2])).'</b> AND MANUFACTURER REF <b>'.strtoupper(trim($rows[3])).'</b>';
								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK EMPTY
								$check_empty_catalog_no[] .= $rows[0];
								$check_empty_manufacturer_code[] .= $rows[1];
								$check_empty_source_type[] .= $rows[2];
								$check_empty_man_ref[] .= $rows[3];
								$check_empty_type[] .= $rows[4];

								// MAX STR
								if(strlen(trim($rows[3])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = 'MANUFACTURER REF <b>"'.strtoupper(trim($rows[3])).'"</b> LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								// CEK DUPLICATE
								if(
									is_null($rows[0]) || $rows[0] == '' || 
									is_null($rows[1]) || $rows[1] == '' ||
									is_null($rows[2]) || $rows[2] == '' ||
									is_null($rows[3]) || $rows[3] == ''
								){
									$check_duplicate[] .= '';
								}else{
									$check_duplicate[] .= 'CATALOG NO <b>'.strtoupper(trim($rows[0])).'</b> WITH MANUFACTURER CODE <b>'.strtoupper(trim($rows[1])).'</b> AND SOURCE TYPE <b>'.strtoupper(trim($rows[2])).'</b> AND MANUFACTURER REF <b>'.strtoupper(trim($rows[3])).'</b>';
								}

								// TABLE
								// ====================================================
								$table .= "<tr><td>".$urut++."</td>";
								$table .= "<td>".strtoupper(trim($rows[0]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[1]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[2]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[3]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[4]))."</td></tr>";

								$data_counter[] = 1;								
							}							
						}						
					}					
					
				}
				$table .= "</tbody></table>";

				$empty_catalog_no = array();
				foreach ($check_empty_catalog_no as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_catalog_no[] = 0;
					 }else{
					 	$empty_catalog_no[] = 1;
					 }
				}

				$empty_manufacturer_code = array();
				foreach ($check_empty_manufacturer_code as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_manufacturer_code[] = 0;
					 }else{
					 	$empty_manufacturer_code[] = 1;
					 }
				}

				$empty_source_type = array();
				foreach ($check_empty_source_type as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_source_type[] = 0;
					 }else{
					 	$empty_source_type[] = 1;
					 }
				}

				$empty_man_ref = array();
				foreach ($check_empty_man_ref as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_man_ref[] = 0;
					 }else{
					 	$empty_man_ref[] = 1;
					 }
				}

				$empty_type = array();
				foreach ($check_empty_type as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_type[] = 0;
					 }else{
					 	$empty_type[] = 1;
					 }
				}

				// hitung jml
				$check_duplicate_ = array_count_values($check_duplicate);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$check_dupl = array();
				foreach ($check_duplicate_ as $key => $value) {
					if($value > 1) {
						$check_dupl[] = 0;
					}else{
						$check_dupl[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY PART MANUFACTURER CODE DATA.</span>';
				}elseif(
					in_array(0, $cek_exist_in_db) ||
					// cek apakah terdapat item yang melebihi maksimum string
					in_array(0, $max_str) ||	
					// cek apakah ada item yg ada dlm database
					in_array(0, $cek_already_in_db) ||
					// cek apakah terdapat yang kosong
					in_array(0, $empty_catalog_no) ||
					in_array(0, $empty_manufacturer_code) ||
					in_array(0, $empty_man_ref) ||
					in_array(0, $empty_source_type) ||
					in_array(0, $empty_type) ||
					// cek apakah ada duplicate dalam spreadsheet
					in_array(0, $check_dupl)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR PART MANUFACTURER CODE SPREADSHEET</strong></span>";

					// EXIST?
					$exist = '';
					if(in_array(0, $cek_exist_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>NOT FOUND RECORD IN DATABASE:</u></strong>";
						foreach ($warn_exist_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$exist = $validasi;
					}

					// MAX LENGTH
					$max_length = '';
					if(in_array(0, $max_str)){
						$validasi = "<br><br><strong class='text-danger'><u>CHARACTER LENGTH MORE THAN ALLOWED:</u> </strong>";
						foreach ($warn_max_str as $value) {
							$validasi .= '<br/>'.$value;
						}
						$max_length = $validasi;
					}

					// ALREADY IN DB
					$already = '';
					if(in_array(0, $cek_already_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>ALREADY IN DATABASE:</u></strong>";
						foreach ($warn_already_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$already = $validasi;
					}

					// CEK EMPTY
					$catalog_no_empty = '';
					if(in_array(0, $empty_catalog_no)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY CATALOG NO:</u></strong>";
						$i = 3;
						foreach ($check_empty_catalog_no as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$catalog_no_empty = $validasi;
					}

					$manufacturer_code_empty = '';
					if(in_array(0, $empty_manufacturer_code)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY MANUFACTURER CODE NO:</u></strong>";
						$i = 3;
						foreach ($check_empty_manufacturer_code as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$manufacturer_code_empty = $validasi;
					}

					$source_type_empty = '';
					if(in_array(0, $empty_source_type)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY SOURCE TYPE NO:</u></strong>";
						$i = 3;
						foreach ($check_empty_source_type as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$source_type_empty = $validasi;
					}

					$man_ref_empty = '';
					if(in_array(0, $empty_man_ref)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY MANUFACTURER REF NO:</u></strong>";
						$i = 3;
						foreach ($check_empty_man_ref as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$man_ref_empty = $validasi;
					}

					$type_empty = '';
					if(in_array(0, $empty_type)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY TYPE NO:</u></strong>";
						$i = 3;
						foreach ($check_empty_type as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$type_empty = $validasi;
					}

					$dupl_ = '';
					$dupl = '';
					if(in_array(0, $check_dupl)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_again = array_count_values($check_duplicate);

						// remove empty
						foreach($check_duplicate_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_ = $validasi;

						if(in_array(1, $ada)){
							$dupl .= "<br><br><strong class='text-danger'><u>DUPLICATE DATA:</u> </strong> ";
							$dupl .= $dupl_;
						}else{
							$dupl .= '';
						}
					}

					echo $exist;
					echo $already;
					echo $max_length;

					echo $catalog_no_empty;
					echo $manufacturer_code_empty;
					echo $source_type_empty;
					echo $man_ref_empty;
					echo $type_empty;

					echo $dupl;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_part_man_code btn btn-sm btn-primary' value='IMPORT PART MANUFACTURER CODE DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'PART EQUIPMENT CODE'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'CATALOG NO'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'EQUIPMENT CODE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'QTY INSTALL'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'MANUFACTURER CODE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[4])) == 'DOC REF'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[5])) == 'DWG REF'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}
					}
				}				
			}

			if (in_array(0, $status)) {
			    echo "<span class='text-danger'>TABLE COLUMN DIDN'T MATCH</span>";
			}else{
				echo "<div id='uploaded_area'>";
				echo "<hr/>";
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF PART EQUIPMENT CODE</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_exist_in_db = [];
					$warn_exist_in_db = [];

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_catalog_no = [];
					$check_empty_eq_code = [];
					$check_empty_qty_install = [];
					$check_empty_man_code = [];
					$check_empty_ref = [];

					$check_duplicate = [];
					$cek_numerical = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='10%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='18%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "<th width='9%'>".strtoupper(trim($rows[2]))."</th>";
								$table .= "<th width='19%'>".strtoupper(trim($rows[3]))."</th>";
								$table .= "<th width='20%'>".strtoupper(trim($rows[4]))."</th>";
								$table .= "<th width='20%'>".strtoupper(trim($rows[5]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// CHEK EXIST IN DB DB?
								if($rows[0] == '' || $rows[0] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = PartMaster::select('id')
										->where('catalog_no', trim($rows[0]))->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'CATALOG NO <b>'.strtoupper(trim($rows[0])).'</b>';
									}
								}

								if($rows[1] == '' || $rows[1] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblEquipmentCode::select('id')
										->where('equipment_code', trim($rows[1]))->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'EQUIPMENT CODE <b>'.strtoupper(trim($rows[1])).'</b>';
									}
								}

								if($rows[3] == '' || $rows[3] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblManufacturerCode::select('id')
										->where('manufacturer_code', trim($rows[3]))->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'MANUFACTURER CODE <b>'.strtoupper(trim($rows[3])).'</b>';
									}
								}

								// CHEK ALREADY IN DB DB?
								$check_already_in_db = PartEquipmentCode::select('part_equipment_code.id')
									->join('part_master', 'part_master.id', 'part_equipment_code.part_master_id')
									->join('tbl_equipment_code', 'tbl_equipment_code.id', 'part_equipment_code.tbl_equipment_code_id')
									->join('tbl_manufacturer_code', 'tbl_manufacturer_code.id', 'part_equipment_code.tbl_manufacturer_code_id')
									->where('catalog_no', trim($rows[0]))
									->where('equipment_code', trim($rows[1]))
									->where('manufacturer_code', trim($rows[3]))
									->first();

								if(count($check_already_in_db)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = 'CATALOG NO <b>'.strtoupper(trim($rows[0])).'</b> WITH EQUIPMENT CODE <b>'.strtoupper(trim($rows[1])).'</b> AND MANUFACTURER CODE <b>'.strtoupper(trim($rows[3])).'</b>';
								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK EMPTY
								$check_empty_catalog_no[] .= $rows[0];
								$check_empty_eq_code[] .= $rows[1];
								$check_empty_qty_install[] .= $rows[2];
								$check_empty_man_code[] .= $rows[3];

								$cek_ref = $rows[4].$rows[5];

								if($cek_ref == '' || $cek_ref == null){
									$check_empty_ref[] = '';
								}else{
									$check_empty_ref[] = 'ADA';
								}

								// MAX STR
								if(strlen(trim($rows[2])) > 11){
									$max_str[] = 0;
									$warn_max_str[] = 'QTY INSTALL <b>"'.strtoupper(trim($rows[2])).'"</b> LENGTH MAY NOT BE GREATER THAN 11';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[4])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = 'DOC REF <b>"'.strtoupper(trim($rows[4])).'"</b> LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[5])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = 'DWG REF <b>"'.strtoupper(trim($rows[5])).'"</b> LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								// CEK DUPLICATE
								if(
									is_null($rows[0]) || $rows[0] == '' || 
									is_null($rows[1]) || $rows[1] == '' ||
									is_null($rows[3]) || $rows[3] == ''
								){
									$check_duplicate[] .= '';
								}else{
									$check_duplicate[] .= 'CATALOG NO <b>'.strtoupper(trim($rows[0])).'</b> WITH EQUIPMENT CODE <b>'.strtoupper(trim($rows[1])).'</b> MANUFACTURER CODE <b>'.strtoupper(trim($rows[3])).'</b>';
								}

								$cek_numerical[] .= $rows[2];

								// TABLE
								// ====================================================
								$table .= "<tr><td>".$urut++."</td>";
								$table .= "<td>".strtoupper(trim($rows[0]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[1]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[2]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[3]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[4]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[5]))."</td></tr>";

								$data_counter[] = 1;								
							}							
						}						
					}					
					
				}
				$table .= "</tbody></table>";

				$empty_catalog_no = array();
				foreach ($check_empty_catalog_no as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_catalog_no[] = 0;
					 }else{
					 	$empty_catalog_no[] = 1;
					 }
				}

				$empty_eq_code = array();
				foreach ($check_empty_eq_code as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_eq_code[] = 0;
					 }else{
					 	$empty_eq_code[] = 1;
					 }
				}

				$empty_qty_install = array();
				foreach ($check_empty_qty_install as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_qty_install[] = 0;
					 }else{
					 	$empty_qty_install[] = 1;
					 }
				}

				$empty_man_code = array();
				foreach ($check_empty_man_code as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_man_code[] = 0;
					 }else{
					 	$empty_man_code[] = 1;
					 }
				}

				$empty_ref = array();
				foreach ($check_empty_ref as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_ref[] = 0;
					 }else{
					 	$empty_ref[] = 1;
					 }
				}

				// hitung jml
				$check_duplicate_ = array_count_values($check_duplicate);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$check_dupl = array();
				foreach ($check_duplicate_ as $key => $value) {
					if($value > 1) {
						$check_dupl[] = 0;
					}else{
						$check_dupl[] = 1;
					}
				}

				// CEK NUMERIK
				$is_numerical = array();
				foreach ($cek_numerical as $value) {
					 if($value <> null && $value <> ''){
					 	if(is_numeric($value) == true){
					 		$is_numerical[] = 1;
					 	}else{
					 		$is_numerical[] = 0;
					 	}					 	
					 }else{
					 	$is_numerical[] = 1;
					 }
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY PART EQUIPMENT CODE DATA.</span>';
				}elseif(
					in_array(0, $cek_exist_in_db) ||
					// cek apakah terdapat item yang melebihi maksimum string
					in_array(0, $max_str) ||	
					// cek apakah ada item yg ada dlm database
					in_array(0, $cek_already_in_db) ||
					// cek apakah terdapat yang kosong
					in_array(0, $empty_catalog_no) ||
					in_array(0, $empty_eq_code) ||
					in_array(0, $empty_qty_install) ||
					in_array(0, $empty_man_code) ||
					in_array(0, $empty_ref) ||
					// cek apakah ada duplicate dalam spreadsheet
					in_array(0, $check_dupl) ||
					// cek apakah value berupa numeric
					in_array(0, $is_numerical)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR PART EQUIPMENT CODE SPREADSHEET</strong></span>";

					// EXIST?
					$exist = '';
					if(in_array(0, $cek_exist_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>NOT FOUND RECORD IN DATABASE:</u></strong>";
						foreach ($warn_exist_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$exist = $validasi;
					}

					// MAX LENGTH
					$max_length = '';
					if(in_array(0, $max_str)){
						$validasi = "<br><br><strong class='text-danger'><u>CHARACTER LENGTH MORE THAN ALLOWED:</u> </strong>";
						foreach ($warn_max_str as $value) {
							$validasi .= '<br/>'.$value;
						}
						$max_length = $validasi;
					}

					// ALREADY IN DB
					$already = '';
					if(in_array(0, $cek_already_in_db)){
						$validasi = "<br><br><strong class='text-danger'><u>ALREADY IN DATABASE:</u></strong>";
						foreach ($warn_already_in_db as $value) {
							$validasi .= '<br/>'.$value;
						}
						$already = $validasi;
					}

					// CEK EMPTY
					$catalog_no_empty = '';
					if(in_array(0, $empty_catalog_no)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY CATALOG NO:</u></strong>";
						$i = 3;
						foreach ($check_empty_catalog_no as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$catalog_no_empty = $validasi;
					}

					$eq_code_empty = '';
					if(in_array(0, $empty_eq_code)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY EQUIPMENT CODE NO:</u></strong>";
						$i = 3;
						foreach ($check_empty_eq_code as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$eq_code_empty = $validasi;
					}
					
					$qty_install_empty = '';
					if(in_array(0, $empty_qty_install)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY QTY INSTALL NO:</u></strong>";
						$i = 3;
						foreach ($check_empty_qty_install as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$qty_install_empty = $validasi;
					}

					$man_code_empty = '';
					if(in_array(0, $empty_man_code)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY MANUFACTURER CODE NO:</u></strong>";
						$i = 3;
						foreach ($check_empty_man_code as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$man_code_empty = $validasi;
					}

					$ref_empty = '';
					if(in_array(0, $empty_ref)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY DOC REF OR DWG REF:</u></strong>";
						$i = 3;
						foreach ($check_empty_ref as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$ref_empty = $validasi;
					}

					$dupl_ = '';
					$dupl = '';
					if(in_array(0, $check_dupl)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_again = array_count_values($check_duplicate);

						// remove empty
						foreach($check_duplicate_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_ = $validasi;

						if(in_array(1, $ada)){
							$dupl .= "<br><br><strong class='text-danger'><u>DUPLICATE DATA:</u> </strong> ";
							$dupl .= $dupl_;
						}else{
							$dupl .= '';
						}
					}

					$is_numeric = '';
					if(in_array(0, $is_numerical)){
						$validasi = "<br><br><strong class='text-danger'><u>QTY INSTALL MUST NUMERIC:</u></strong> ";
						$i = 3;
						foreach ($cek_numerical as $value) {
							if($value <> null && $value <> ''){
								if(is_numeric($value) != true){
									$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
								}else{
									$i++;
								}
							}else{
								$i++;
							}							
						}
						$is_numeric = $validasi;
					}

					echo $exist;
					echo $already;
					echo $max_length;

					echo $catalog_no_empty;
					echo $eq_code_empty;
					echo $qty_install_empty;
					echo $man_code_empty;
					echo $ref_empty;

					echo $dupl;
					echo $is_numeric;

				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_part_eq_code btn btn-sm btn-primary' value='IMPORT PART EQUIPMENT CODE DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}else{
			echo  'WHOOPS, YOU TRY TO UPLOADING WRONG SPREADSHEET :(';
		}
	}

    public function importInc($file){

    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$inc 			= strtoupper(trim($cel[0]));
					$item_name 		= strtoupper(trim($cel[1]));
					$short_name 	= strtoupper(trim($cel[2]));
					$eng_definition = strtoupper(trim($cel[3]));
					$ind_definition = strtoupper(trim($cel[4]));
					$id 			= \Auth::user()->id;
					$date 			= \Carbon\Carbon::now();

					$dataSet[] = [
						'inc'				=> $inc,
						'item_name'			=> $item_name,
						'short_name'		=> $short_name,
						'sap_code' 			=> $inc,
		        		'sap_char_id' 		=> $inc,
						'eng_definition'	=> $eng_definition,
						'ind_definition'	=> $ind_definition,
						'created_by' 		=> $id,
		        		'last_updated_by' 	=> $id,
		        		'created_at'		=> $date,
     					'updated_at'		=> $date
					];					
				}
			}
		}

		if(count($dataSet)>1000){
			\DB::transaction(function () use ($dataSet){
				foreach (array_chunk($dataSet,1000) as $data) {
	               TblInc::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblInc::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importChar($file){

    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$characteristic = strtoupper(trim($cel[0]));
					$label 			= strtoupper(trim($cel[1]));
					$position 		= strtoupper(trim($cel[2]));

					if(strtoupper(trim($cel[3])) == 'YES'){
						$space 		= 1;
					}else{
						$space 		= 0;
					}
					
					$type 			= strtoupper(trim($cel[4]));
					$id 			= \Auth::user()->id;
					$date 			= \Carbon\Carbon::now();

					$dataSet[] = [
						'characteristic'	=> $characteristic,
						'label'				=> $label,
						'position'			=> $position,
						'space' 			=> $space,
		        		'type' 				=> $type,
						'created_by' 		=> $id,
		        		'last_updated_by' 	=> $id,
		        		'created_at'		=> $date,
     					'updated_at'		=> $date
					];					
				}
			}
		}

		if(count($dataSet)>1000){
			\DB::transaction(function () use ($dataSet){
				foreach (array_chunk($dataSet,1000) as $data) {
	               TblCharacteristic::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblCharacteristic::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importIncChar($file){

    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$tbl_inc_id 			= TblInc::select('id')->where('inc', trim($cel[0]))->first()->id;
					$tbl_characteristic_id 	= TblCharacteristic::select('id')->where('characteristic', trim($cel[1]))->first()->id;
					$default_short_separator= strtoupper(trim($cel[2]));
					$sequence 				= strtoupper(trim($cel[3]));
					$id 					= \Auth::user()->id;
					$date 					= \Carbon\Carbon::now();

					$dataSet[] = [
						'tbl_inc_id'				=> $tbl_inc_id,
						'tbl_characteristic_id'		=> $tbl_characteristic_id,
						'default_short_separator'	=> $default_short_separator,
						'sequence' 					=> $sequence,
						'created_by' 		=> $id,
		        		'last_updated_by' 	=> $id,
		        		'created_at'		=> $date,
     					'updated_at'		=> $date
					];					
				}
			}
		}

		if(count($dataSet)>1000){
			\DB::transaction(function () use ($dataSet){
				foreach (array_chunk($dataSet,1000) as $data) {
	               LinkIncCharacteristic::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			LinkIncCharacteristic::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importGroup($file){

    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$group 			= strtoupper(trim($cel[0]));
					$name 			= strtoupper(trim($cel[1]));
					$eng_definition	= strtoupper(trim($cel[2]));
					$ind_definition	= strtoupper(trim($cel[3]));
					$id 			= \Auth::user()->id;
					$date 			= \Carbon\Carbon::now();

					$dataSet[] = [
						'group'				=> $group,
						'name'				=> $name,
						'eng_definition'	=> $eng_definition,
						'ind_definition'	=> $ind_definition,
						'created_by' 		=> $id,
		        		'last_updated_by' 	=> $id,
		        		'created_at'		=> $date,
     					'updated_at'		=> $date
					];					
				}
			}
		}

		if(count($dataSet)>1000){
			\DB::transaction(function () use ($dataSet){
				foreach (array_chunk($dataSet,1000) as $data) {
	               TblGroup::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblGroup::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importGroupClass($file){

    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$tbl_group_id 		= TblGroup::select('id')->where('group', trim($cel[0]))->first()->id;
					$class 				= strtoupper(trim($cel[1]));
					$name 				= strtoupper(trim($cel[2]));
					$eng_definition 	= strtoupper(trim($cel[3]));
					$ind_definition 	= strtoupper(trim($cel[4]));
					$id 				= \Auth::user()->id;
					$date 				= \Carbon\Carbon::now();

					$dataSet[] = [
						'tbl_group_id'		=> $tbl_group_id,
						'class'				=> $class,
						'name'				=> $name,
						'eng_definition' 	=> $eng_definition,
						'ind_definition' 	=> $ind_definition,
						'created_by' 		=> $id,
		        		'last_updated_by' 	=> $id,
		        		'created_at'		=> $date,
     					'updated_at'		=> $date
					];					
				}
			}
		}

		if(count($dataSet)>1000){
			\DB::transaction(function () use ($dataSet){
				foreach (array_chunk($dataSet,1000) as $data) {
	               TblGroupClass::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblGroupClass::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importIncGroupClass($file){

    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$tbl_inc_id 		= TblInc::select('id')->where('inc', trim($cel[0]))->first()->id;

					$tbl_group_class_id = TblGroupClass::select('tbl_group_class.id')
						->join('tbl_group', 'tbl_group.id', '=', 'tbl_group_class.tbl_group_id')
						->where('group', trim(substr($cel[1], 0, 2)))
						->where('class', trim(substr($cel[1], 2, 2)))
						->first()->id;
					$tbl_group_class_id = $tbl_group_class_id;

					$id 				= \Auth::user()->id;
					$date 				= \Carbon\Carbon::now();

					$dataSet[] = [
						'tbl_inc_id'		=> $tbl_inc_id,
						'tbl_group_class_id'=> $tbl_group_class_id,
						'created_by' 		=> $id,
		        		'last_updated_by' 	=> $id,
		        		'created_at'		=> $date,
     					'updated_at'		=> $date
					];					
				}
			}
		}

		if(count($dataSet)>1000){
			\DB::transaction(function () use ($dataSet){
				foreach (array_chunk($dataSet,1000) as $data) {
	               LinkIncGroupClass::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			LinkIncGroupClass::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importIncCharValue($file){

    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$tbl_inc_characteristic_id = LinkIncCharacteristic::select('link_inc_characteristic.id')
						->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_characteristic.tbl_inc_id')
						->join('tbl_characteristic', 'tbl_characteristic.id', '=', 'link_inc_characteristic.tbl_characteristic_id')
						->where('inc', trim($cel[0]))
						->where('characteristic', trim($cel[1]))
						->first()->id;

					$value 					= strtoupper(trim($cel[2]));
					$abbrev 				= strtoupper(trim($cel[3]));

					if(strtoupper(trim($cel[4])) == 'YES'){
						$approved 		= 1;
					}else{
						$approved 		= 0;
					}

					$id 					= \Auth::user()->id;
					$date 					= \Carbon\Carbon::now();

					$dataSet[] = [
						'tbl_inc_characteristic_id' 	=> $tbl_inc_characteristic_id,
						'value' 						=> $value,
						'abbrev'						=> $abbrev,
						'approved'						=> $approved,
						'created_by' 		=> $id,
		        		'last_updated_by' 	=> $id,
		        		'created_at'		=> $date,
     					'updated_at'		=> $date
					];					
				}
			}
		}

		if(count($dataSet)>1000){
			\DB::transaction(function () use ($dataSet){
				foreach (array_chunk($dataSet,1000) as $data) {
	               LinkIncCharacteristicValue::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			LinkIncCharacteristicValue::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importManufacturerCode($file){

    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){

					$manufacturer_code 		= strtoupper(trim($cel[0]));
					$manufacturer_name 		= strtoupper(trim($cel[1]));
					$address 				= strtoupper(trim($cel[2]));
					$id 					= \Auth::user()->id;
					$date 					= \Carbon\Carbon::now();

					$dataSet[] = [
						'manufacturer_code' => $manufacturer_code,
						'manufacturer_name' => $manufacturer_name,
						'address'			=> $address,
						'created_by' 		=> $id,
		        		'last_updated_by' 	=> $id,
		        		'created_at'		=> $date,
     					'updated_at'		=> $date
					];					
				}
			}
		}

		if(count($dataSet)>1000){
			\DB::transaction(function () use ($dataSet){
				foreach (array_chunk($dataSet,1000) as $data) {
	               TblManufacturerCode::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblManufacturerCode::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importSourceType($file){

    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$type 			= strtoupper(trim($cel[0]));
					$description 	= strtoupper(trim($cel[1]));
					$id 					= \Auth::user()->id;
					$date 					= \Carbon\Carbon::now();

					$dataSet[] = [
						'type' 				=> $type,
						'description' 		=> $description,
						'created_by' 		=> $id,
		        		'last_updated_by' 	=> $id,
		        		'created_at'		=> $date,
     					'updated_at'		=> $date
					];					
				}
			}
		}

		if(count($dataSet)>1000){
			\DB::transaction(function () use ($dataSet){
				foreach (array_chunk($dataSet,1000) as $data) {
	               TblSourceType::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblSourceType::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importPartManCodeType($file){

    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();

			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$type 			= strtoupper(trim($cel[0]));
					$description 	= strtoupper(trim($cel[1]));
					$id 					= \Auth::user()->id;
					$date 					= \Carbon\Carbon::now();

					$dataSet[] = [
						'type' 				=> $type,
						'description' 		=> $description,
						'created_by' 		=> $id,
		        		'last_updated_by' 	=> $id,
		        		'created_at'		=> $date,
     					'updated_at'		=> $date
					];					
				}
			}
		}

		if(count($dataSet)>1000){
			\DB::transaction(function () use ($dataSet){
				foreach (array_chunk($dataSet,1000) as $data) {
	               TblPartManufacturerCodeType::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblPartManufacturerCodeType::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importEquipmentCode($file){

    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();

			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$equipment_code = strtoupper(trim($cel[0]));
					$equipment_name = strtoupper(trim($cel[1]));
					$id 			= \Auth::user()->id;
					$date 			= \Carbon\Carbon::now();

					$dataSet[] = [
						'equipment_code' => $equipment_code,
						'equipment_name' => $equipment_name,
						'created_by' 	 => $id,
		        		'last_updated_by'=> $id,
		        		'created_at'	 => $date,
     					'updated_at'	 => $date
					];					
				}
			}
		}

		if(count($dataSet)>1000){
			\DB::transaction(function () use ($dataSet){
				foreach (array_chunk($dataSet,1000) as $data) {
	               TblEquipmentCode::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblEquipmentCode::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importEquipmentPlant($file){

    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$equipment_code = TblEquipmentCode::select('id')
						->where('equipment_code', trim($cel[0]))
						->first()->id;

					$plant = TblPlant::select('tbl_plant.id')
						->join('tbl_company', 'tbl_company.id', 'tbl_plant.tbl_company_id')
						->join('tbl_holding', 'tbl_holding.id', 'tbl_company.tbl_holding_id')
						->where('holding', trim($cel[1]))
						->where('company', trim($cel[2]))
						->where('plant', trim($cel[3]))
						->first()->id;
					
					$date 	= \Carbon\Carbon::now();

					$dataSet[] = [
						'tbl_equipment_code_id' => $equipment_code,
						'tbl_plant_id' 			=> $plant,
		        		'created_at'	 		=> $date,
     					'updated_at'	 		=> $date
					];					
				}
			}
		}

		if(count($dataSet)>1000){
			\DB::transaction(function () use ($dataSet){
				foreach (array_chunk($dataSet,1000) as $data) {
	               TblEquipmentPlant::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblEquipmentPlant::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importPartMaster($file){

    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			foreach ($rows as $cel) {
				$key = $i++;
				if($key == 2){
					$unit_issue = strtoupper(trim($cel[7]));
					$unit_purchase = strtoupper(trim($cel[8]));
				}elseif($key > 2){
					
					$catalog_no 	= strtoupper(trim($cel[0]));	
					$tbl_holding_id = TblHolding::select('id')->where('holding', trim($cel[1]))->first()->id;	
					$holding_no 	= strtoupper(trim($cel[2]));
					$reference_no 	= strtoupper(trim($cel[3]));

					$link_inc_group_class_id = LinkIncGroupClass::select('link_inc_group_class.id')
					->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_group_class.tbl_inc_id')
					->join('tbl_group_class', 'tbl_group_class.id', '=', 'link_inc_group_class.tbl_group_class_id')
					->join('tbl_group', 'tbl_group.id', '=', 'tbl_group_class.tbl_group_id')
					->where('inc', trim($cel[4]))
					->where('group', substr(trim($cel[5]), 0, 2))
					->where('class', substr(trim($cel[5]), 2, 2))
					->first()->id;

					$catalog_type 	= strtolower(trim($cel[6]));

					if($unit_issue == 'UNIT ISSUE2'){
						$unit_issue = TblUnitOfMeasurement::select('id')->where('unit2', trim($cel[7]))->first()->id;
					}elseif ($unit_issue == 'UNIT ISSUE3') {
						$unit_issue = TblUnitOfMeasurement::select('id')->where('unit3', trim($cel[7]))->first()->id;
					}elseif ($unit_issue == 'UNIT ISSUE4') {
						$unit_issue = TblUnitOfMeasurement::select('id')->where('unit3', trim($cel[7]))->first()->id;
					}

					if($unit_purchase == 'UNIT PURCHASE2'){
						$unit_purchase = TblUnitOfMeasurement::select('id')->where('unit2', trim($cel[8]))->first()->id;
					}elseif ($unit_purchase == 'UNIT PURCHASE3') {
						$unit_purchase = TblUnitOfMeasurement::select('id')->where('unit3', trim($cel[8]))->first()->id;
					}elseif ($unit_purchase == 'UNIT PURCHASE4') {
						$unit_purchase = TblUnitOfMeasurement::select('id')->where('unit3', trim($cel[8]))->first()->id;
					}

					$tbl_catalog_status_id = TblCatalogStatus::select('id')->where('status', strtoupper(trim($cel[9])))->first()->id;
					$conversion = strtoupper(trim($cel[10]));
					$tbl_user_class_id = TblUserClass::select('id')->where('class', trim($cel[11]))->first()->id;
					$tbl_item_type_id = TblItemType::select('id')->where('type', trim($cel[12]))->first()->id;
					$tbl_harmonized_code_id = TblHarmonizedCode::select('id')->where('code', trim($cel[13]))->first()->id;
					$tbl_hazard_class_id = TblHazardClass::select('id')->where('class', trim($cel[14]))->first()->id;
					
					$weight_value = strtoupper(trim($cel[15]));

					$tbl_weight_unit_id = TblWeightUnit::select('id')->where('unit', trim($cel[16]))->first()->id;
					$tbl_stock_type_id = TblStockType::select('id')->where('type', trim($cel[17]))->first()->id;

					$average_unit_price = strtoupper(trim($cel[18]));
					$memo = strtoupper(trim($cel[19]));

					$date 			= \Carbon\Carbon::now();
					$id 			= \Auth::user()->id;

					$dataSet[] = [
						'catalog_no' 				=> $catalog_no,
						'tbl_holding_id' 			=> $tbl_holding_id,
						'holding_no' 				=> $holding_no,
						'reference_no' 				=> $reference_no,

						'link_inc_group_class_id' 	=> $link_inc_group_class_id,

						'catalog_type' 				=> $catalog_type,

						'unit_issue' 				=> $unit_issue,
						'unit_purchase' 			=> $unit_purchase,

						'tbl_catalog_status_id' 	=> $tbl_catalog_status_id,
						'conversion' 				=> $conversion,
						'tbl_user_class_id' 		=> $tbl_user_class_id,
						'tbl_item_type_id' 			=> $tbl_item_type_id,
						'tbl_harmonized_code_id' 	=> $tbl_harmonized_code_id,
						'tbl_hazard_class_id' 		=> $tbl_hazard_class_id,
						'weight_value' 				=> $weight_value,
						'tbl_weight_unit_id' 		=> $tbl_weight_unit_id,
						'tbl_stock_type_id' 		=> $tbl_stock_type_id,
						'average_unit_price' 		=> $average_unit_price,
						'memo' 						=> $memo,
		        		'created_by'	 			=> $id,
		        		'last_updated_by'	 		=> $id,
		        		'created_at'	 			=> $date,
     					'updated_at'	 			=> $date
					];					
				}
			}
		}

		if(count($dataSet)>1000){
			\DB::transaction(function () use ($dataSet){
				foreach (array_chunk($dataSet,1000) as $data) {
	               PartMaster::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			$test = PartMaster::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importPartManCode($file){

    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){

					$part_master_id = PartMaster::select('id')->where('catalog_no', trim($cel[0]))->first()->id;
					$tbl_manufacturer_code_id = TblManufacturerCode::select('id')->where('manufacturer_code', trim($cel[1]))->first()->id;
					$tbl_source_type_id = TblSourceType::select('id')->where('type', trim($cel[2]))->first()->id;
					$manufacturer_ref = strtoupper(trim($cel[3]));
					$tbl_part_manufacturer_code_type_id = TblPartManufacturerCodeType::select('id')->where('type', trim($cel[4]))->first()->id;
					$date 			= \Carbon\Carbon::now();
					$id 			= \Auth::user()->id;

					$dataSet[] = [
						'part_master_id' 					=> $part_master_id,
						'tbl_manufacturer_code_id' 			=> $tbl_manufacturer_code_id,
						'tbl_source_type_id' 				=> $tbl_source_type_id,
						'manufacturer_ref' 					=> $manufacturer_ref,
						'tbl_part_manufacturer_code_type_id'=> $tbl_part_manufacturer_code_type_id,
						'created_by' 	=> $id,
						'last_updated_by'=> $id,
		        		'created_at'	 => $date,
     					'updated_at'	 => $date
					];					
				}
			}
		}

		if(count($dataSet)>1000){
			\DB::transaction(function () use ($dataSet){
				foreach (array_chunk($dataSet,1000) as $data) {
	               PartManufacturerCode::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			PartManufacturerCode::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importPartEqCode($file){

    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){

					$part_master_id 	= PartMaster::select('id')->where('catalog_no', trim($cel[0]))->first()->id;
					$tbl_equipment_code_id = TblEquipmentCode::select('id')->where('equipment_code', trim($cel[1]))->first()->id;
					$qty_install = strtoupper(trim($cel[2]));
					$tbl_manufacturer_code_id = TblManufacturerCode::select('id')->where('manufacturer_code', trim($cel[3]))->first()->id;
					$doc_ref = strtoupper(trim($cel[4]));
					$dwg_ref = strtoupper(trim($cel[5]));
					$date 			= \Carbon\Carbon::now();
					$id 			= \Auth::user()->id;

					$dataSet[] = [
						'part_master_id' 			=> $part_master_id,
						'tbl_equipment_code_id' 	=> $tbl_equipment_code_id,
						'qty_install' 				=> $qty_install,
						'tbl_manufacturer_code_id'	=> $tbl_manufacturer_code_id,
						'doc_ref' 					=> $doc_ref,
						'dwg_ref'					=> $dwg_ref,
						'created_by' 		=> $id,
						'last_updated_by'	=> $id,
		        		'created_at'	 	=> $date,
     					'updated_at'	 	=> $date
					];					
				}
			}
		}

		if(count($dataSet)>1000){
			\DB::transaction(function () use ($dataSet){
				foreach (array_chunk($dataSet,1000) as $data) {
	               PartEquipmentCode::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			PartEquipmentCode::insert($dataSet);
			return number_format(count($dataSet));
		}
    }
}