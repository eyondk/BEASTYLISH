<?php

class Report extends Controller
{

    public function index()
    {
        $report = new Reports;
        $reports = $report->getWeeklyReportSales();
        $data['report'] = $reports;

       
        $this->view('Report',$data);
    }

}
