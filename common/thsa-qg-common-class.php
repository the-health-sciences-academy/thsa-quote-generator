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

		$path = get_template_directory().'/'.THSA_QG_FOLDER.'/'.$other.'templates';
		$child = get_template_directory().'-child/'.THSA_QG_FOLDER.'/'.$other.'templates';

		if(is_dir($path.'/'.$file)){
			include $path.'/'.$file;
		}elseif(is_dir($child.'/'.$file)){
			include $child.'/'.$file;
		}else{
			if(isset($params['path'])){
				$other = $params['path'];
			}
			include THSA_QG_PLUGIN_PATH.$other.'/templates/'.$file;
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
        wp_enqueue_script( THSA_QG_PREFIX.'-common-js' );
	}

	/**
	 * 
	 * 
	 * common_labels
	 * @since 1.2.0
	 * @param
	 * @return array
	 * 
	 * 
	 */
	public static function labels()
	{
		$labels = [
			'select' => __('Select','thsa-quote-generator'),
			'search_user' => __('Select User', 'thsa-quote-generator'),
			'enter_keywords' => __('Enter Keywords', 'thsa-quote-generator'),
			'no_products_added' => __('No products added', 'thsa-quote-generator'),
			'no_fees_added' => __('No fees added','thsa-quote-generator'),
			'processing' => __('Processing please wait...','thsa-quote-generator'),
			'confirm_message' => __('Are you sure you want to remove selected item(s)','thsa-quote-generator')
		];
		return json_encode($labels);
	}

	/**
	 * 
	 * 
	 * sanitize_json
	 * @since 1.2.0
	 * @param json
	 * @return array
	 * 
	 * 
	 */
	public function sanitize_json($data)
	{
		$data = stripslashes($data);
        $data_ = (array) json_decode($data);
        array_map(function($key, $val){
            return [sanitize_text_field($key), sanitize_text_field($val)];
        },array_keys($data_),array_values($data_));
		return $data_;
	}

	/**
	 * 
	 * tab_manager
	 * @since 1.2.0
	 * @param array
	 * @return string
	 * 
	 */
	public function tab_settings_manager($data = [])
	{	
		if(empty($data))
			return;
		
		$data = apply_filters('thsa_quote_settings_tab_manager', $data);
		$tabs = null;
		foreach($data as $row){
			$tabs .= '<li class="'.$row['status'].'" data-target="'.$row['target'].'">'.$row['text'].'</li>';
		}
		return $tabs;
	}
	
	/**
	 * 
	 * tab_content_manager
	 * @since 1.2.0
	 * @param array
	 * @return string
	 * 
	 */
	public function tab_content_manager($data = [])
	{
		if(empty($data))
			return;



		$data = apply_filters('thsa_quote_settings_content_manager', $data);
		$content = null;
		foreach($data as $row){
			if(is_array($row['content'])):
				$cl = $row['content'][0];
				$fn = $row['content'][1];
			?>
				<div class="thsa_qg_tab_content <?php echo $row['class'].' '.$row['status']; ?>"><?php $cl->$fn(); ?></div>
			<?php
			else:
			?>
				<div class="thsa_qg_tab_content <?php echo $row['class'].' '.$row['status']; ?>"><?php $row['content']; ?></div>
			<?php
			endif;
		}
		
	}

}
?>