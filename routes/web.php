<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('current-user', function(){
	return App\User::select('name', 'username', 'email')->where('id', Auth::user()->id)->first();
});

Route::get('test', 'TestController@index');

// =======================================================
// SEARCH ITEMS
// =======================================================
Route::post('search', 'SearchController@index');

Route::post('search-items/select-search-catalog-no', 'SearchController@selectSearchCatalogNo');
Route::post('search-items/select-search-holding-no', 'SearchController@selectSearchHoldingNo');
Route::post('search-items/select-search-inc-item-name', 'SearchController@selectSearchIncItemName');
Route::post('search-items/select-search-colloquial', 'SearchController@selectSearchColloquial');
Route::post('search-items/select-search-group-class', 'SearchController@selectSearchGroupClass');
Route::post('search-items/select-search-catalog-status', 'SearchController@selectSearchCatalogStatus');
Route::post('search-items/select-search-item-type', 'SearchController@selectSearchItemType');
Route::post('search-items/select-search-manufacturer', 'SearchController@selectSearchManufacturer');
Route::post('search-items/select-search-part-number', 'SearchController@selectSearchPartNumber');
Route::post('search-items/select-search-equipment', 'SearchController@selectSearchEquipment');
Route::post('search-items/select-search-holding', 'SearchController@selectSearchHolding');
Route::post('search-items/select-search-company', 'SearchController@selectSearchCompany');
Route::post('search-items/select-search-plant', 'SearchController@selectSearchPlant');
Route::post('search-items/select-search-location', 'SearchController@selectSearchLocation');
Route::post('search-items/select-search-shelf', 'SearchController@selectSearchShelf');
Route::post('search-items/select-search-bin', 'SearchController@selectSearchBin');
Route::post('search-items/select-search-user', 'SearchController@selectSearchUser');
// =======================================================
// END SEARCH ITEMS
// =======================================================

// =======================================================
// HOME
// =======================================================

Route::get('/', 'HomeController@index');

// Search
Route::post('home/search', 'HomeController@search');

// PartMaster
Route::get('home/part-master/{key}', 'HomeController@getPartMaster');
Route::get('home/click-row-part-master/{id}', 'HomeController@clickRowPartMaster');

// Add Company when empty
Route::post('home/select-add-company/{partMasterId}', 'HomeController@selectAddCompany');
Route::post('home/add-company/', 'HomeController@addCompany');

// Get Company Data by partMasterId
Route::get('home/select-company/{partMasterId}', 'HomeController@selectCompany');

// INC - Group Class
Route::get('home/inc-group-class/{id}', 'HomeController@getIncGroupClass');
Route::post('home/select-inc', 'HomeController@selectInc');
Route::get('home/group-class/{incId}', 'HomeController@getGroupClass');

// Short Description Result
Route::get('home/short-description/{partMasterId}/{companyId}', 'HomeController@getShortDescription');

// Characteristic Value
Route::get('home/characteristic-value/{incId}/{partMasterId}/{companyId}', 'HomeController@getCharacteristicValue');
Route::get('home/inc-char-values/{incCharId}/{incId}/{charId}', 'HomeController@getIncCharValues');
// Add new value
Route::post('home/add-values', 'HomeController@addValues');
Route::post('home/submit-values', 'HomeController@submitValues');

// Part Manufacturer Code
Route::get('home/part-manufacturer-code/{partMasterId}', 'HomeController@getPartManufacturerCode');
Route::post('home/select-manufacturer-code', 'HomeController@selectManufacturerCode');
Route::get('home/source-type', 'HomeController@getSourceType');
Route::get('home/manufacturer-code-type', 'HomeController@getPartManufacturerCodeType');
Route::post('home/add-part-manufacturer-code', 'HomeController@addPartManufacturerCode');
Route::get('home/edit-part-manufacturer-code/{id}', 'HomeController@editPartManufacturerCode');
Route::put('home/update-part-manufacturer-code', 'HomeController@updatePartManufacturerCode');
Route::delete('home/delete-part-manufacturer-code/{id}', 'HomeController@deletePartManufacturerCode');

// Part Colloquial
Route::get('home/part-colloquial/{partMasterId}', 'HomeController@getPartColloquial');
Route::post('home/add-part-colloquial', 'HomeController@addPartColloquial');
Route::put('home/update-part-colloquial', 'HomeController@updatePartColloquial');
Route::delete('home/delete-part-colloquial/{id}', 'HomeController@deletePartColloquial');

