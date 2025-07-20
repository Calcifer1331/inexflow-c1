<?php

namespace App\Controllers;

use App\Models\ReportsModel;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class ReportsController extends ResourceController
{
    protected $modelName = 'App\Models\Reports';
    protected $format    = 'json';

    protected ReportsModel $reportsModel;

    public function __construct()
    {
        if (!session()->get('id')) return $this->respond(['error' => 'Unauthorized'], 401);
        if (session()->get('role') !== 'businessman') return $this->respond(['success' => false], 403);

        $this->reportsModel = new ReportsModel();
    }

    public function index()
    {
        return $this->respond([
            $this->reportsModel->getIncomeStatement("9311744c-3746-3502-84c9-d06e8b5ea2d6"),
            $this->reportsModel->getCashFlow("9311744c-3746-3502-84c9-d06e8b5ea2d6", ["group_by" => "year"]),
            $this->reportsModel->getCategoryAnalysis("9311744c-3746-3502-84c9-d06e8b5ea2d6"),
            $this->reportsModel->getBusinessMetrics("9311744c-3746-3502-84c9-d06e8b5ea2d6"),
            // $this->reportsModel->getPaymentMethodAnalysis("9311744c-3746-3502-84c9-d06e8b5ea2d6")
        ]);
    }
}
