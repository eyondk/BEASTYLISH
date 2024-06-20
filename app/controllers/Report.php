<?php

class Report extends Controller
{

    public function index()
    {
        if (!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] === null) {
         
            header('Location: login'); 
            exit();
        }
        $report = new Reports;
        $reports = $report->getWeeklyReportSales();
        $data['report'] = $reports;

       
        $this->view('admin/Report',$data);
    }

}