// Part Equipment Code
Route::get('home/part-equipment-code/{part_master_id}', 'HomeController@getPartEquipmentCode');
Route::post('home/select-equipment-code', 'HomeController@selectEquipmentCode');
Route::post('home/add-part-equipment-code', 'HomeController@addPartEquipmentCode');
Route::get('home/edit-part-equipment-code/{id}', 'HomeController@editPartEquipmentCode');
Route::put('home/update-part-equipment-code', 'HomeController@updatePartEquipmentCode');
Route::delete('home/delete-part-equipment-code/{id}', 'HomeController@deletePartEquipmentCode');

// Part Source Description
Route::get('home/part-source-description/{part_master_id}', 'HomeController@getPartSourceDescription');

// Part Source Part No
Route::get('home/part-source-part-no/{part_master_id}', 'HomeController@getPartSourcePartNo');

// =======================================================
// END HOME
// =======================================================

// =======================================================
// DICTIONARY
// =======================================================
Route::get('dictionary', 'DictionaryController@index');

// ITEM NAME
Route::get('dictionary/item-name', 'DictionaryController@getItemName');
Route::post('dictionary/select-colloquial', 'DictionaryController@selectColloquial');
Route::post('dictionary/select-group', 'DictionaryController@selectGroup');
Route::post('dictionary/select-class', 'DictionaryController@selectClass');
Route::post('dictionary/select-characteristic', 'DictionaryController@selectCharacteristic');
Route::get('dictionary/colloquial/{tblIncId}', 'DictionaryController@getColloquial');
			

// =======================================================
// END DICTIONARY
// =======================================================

