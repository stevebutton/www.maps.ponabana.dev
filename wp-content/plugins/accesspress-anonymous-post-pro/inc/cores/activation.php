<?php 

global $wpdb;
/**
 * Creating table for storing social icons sets
 * */
$table_name = $wpdb->prefix . 'ap_pro_forms';
$sql = "CREATE TABLE IF NOT EXISTS $table_name 
                                    (
                                    ap_form_id INT NOT NULL AUTO_INCREMENT, 
                                    PRIMARY KEY(ap_form_id),
                                    form_details TEXT
                                    )";
$table_check = $wpdb->query($sql);
if($table_check!==0)
{
    $ap_settings = get_option('ap_pro_settings');
    if(!empty($ap_settings))
    {
        $default_settings = $ap_settings;
    }
    else
    {
        $default_settings = $this->get_default_settings();
    }
    $default_settings = serialize($default_settings);
    $wpdb->insert( 
	$table_name, 
array( 
		'form_details' => $default_settings
        
	),
	array( 
		
        '%s' 
	)
);
}