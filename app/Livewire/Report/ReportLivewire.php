<?php

namespace App\Livewire\Report;

use App\Models\Designation;
use App\Models\Organization;
use App\Models\Voter;
use ArrayObject;
use FPDF;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use PhpParser\Node\Expr\Cast\Array_;

class ReportLivewire extends Component
{
    use WithFileUploads;

    public $barangay;
    public $reportType;
    public $reportSubType = [];

    public $reportSubTypeSelected = "";
    public $preview = false;
    public $dataSets = [];

    // Create validation rules
    protected $rules = [
        'barangay' => 'required',
        'reportType' => 'required'
    ];

    public function initializeSubType()
    {
        if ($this->reportType == "Active Voter of Organization") {
            $organizations = Organization::all();
            foreach ($organizations as $organization) {
                $this->reportSubType[$organization->id] = $organization->name;
            }
        } else if ($this->reportType == "Active Voter of Barangay Staff") {
            $designations = Designation::all();
            foreach ($designations as $designation) {
                $this->reportSubType[$designation->id] = $designation->name;
            }
        } else {
            $this->reportSubType = [];
        }
    }


    public function generatePreviewReport()
    {
        if ($this->reportType == "Active Voter") {

            $this->dataSets = Voter::where(['barangay' => $this->barangay, 'status' => 'Active'])
                ->orderBy('lname', 'ASC')
                ->get();

            $this->preview = true;
        } else if ($this->reportType == "Active Voter of Organization") {

            $this->dataSets = Voter::select(
                'voters.fname',
                'voters.mname',
                'voters.lname',
                'voters.precinct_no',
                'voters.gender',
                'voters.dob',
                'voters.status',
                'voters.remarks',
                'voters.image_path',
                'organizations.name'
            )
                ->join('voter_organizations', 'voter_organizations.voter_id', '=', 'voters.id')
                ->join('organizations', 'organizations.id', '=', 'voter_organizations.organization_id')
                ->where('voters.barangay', $this->barangay)
                ->where('voters.status', 'Active');

            if ($this->reportSubTypeSelected) {
                $this->dataSets->where('organizations.id', $this->reportSubTypeSelected);
            }

            $this->dataSets->orderBy('organizations.name', 'ASC');

            $this->dataSets = $this->dataSets->get();
            $this->preview = true;
        } else if ($this->reportType == "Active Voter of Barangay Staff") {

            $this->dataSets = Voter::select(
                'voters.fname',
                'voters.mname',
                'voters.lname',
                'voters.precinct_no',
                'voters.gender',
                'voters.dob',
                'voters.status',
                'voters.remarks',
                'voters.image_path',
                'designations.name'
            )
                ->join('voter_designations', 'voter_designations.voter_id', '=', 'voters.id')
                ->join('designations', 'designations.id', '=', 'voter_designations.organization_id')
                ->where('voters.barangay', $this->barangay)
                ->where('voters.status', 'Active');

            if ($this->reportSubTypeSelected) {
                $this->dataSets->where('designations.id', $this->reportSubTypeSelected);
            }

            $this->dataSets->orderBy('designations.name', 'ASC');

            $this->dataSets = $this->dataSets->get();
            $this->preview = true;
        }
    }


