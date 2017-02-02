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

use App\Models\PartBinLocation;
use App\Models\PartCompany;
use App\Models\PartMaster;
use App\Models\PartManufacturerCode;
use App\Models\PartEquipmentCode;

use App\Models\TblAbbrev;
use App\Models\TblBin;
use App\Models\TblCatalogStatus;
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

    public function readSource($filename){
    	ini_set('max_execution_time', 300); // 3 minutes

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
						foreach ($check_empty_group as $value) {
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

					$cek_wrong_value = [];
					$warn_wrong_value = [];

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
								$table .= "<th width='30%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "<th width='25%'>".strtoupper(trim($rows[2]))."</th>";
								$table .= "<th width='20%'>".strtoupper(trim($rows[3]))."</th>";
								$table .= "<th width='10%'>".strtoupper(trim($rows[4]))."</th>";
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
								if(strlen(trim($rows[2])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = '<b>VALUE</b> "'.strtoupper(trim($rows[2])).'" LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[3])) > 40){
									$max_str[] = 0;
									$warn_max_str[] = '<b>ABBREV</b> "'.strtoupper(trim($rows[3])).'" LENGTH MAY NOT BE GREATER THAN 40';
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
									$check_duplicate_inc_char_value[] .= 'INC <b>'.trim(strtoupper($rows[0])).'</b> AND CHARACTERISTIC <b>'.trim(strtoupper($rows[1])).'</b> WITH VALUE <b>'.trim(strtoupper($rows[2])).'</b>';
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

						if(strtoupper(trim($rows[2])) == 'DOCUMENT REF'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'COMPANY'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[4])) == 'PLANT'){
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

					$cek_exist_in_db = [];
					$warn_exist_in_db = [];

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_equipment_code = [];
					$check_empty_equipment_name = [];
					$check_empty_company = [];
					$check_empty_plant = [];

					$check_duplicate_code_company = [];

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
								$table .= "<th width='20%'>".strtoupper(trim($rows[4]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// VALIDATION
								// ===============================================
								
								// CHEK EXIST IN DB DB?
								if($rows[3] == '' || $rows[3] == null || 
									$rows[4] == '' || $rows[4] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblPlant::select('tbl_plant.id')
										->join('tbl_company', 'tbl_company.id', '=', 'tbl_plant.tbl_company_id')
										->where('company', trim($rows[3]))
										->where('plant', trim($rows[4]))
										->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'PLANT <b>'.strtoupper(trim($rows[4])).'</b> WITH COMPANY <b>'.strtoupper(trim($rows[3])).'</b>';
									}
								}

								// CHEK ALREADY IN DB DB?
								$check_already_in_db_column = TblEquipmentCode::select('tbl_equipment_code.id')
									->join('tbl_company', 'tbl_company.id', 'tbl_equipment_code.tbl_company_id')
									->where('equipment_code', trim($rows[0]))
									->where('company', trim($rows[3]))
									->first();

								if(count($check_already_in_db_column)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = 'EQUIPMENT CODE <b>'.strtoupper(trim($rows[0])).'</b> WITH COMPANY <b>'.strtoupper(trim($rows[3])).'</b>';
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

								$check_empty_equipment_code[] .= $rows[0];
								$check_empty_equipment_name[] .= $rows[1];
								$check_empty_company[] .= $rows[3];
								$check_empty_plant[] .= $rows[4];

								if(is_null($rows[0]) || $rows[0] == '' || is_null($rows[3]) || $rows[3] == ''){
									$check_duplicate_code_company[] .= '';
								}else{
									$check_duplicate_code_company[] .= 'EQUIPMENT CODE <b>'.strtoupper(trim($rows[0])).'</b> WITH COMPANY <b>'.strtoupper(trim($rows[3])).'</b>';
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
				$code_company_check_duplicate = array_count_values($check_duplicate_code_company);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$check_dupl_code_company = array();
				foreach ($code_company_check_duplicate as $key => $value) {
					if($value > 1) {
						$check_dupl_code_company[] = 0;
					}else{
						$check_dupl_code_company[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY EQUIPMENT CODE DATA.</span>';
				}elseif(
					in_array(0, $cek_exist_in_db) ||
					// cek apakah ada item yg ada dlm database
					in_array(0, $cek_already_in_db) ||
					// cek apakah terdapat item yang melebihi maksimum string
					in_array(0, $max_str) ||
					// cek apakah terdapat yang kosong
					in_array(0, $empty_equipment_code) ||
					in_array(0, $empty_equipment_name) ||
					in_array(0, $empty_company) ||
					in_array(0, $empty_plant) ||
					// cek apakah ada duplicate dalam spreadsheet
					in_array(0, $check_dupl_code_company)
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

					$dupl_code_company_ = '';
					$dupl_code_company = '';
					if(in_array(0, $check_dupl_code_company)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_code_company_again = array_count_values($check_duplicate_code_company);

						// remove empty
						foreach($check_duplicate_code_company_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_code_company_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_code_company_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_code_company_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_code_company .= "<br><br><strong class='text-danger'><u>DUPLICATE EQUIPMENT CODE AND COMPANY:</u> </strong> ";
							$dupl_code_company .= $dupl_code_company_;
						}else{
							$dupl_code_company .= '';
						}
					}

					echo $exist;
					echo $already;
					echo $max_length;
					echo $equipment_code_empty;
					echo $equipment_name_empty;
					echo $company_empty;
					echo $plant_empty;
					echo $dupl_code_company;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_eq_code btn btn-sm btn-primary' value='IMPORT EQUIPMENT CODE DATA'>";
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

						if(strtoupper(trim($rows[2])) == 'COMPANY'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'HOLDING NO'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[4])) == 'REFERENCE NO'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[5])) == 'INC'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[6])) == 'GROUP CLASS'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[7])) == 'CATALOG TYPE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[8])) == 'UNIT ISSUE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[9])) == 'UNIT PURCHASE'){
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
					$check_empty_company = [];
					$check_empty_catalog_type = [];

					$check_duplicate = [];
					$check_duplicate_hol_no = [];

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

								if($rows[2] == '' || $rows[2] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblCompany::select('tbl_company.id')
										->join('tbl_holding', 'tbl_holding.id', 'tbl_company.tbl_holding_id')
										->where('holding', trim($rows[1]))
										->where('company', trim($rows[2]))->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'COMPANY <b>'.strtoupper(trim($rows[2])).'</b>';
									}
								}

								if(
									$rows[5] == '' || $rows[5] == null || 
									$rows[6] == '' || $rows[6] == null ||
									strlen(trim($rows[5])) > 5 ||
									strlen(trim($rows[6])) > 4
								){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = LinkIncGroupClass::select('link_inc_group_class.id')
										->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_group_class.tbl_inc_id')
										->join('tbl_group_class', 'tbl_group_class.id', '=', 'link_inc_group_class.tbl_group_class_id')
										->join('tbl_group', 'tbl_group.id', '=', 'tbl_group_class.tbl_group_id')
										->where('inc', trim($rows[5]))
										->where('group', substr(trim($rows[6]),0,2))
										->where('class', substr(trim($rows[6]),2,2))
										->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'INC <b>'.strtoupper(trim($rows[5])).'</b> WITH GROUP CLASS <b>'.strtoupper(trim($rows[6])).'</b>';
									}
								}

								if(
									$rows[8] == '' || $rows[8] == null
								){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblUnitOfMeasurement::select('id')
										->where('name', trim($rows[8]))->first();								

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'UNIT ISSUE <b>'.strtoupper(trim($rows[8])).'</b>';
									}
								}

								if(
									$rows[9] == '' || $rows[9] == null
								){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblUnitOfMeasurement::select('id')
										->where('name', trim($rows[9]))->first();									

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'UNIT PURCHASE <b>'.strtoupper(trim($rows[9])).'</b>';
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
								$check_empty_company[] .= $rows[2];
								$check_empty_catalog_type[] .= $rows[7];

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

								if($rows[4] <> '' && $rows[4] <> null){
									if(strlen(trim($rows[4])) > 255){
										$max_str[] = 0;
										$warn_max_str[] = 'REFERENCE NO <b>"'.strtoupper(trim($rows[4])).'"</b> LENGTH MAY NOT BE GREATER THAN 255';
									}else{
										$max_str[] = 1;
									}
								}else{
									$max_str[] = 1;
								}								

								if($rows[5] <> '' && $rows[5] <> null){
									if(strlen(trim($rows[5])) > 5){
										$max_str[] = 0;
										$warn_max_str[] = 'INC <b>"'.strtoupper(trim($rows[5])).'"</b> LENGTH MAY NOT BE GREATER THAN 5';
									}else{
										$max_str[] = 1;
									}
								}else{
									$max_str[] = 1;
								}

								if($rows[6] <> '' && $rows[6] <> null){
									if(strlen(trim($rows[6])) > 4){
										$max_str[] = 0;
										$warn_max_str[] = 'GROUP CLASS <b>"'.strtoupper(trim($rows[6])).'"</b> LENGTH MAY NOT BE GREATER THAN 4';
									}else{
										$max_str[] = 1;
									}
								}else{
									$max_str[] = 1;
								}

								// CEK DUPLICATE
								if(
									$rows[0] <> '' && $rows[0] <> null && 
									$rows[1] <> '' && $rows[1] <> null
								){
									$check_duplicate[] .= 'CATALOG NO <b>'.strtoupper(trim($rows[0])).'</b> WITH HOLDING <b>'.strtoupper(trim($rows[1])).'</b>';
								}else{
									$check_duplicate[] .= '';
								}

								if(
									$rows[1] <> '' && $rows[1] <> null && 
									$rows[3] <> '' && $rows[3] <> null
								){
									$check_duplicate_hol_no[] .= 'HOLDING <b>'.strtoupper(trim($rows[1])).'</b> WITH HOLDING NO <b>'.strtoupper(trim($rows[3])).'</b>';
								}else{
									$check_duplicate_hol_no[] .= '';
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
									->where('holding_no', trim($rows[3]))
									->first();

								if(count($check_already_in_db_hol_no_hol)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = 'HOLDING <b>'.strtoupper(trim($rows[1])).'</b> WITH HOLDING NO <b>'.strtoupper(trim($rows[3])).'</b>';
								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK WRONG VALUE
								$urutan = $urut2++;
								if(
									strtoupper(trim($rows[7])) != 'GEN' &&
									strtoupper(trim($rows[7])) != 'OEM'
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

				$empty_company = array();
				foreach ($check_empty_company as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_company[] = 0;
					 }else{
					 	$empty_company[] = 1;
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

				// hitung jml
				$check_duplicate_ = array_count_values($check_duplicate);
				// hapus yg kosong
				foreach($check_duplicate_ as $key=>$value){
				    if(is_null($key) || $key == '')
				        unset($check_duplicate_[$key]);
				}
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$check_dupl = array();
				foreach ($check_duplicate_ as $key => $value) {
					if($value > 1) {
						$check_dupl[] = 0;
					}else{
						$check_dupl[] = 1;
					}
				}

				// hitung jml
				$check_duplicate_hol_no_ = array_count_values($check_duplicate_hol_no);
				// hapus yg kosong
				foreach($check_duplicate_hol_no_ as $key=>$value){
				    if(is_null($key) || $key == '')
				        unset($check_duplicate_hol_no_[$key]);
				}

				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$check_dupl_hol_no = array();
				foreach ($check_duplicate_hol_no_ as $key => $value) {
					if($value > 1) {
						$check_dupl_hol_no[] = 0;
					}else{
						$check_dupl_hol_no[] = 1;
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

				$raw_status = TblCatalogStatus::select('id')->where('status', 'RAW')->first();
				if(count($raw_status)<>1){
					$cek_raw_status = 0;					
				}else{
					$cek_raw_status = 1;
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
					in_array(0, $empty_company) ||
					in_array(0, $empty_catalog_type) ||
					// cek apakah ada duplicate dalam spreadsheet
					in_array(0, $check_dupl) ||
					in_array(0, $check_dupl_hol_no) ||
					// cek apakan kolom mempunyai value yg benar
					in_array(0, $cek_wrong_value) ||
					// cek apakah value berupa numeric
					in_array(0, $is_numerical_wv) ||
					in_array(0, $is_numerical_aup) ||
					$cek_raw_status == 0
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
							$dupl .= "<br><br><strong class='text-danger'><u>DUPLICATE CATALOG NO WITH HOLDING:</u> </strong> ";
							$dupl .= $dupl_;
						}else{
							$dupl .= '';
						}
					}

					$dupl_hol_no_ = '';
					$dupl_hol_no = '';
					if(in_array(0, $check_dupl_hol_no)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_hol_no_again = array_count_values($check_duplicate_hol_no);

						// remove empty
						foreach($check_duplicate_hol_no_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_hol_no_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_hol_no_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_hol_no_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_hol_no .= "<br><br><strong class='text-danger'><u>DUPLICATE HOLDING WITH HOLDING NO:</u> </strong> ";
							$dupl_hol_no .= $dupl_hol_no_;
						}else{
							$dupl_hol_no .= '';
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

					if($cek_raw_status == 0){
						echo '<br/><span class="text-danger">RAW STATUS NOT DEFINED, PLEASE CONTACT YOUR ADMINISTRATOR</span>';
					}					

					echo $exist;
					echo $already;
					echo $max_length;
					echo $catalog_no_empty;
					echo $holding_empty;
					echo $company_empty;
					echo $catalog_type_empty;
					echo $dupl;
					echo $dupl_hol_no;
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
						if(strtoupper(trim($rows[0])) == 'HOLDING'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'CATALOG NO'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'MANUFACTURER CODE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'SOURCE TYPE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[4])) == 'MANUFACTURER REF'){
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

					$check_empty_holding = [];
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
								$table .= "<th width='7%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='7%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "<th width='20%'>".strtoupper(trim($rows[2]))."</th>";
								$table .= "<th width='8%'>".strtoupper(trim($rows[3]))."</th>";
								$table .= "<th width='30%'>".strtoupper(trim($rows[4]))."</th>";
								$table .= "<th width='15%'>".strtoupper(trim($rows[5]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// CHEK EXIST IN DB DB?
								if($rows[0] == '' || $rows[0] == null || $rows[1] == '' || $rows[1] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = PartMaster::select('part_master.id')
										->join('tbl_holding', 'tbl_holding.id', 'part_master.tbl_holding_id')
										->where('holding', trim($rows[0]))
										->where('catalog_no', trim($rows[1]))
										->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'HOLDING <b>'.strtoupper(trim($rows[0])).'</b> WITH CATALOG NO <b>'.strtoupper(trim($rows[1])).'</b>';
									}
								}

								if($rows[2] == '' || $rows[2] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblManufacturerCode::select('id')
										->where('manufacturer_code', trim($rows[2]))->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'MANUFACTURER CODE <b>'.strtoupper(trim($rows[2])).'</b>';
									}
								}

								if($rows[3] == '' || $rows[3] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblSourceType::select('id')
										->where('type', trim($rows[3]))->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'SOURCE TYPE <b>'.strtoupper(trim($rows[3])).'</b>';
									}
								}

								if($rows[5] == '' || $rows[5] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblPartManufacturerCodeType::select('id')
										->where('type', trim($rows[5]))->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'TYPE <b>'.strtoupper(trim($rows[5])).'</b>';
									}
								}

								// CHEK ALREADY IN DB DB?
								$check_already_in_db = PartManufacturerCode::select('part_manufacturer_code.id')
									->join('part_master', 'part_master.id', 'part_manufacturer_code.part_master_id')
									->join('tbl_holding', 'tbl_holding.id', 'part_master.tbl_holding_id')
									->join('tbl_manufacturer_code', 'tbl_manufacturer_code.id', 'part_manufacturer_code.tbl_manufacturer_code_id')
									->join('tbl_source_type', 'tbl_source_type.id', 'part_manufacturer_code.tbl_source_type_id')
									->where('holding', trim($rows[0]))
									->where('catalog_no', trim($rows[1]))
									->where('manufacturer_code', trim($rows[2]))
									->where('type', trim($rows[3]))
									->where('manufacturer_ref', trim($rows[4]))
									->first();

								if(count($check_already_in_db)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = 'HOLDING <b>'.strtoupper(trim($rows[0])).'</b> WITH CATALOG NO <b>'.strtoupper(trim($rows[1])).'</b> WITH MANUFACTURER CODE <b>'.strtoupper(trim($rows[2])).'</b> AND SOURCE TYPE <b>'.strtoupper(trim($rows[3])).'</b> AND MANUFACTURER REF <b>'.strtoupper(trim($rows[4])).'</b>';
								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK EMPTY
								$check_empty_holding[] .= $rows[0];
								$check_empty_catalog_no[] .= $rows[1];
								$check_empty_manufacturer_code[] .= $rows[2];
								$check_empty_source_type[] .= $rows[3];
								$check_empty_man_ref[] .= $rows[4];
								$check_empty_type[] .= $rows[5];

								// MAX STR
								if(strlen(trim($rows[4])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = 'MANUFACTURER REF <b>"'.strtoupper(trim($rows[4])).'"</b> LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								// CEK DUPLICATE
								if(
									is_null($rows[0]) || $rows[0] == '' || 
									is_null($rows[1]) || $rows[1] == '' ||
									is_null($rows[2]) || $rows[2] == '' ||
									is_null($rows[3]) || $rows[3] == '' ||
									is_null($rows[4]) || $rows[4] == ''
								){
									$check_duplicate[] .= '';
								}else{
									$check_duplicate[] .= 'HOLDING <b>'.strtoupper(trim($rows[0])).'</b> WITH CATALOG NO <b>'.strtoupper(trim($rows[1])).'</b> WITH MANUFACTURER CODE <b>'.strtoupper(trim($rows[2])).'</b> AND SOURCE TYPE <b>'.strtoupper(trim($rows[3])).'</b> AND MANUFACTURER REF <b>'.strtoupper(trim($rows[4])).'</b>';
								}

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

				$empty_holding = array();
				foreach ($check_empty_holding as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_holding[] = 0;
					 }else{
					 	$empty_holding[] = 1;
					 }
				}

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
					in_array(0, $empty_holding) ||
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

					echo $holding_empty;
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
						if(strtoupper(trim($rows[0])) == 'HOLDING'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'COMPANY'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'CATALOG NO'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'EQUIPMENT CODE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[4])) == 'QTY INSTALL'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[5])) == 'MANUFACTURER CODE'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[6])) == 'DRAWING REF'){
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

					$check_empty_holding = [];
					$check_empty_company = [];
					$check_empty_catalog_no = [];
					$check_empty_eq_code = [];
					$check_empty_qty_install = [];
					$check_empty_man_code = [];

					$check_duplicate = [];
					$cek_numerical = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='14%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='14%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "<th width='7%'>".strtoupper(trim($rows[2]))."</th>";
								$table .= "<th width='15%'>".strtoupper(trim($rows[3]))."</th>";
								$table .= "<th width='7%'>".strtoupper(trim($rows[4]))."</th>";
								$table .= "<th width='20%'>".strtoupper(trim($rows[5]))."</th>";
								$table .= "<th width='20%'>".strtoupper(trim($rows[6]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// CHEK EXIST IN DB DB?
								if(
									$rows[0] == '' || $rows[0] == null || 
									$rows[1] == '' || $rows[1] == null ||
									$rows[2] == '' || $rows[2] == null
								){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = PartMaster::select('part_master.id')
										->join('tbl_holding', 'tbl_holding.id', 'part_master.tbl_holding_id')
										->where('holding', trim($rows[0]))
										->where('catalog_no', trim($rows[2]))
										->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'HOLDING <b>'.strtoupper(trim($rows[0])).'</b> WITH COMPANY <b>'.strtoupper(trim($rows[1])).'</b> WITH CATALOG NO <b>'.strtoupper(trim($rows[2])).'</b>';
									}
								}

								if($rows[3] == '' || $rows[3] == null || $rows[1] == '' || $rows[1] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblEquipmentCode::select('tbl_equipment_code.id')
										->join('tbl_company', 'tbl_company.id', 'tbl_equipment_code.tbl_company_id')
										->where('equipment_code', trim($rows[3]))
										->where('company', trim($rows[1]))
										->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'EQUIPMENT CODE <b>'.strtoupper(trim($rows[1])).'</b>';
									}
								}

								if($rows[5] == '' || $rows[5] == null){

									$cek_exist_in_db[] = 1;
								
								}else{
									$exist_column = TblManufacturerCode::select('id')
										->where('manufacturer_code', trim($rows[5]))->first();

									if(count($exist_column)>0){
										$cek_exist_in_db[] = 1;
									}else{
										$cek_exist_in_db[] = 0;
										$warn_exist_in_db[] = 'MANUFACTURER CODE <b>'.strtoupper(trim($rows[5])).'</b>';
									}
								}

								// CHEK ALREADY IN DB DB?
								$check_already_in_db = PartEquipmentCode::select('part_equipment_code.id')
									->join('part_master', 'part_master.id', 'part_equipment_code.part_master_id')
									->join('part_company', 'part_company.part_master_id', 'part_master.id')
									->join('tbl_company', 'tbl_company.id', 'part_company.tbl_company_id')
									->join('tbl_holding', 'tbl_holding.id', 'part_master.tbl_holding_id')
									->join('tbl_equipment_code', 'tbl_equipment_code.id', 'part_equipment_code.tbl_equipment_code_id')
									->join('tbl_manufacturer_code', 'tbl_manufacturer_code.id', 'part_equipment_code.tbl_manufacturer_code_id')
									->where('holding', trim($rows[0]))
									->where('company', trim($rows[1]))
									->where('catalog_no', trim($rows[2]))
									->where('equipment_code', trim($rows[3]))
									->where('manufacturer_code', trim($rows[5]))
									->first();

								if(count($check_already_in_db)>0){
									$cek_already_in_db[] = 0;
									$warn_already_in_db[] = 'HOLDING <b>'.strtoupper(trim($rows[0])).'</b> WITH COMPANY NO <b>'.strtoupper(trim($rows[1])).'</b> WITH CATALOG NO <b>'.strtoupper(trim($rows[2])).'</b> WITH EQUIPMENT CODE <b>'.strtoupper(trim($rows[3])).'</b> AND MANUFACTURER CODE <b>'.strtoupper(trim($rows[5])).'</b>';
								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK EMPTY
								$check_empty_holding[] .= $rows[0];
								$check_empty_company[] .= $rows[1];
								$check_empty_catalog_no[] .= $rows[2];
								$check_empty_eq_code[] .= $rows[3];
								$check_empty_qty_install[] .= $rows[4];
								$check_empty_man_code[] .= $rows[5];

								// MAX STR
								if(strlen(trim($rows[4])) > 11){
									$max_str[] = 0;
									$warn_max_str[] = 'QTY INSTALL <b>"'.strtoupper(trim($rows[4])).'"</b> LENGTH MAY NOT BE GREATER THAN 11';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[6])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = 'DRAWING REF <b>"'.strtoupper(trim($rows[6])).'"</b> LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								// CEK DUPLICATE
								if(
									is_null($rows[0]) || $rows[0] == '' || 
									is_null($rows[1]) || $rows[1] == '' ||
									is_null($rows[2]) || $rows[2] == '' ||
									is_null($rows[5]) || $rows[5] == ''
								){
									$check_duplicate[] .= '';
								}else{
									$check_duplicate[] .= 'HOLDING <b>'.strtoupper(trim($rows[0])).'</b> WITH COMPANY <b>'.strtoupper(trim($rows[1])).'</b> WITH CATALOG NO <b>'.strtoupper(trim($rows[2])).'</b> WITH EQUIPMENT CODE <b>'.strtoupper(trim($rows[3])).'</b> MANUFACTURER CODE <b>'.strtoupper(trim($rows[5])).'</b>';
								}

								$cek_numerical[] .= $rows[4];

								// TABLE
								// ====================================================
								$table .= "<tr><td>".$urut++."</td>";
								$table .= "<td>".strtoupper(trim($rows[0]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[1]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[2]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[3]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[4]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[5]))."</td>";
								$table .= "<td>".strtoupper(trim($rows[6]))."</td></tr>";

								$data_counter[] = 1;								
							}							
						}						
					}					
					
				}
				$table .= "</tbody></table>";

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
					 	$emptycompany[] = 1;
					 }
				}

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
					in_array(0, $empty_holding) ||
					in_array(0, $empty_company) ||
					in_array(0, $empty_catalog_no) ||
					in_array(0, $empty_eq_code) ||
					in_array(0, $empty_qty_install) ||
					in_array(0, $empty_man_code) ||
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
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY HOLDING:</u></strong>";
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

					echo $holding_empty;
					echo $company_empty;
					echo $catalog_no_empty;
					echo $eq_code_empty;
					echo $qty_install_empty;
					echo $man_code_empty;

					echo $dupl;
					echo $is_numeric;

				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_part_eq_code btn btn-sm btn-primary' value='IMPORT PART EQUIPMENT CODE DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'HOLDING'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'HOLDING'){
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
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF HOLDING</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_holding = [];
					$check_empty_description = [];

					$check_duplicate_holding = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='15%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='82%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// VALIDATION
								// ===============================================
								
								// CHEK ALREADY IN DB DB?
								if($rows[0] <> '' && $rows[0] <> null){

									$holding_column = TblHolding::where('holding', $rows[0])
										->select('holding')
										->first();

									if(count($holding_column)>0){
										$cek_already_in_db[] = 0;
										$warn_already_in_db[] = '<b>HOLDING:</b> '.strtoupper(trim($rows[0]));
									}else{
										$cek_already_in_db[] = 1;
									}

								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[0])) > 50){
									$max_str[] = 0;
									$warn_max_str[] = '<b>HOLDING</b> "'.strtoupper(trim($rows[0])).'" LENGTH MAY NOT BE GREATER THAN 50';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[1])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = '<b>DESCRIPTION</b> "'.strtoupper(trim($rows[1])).'" LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								$check_empty_holding[] .= $rows[0];
								$check_empty_description[] .= $rows[1];

								if(is_null($rows[0]) || $rows[0] == ''){
									$check_duplicate_holding[] .= '';
								}else{
									$check_duplicate_holding[] .= $rows[0];
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

				$empty_holding = array();
				foreach ($check_empty_holding as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_holding[] = 0;
					 }else{
					 	$empty_holding[] = 1;
					 }
				}

				$empty_decription = array();
				foreach ($check_empty_description as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_decription[] = 0;
					 }else{
					 	$empty_decription[] = 1;
					 }
				}

				// hitung jml
				$holding_check_duplicate = array_count_values($check_duplicate_holding);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_holding = array();
				foreach ($holding_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_holding[] = 0;
					}else{
						$chek_dupl_holding[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY HOLDING DATA.</span>';
				}elseif(
					in_array(0, $cek_already_in_db) ||
					in_array(0, $max_str) ||
					in_array(0, $empty_holding) ||
					in_array(0, $empty_decription) ||
					in_array(0, $chek_dupl_holding)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR HOLDING SPREADSHEET</strong></span>";
					
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

					$description_empty = '';
					if(in_array(0, $empty_description)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY DESCRIPTION:</u></strong>";
						$i = 3;
						foreach ($check_empty_description as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$description_empty = $validasi;
					}

					$dupl_holding_ = '';
					$dupl_holding = '';
					if(in_array(0, $chek_dupl_holding)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_holding_again = array_count_values($check_duplicate_holding);

						// remove empty
						foreach($check_duplicate_holding_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_holding_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_holding_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_holding_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_holding .= "<br><br><strong class='text-danger'><u>DUPLICATE HOLDING:</u> </strong> ";
							$dupl_holding .= $dupl_holding_;
						}else{
							$dupl_holding .= '';
						}
					}

					echo $already;
					echo $max_length;
					echo $holding_empty;
					echo $description_empty;
					echo $dupl_holding;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_holding btn btn-sm btn-primary' value='IMPORT HOLDING DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'COMPANY'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'COMPANY'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'DESCRIPTION'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'HOLDING'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'UOM TYPE'){
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
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF COMPANY</strong> DATA</div>";
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

					$check_empty_holding = [];
					$check_empty_description = [];
					$check_empty_company = [];
					$check_empty_uom_type = [];

					$cek_wrong_value = [];
					$warn_wrong_value = [];

					$check_duplicate_company_holding = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='15%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='30%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "<th width='43%'>".strtoupper(trim($rows[2]))."</th>";
								$table .= "<th width='10%'>".strtoupper(trim($rows[3]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// VALIDATION
								// ===============================================
								
								// CHEK ALREADY IN DB DB?
								if(
									$rows[0] <> '' && 
									$rows[0] <> null &&
									$rows[2] <> '' && 
									$rows[2] <> null
								){

									$company_holding_column = TblCompany::join('tbl_holding', 'tbl_holding.id', 'tbl_company.tbl_holding_id')
										->where('company', $rows[0])
										->where('holding', $rows[2])
										->select('company')
										->first();

									if(count($company_holding_column)>0){
										$cek_already_in_db[] = 0;
										$warn_already_in_db[] = '<b>COMPANY:</b> '.strtoupper(trim($rows[0])).' WITH <b>HOLDING</b> '.strtoupper(trim($rows[2]));
									}else{
										$cek_already_in_db[] = 1;
									}

								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[0])) > 50){
									$max_str[] = 0;
									$warn_max_str[] = '<b>COMPANY</b> "'.strtoupper(trim($rows[0])).'" LENGTH MAY NOT BE GREATER THAN 50';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[1])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = '<b>DESCRIPTION</b> "'.strtoupper(trim($rows[1])).'" LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								// CHECK EMPTY
								$check_empty_company[] .= $rows[0];
								$check_empty_description[] .= $rows[1];
								$check_empty_holding[] .= $rows[2];
								$check_empty_uom_type[] .= $rows[3];

								// CEK WRONG VALUE
								$urutan = $urut2++;
								if(
									strtoupper(trim($rows[3])) != '2' &&
									strtoupper(trim($rows[3])) != '3' &&
									strtoupper(trim($rows[3])) != '4'
								){
									$cek_wrong_value[] = 0;
									$warn_wrong_value[] = '<b>UOM TYPE</b> COLUMN ON LINE <b>#'.$urutan.'</b> MUST BE FILLED WITH "2" OR "3" OR "4"';
								}else{
									$cek_wrong_value[] = 1;
								}

								// CHECK DUPLICATE
								if(is_null($rows[0]) || $rows[0] == ''){
									$check_duplicate_company_holding[] .= '';
								}else{
									$check_duplicate_company_holding[] .= 'COMPANY <b>'.$rows[0].'</b> WITH HOLDING <b>'.$rows[2].'</b>';
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

				$empty_company = array();
				foreach ($check_empty_company as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_company[] = 0;
					 }else{
					 	$empty_company[] = 1;
					 }
				}

				$empty_description = array();
				foreach ($check_empty_description as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_description[] = 0;
					 }else{
					 	$empty_description[] = 1;
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

				$empty_uom_type = array();
				foreach ($check_empty_uom_type as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_uom_type[] = 0;
					 }else{
					 	$empty_uom_type[] = 1;
					 }
				}

				$company_holding_check_duplicate = array_count_values($check_duplicate_company_holding);
				$chek_dupl_company_holding = array();
				foreach ($company_holding_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_company_holding[] = 0;
					}else{
						$chek_dupl_company_holding[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY COMPANY DATA.</span>';
				}elseif(
					in_array(0, $cek_already_in_db) ||
					in_array(0, $max_str) ||
					in_array(0, $cek_wrong_value) ||
					in_array(0, $empty_company) ||
					in_array(0, $empty_description) ||
					in_array(0, $empty_holding) ||
					in_array(0, $empty_uom_type) ||
					in_array(0, $chek_dupl_company_holding) || 
					in_array(0, $cek_wrong_value)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR COMPANY SPREADSHEET</strong></span>";
					
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

					$description_empty = '';
					if(in_array(0, $empty_description)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY DESCRIPTION:</u></strong>";
						$i = 3;
						foreach ($check_empty_description as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$description_empty = $validasi;
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

					$uom_type_empty = '';
					if(in_array(0, $empty_uom_type)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY UOM TYPE:</u></strong>";
						$i = 3;
						foreach ($check_empty_uom_type as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$uom_type_empty = $validasi;
					}

					$dupl_company_holding_ = '';
					$dupl_company_holding = '';
					if(in_array(0, $chek_dupl_company_holding)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_company_holding_again = array_count_values($check_duplicate_company_holding);

						// remove empty
						foreach($check_duplicate_company_holding_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_company_holding_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_company_holding_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_company_holding_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_company_holding .= "<br><br><strong class='text-danger'><u>DUPLICATE HOLDING:</u> </strong> ";
							$dupl_company_holding .= $dupl_company_holding_;
						}else{
							$dupl_company_holding .= '';
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

					echo $already;
					echo $max_length;
					echo $company_empty;
					echo $description_empty;
					echo $holding_empty;
					echo $uom_type_empty;
					echo $dupl_company_holding;
					echo $wrong_value;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_company btn btn-sm btn-primary' value='IMPORT COMPANY DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'USER CLASS'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'CLASS'){
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
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF USER CLASS</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_class = [];
					$check_empty_description = [];

					$check_duplicate_class = [];

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
								if($rows[0] <> '' && $rows[0] <> null){

									$class_column = TblUserClass::where('class', trim($rows[0]))
										->select('class')
										->first();

									if(count($class_column)>0){
										$cek_already_in_db[] = 0;
										$warn_already_in_db[] = '<b>CLASS:</b> '.strtoupper(trim($rows[0]));
									}else{
										$cek_already_in_db[] = 1;
									}

								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[0])) > 50){
									$max_str[] = 0;
									$warn_max_str[] = '<b>CLASS</b> "'.strtoupper(trim($rows[0])).'" LENGTH MAY NOT BE GREATER THAN 50';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[1])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = '<b>DESCRIPTION</b> "'.strtoupper(trim($rows[1])).'" LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								$check_empty_class[] .= $rows[0];
								$check_empty_description[] .= $rows[1];

								if(is_null($rows[0]) || $rows[0] == ''){
									$check_duplicate_class[] .= '';
								}else{
									$check_duplicate_class[] .= $rows[0];
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

				$empty_class = array();
				foreach ($check_empty_class as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_class[] = 0;
					 }else{
					 	$empty_class[] = 1;
					 }
				}

				$empty_description = array();
				foreach ($check_empty_description as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_description[] = 0;
					 }else{
					 	$empty_description[] = 1;
					 }
				}

				// hitung jml
				$class_check_duplicate = array_count_values($check_duplicate_class);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_class = array();
				foreach ($class_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_class[] = 0;
					}else{
						$chek_dupl_class[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY USER CLASS DATA.</span>';
				}elseif(
					in_array(0, $cek_already_in_db) ||
					in_array(0, $max_str) ||
					in_array(0, $empty_class) ||
					in_array(0, $empty_description) ||
					in_array(0, $chek_dupl_class)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR USER CLASS SPREADSHEET</strong></span>";
					
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

					$description_empty = '';
					if(in_array(0, $empty_description)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY DESCRIPTION:</u></strong>";
						$i = 3;
						foreach ($check_empty_description as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$description_empty = $validasi;
					}

					$dupl_class_ = '';
					$dupl_class = '';
					if(in_array(0, $chek_dupl_class)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_class_again = array_count_values($check_duplicate_class);

						// remove empty
						foreach($check_duplicate_class_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_class_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_class_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_class_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_class .= "<br><br><strong class='text-danger'><u>DUPLICATE CLASS:</u> </strong> ";
							$dupl_class .= $dupl_class_;
						}else{
							$dupl_class .= '';
						}
					}

					echo $already;
					echo $max_length;
					echo $class_empty;
					echo $description_empty;
					echo $dupl_class;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_user_class btn btn-sm btn-primary' value='IMPORT USER CLASS DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'ITEM TYPE'){

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
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF ITEM TYPE</strong> DATA</div>";
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
					$check_empty_description = [];

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
								if($rows[0] <> '' && $rows[0] <> null){

									$class_column = TblItemType::where('type', trim($rows[0]))
										->select('type')
										->first();

									if(count($class_column)>0){
										$cek_already_in_db[] = 0;
										$warn_already_in_db[] = '<b>TYPE:</b> '.strtoupper(trim($rows[0]));
									}else{
										$cek_already_in_db[] = 1;
									}

								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[0])) > 50){
									$max_str[] = 0;
									$warn_max_str[] = '<b>TYPE</b> "'.strtoupper(trim($rows[0])).'" LENGTH MAY NOT BE GREATER THAN 50';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[1])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = '<b>DESCRIPTION</b> "'.strtoupper(trim($rows[1])).'" LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								$check_empty_type[] .= $rows[0];
								$check_empty_description[] .= $rows[1];

								if(is_null($rows[0]) || $rows[0] == ''){
									$check_duplicate_type[] .= '';
								}else{
									$check_duplicate_type[] .= $rows[0];
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

				$empty_description = array();
				foreach ($check_empty_description as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_description[] = 0;
					 }else{
					 	$empty_description[] = 1;
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
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY ITEM TYPE DATA.</span>';
				}elseif(
					in_array(0, $cek_already_in_db) ||
					in_array(0, $max_str) ||
					in_array(0, $empty_type) ||
					in_array(0, $empty_description) ||
					in_array(0, $chek_dupl_type)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR ITEM TYPE SPREADSHEET</strong></span>";
					
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

					$description_empty = '';
					if(in_array(0, $empty_description)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY DESCRIPTION:</u></strong>";
						$i = 3;
						foreach ($check_empty_description as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$description_empty = $validasi;
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
					echo $description_empty;
					echo $dupl_type;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_item_type btn btn-sm btn-primary' value='IMPORT ITEM TYPE DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'HARMONIZED CODE'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'CODE'){
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
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF HARMONIZED CODE</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_code = [];
					$check_empty_description = [];

					$check_duplicate_code = [];

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
								if($rows[0] <> '' && $rows[0] <> null){

									$class_column = TblHarmonizedCode::where('code', trim($rows[0]))
										->select('code')
										->first();

									if(count($class_column)>0){
										$cek_already_in_db[] = 0;
										$warn_already_in_db[] = '<b>CODE:</b> '.strtoupper(trim($rows[0]));
									}else{
										$cek_already_in_db[] = 1;
									}

								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[0])) > 50){
									$max_str[] = 0;
									$warn_max_str[] = '<b>CODE</b> "'.strtoupper(trim($rows[0])).'" LENGTH MAY NOT BE GREATER THAN 50';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[1])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = '<b>DESCRIPTION</b> "'.strtoupper(trim($rows[1])).'" LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								$check_empty_code[] .= $rows[0];
								$check_empty_description[] .= $rows[1];

								if(is_null($rows[0]) || $rows[0] == ''){
									$check_duplicate_code[] .= '';
								}else{
									$check_duplicate_code[] .= $rows[0];
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

				$empty_code = array();
				foreach ($check_empty_code as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_code[] = 0;
					 }else{
					 	$empty_code[] = 1;
					 }
				}

				$empty_description = array();
				foreach ($check_empty_description as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_description[] = 0;
					 }else{
					 	$empty_description[] = 1;
					 }
				}

				// hitung jml
				$code_check_duplicate = array_count_values($check_duplicate_code);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_code = array();
				foreach ($code_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_code[] = 0;
					}else{
						$chek_dupl_code[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY HARMONIZED CODE DATA.</span>';
				}elseif(
					in_array(0, $cek_already_in_db) ||
					in_array(0, $max_str) ||
					in_array(0, $empty_code) ||
					in_array(0, $empty_description) ||
					in_array(0, $chek_dupl_code)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR ITEM TYPE SPREADSHEET</strong></span>";
					
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

					$code_empty = '';
					if(in_array(0, $empty_code)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY CODE:</u></strong>";
						$i = 3;
						foreach ($check_empty_code as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$code_empty = $validasi;
					}

					$description_empty = '';
					if(in_array(0, $empty_description)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY DESCRIPTION:</u></strong>";
						$i = 3;
						foreach ($check_empty_description as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$description_empty = $validasi;
					}

					$dupl_code_ = '';
					$dupl_code = '';
					if(in_array(0, $chek_dupl_code)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_code_again = array_count_values($check_duplicate_code);

						// remove empty
						foreach($check_duplicate_code_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_code_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_code_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_code_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_code .= "<br><br><strong class='text-danger'><u>DUPLICATE CODE:</u> </strong> ";
							$dupl_code .= $dupl_code_;
						}else{
							$dupl_code .= '';
						}
					}

					echo $already;
					echo $max_length;
					echo $code_empty;
					echo $description_empty;
					echo $dupl_code;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_harmonized_code btn btn-sm btn-primary' value='IMPORT HARMONIZED CODE DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'HAZARD CLASS'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'CLASS'){
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
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF HAZARD CLASS</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_class = [];
					$check_empty_description = [];

					$check_duplicate_class = [];

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
								if($rows[0] <> '' && $rows[0] <> null){

									$class_column = TblHazardClass::where('class', trim($rows[0]))
										->select('class')
										->first();

									if(count($class_column)>0){
										$cek_already_in_db[] = 0;
										$warn_already_in_db[] = '<b>CLASS:</b> '.strtoupper(trim($rows[0]));
									}else{
										$cek_already_in_db[] = 1;
									}

								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[0])) > 50){
									$max_str[] = 0;
									$warn_max_str[] = '<b>CLASS</b> "'.strtoupper(trim($rows[0])).'" LENGTH MAY NOT BE GREATER THAN 50';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[1])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = '<b>DESCRIPTION</b> "'.strtoupper(trim($rows[1])).'" LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								$check_empty_class[] .= $rows[0];
								$check_empty_description[] .= $rows[1];

								if(is_null($rows[0]) || $rows[0] == ''){
									$check_duplicate_class[] .= '';
								}else{
									$check_duplicate_class[] .= $rows[0];
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

				$empty_class = array();
				foreach ($check_empty_class as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_class[] = 0;
					 }else{
					 	$empty_class[] = 1;
					 }
				}

				$empty_description = array();
				foreach ($check_empty_description as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_description[] = 0;
					 }else{
					 	$empty_description[] = 1;
					 }
				}

				// hitung jml
				$class_check_duplicate = array_count_values($check_duplicate_class);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_class = array();
				foreach ($class_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_class[] = 0;
					}else{
						$chek_dupl_class[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY HAZARD CLASS DATA.</span>';
				}elseif(
					in_array(0, $cek_already_in_db) ||
					in_array(0, $max_str) ||
					in_array(0, $empty_class) ||
					in_array(0, $empty_description) ||
					in_array(0, $chek_dupl_class)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR HAZARD CLAS SPREADSHEET</strong></span>";
					
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

					$description_empty = '';
					if(in_array(0, $empty_description)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY DESCRIPTION:</u></strong>";
						$i = 3;
						foreach ($check_empty_description as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$description_empty = $validasi;
					}

					$dupl_class_ = '';
					$dupl_class = '';
					if(in_array(0, $chek_dupl_class)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_class_again = array_count_values($check_duplicate_class);

						// remove empty
						foreach($check_duplicate_class_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_class_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_class_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_class_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_class .= "<br><br><strong class='text-danger'><u>DUPLICATE CLASS:</u> </strong> ";
							$dupl_class .= $dupl_class_;
						}else{
							$dupl_class .= '';
						}
					}

					echo $already;
					echo $max_length;
					echo $class_empty;
					echo $description_empty;
					echo $dupl_class;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_hazard_class btn btn-sm btn-primary' value='IMPORT HAZARD CLASS DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'WEIGHT UNIT'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'UNIT'){
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
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF WEIGHT UNIT</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_unit = [];
					$check_empty_description = [];

					$check_duplicate_unit = [];

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
								if($rows[0] <> '' && $rows[0] <> null){

									$class_column = TblWeightUnit::where('unit', trim($rows[0]))
										->select('unit')
										->first();

									if(count($class_column)>0){
										$cek_already_in_db[] = 0;
										$warn_already_in_db[] = '<b>UNIT:</b> '.strtoupper(trim($rows[0]));
									}else{
										$cek_already_in_db[] = 1;
									}

								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[0])) > 15){
									$max_str[] = 0;
									$warn_max_str[] = '<b>UNIT</b> "'.strtoupper(trim($rows[0])).'" LENGTH MAY NOT BE GREATER THAN 15';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[1])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = '<b>DESCRIPTION</b> "'.strtoupper(trim($rows[1])).'" LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								$check_empty_unit[] .= $rows[0];
								$check_empty_description[] .= $rows[1];

								if(is_null($rows[0]) || $rows[0] == ''){
									$check_duplicate_unit[] .= '';
								}else{
									$check_duplicate_unit[] .= $rows[0];
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

				$empty_unit = array();
				foreach ($check_empty_unit as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_unit[] = 0;
					 }else{
					 	$empty_unit[] = 1;
					 }
				}

				$empty_description = array();
				foreach ($check_empty_description as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_description[] = 0;
					 }else{
					 	$empty_description[] = 1;
					 }
				}

				// hitung jml
				$unit_check_duplicate = array_count_values($check_duplicate_unit);
				// jika lebih dari 1 maka = 0, kalau tidak = 1
				$chek_dupl_unit = array();
				foreach ($unit_check_duplicate as $key => $value) {
					if($value > 1) {
						$chek_dupl_unit[] = 0;
					}else{
						$chek_dupl_unit[] = 1;
					}
				}

				if(count($data_counter) < 1){
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY WEIGHT UNIT DATA.</span>';
				}elseif(
					in_array(0, $cek_already_in_db) ||
					in_array(0, $max_str) ||
					in_array(0, $empty_unit) ||
					in_array(0, $empty_description) ||
					in_array(0, $chek_dupl_unit)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR WEIGHT UNIT SPREADSHEET</strong></span>";
					
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

					$unit_empty = '';
					if(in_array(0, $empty_unit)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY UNIT:</u></strong>";
						$i = 3;
						foreach ($check_empty_unit as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$unit_empty = $validasi;
					}

					$description_empty = '';
					if(in_array(0, $empty_description)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY DESCRIPTION:</u></strong>";
						$i = 3;
						foreach ($check_empty_description as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$description_empty = $validasi;
					}

					$dupl_unit_ = '';
					$dupl_unit = '';
					if(in_array(0, $chek_dupl_unit)){
						$validasi = '';
						// count to get duplicate (> 1)
						$check_duplicate_unit_again = array_count_values($check_duplicate_unit);

						// remove empty
						foreach($check_duplicate_unit_again as $key=>$value){
						    if(is_null($key) || $key == '')
						        unset($check_duplicate_unit_again[$key]);
						}

						// get only > 1
						$ada = array();
						foreach ($check_duplicate_unit_again as $key => $value) {
							if($value > 1) {
								$validasi .= '<br/>'.$key;
								$ada[] = 1;
							}else{
								$ada[] = 0;
							}
						}
						$dupl_unit_ = $validasi;

						if(in_array(1, $ada)){
							$dupl_unit .= "<br><br><strong class='text-danger'><u>DUPLICATE CLASS:</u> </strong> ";
							$dupl_unit .= $dupl_unit_;
						}else{
							$dupl_unit .= '';
						}
					}

					echo $already;
					echo $max_length;
					echo $unit_empty;
					echo $description_empty;
					echo $dupl_unit;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_weight_unit btn btn-sm btn-primary' value='IMPORT WEIGHT UNIT DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'STOCK TYPE'){

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
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF STOCK TYPE</strong> DATA</div>";
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
					$check_empty_description = [];

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
								if($rows[0] <> '' && $rows[0] <> null){

									$class_column = TblStockType::where('type', trim($rows[0]))
										->select('type')
										->first();

									if(count($class_column)>0){
										$cek_already_in_db[] = 0;
										$warn_already_in_db[] = '<b>TYPE:</b> '.strtoupper(trim($rows[0]));
									}else{
										$cek_already_in_db[] = 1;
									}

								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[0])) > 50){
									$max_str[] = 0;
									$warn_max_str[] = '<b>TYPE</b> "'.strtoupper(trim($rows[0])).'" LENGTH MAY NOT BE GREATER THAN 50';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[1])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = '<b>DESCRIPTION</b> "'.strtoupper(trim($rows[1])).'" LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								$check_empty_type[] .= $rows[0];
								$check_empty_description[] .= $rows[1];

								if(is_null($rows[0]) || $rows[0] == ''){
									$check_duplicate_type[] .= '';
								}else{
									$check_duplicate_type[] .= $rows[0];
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

				$empty_description = array();
				foreach ($check_empty_description as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_description[] = 0;
					 }else{
					 	$empty_description[] = 1;
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
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY STOCK TYPE DATA.</span>';
				}elseif(
					in_array(0, $cek_already_in_db) ||
					in_array(0, $max_str) ||
					in_array(0, $empty_type) ||
					in_array(0, $empty_description) ||
					in_array(0, $chek_dupl_type)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR STOCK TYPE SPREADSHEET</strong></span>";
					
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

					$description_empty = '';
					if(in_array(0, $empty_description)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY DESCRIPTION:</u></strong>";
						$i = 3;
						foreach ($check_empty_description as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$description_empty = $validasi;
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
					echo $description_empty;
					echo $dupl_type;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_stock_type btn btn-sm btn-primary' value='IMPORT STOCK TYPE DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}elseif($table_name == 'UNIT OF MEASUREMENT'){

			$status = array();
			foreach ($reader->getSheetIterator() as $sheet) {
				$i = 1;
				foreach ($sheet->getRowIterator() as $rows) {
					if($i++ == 2){
						if(strtoupper(trim($rows[0])) == 'NAME'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[1])) == 'UNIT 2'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[2])) == 'UNIT 3'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[3])) == 'UNIT 4'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[4])) == 'ENG DEFINITION'){
							$status[] = 1;
						}else{
							$status[] = 0;
						}

						if(strtoupper(trim($rows[5])) == 'IND DEFINITION'){
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
				$table = "<div id='message' style='margin-top:10px;'>READY TO IMPORT YOUR <strong><span id='counter'></span> OF UNIT OF MEASUREMENT</strong> DATA</div>";
				$table .= "<table id='datatables' class='table table-striped table-bordered' width='100%'>";
				foreach ($reader->getSheetIterator() as $sheet) {
					$i = 1;
					$first = true;
					$urut = 3;

					$cek_already_in_db = [];
					$warn_already_in_db = [];

					$max_str = [];
					$warn_max_str = [];

					$check_empty_name = [];
					$check_empty_unit2 = [];
					$check_empty_unit3 = [];
					$check_empty_unit4 = [];

					$check_duplicate_name = [];

					$data_counter = [];
					foreach ($sheet->getRowIterator() as $rows) {
						if($i++ > 1){
							if($first){
								$table .= "<thead><tr>";
								$table .= "<th width='3%'>#</th>";
								$table .= "<th width='10%'>".strtoupper(trim($rows[0]))."</th>";
								$table .= "<th width='7%'>".strtoupper(trim($rows[1]))."</th>";
								$table .= "<th width='7%'>".strtoupper(trim($rows[2]))."</th>";
								$table .= "<th width='7%'>".strtoupper(trim($rows[3]))."</th>";
								$table .= "<th width='33%'>".strtoupper(trim($rows[4]))."</th>";
								$table .= "<th width='33%'>".strtoupper(trim($rows[5]))."</th>";
								$table .= "</tr></thead>";
								$table .= "<tbody>";
								$first = false;
							}else{

								// VALIDATION
								// ===============================================
								
								// CHEK ALREADY IN DB DB?
								if($rows[0] <> '' && $rows[0] <> null){

									$class_column = TblUnitOfMeasurement::where('name', trim($rows[0]))
										->select('name')
										->first();

									if(count($class_column)>0){
										$cek_already_in_db[] = 0;
										$warn_already_in_db[] = '<b>NAME:</b> '.strtoupper(trim($rows[0]));
									}else{
										$cek_already_in_db[] = 1;
									}

								}else{
									$cek_already_in_db[] = 1;
								}

								// CEK MAX STRING LENGTH
								if(strlen(trim($rows[0])) > 255){
									$max_str[] = 0;
									$warn_max_str[] = '<b>NAME </b> "'.strtoupper(trim($rows[0])).'" LENGTH MAY NOT BE GREATER THAN 255';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[1])) > 2){
									$max_str[] = 0;
									$warn_max_str[] = '<b>UNIT 2</b> "'.strtoupper(trim($rows[1])).'" LENGTH MAY NOT BE GREATER THAN 2';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[2])) > 3){
									$max_str[] = 0;
									$warn_max_str[] = '<b>UNIT 3</b> "'.strtoupper(trim($rows[2])).'" LENGTH MAY NOT BE GREATER THAN 3';
								}else{
									$max_str[] = 1;
								}

								if(strlen(trim($rows[3])) > 4){
									$max_str[] = 0;
									$warn_max_str[] = '<b>UNIT 4</b> "'.strtoupper(trim($rows[3])).'" LENGTH MAY NOT BE GREATER THAN 4';
								}else{
									$max_str[] = 1;
								}

								$check_empty_name[] .= $rows[0];
								$check_empty_unit2[] .= $rows[1];
								$check_empty_unit3[] .= $rows[2];
								$check_empty_unit4[] .= $rows[3];

								if(is_null($rows[0]) || $rows[0] == ''){
									$check_duplicate_name[] .= '';
								}else{
									$check_duplicate_name[] .= $rows[0];
								}	

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

				$empty_name = array();
				foreach ($check_empty_name as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_name[] = 0;
					 }else{
					 	$empty_name[] = 1;
					 }
				}

				$empty_unit2 = array();
				foreach ($check_empty_unit2 as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_unit2[] = 0;
					 }else{
					 	$empty_unit2[] = 1;
					 }
				}

				$empty_unit3 = array();
				foreach ($check_empty_unit3 as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_unit3[] = 0;
					 }else{
					 	$empty_unit3[] = 1;
					 }
				}

				$empty_unit4 = array();
				foreach ($check_empty_unit4 as $value) {
					 if(is_null($value) || $value == ''){
					 	$empty_unit4[] = 0;
					 }else{
					 	$empty_unit4[] = 1;
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
					echo '<span class="text-danger">YOU TRY TO UPLOAD SPREADSHEET WITH EMPTY UNIT OF MEASUREMENT DATA.</span>';
				}elseif(
					in_array(0, $cek_already_in_db) ||
					in_array(0, $max_str) ||
					in_array(0, $empty_name) ||
					in_array(0, $empty_unit2) ||
					in_array(0, $empty_unit3) ||
					// in_array(0, $empty_unit4) ||
					in_array(0, $chek_dupl_name)
				){
					
					echo "<span><strong>PLEASE CHECK YOUR UNIT OF MEASUREMENT SPREADSHEET</strong></span>";
					
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

					$unit2_empty = '';
					if(in_array(0, $empty_unit2)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY UNIT 2:</u></strong>";
						$i = 3;
						foreach ($check_empty_unit2 as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$unit2_empty = $validasi;
					}

					$unit3_empty = '';
					if(in_array(0, $empty_unit3)){
						$validasi = "<br><br><strong class='text-danger'><u>EMPTY UNIT 3:</u></strong>";
						$i = 3;
						foreach ($check_empty_unit3 as $value) {
							 if(is_null($value) || $value == ''){
							 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
							 }else{
							 	$i++;
							 }
						}
						$unit3_empty = $validasi;
					}

					// $unit4_empty = '';
					// if(in_array(0, $empty_unit4)){
					// 	$validasi = "<br><br><strong class='text-danger'><u>EMPTY UNIT 4:</u></strong>";
					// 	$i = 3;
					// 	foreach ($check_empty_unit4 as $value) {
					// 		 if(is_null($value) || $value == ''){
					// 		 	$validasi .= '<br/><span>ON LINE <b>#'.$i++.'</b> IN YOUR SPREADSHEET.</span>';
					// 		 }else{
					// 		 	$i++;
					// 		 }
					// 	}
					// 	$unit4_empty = $validasi;
					// }

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
					echo $name_empty;
					echo $unit2_empty;
					echo $unit3_empty;
					// echo $unit4_empty;
					echo $dupl_name;
				}else{
					echo "<span id='data_counter'>".number_format(count($data_counter))."</span>";
					echo "<input type='button' class='import_to_db import_unit_of_measurement btn btn-sm btn-primary' value='IMPORT UNIT OF MEASUREMENT DATA'>";
					echo $table;
				}
				echo "</div>";
			}

		}else{
			echo  'WHOOPS, YOU TRY TO UPLOADING WRONG SPREADSHEET :(';
		}
	}

    public function importInc($file){

    	ini_set('max_execution_time', 300); // 3 minutes
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

    	ini_set('max_execution_time', 300); // 3 minutes
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

    	ini_set('max_execution_time', 300); // 3 minutes
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

    	ini_set('max_execution_time', 300); // 3 minutes
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

    	ini_set('max_execution_time', 300); // 3 minutes
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

    	ini_set('max_execution_time', 300); // 3 minutes
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
    	ini_set('max_execution_time', 300); // 3 minutes
    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$link_inc_characteristic_id = LinkIncCharacteristic::select('link_inc_characteristic.id')
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
						'link_inc_characteristic_id' 	=> $link_inc_characteristic_id,
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

    	ini_set('max_execution_time', 300); // 3 minutes
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

    	ini_set('max_execution_time', 300); // 3 minutes
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

    	ini_set('max_execution_time', 300); // 3 minutes
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

    	ini_set('max_execution_time', 300); // 3 minutes
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
					$document_ref = strtoupper(trim($cel[2]));
					$tbl_company_id = TblCompany::select('id')->where('company', trim($cel[3]))->first()->id;
					$tbl_plant_id   = TblPlant::select('id')->where('plant', trim($cel[4]))->where('tbl_company_id', $tbl_company_id)->first()->id;
					$id 			= \Auth::user()->id;
					$date 			= \Carbon\Carbon::now();

					$dataSet[] = [
						'equipment_code' => $equipment_code,
						'equipment_name' => $equipment_name,
						'document_ref' 	 => $document_ref,
						'tbl_company_id' => $tbl_company_id,
						'tbl_plant_id' 	 => $tbl_plant_id,
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

    public function importPartMaster($file){

    	ini_set('max_execution_time', 300); // 3 minutes
    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					
					$catalog_no 	= strtoupper(trim($cel[0]));	
					$tbl_holding_id = TblHolding::select('id')->where('holding', trim($cel[1]))->first()->id;	
					$holding_no 	= strtoupper(trim($cel[3]));
					$reference_no 	= strtoupper(trim($cel[4]));

					if(
						trim($cel[5]) <> '' && trim($cel[5]) <> null &&
						trim($cel[6]) <> '' && trim($cel[6]) <> null
					){
						$link_inc_group_class_id = LinkIncGroupClass::select('link_inc_group_class.id')
							->join('tbl_inc', 'tbl_inc.id', '=', 'link_inc_group_class.tbl_inc_id')
							->join('tbl_group_class', 'tbl_group_class.id', '=', 'link_inc_group_class.tbl_group_class_id')
							->join('tbl_group', 'tbl_group.id', '=', 'tbl_group_class.tbl_group_id')
							->where('inc', trim($cel[5]))
							->where('group', substr(trim($cel[6]), 0, 2))
							->where('class', substr(trim($cel[6]), 2, 2))
							->first()->id;
					}else{
						$link_inc_group_class_id = null;
					}
					

					$catalog_type 	= strtolower(trim($cel[7]));

					if(trim($cel[8]) <> '' && trim($cel[8]) <> null){
						$unit_issue = TblUnitOfMeasurement::select('id')->where('name', trim($cel[8]))->first()->id;
					}else{
						$unit_issue = null;
					}

					if(trim($cel[9]) <> '' && trim($cel[9]) <> null){
						$unit_purchase = TblUnitOfMeasurement::select('id')->where('name', trim($cel[9]))->first()->id;
					}else{
						$unit_purchase = null;
					}

					if(trim($cel[10]) <> '' && trim($cel[10]) <> null){
						$conversion = strtoupper(trim($cel[10]));
					}else{
						$conversion = '';
					}
					
					if(trim($cel[11]) <> '' && trim($cel[11]) <> null){
						$tbl_user_class_id = TblUserClass::select('id')->where('class', trim($cel[11]))->first()->id;
					}else{
						$tbl_user_class_id = null;
					}

					if(trim($cel[12]) <> '' && trim($cel[12]) <> null){
						$tbl_item_type_id = TblItemType::select('id')->where('type', trim($cel[12]))->first()->id;
					}else{
						$tbl_item_type_id = null;
					}

					if(trim($cel[13]) <> '' && trim($cel[13]) <> null){
						$tbl_harmonized_code_id = TblHarmonizedCode::select('id')->where('code', trim($cel[13]))->first()->id;
					}else{
						$tbl_harmonized_code_id = null;
					}

					if(trim($cel[14]) <> '' && trim($cel[14]) <> null){
						$tbl_hazard_class_id = TblHazardClass::select('id')->where('class', trim($cel[14]))->first()->id;
					}else{
						$tbl_hazard_class_id = null;
					}					
					
					if(trim($cel[15]) <> '' && trim($cel[15]) <> null){
						$weight_value = strtoupper(trim($cel[15]));
					}else{
						$weight_value = 0;
					}

					if(trim($cel[16]) <> '' && trim($cel[16]) <> null){
						$tbl_weight_unit_id = TblWeightUnit::select('id')->where('unit', trim($cel[16]))->first()->id;
					}else{
						$tbl_weight_unit_id = null;
					}

					if(trim($cel[17]) <> '' && trim($cel[17]) <> null){
						$tbl_stock_type_id = TblStockType::select('id')->where('type', trim($cel[17]))->first()->id;
					}else{
						$tbl_stock_type_id = null;
					}

					if(trim($cel[17]) <> '' && trim($cel[17]) <> null){
						$average_unit_price = strtoupper(trim($cel[18]));
					}else{
						$average_unit_price = 0;
					}
					
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
			\DB::transaction(function () use ($dataSet, $reader){
				foreach (array_chunk($dataSet,1000) as $data) {
	               	if(PartMaster::insert($data)){
	               		// auto input PartCompany
	               		foreach ($reader->getSheetIterator() as $sheet2) {
							$i = 1;
							$dataCompany = [];
							$rows = $sheet2->getRowIterator();
							foreach ($rows as $cel) {
								$key = $i++;
								if($key > 2){
									
									$part_master_id = PartMaster::select('part_master.id')
										->join('tbl_holding', 'tbl_holding.id', 'part_master.tbl_holding_id')
										->where('catalog_no', trim($cel[0]))
										->where('holding', trim($cel[1]))
										->first()->id;

									$tbl_catalog_status_id = TblCatalogStatus::select('id')
										->where('status', 'RAW')->first()->id;

									$tbl_company_id = TblCompany::select('tbl_company.id')
										->join('tbl_holding', 'tbl_holding.id', 'tbl_company.tbl_holding_id')
										->where('holding', trim($cel[1]))
										->where('company', trim($cel[2]))
										->first()->id;
									$date 			= \Carbon\Carbon::now();

									$dataCompany[] = [
										'part_master_id' 		=> $part_master_id,
										'tbl_company_id' 		=> $tbl_company_id,
										'tbl_catalog_status_id' => $tbl_catalog_status_id,
						        		'created_at'	 => $date,
				     					'updated_at'	 => $date
									];					
								}
							}
						}

						if(count($dataCompany)>1000){
							foreach (array_chunk($dataCompany,1000) as $data) {
								PartCompany::insert(dataCompany);
							}
						}else{
							PartCompany::insert(dataCompany);
						}
	               	}
	            }
        	});
            return number_format(count($dataSet));
		}else{
			\DB::transaction(function () use ($dataSet, $reader){
				if(PartMaster::insert($dataSet)){

	           		foreach ($reader->getSheetIterator() as $sheet2) {
						$i = 1;
						$dataCompany = [];
						$rows = $sheet2->getRowIterator();
						foreach ($rows as $cel) {
							$key = $i++;
							if($key > 2){
								
								$part_master_id = PartMaster::select('part_master.id')
									->join('tbl_holding', 'tbl_holding.id', 'part_master.tbl_holding_id')
									->where('catalog_no', trim($cel[0]))
									->where('holding', trim($cel[1]))
									->first()->id;

								$tbl_catalog_status_id = TblCatalogStatus::select('id')
									->where('status', 'RAW')->first()->id;

								$tbl_company_id = TblCompany::select('tbl_company.id')
									->join('tbl_holding', 'tbl_holding.id', 'tbl_company.tbl_holding_id')
									->where('holding', trim($cel[1]))
									->where('company', trim($cel[2]))
									->first()->id;
								$date 			= \Carbon\Carbon::now();

								$dataCompany[] = [
									'part_master_id' 		=> $part_master_id,
									'tbl_company_id' 		=> $tbl_company_id,
									'tbl_catalog_status_id' => $tbl_catalog_status_id,
					        		'created_at'	 => $date,
			     					'updated_at'	 => $date
								];					
							}
						}
					}

					if(count($dataCompany)>1000){
						foreach (array_chunk($dataCompany,1000) as $data) {
							PartCompany::insert($dataCompany);
						}
					}else{
						PartCompany::insert($dataCompany);
					}
	           	}
           	});
			return number_format(count($dataSet));
		}
    }

    public function importPartManCode($file){

    	ini_set('max_execution_time', 300); // 3 minutes
    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){

					$part_master_id = PartMaster::select('part_master.id')
						->join('tbl_holding', 'tbl_holding.id', 'part_master.tbl_holding_id')
						->where('holding', trim($cel[0]))
						->where('catalog_no', trim($cel[1]))
						->first()->id;
					$tbl_manufacturer_code_id = TblManufacturerCode::select('id')
						->where('manufacturer_code', trim($cel[2]))
						->first()->id;
					$tbl_source_type_id = TblSourceType::select('id')
						->where('type', trim($cel[3]))
						->first()->id;
					$manufacturer_ref = strtoupper(trim($cel[4]));
					$tbl_part_manufacturer_code_type_id = TblPartManufacturerCodeType::select('id')
						->where('type', trim($cel[5]))
						->first()->id;
					$date 			= \Carbon\Carbon::now();
					$id 			= \Auth::user()->id;

					$dataSet[] = [
						'part_master_id' 					=> $part_master_id,
						'tbl_manufacturer_code_id' 			=> $tbl_manufacturer_code_id,
						'tbl_source_type_id' 				=> $tbl_source_type_id,
						'manufacturer_ref' 					=> $manufacturer_ref,
						'tbl_part_manufacturer_code_type_id'=> $tbl_part_manufacturer_code_type_id,
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

					$part_master_id = PartMaster::select('part_master.id')
						->join('tbl_holding', 'tbl_holding.id', 'part_master.tbl_holding_id')
						->where('holding', trim($cel[0]))
						->where('catalog_no', trim($cel[2]))
						->first()->id;

					$tbl_equipment_code_id = TblEquipmentCode::select('tbl_equipment_code.id')
						->join('tbl_company', 'tbl_company.id', 'tbl_equipment_code.tbl_company_id')
						->where('company', trim($cel[1]))
						->where('equipment_code', trim($cel[3]))->first()->id;

					$qty_install = strtoupper(trim($cel[4]));
					$tbl_manufacturer_code_id = TblManufacturerCode::select('id')
						->where('manufacturer_code', trim($cel[5]))->first()->id;
					$drawing_ref = strtoupper(trim($cel[6]));
					$date 			= \Carbon\Carbon::now();
					$id 			= \Auth::user()->id;

					$dataSet[] = [
						'part_master_id' 			=> $part_master_id,
						'tbl_equipment_code_id' 	=> $tbl_equipment_code_id,
						'qty_install' 				=> $qty_install,
						'tbl_manufacturer_code_id'	=> $tbl_manufacturer_code_id,
						'drawing_ref'				=> $drawing_ref,
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

    public function importHolding($file){

    	ini_set('max_execution_time', 300); // 3 minutes
    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$holding 		= strtoupper(trim($cel[0]));
					$description 	= strtoupper(trim($cel[1]));
					$id 			= \Auth::user()->id;
					$date 			= \Carbon\Carbon::now();

					$dataSet[] = [
						'holding'			=> $holding,
						'description'		=> $description,
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
	               TblHolding::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblHolding::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importCompany($file){
    	ini_set('max_execution_time', 300); // 3 minutes
    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$company 		= strtoupper(trim($cel[0]));
					$description 	= strtoupper(trim($cel[1]));
					$tbl_holding_id = TblHolding::where('holding',strtoupper(trim($cel[2])))->select('id')->first()->id;
					$uom_type 		= trim($cel[3]);
					$id 			= \Auth::user()->id;
					$date 			= \Carbon\Carbon::now();

					$dataSet[] = [
						'company'			=> $company,
						'description'		=> $description,
						'tbl_holding_id'	=> $tbl_holding_id,
						'uom_type'			=> $uom_type,
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
	               TblCompany::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblCompany::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importUserClass($file){
    	ini_set('max_execution_time', 300); // 3 minutes
    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$class 			= strtoupper(trim($cel[0]));
					$description 	= strtoupper(trim($cel[1]));
					$id 			= \Auth::user()->id;
					$date 			= \Carbon\Carbon::now();

					$dataSet[] = [
						'class'				=> $class,
						'description'		=> $description,
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
	               TblUserClass::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblUserClass::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importItemType($file){
    	ini_set('max_execution_time', 300); // 3 minutes
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
					$id 			= \Auth::user()->id;
					$date 			= \Carbon\Carbon::now();

					$dataSet[] = [
						'type'				=> $type,
						'description'		=> $description,
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
	               TblItemType::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblItemType::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importHarmonizedCode($file){
    	ini_set('max_execution_time', 300); // 3 minutes
    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$code 			= strtoupper(trim($cel[0]));
					$description 	= strtoupper(trim($cel[1]));
					$id 			= \Auth::user()->id;
					$date 			= \Carbon\Carbon::now();

					$dataSet[] = [
						'code'				=> $code,
						'description'		=> $description,
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
	               TblHarmonizedCode::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblHarmonizedCode::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importHazardClass($file){
    	ini_set('max_execution_time', 300); // 3 minutes
    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$class 			= strtoupper(trim($cel[0]));
					$description 	= strtoupper(trim($cel[1]));
					$id 			= \Auth::user()->id;
					$date 			= \Carbon\Carbon::now();

					$dataSet[] = [
						'class'				=> $class,
						'description'		=> $description,
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
	               TblHazardClass::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblHazardClass::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importWeightUnit($file){
    	ini_set('max_execution_time', 300); // 3 minutes
    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$unit 			= strtoupper(trim($cel[0]));
					$description 	= strtoupper(trim($cel[1]));
					$id 			= \Auth::user()->id;
					$date 			= \Carbon\Carbon::now();

					$dataSet[] = [
						'unit'				=> $unit,
						'description'		=> $description,
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
	               TblWeightUnit::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblWeightUnit::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importStockType($file){
    	ini_set('max_execution_time', 300); // 3 minutes
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
					$id 			= \Auth::user()->id;
					$date 			= \Carbon\Carbon::now();

					$dataSet[] = [
						'type'				=> $type,
						'description'		=> $description,
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
	               TblStockType::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblStockType::insert($dataSet);
			return number_format(count($dataSet));
		}
    }

    public function importUnitOfMeasurement($file){
    	ini_set('max_execution_time', 300); // 3 minutes
    	$reader = $this->readSpreadSheet($file);
    	foreach ($reader->getSheetIterator() as $sheet) {
			$i = 1;
			$dataSet = [];
			$rows = $sheet->getRowIterator();
			
			foreach ($rows as $cel) {
				$key = $i++;
				if($key > 2){
					$name 			= strtoupper(trim($cel[0]));
					$unit2 			= strtoupper(trim($cel[1]));
					$unit3 			= strtoupper(trim($cel[2]));
					$unit4 			= strtoupper(trim($cel[3]));
					$eng_definition = strtoupper(trim($cel[4]));
					$ind_definition = strtoupper(trim($cel[5]));
					$id 			= \Auth::user()->id;
					$date 			= \Carbon\Carbon::now();

					$dataSet[] = [
						'name'				=> $name,
						'unit2'				=> $unit2,
						'unit3'				=> $unit3,
						'unit4'				=> $unit4,
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
	               TblUnitOfMeasurement::insert($data);
	            }
        	});
            return number_format(count($dataSet));
		}else{
			TblUnitOfMeasurement::insert($dataSet);
			return number_format(count($dataSet));
		}
    }
}