// =======================================================
// TOOLS
// =======================================================
Route::get('tools', 'ToolsController@index');
Route::get('tools/dest-table/{table}', 'ToolsController@dest_table');
Route::post('tools/upload', 'ToolsController@upload');
Route::get('tools/read-source/{source}', 'ToolsController@readSource');
// =======================================================
Route::post('tools/insert-pmc', 'ToolsController@insertPmc');
Route::post('tools/insert-pec', 'ToolsController@insertPec');
Route::post('tools/insert-tgc', 'ToolsController@insertTgc');
Route::post('tools/insert-igc', 'ToolsController@insertIgc');
Route::post('tools/insert-ic', 'ToolsController@insertIc');
Route::post('tools/insert-icv', 'ToolsController@insertIcv');
Route::post('tools/insert-m', 'ToolsController@insertM');
// =======================================================
// END IMPORT
// =======================================================


	// Commodity Information
	Route::get('home/commodity-information/{catalogNo}', 'HomeController@getCommodityInformation');
	Route::post('home/select-item-type', 'HomeController@selectItemType');
	Route::get('home/item-type', function(){
		return App\TblItemType::select('type', 'description')->get();
	});
	Route::get('home/commodity-information-detail/{catalogNo}', 'HomeController@getCommodityInformationDetail');

	Route::get('home/part-bin-location-description/{id}', 'HomeController@getPartBinLocationDescription');	
	Route::post('home/add-part-bin-location', 'HomeController@addPartBinLocation');
	Route::put('home/update-part-bin-location/{partBinLocationId}', 'HomeController@updatePartBinLocation');
	Route::delete('home/delete-part-bin-location/{partBinLocationId}', 'HomeController@deletePartBinLocation');

	// SETTINGS
	// CHARACTERISTICS SETTINGS
	Route::get('characteristics-settings', 'CharacteristicsSettingsController@index');

	// SETTINGS
	Route::get('settings', 'SettingsController@index');
	
	// HOLDING - BIN SELECT
	Route::post('settings/select-holding', 'SettingsController@selectHolding');
	Route::post('settings/select-company/{holdingId}', 'SettingsController@selectCompany');
	Route::post('settings/select-plant/{companyId}', 'SettingsController@selectPlant');
	Route::post('settings/select-location/{plantId}', 'SettingsController@selectLocation');
	Route::post('settings/select-shelf/{locationId}', 'SettingsController@selectShelf');	

	// FOR CHARACTERISTICS TAB
	Route::post('settings/select-inc', 'HomeController@selectInc');
	
	// CHARACTERISTICS VALUE TAB
	Route::get('settings/char/{incId}/{companyId}', 'SettingsController@getChar');
	Route::put('settings/update-char-val-order', 'SettingsController@updateCharValOrder');
	Route::put('settings/update-char-visibility', 'SettingsController@updateCharVisibility');
	Route::get('settings/edit-company-char/{id}', 'SettingsController@editCompanyChar');
	Route::get('settings/po-style', 'SettingsController@getPoStyle');
	Route::put('settings/update-company-char', 'SettingsController@updateCompanyChar');
	Route::get('settings/char-value/{licId}/{companyId}', 'SettingsController@getCharValue');
	Route::put('settings/update-value', 'SettingsController@updateValue');
	Route::delete('settings/delete-value/{cvid}/{licvid}', 'SettingsController@deleteValue');
	Route::post('settings/add-char-value', 'SettingsController@addCharValue');

	// SHORT DESCRIPTION FORMAT
	Route::get('settings/get-short-desc/{incId}/{companyId}', 'SettingsController@getShortDesc');
	Route::put('settings/update-short-desc-order', 'SettingsController@updateShortDescOrder');
	Route::put('settings/update-short-visibility', 'SettingsController@updateShortVisibility');
	Route::put('settings/update-short-separator', 'SettingsController@updateShortSeparator');
	// END SHORT DESCRIPTION FORMAT

	// CATALOG STATUS Tab
	Route::get('settings/datatables-catalog-status', 'SettingsController@datatablesCatalogStatus');
	Route::post('settings/add-catalog-status', 'SettingsController@addCatalogStatus');
	Route::put('settings/update-catalog-status/{id}', 'SettingsController@updateCatalogStatus');
	Route::delete('settings/delete-catalog-status/{id}', 'SettingsController@deleteCatalogStatus');

	// EQUIPMENT CODE Tab
	Route::get('settings/datatables-equipment-code', 'SettingsController@datatablesEquipmentCode');
	Route::get('settings/edit-equipment-code/{id}', 'SettingsController@editEquipmentCode');
	Route::post('settings/add-equipment-code', 'SettingsController@addEquipmentCode');
	Route::put('settings/update-equipment-code/{id}', 'SettingsController@updateEquipmentCode');
	Route::delete('settings/delete-equipment-code/{id}', 'SettingsController@deleteEquipmentCode');

	// HARMONIZED CODE Tab
	Route::get('settings/datatables-harmonized-code', 'SettingsController@datatablesHarmonizedCode');
	Route::post('settings/add-harmonized-code', 'SettingsController@addHarmonizedCode');
	Route::put('settings/update-harmonized-code/{id}', 'SettingsController@updateHarmonizedCode');
	Route::delete('settings/delete-harmonized-code/{id}', 'SettingsController@deleteHarmonizedCode');

	// HAZARD CLASS Tab
	Route::get('settings/datatables-hazard-class', 'SettingsController@datatablesHazardClass');
	Route::post('settings/add-hazard-class', 'SettingsController@addHazardClass');
	Route::put('settings/update-hazard-class/{id}', 'SettingsController@updateHazardClass');
	Route::delete('settings/delete-hazard-class/{id}', 'SettingsController@deleteHazardClass');		

	// HOLDING Tab
	Route::get('settings/datatables-holding', 'SettingsController@datatablesHolding');
	Route::post('settings/add-holding', 'SettingsController@addHolding');
	Route::put('settings/update-holding/{id}', 'SettingsController@updateHolding');
	Route::delete('settings/delete-holding/{id}', 'SettingsController@deleteHolding');

	// COMPANY Tab
	Route::get('settings/datatables-company', 'SettingsController@datatablesCompany');
	Route::get('settings/edit-company/{id}', 'SettingsController@editCompany');
	Route::post('settings/add-company', 'SettingsController@addCompany');
	Route::put('settings/update-company/{id}', 'SettingsController@updateCompany');
	Route::delete('settings/delete-company/{id}', 'SettingsController@deleteCompany');

	// PLANT Tab
	Route::get('settings/datatables-plant', 'SettingsController@datatablesPlant');
	Route::get('settings/edit-plant/{id}', 'SettingsController@editPlant');
	Route::post('settings/add-plant', 'SettingsController@addPlant');
	Route::put('settings/update-plant/{id}', 'SettingsController@updatePlant');
	Route::delete('settings/delete-plant/{id}', 'SettingsController@deletePlant');

	// LOCATION Tab
	Route::get('settings/datatables-location', 'SettingsController@datatablesLocation');
	Route::get('settings/edit-location/{id}', 'SettingsController@editLocation');
	Route::post('settings/add-location', 'SettingsController@addLocation');
	Route::put('settings/update-location/{id}', 'SettingsController@updateLocation');
	Route::delete('settings/delete-location/{id}', 'SettingsController@deleteLocation');

	// SHELF Tab
	Route::get('settings/datatables-shelf', 'SettingsController@datatablesShelf');
	Route::get('settings/edit-shelf/{id}', 'SettingsController@editShelf');
	Route::post('settings/add-shelf', 'SettingsController@addShelf');
	Route::put('settings/update-shelf/{id}', 'SettingsController@updateShelf');
	Route::delete('settings/delete-shelf/{id}', 'SettingsController@deleteShelf');

	// BIN Tab
	Route::get('settings/datatables-bin', 'SettingsController@datatablesBin');
	Route::get('settings/edit-bin/{id}', 'SettingsController@editBin');
	Route::post('settings/add-bin', 'SettingsController@addBin');
	Route::put('settings/update-bin/{id}', 'SettingsController@updateBin');
	Route::delete('settings/delete-bin/{id}', 'SettingsController@deleteBin');

	// ITEM TYPE Tab
	Route::get('settings/datatables-item-type', 'SettingsController@datatablesItemType');
	Route::post('settings/add-item-type', 'SettingsController@addItemType');
	Route::put('settings/update-item-type/{id}', 'SettingsController@updateItemType');
	Route::delete('settings/delete-item-type/{id}', 'SettingsController@deleteItemType');

	// SOURCE TYPE Tab
	Route::get('settings/datatables-source-type', 'SettingsController@datatablesSourceType');
	Route::post('settings/add-source-type', 'SettingsController@addSourceType');
	Route::put('settings/update-source-type/{id}', 'SettingsController@updateSourceType');
	Route::delete('settings/delete-source-type/{id}', 'SettingsController@deleteSourceType');

	// STOCK TYPE Tab
	Route::get('settings/datatables-stock-type', 'SettingsController@datatablesStockType');
	Route::post('settings/add-stock-type', 'SettingsController@addStockType');
	Route::put('settings/update-stock-type/{id}', 'SettingsController@updateStockType');
	Route::delete('settings/delete-stock-type/{id}', 'SettingsController@deleteStockType');

	// UNIT OF MEASUREMENT Tab
	Route::get('settings/datatables-unit-of-measurement', 'SettingsController@datatablesUnitOfMeasurement');
	Route::get('settings/edit-unit-of-measurement/{id}', 'SettingsController@editUnitOfMeasurement');
	Route::post('settings/add-unit-of-measurement', 'SettingsController@addUnitOfMeasurement');
	Route::put('settings/update-unit-of-measurement/{id}', 'SettingsController@updateUnitOfMeasurement');
	Route::delete('settings/delete-unit-of-measurement/{id}', 'SettingsController@deleteUnitOfMeasurement');

	// USER CLASS Tab
	Route::get('settings/datatables-user-class', 'SettingsController@datatablesUserClass');
	Route::post('settings/add-user-class', 'SettingsController@addUserClass');
	Route::put('settings/update-user-class/{id}', 'SettingsController@updateUserClass');
	Route::delete('settings/delete-user-class/{id}', 'SettingsController@deleteUserClass');

	// WEIGHT UNIT Tab
	Route::get('settings/datatables-weight-unit', 'SettingsController@datatablesWeightUnit');
	Route::post('settings/add-weight-unit', 'SettingsController@addWeightUnit');
	Route::put('settings/update-weight-unit/{id}', 'SettingsController@updateWeightUnit');
	Route::delete('settings/delete-weight-unit/{id}', 'SettingsController@deleteWeightUnit');


	Route::get('oke', function(){

		return App\Models\PartMaster::select('link_inc_group_class_id','tbl_inc_id')
                    ->join('link_inc_group_class', 'link_inc_group_class.id', '=', 'part_master.link_inc_group_class_id')
                    ->where('part_master.id', 1)
                    ->first();
	});