    public function generateReport()
    {
        // Validate inputs before generating the report
        $this->validate();

        if (!empty($this->barangay) && !empty($this->reportType)) {
            switch ($this->reportType) {
                case "Active Voter":

                    $pdf = new FPDF();
                    $pdf->AddPage();
                    $pdf->SetFont('Arial', 'B', 14);
                    $pdf->Cell(0, 8, 'Active Voters of ' . $this->barangay, 0, 1);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->Cell(190, 5, 'An active voter is an individual who participates in elections by registering to vote and casting their ballot. This engagement can occur in various forms,', 0, 1, 'L');
                    $pdf->Cell(190, 5, 'including voting in local, state, and national elections, as well as participating in primaries and referendums. Active voters often stay informed about', 0, 1, 'L');
                    $pdf->Cell(190, 5, 'political issues, candidates, and policies, reflecting their commitment to civic duty and influence in the democratic process.', 0, 1, 'L');

                    $pdf->ln();
                    $pdf->Cell(10, 7, '#', 1, 0, 'L');
                    $pdf->Cell(90, 7, 'Name', 1, 0, 'L');
                    $pdf->Cell(60, 7, 'Precinct No.', 1, 0, 'L');
                    $pdf->Cell(30, 7, 'Status', 1, 1, 'L');

                    $i = 1;
                    foreach ($this->dataSets as $voter) {
                        $pdf->Cell(10, 7, $i++, 1, 0, 'L');
                        $pdf->Cell(90, 7, $voter->lname . ', ' . $voter->fname . ' ' . $voter->mname, 1, 0, 'L');
                        $pdf->Cell(60, 7, $voter->precinct_no, 1, 0, 'L');
                        $pdf->Cell(30, 7, $voter->status, 1, 1, 'L');
                    }

                    return response()->streamDownload(function () use ($pdf) {
                        $pdf->Output();
                    }, str_replace(' ', '_', $this->reportType) . '_Of_' . str_replace(' ', '_', $this->barangay) . '.pdf');

                    break;
                case "Active Voter of Organization":

                    $activeVoters = Voter::select(
                        'voters.id',
                        'voters.fname',
                        'voters.mname',
                        'voters.lname',
                        'voters.barangay',
                        'voters.precinct_no',
                        'voters.gender',
                        'voters.dob',
                        'voters.status',
                        'voters.remarks',
                        'voters.image_path',
                        DB::raw('GROUP_CONCAT(DISTINCT organizations.name SEPARATOR ", ") as voter_organizations')
                    )
                        ->join('voter_organizations', 'voter_organizations.voter_id', '=', 'voters.id')
                        ->join('organizations', 'organizations.id', '=', 'voter_organizations.organization_id')

                        ->where('voters.barangay', '=', $this->barangay)


                        ->groupBy(
                            'voters.id',
                            'voters.fname',
                            'voters.mname',
                            'voters.lname',
                            'voters.barangay',
                            'voters.precinct_no',
                            'voters.gender',
                            'voters.dob',
                            'voters.status',
                            'voters.remarks',
                            'voters.image_path',
                        )

                        ->get();

                    $pdf = new FPDF();
                    $pdf->AddPage();
                    $pdf->SetFont('Arial', 'B', 14);
                    $pdf->Cell(0, 8, $this->reportType . ' of ' . $this->barangay, 0, 1);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->Cell(190, 5, 'An active voter is an individual who participates in elections by registering to vote and casting their ballot. This engagement can occur in various forms,', 0, 1, 'L');
                    $pdf->Cell(190, 5, 'including voting in local, state, and national elections, as well as participating in primaries and referendums. Active voters often stay informed about', 0, 1, 'L');
                    $pdf->Cell(190, 5, 'political issues, candidates, and policies, reflecting their commitment to civic duty and influence in the democratic process.', 0, 1, 'L');

                    $pdf->ln();
                    $pdf->Cell(10, 7, '#', 1, 0, 'L');
                    $pdf->Cell(70, 7, 'Name', 1, 0, 'L');
                    $pdf->Cell(35, 7, 'Precinct No.', 1, 0, 'L');
                    $pdf->Cell(55, 7, 'Organization', 1, 0, 'L');
                    $pdf->Cell(30, 7, 'Status', 1, 1, 'L');

                    $i = 0;
                    foreach ($this->dataSets as $voter) {
                        $pdf->Cell(35, 7, $i++, 1, 0, 'L');
                        $pdf->Cell(70, 7, $voter->fname . ' ' . $voter->mname . ' ' . $voter->lname, 1, 0, 'L');
                        $pdf->Cell(35, 7, $voter->precinct_no, 1, 0, 'L');
                        $pdf->Cell(55, 7, $voter->voter_organizations, 1, 0, 'L');
                        $pdf->Cell(30, 7, $voter->status, 1, 1, 'L');
                    }

                    return response()->streamDownload(function () use ($pdf) {
                        $pdf->Output();
                    }, str_replace(' ', '_', $this->reportType) . '_Of_' . str_replace(' ', '_', $this->barangay) . '.pdf');

                    break;
                case "Active Voter of Barangay Staff":

                    $activeVoters = Voter::select(
                        'voters.id',
                        'voters.fname',
                        'voters.mname',
                        'voters.lname',
                        'voters.barangay',
                        'voters.precinct_no',
                        'voters.gender',
                        'voters.dob',
                        'voters.status',
                        'voters.remarks',
                        'voters.image_path',
                        DB::raw('GROUP_CONCAT(DISTINCT designations.name SEPARATOR ", ") as vdesignations')
                    )
                        ->join('voter_designations', 'voter_designations.voter_id', '=', 'voters.id')
                        ->join('designations', 'designations.id', '=', 'voter_designations.designation_id')

                        ->where('voters.barangay', '=', $this->barangay)

                        ->groupBy(
                            'voters.id',
                            'voters.fname',
                            'voters.mname',
                            'voters.lname',
                            'voters.barangay',
                            'voters.precinct_no',
                            'voters.gender',
                            'voters.dob',
                            'voters.status',
                            'voters.remarks',
                            'voters.image_path',
                        )

                        ->get();

                    $pdf = new FPDF();
                    $pdf->AddPage();
                    $pdf->SetFont('Arial', 'B', 14);
                    $pdf->Cell(0, 8, $this->reportType . ' of ' . $this->barangay, 0, 1);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->Cell(190, 5, 'An active voter is an individual who participates in elections by registering to vote and casting their ballot. This engagement can occur in various forms,', 0, 1, 'L');
                    $pdf->Cell(190, 5, 'including voting in local, state, and national elections, as well as participating in primaries and referendums. Active voters often stay informed about', 0, 1, 'L');
                    $pdf->Cell(190, 5, 'political issues, candidates, and policies, reflecting their commitment to civic duty and influence in the democratic process.', 0, 1, 'L');

                    $pdf->ln();
                    $pdf->Cell(10, 7, '#', 1, 0, 'L');
                    $pdf->Cell(70, 7, 'Name', 1, 0, 'L');
                    $pdf->Cell(25, 7, 'Precinct No.', 1, 0, 'L');
                    $pdf->Cell(55, 7, 'Designation', 1, 0, 'L');
                    $pdf->Cell(30, 7, 'Status', 1, 1, 'L');

                    $i = 0;

                    foreach ($activeVoters as $voter) {
                        $pdf->Cell(10, 7, $i++, 1, 0, 'L');
                        $pdf->Cell(70, 7, $voter->fname . ' ' . $voter->mname . ' ' . $voter->lname, 1, 0, 'L');
                        $pdf->Cell(25, 7, $voter->precinct_no, 1, 0, 'L');
                        $pdf->Cell(55, 7, $voter->vdesignations, 1, 0, 'L');
                        $pdf->Cell(30, 7, $voter->status, 1, 1, 'L');
                    }

                    return response()->streamDownload(function () use ($pdf) {
                        $pdf->Output();
                    }, str_replace(' ', '_', $this->reportType) . '_Of_' . str_replace(' ', '_', $this->barangay) . '.pdf');

                    break;
                default:
                    session()->flash('message', 'Invalid report type selected.');
                    break;
            }
        } else {
            session()->flash('message', 'Please select a barangay and report type.');
        }
    }

    public function render()
    {
        return view(
            'livewire.report.report-livewire'
        );
    }
}
