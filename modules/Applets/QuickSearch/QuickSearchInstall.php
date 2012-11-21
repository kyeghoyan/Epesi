<?php

defined("_VALID_ACCESS") || die('Direct access forbidden');

class Applets_QuickSearchInstall extends ModuleInstall{

	public function install() {
		$ret = true;
		/*Base_ThemeCommon::install_default_theme($this -> get_type());
		$ret &= DB::CreateTable('quick_search', 
									'search_id I4 AUTO KEY, 
									search_alias_name C(100) NOTNULL,
									search_recordset C(100) NOTNULL, 
									search_fields TEXT NOTNULL,
									search_placeholder TEXT,
									search_status C(1) NOTNULL,
									format TEXT');
								
		if(!$ret){
			print('Unable to create table vacation planner.<br>');
			return false;
		}*/
		$recordsetName = "quick_search";
		$fields = array(
					array('name'=>__('Preset name'), 
							'type'=>'text', 
							'param'=>'255', 
							'visible'=>true, 
							'required'=>true),
					
					array('name' => __('Recordsets'),
							'type'=>'quick_search', 
							'QFfield_callback'=>array('Applets_QuickSearchCommon', 'QFfield_recordsets'), 
							'display_callback'=>array('Applets_QuickSearchCommon', 'display_recordsets'), 
							'required'=>true, 
							'extra'=>false, 
							'visible'=>true),
					array('name'=>__('Placeholder'), 'type'=>'text', 'param'=>'255', 'visible'=>true, 'required'=>true),	
					array('name' => __('Select field'),
							'type'=>'quick_search', 
							'QFfield_callback'=>array('Applets_QuickSearchCommon', 'QFfield_recordfields'), 
							'display_callback'=>array('Applets_QuickSearchCommon', 'display_recordfields'), 
							'required'=>true, 
							'extra'=>false, 
							'visible'=>true),	
					array('name'=>__('Result Format'), 
							'type'=>'long text', 
							'param'=>'255', 
							'required'=>true, 
							'visible'=>true)
							
				);				
		Utils_RecordBrowserCommon::install_new_recordset($recordsetName,$fields);	
		Utils_RecordBrowserCommon::set_caption($recordsetName, __('Quick Search'));
		Utils_RecordBrowserCommon::set_favorites($recordsetName, false);

		Utils_RecordBrowserCommon::add_access($recordsetName, 'view', 'ACCESS:employee', array('(!permission'=>2, '|employees'=>'USER'));
		Utils_RecordBrowserCommon::add_access($recordsetName, 'add', 'ACCESS:employee');
		Utils_RecordBrowserCommon::add_access($recordsetName, 'edit', 'ACCESS:employee', array('(permission'=>0, '|employees'=>'USER', '|customers'=>'USER'));
		Utils_RecordBrowserCommon::add_access($recordsetName, 'delete', 'ACCESS:employee', array(':Created_by'=>'USER_ID'));
		Utils_RecordBrowserCommon::add_access($recordsetName, 'delete', array('ACCESS:employee','ACCESS:manager'));
	
		return $ret;
	}

	public function uninstall() {
		$ret = true;
		/*Base_ThemeCommon::uninstall_default_theme($this->get_type());
		$ret = true;
		Base_ThemeCommon::uninstall_default_theme($this->get_type());
		$ret &= DB::DropTable('quick_search');
		if(!$ret){
			print "Table doesn't exist";
			$ret = false;
		}*/	
		Utils_RecordBrowserCommon::uninstall_recordset('quick_search');
		return $ret;
	}
	public function version() {
		return array("1.0");
	}

	public static function simple_setup() {
		return array('package'=>__('EPESI Core'), 'option'=>__('Additional applets'));
	}

	public function requires($v) {
		return array(
			array('name'=>'Utils/RecordBrowser', 'version'=>0),
			array('name'=>'Base/Acl','version'=>0),
			array('name'=>'Base/User','version'=>0),
			array('name'=>'Utils/BBCode', 'version'=>0), 
			array('name'=>'Base/Lang','version'=>0),
			array('name'=>'Libs/QuickForm','version'=>0),
			array('name'=>'Base/Theme','version'=>0),
			array('name'=>'Base/Error','version'=>0),
			array('name'=>'Base/Dashboard','version'=>0));
	}

	public static function info() {
		$html="Use for quick search on contacts and companies";
		return array(
			'Description'=>$html,
			'Author'=>'bistmaster@hotmail.com',
			'License'=>'MIT');
	}	
}

?>