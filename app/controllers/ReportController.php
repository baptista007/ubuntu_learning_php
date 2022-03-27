<?php

/**
 * Report Page Controller
 * @category  Controller
 */
class ReportController extends SecureController {

    /**
     * Render All Records  in a  Data Table 
     * @return Html View
     */
    function index() {
        $this->view->render(null, null, "report_layout.php");
    }

    function static() {
        $this->view->page_title = "Static Reports";
        $this->view->render('reports/static.php', null, "main_layout.php");
    }
    
    function dynamic() {
        $this->view->page_title = "Dynamic Reports";
        $this->view->render('reports/dynamic.php', null, "main_layout.php");
    }
    
    function construction() {
        $this->view->page_title = "Construction Statistics";
        $this->view->render('reports/construction.php', null, "main_layout.php"); 
    }

    function completed() {
        $this->view->page_title = "Statistics of Completed Houses";
        $this->view->render('reports/completed.php', null, "main_layout.php");
    }
    
    function transfers() {
        $this->view->page_title = "Statistics of Transfers";
        $this->view->render('reports/transfers.php', null, "main_layout.php");
    }
    
    function completed_occupied() {
        $this->view->page_title = "Completed Houses vs. Occupied Houses";
        $this->view->render('reports/completed_occupied.php', null, "main_layout.php");
    }
    
    function agree_devs() {
        $this->view->page_title = "Developers Signed Agreements vs. Active Developments";
        $this->view->render('reports/agree_devs.php', null, "main_layout.php");
    }
    
    function builders_devs() {
        $this->view->page_title = "Active Builders vs. Active Developments";
        $this->view->render('reports/builders_devs.php', null, "main_layout.php");
    }
    
    function growth() {
        $this->view->page_title = "Growth Analysis";
        $this->view->render('reports/growth.php', null, "main_layout.php");
    }
}
