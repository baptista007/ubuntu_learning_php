<?php
/**
 * Info Contoller Class
 * @category  Controller
 */

class ErrorsController extends SecureController{

	/**
     * Display About us page
     * @return Html View
     */
	function forbidden(){
		$this->view->render("errors/forbidden.php" ,null,"default_layout.php");
	}
}
