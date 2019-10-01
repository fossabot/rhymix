<?php
/* Copyright (C) NAVER <http://www.navercorp.com> */
/**
 * The view class file module
 * @author NAVER (developers@xpressengine.com)
 */
class fileView extends file
{
	/**
	 * Initialization
	 * @return void
	 */
	function init()
	{
	}

	/**
	 * This is for additional configuration for service module
	 * It only receives file configurations
	 *
	 * @param string $obj The html string of page of addition setup of module
	 * @return void
	 */
	function triggerDispFileAdditionSetup(&$obj)
	{
		$current_module_srl = Context::get('module_srl');
		if(!$current_module_srl)
		{
			// Get information of the current module
			$current_module_srl = Context::get('current_module_info')->module_srl;
			if(!$current_module_srl)
			{
				return;
			}
		}
		
		// Get file configurations of the module
		$oFileModel = getModel('file');
		$config = $oFileModel->getFileConfig($current_module_srl);
		Context::set('config', $config);
		Context::set('is_ffmpeg', is_command($config->ffmpeg_command) && is_command($config->ffprobe_command));
		
		// Get a permission for group setting
		$oMemberModel = getModel('member');
		$group_list = $oMemberModel->getGroups();
		Context::set('group_list', $group_list);
		
		// Set a template file
		$oTemplate = TemplateHandler::getInstance();
		$tpl = $oTemplate->compile($this->module_path . 'tpl', 'file_module_config');
		$obj .= $tpl;
	}
}
/* End of file file.view.php */
/* Location: ./modules/file/file.view.php */
