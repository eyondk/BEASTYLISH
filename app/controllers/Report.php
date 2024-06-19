<?php

class Report extends Controller
{

    public function index()
    {
        if (!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] === null) {
            // Redirect to the login page
            header('Location: login'); // Adjust the path as needed for your application
            exit();
        }
        $report = new Reports;
        $reports = $report->getWeeklyReportSales();
        $data['report'] = $reports;

       
        $this->view('admin/Report',$data);
    }

}
