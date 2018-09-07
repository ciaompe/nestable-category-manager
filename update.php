<?php
//requre init file
require 'init.php';

//get post data and update category database
if(isset($_POST['data'])) {

	$data = ($_POST['data'] != "" && $_POST['data'] != null) ? $_POST['data'] : false;

	if($data) {

		$data  = json_decode($data,true, 64);
		//setting category tree array
		$data = $cat->setArray($data);

		foreach ($data as $key => $value) {
			if (is_array($value)) {
	            $db->update('category', $value['id'], [
	                'depth' => $key,
					'parent' => $value['parent']
	            ]);
			}
		}
	}

}
