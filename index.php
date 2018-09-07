<?php
//requre init file
require 'init.php';

//get all categories to the index
$categories = $db->getAll('category', 'ORDER BY depth ASC')->toArray();

//rendering index.html template to the system with category tree data
echo $twig->render('index.html', [
	'categories' => $cat->buildTree($categories)
]);
