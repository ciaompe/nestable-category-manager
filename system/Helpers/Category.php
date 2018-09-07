<?php

namespace Ciaompe\Helpers;

use Ciaompe\Helpers\Database;

class Category {

    protected $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }
	/*
	Build category recursive method
	*/
	public static function buildTree(array $elements, $parentId = 0) {
	    $branch = array();
	    foreach ($elements as $element) {
	        if ($element['parent'] == $parentId) {
	            $children = self::buildTree($elements, $element['id']);
	            if ($children) {
	                $element['children'] = $children;
	            }
	            $branch[] = $element;
	        }
	    }
	    return $branch;
	}
	/*
	Category tree postion update recursive method
	*/
	public static function setArray($inptz, $prnt = 0){
		$r = [];
		foreach ($inptz as $inpt) {
			$subInpt = [];
			if (isset($inpt['children'])) {
				$subInpt = self::setArray($inpt['children'], $inpt['id']);
			}
			$r[] = ['id' => $inpt['id'], 'parent' => $prnt];
			$r = array_merge($r, $subInpt);
		}
		return $r;
	}
}
