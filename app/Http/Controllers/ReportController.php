<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Voter;
use FPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $barangays = Barangay::where('municipality_id', auth()->user()->municipality_id)->get();
        return view(
            'report.index',
            [
                'barangays' => $barangays
            ]
        );
    }

    public function initialize(Request $request)
    {
        $barangay               = $request->input('barangay');
        $type                   = $request->input('type');
        $sub_type               = $request->input('sub_type');

        if ($type == "Active Voter of Organization") {

            $voters = Voter::select(
                'voters.fname',
                'voters.mname',
                'voters.lname',
                'voters.precinct_no',
                'voters.gender',
                'voters.dob',
                'voters.status',
                'voters.remarks',
                'voters.image_path',
                DB::raw('GROUP_CONCAT(organizations.name SEPARATOR ", ") as organizations_names') // Using GROUP_CONCAT here
            )
                ->join('voter_organizations', 'voter_organizations.voter_id', '=', 'voters.id')
                ->join('organizations', 'organizations.id', '=', 'voter_organizations.organization_id')
                ->where('voters.municipality_id', auth()->user()->municipality_id)
                ->where('voters.barangay_id', $barangay)
                ->where('voters.status', 'Active');

            if ($sub_type) {
                $voters = $voters->where('organizations.id', $sub_type);
            }

            $voters = $voters->groupBy(
                'voters.id',
                'voters.fname',
                'voters.mname',
                'voters.lname',
                'voters.precinct_no',
                'voters.gender',
                'voters.dob',
                'voters.status',
                'voters.remarks',
                'voters.image_path'
            );

            $voters = $voters->get();

            $this->generateReport($voters, $type, $barangay);
        } else if ($type == "Active Voter of Barangay Staff") {

            $voters = Voter::select(
                'voters.fname',
                'voters.mname',
                'voters.lname',
                'voters.precinct_no',
                'voters.gender',
                'voters.dob',
                'voters.status',
                'voters.remarks',
                'voters.image_path',
                DB::raw('GROUP_CONCAT(designations.name SEPARATOR ", ") as designations_names') // Using GROUP_CONCAT here
            )
                ->join('voter_designations', 'voter_designations.voter_id', '=', 'voters.id')
                ->join('designations', 'designations.id', '=', 'voter_designations.designation_id')
                ->where('voters.municipality_id', auth()->user()->municipality_id)
                ->where('voters.barangay_id', $barangay)
                ->where('voters.status', 'Active');

            if ($sub_type) {
                $voters->where('designations.id', $sub_type);
            }

            $voters = $voters->groupBy(
                'voters.id', // Group by voter id to ensure we get one row per voter
                'voters.fname',
                'voters.mname',
                'voters.lname',
                'voters.precinct_no',
                'voters.gender',
                'voters.dob',
                'voters.status',
                'voters.remarks',
                'voters.image_path'
            );

            $voters = $voters->get();

            $this->generateReport($voters, $type, $barangay);
        } else {
            $voters = Voter::where('barangay_id', $barangay)
                ->where('municipality_id', auth()->user()->municipality_id)
                ->orderBy('lname')
                ->get();

            $this->generateReport($voters, $type, $barangay);
        }
    }

    private function generateReport($data, $type, $barangay)
    {
        if (!empty($barangay) && !empty($type)) {

            $currentBarangay = Barangay::where('id', $barangay)->first()->name;
            switch ($type) {
                case "Active Voter":

                    $pdf = new FPDF();
                    $pdf->AddPage();
                    $pdf->SetFont('Arial', 'B', 14);
                    $pdf->Cell(0, 8, 'Active Voters of ' . $currentBarangay, 0, 1);
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
                    foreach ($data as $voter) {
                        $pdf->Cell(10, 7, $i++, 1, 0, 'L');
                        $pdf->Cell(90, 7, $voter->lname . ', ' . $voter->fname . ' ' . $voter->mname, 1, 0, 'L');
                        $pdf->Cell(60, 7, $voter->precinct_no, 1, 0, 'L');
                        $pdf->Cell(30, 7, $voter->status, 1, 1, 'L');
                    }

                    $pdf->Output();
                    exit;

                    break;
                case "Active Voter of Organization":

                    $pdf = new FPDF();
                    $pdf->AddPage();
                    $pdf->SetFont('Arial', 'B', 14);
                    $pdf->Cell(0, 8, $type . ' of ' . $currentBarangay, 0, 1);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->Cell(190, 5, 'An active voter is an individual who participates in elections by registering to vote and casting their ballot. This engagement can occur in various forms,', 0, 1, 'L');
                    $pdf->Cell(190, 5, 'including voting in local, state, and national elections, as well as participating in primaries and referendums. Active voters often stay informed about', 0, 1, 'L');
                    $pdf->Cell(190, 5, 'political issues, candidates, and policies, reflecting their commitment to civic duty and influence in the democratic process.', 0, 1, 'L');

                    $pdf->ln();
                    $pdf->Cell(10, 7, '#', 1, 0, 'L');
                    $pdf->Cell(70, 7, 'Name', 1, 0, 'L');
                    $pdf->Cell(25, 7, 'Precinct No.', 1, 0, 'L');
                    $pdf->Cell(55, 7, 'Organization', 1, 0, 'L');
                    $pdf->Cell(30, 7, 'Status', 1, 1, 'L');

                    $i = 1;
                    foreach ($data as $voter) {
                        $pdf->Cell(10, 7, $i++, 1, 0, 'L');
                        $pdf->Cell(70, 7, $voter->fname . ' ' . $voter->mname . ' ' . $voter->lname, 1, 0, 'L');
                        $pdf->Cell(25, 7, $voter->precinct_no, 1, 0, 'L');
                        $pdf->Cell(55, 7, $voter->organizations_names, 1, 0, 'L');
                        $pdf->Cell(30, 7, $voter->status, 1, 1, 'L');
                    }

                    $pdf->Output();
                    exit;

                    break;
                case "Active Voter of Barangay Staff":

                    $pdf = new FPDF();
                    $pdf->AddPage();
                    $pdf->SetFont('Arial', 'B', 14);
                    $pdf->Cell(0, 8, $type . ' of ' . $currentBarangay, 0, 1);
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

                    $i = 1;

                    foreach ($data as $voter) {
                        $pdf->Cell(10, 7, $i++, 1, 0, 'L');
                        $pdf->Cell(70, 7, $voter->fname . ' ' . $voter->mname . ' ' . $voter->lname, 1, 0, 'L');
                        $pdf->Cell(25, 7, $voter->precinct_no, 1, 0, 'L');
                        $pdf->Cell(55, 7, $voter->designations_names, 1, 0, 'L');
                        $pdf->Cell(30, 7, $voter->status, 1, 1, 'L');
                    }

                    $pdf->Output();
                    exit;

                    break;
                default:
                    session()->flash('message', 'Invalid report type selected.');
                    break;
            }
        }
    }
}
