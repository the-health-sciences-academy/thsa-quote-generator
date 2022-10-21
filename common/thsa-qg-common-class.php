<?php 
/**
 * 
 * 
 * thsa_qg_common_class
 * class for global usage, contents methods that can be use through out admin and public
 * @since 1.2.0
 * @author thsa
 * 
 * 
 */
namespace thsa\qg\common;


class thsa_qg_common_class
{

    /**
     * 
     * 
     * set_template
     * render content via template html file
     * @since 1.2.0
     * @param file, array
     * @return file
     * 
     * 
     */
    public function set_template($file, $params = [])
    {
        if(!$file)
			return;

		if(strpos($file,'.php') === false)
			$file = $file.'.php';

		$other = null;
		if(isset($params['other'])){
			$other = $params['other'].'/';
		}

		$path = get_template_directory().'/'.THSA_KW_FOLDER_NAME.'/'.$other.'templates';
		$child = get_template_directory().'-child/'.THSA_KW_FOLDER_NAME.'/'.$other.'templates';

		if(is_dir($path.'/'.$file)){
			include $path.'/'.$file;
		}elseif(is_dir($child.'/'.$file)){
			include $child.'/'.$file;
		}else{
			if(isset($params['other'])){
				$other = $params['other'];
			}
			include THSA_KW_API_PATH.$other.'/templates/'.$file;
		}
    }


	/**
	 * 
	 * load_js
	 * load common js
	 * @since 1.2.0
	 * 
	 */
	public function load_js()
	{
		wp_register_script( THSA_QG_PREFIX.'-common-js', THSA_QG_PLUGIN_URL.'common/assets/thsa-qg-common.js', array('jquery') );
        wp_enqueue_script( THSA_QG_PREFIX.'-common-js-scripts' );
	}

}
?>