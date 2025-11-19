<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Municipality;
use App\Models\Voter;
use FPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $barangays = Barangay::where('municipality_id', auth()->user()->municipality_id)->get();
        return view('report.index', ['barangays' => $barangays]);
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
                ->where('voters.status', 'Active')
                ->where('voters.is_checked', 1);

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
                'barangays.name as barangay_name',
                DB::raw('GROUP_CONCAT(designations.name SEPARATOR ", ") as designations_names')
            )
                ->join('voter_designations', 'voter_designations.voter_id', '=', 'voters.id')
                ->join('designations', 'designations.id', '=', 'voter_designations.designation_id')
                ->join('barangays', 'barangays.id', '=', 'voters.barangay_id') // Add this join
                ->where('voters.municipality_id', auth()->user()->municipality_id)
                ->where('voters.status', 'Active')
                ->where('voters.is_checked', 1);

            // Conditionally apply barangay filter
            if ($barangay) {
                $voters->where('voters.barangay_id', $barangay);
            }

            // Conditionally apply designation filter
            if ($sub_type) {
                $voters->where('designations.id', $sub_type);
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
                'voters.image_path',
                'barangays.name'
            )->get();

            $currentDesignation = DB::table('designations')->where('id', $sub_type)->first()->name;
            $this->generateReport($voters, $type, $barangay, $currentDesignation);
        } else {
            $sub_type_array = explode('-', $sub_type);

            $isGuiconsulta = trim($sub_type_array[1]) == 'Yes' ? NULL : 'No';
            $voters = Voter::where('barangay_id', $barangay)
                ->where(['municipality_id' => auth()->user()->municipality_id, 'status' => 'Active', 'is_checked' => 1, 'is_guiconsulta' => $isGuiconsulta])

                ->orderByRaw("FIELD(voters.remarks, 'Opponent', 'Undecided', 'Ally')")
                ->orderBy('lname')
                ->get();

            $this->generateReport($voters, $type, $barangay, $isGuiconsulta);
        }
    }

    private function generateReport($data, $type, $barangay, $subtype = null)
    {
        if (!empty($barangay) && !empty($type)) {

            $currentBarangay = Barangay::where('id', $barangay)->first()->name;
            switch ($type) {
                case "Active Voter":

                    $pdf = new FPDF();
                    $pdf->AddPage();
                    $pdf->SetFont('Arial', 'B', 14);
                    if ($subtype == 'Yes' || $subtype == null) {
                        $pdf->Cell(0, 8, 'Guiconsulta Profiled of Barangay ' . $currentBarangay, 0, 1);
                    } else {
                        $pdf->Cell(0, 8, 'Guiconsulta Not Profiled of Barangay' . $currentBarangay, 0, 1);
                    }

                    $pdf->ln();
                    $pdf->SetFont('Arial', 'B', 8);
                    $pdf->Cell(10, 7, '#', 1, 0, 'L');
                    $pdf->Cell(90, 7, 'Name', 1, 0, 'L');
                    $pdf->Cell(60, 7, 'Precinct No.', 1, 0, 'L');
                    $pdf->Cell(30, 7, 'Tagging', 1, 1, 'L');

                    $i = 1;
                    foreach ($data as $voter) {
                        $pdf->Cell(10, 7, $i++, 1, 0, 'L');
                        $pdf->Cell(90, 7, $voter->lname . ', ' . $voter->fname . ' ' . $voter->mname, 1, 0, 'L');
                        $pdf->Cell(60, 7, $voter->precinct_no, 1, 0, 'L');
                        $pdf->Cell(30, 7, $voter->remarks, 1, 1, 'L');
                    }

                    $pdf->Output();
                    exit;

                    break;
                case "Active Voter of Organization":

                    $pdf = new FPDF();
                    $pdf->AddPage();
                    $pdf->SetFont('Arial', 'B', 14);
                    $pdf->Cell(0, 8, $type . ' in ' . $currentBarangay, 0, 1);
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
                    $pdf->Cell(0, 8, $subtype . ' of ' . $currentBarangay, 0, 1);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->Cell(190, 5, 'An active voter is an individual who participates in elections by registering to vote and casting their ballot. This engagement can occur in various forms,', 0, 1, 'L');
                    $pdf->Cell(190, 5, 'including voting in local, state, and national elections, as well as participating in primaries and referendums. Active voters often stay informed about', 0, 1, 'L');
                    $pdf->Cell(190, 5, 'political issues, candidates, and policies, reflecting their commitment to civic duty and influence in the democratic process.', 0, 1, 'L');

                    $pdf->ln();
                    $pdf->Cell(10, 7, '#', 1, 0, 'L');
                    $pdf->Cell(60, 7, 'Name', 1, 0, 'L');
                    $pdf->Cell(35, 7, 'Barangay', 1, 0, 'L');
                    $pdf->Cell(55, 7, 'Designation', 1, 0, 'L');
                    $pdf->Cell(30, 7, 'Status', 1, 1, 'L');

                    $i = 1;

                    foreach ($data as $voter) {
                        $pdf->Cell(10, 7, $i++, 1, 0, 'L');
                        $pdf->Cell(60, 7, $voter->fname . ' ' . $voter->mname . ' ' . $voter->lname, 1, 0, 'L');
                        $pdf->Cell(35, 7, $voter->barangay_name, 1, 0, 'L');
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
        } else {
            switch ($type) {
                case "Active Voter":
                    // $pdf = new FPDF();
                    // $pdf->AddPage();
                    // $pdf->SetFont('Arial', 'B', 14);
                    // if ($subtype == 'Yes' || $subtype == null) {
                    //     $pdf->Cell(0, 8, 'Guiconsulta Profiled of Barangay ' . $currentBarangay, 0, 1);
                    // } else {
                    //     $pdf->Cell(0, 8, 'Guiconsulta Not Profiled of Barangay' . $currentBarangay, 0, 1);
                    // }

                    // $pdf->ln();
                    // $pdf->SetFont('Arial', 'B', 8);
                    // $pdf->Cell(10, 7, '#', 1, 0, 'L');
                    // $pdf->Cell(90, 7, 'Name', 1, 0, 'L');
                    // $pdf->Cell(60, 7, 'Precinct No.', 1, 0, 'L');
                    // $pdf->Cell(30, 7, 'Tagging', 1, 1, 'L');

                    // $i = 1;
                    // foreach ($data as $voter) {
                    //     $pdf->Cell(10, 7, $i++, 1, 0, 'L');
                    //     $pdf->Cell(90, 7, $voter->lname . ', ' . $voter->fname . ' ' . $voter->mname, 1, 0, 'L');
                    //     $pdf->Cell(60, 7, $voter->precinct_no, 1, 0, 'L');
                    //     $pdf->Cell(30, 7, $voter->remarks, 1, 1, 'L');
                    // }

                    // $pdf->Output();
                    // exit;

                    break;
                case "Active Voter of Organization":

                    $pdf = new FPDF();
                    $pdf->AddPage();
                    $pdf->SetFont('Arial', 'B', 14);
                    $pdf->Cell(0, 8, $type . ' of all Barangay', 0, 1);
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
                    $pdf->Cell(0, 8, $subtype . ' of all Barangay', 0, 1);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->Cell(190, 5, 'An active voter is an individual who participates in elections by registering to vote and casting their ballot. This engagement can occur in various forms,', 0, 1, 'L');
                    $pdf->Cell(190, 5, 'including voting in local, state, and national elections, as well as participating in primaries and referendums. Active voters often stay informed about', 0, 1, 'L');
                    $pdf->Cell(190, 5, 'political issues, candidates, and policies, reflecting their commitment to civic duty and influence in the democratic process.', 0, 1, 'L');

                    $pdf->ln();
                    $pdf->Cell(10, 7, '#', 1, 0, 'L');
                    $pdf->Cell(60, 7, 'Name', 1, 0, 'L');
                    $pdf->Cell(35, 7, 'Barangay', 1, 0, 'L');
                    $pdf->Cell(55, 7, 'Designation', 1, 0, 'L');
                    $pdf->Cell(30, 7, 'Status', 1, 1, 'L');

                    $i = 1;

                    foreach ($data as $voter) {
                        $pdf->Cell(10, 7, $i++, 1, 0, 'L');
                        $pdf->Cell(60, 7, $voter->fname . ' ' . $voter->mname . ' ' . $voter->lname, 1, 0, 'L');
                        $pdf->Cell(35, 7, $voter->barangay_name, 1, 0, 'L');
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






    // Super Admin

    public function municipalTotalVoter()
    {
        $voterFactions = Municipality::select('municipalities.name')

            // Get the count of allies, opponents, and undecided voters
            ->selectRaw('COUNT(voters.id) as total_voters')
            ->selectRaw('SUM(voters.remarks = "ally") as ally_count')
            ->selectRaw('SUM(voters.remarks = "opponent") as opponent_count')
            ->selectRaw('SUM(voters.remarks = "undecided") as undecided_count')

            // Use LEFT JOIN to include municipalities even without voters
            ->leftJoin('voters', 'municipalities.id', '=', 'voters.municipality_id')

            // Filter for active voters and search condition
            ->where(function ($query) {
                $query->where('voters.status', 'Active')
                    ->orWhereNull('voters.status');
            })

            // Group by municipality name
            ->groupBy('municipalities.id', 'municipalities.name')

            // Order by municipality name
            ->orderBy('municipalities.name', 'asc')
            ->get();

        // Calculate percentages
        $voterFactions = $voterFactions->map(function ($municipality) {
            $totalVoters = $municipality->total_voters;

            // Calculate the percentage for each category
            $municipality->ally_percentage = $totalVoters ? round(($municipality->ally_count / $totalVoters) * 100, 2) : 0;
            $municipality->opponent_percentage = $totalVoters ? round(($municipality->opponent_count / $totalVoters) * 100, 2) : 0;
            $municipality->undecided_percentage = $totalVoters ? round(($municipality->undecided_count / $totalVoters) * 100, 2) : 0;

            return $municipality;
        });

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, "Total voters per Municipalities", 0, 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(190, 5, "The Total Voters per Municipality report provides a detailed breakdown of the number of registered voters in each municipality or city. It helps election officials, policymakers, and researchers analyze voter distribution, plan resource allocation, and anticipate turnout trends. This data is crucial for ensuring fair and efficient elections, optimizing polling station placements, and promoting voter engagement for a more inclusive democratic process.", 0, 'L');

        $pdf->ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(173, 216, 230); // RGB for light blue
        $pdf->Cell(10, 10, '#', 1, 0, 'L', true);
        $pdf->Cell(150, 10, strtoupper('Municipality / City'), 1, 0, 'L', true);
        $pdf->Cell(30, 10, 'TOTAL', 1, 1, 'C', true);

        $i = 1;
        $pdf->SetFont('Arial', 'B', 8);
        foreach ($voterFactions as $voter) {
            $pdf->Cell(10, 10, $i++, 1, 0, 'L');
            $pdf->Cell(150, 10, strtoupper($voter->name), 1, 0, 'L');
            $pdf->Cell(30, 10, number_format($voter->total_voters), 1, 1, 'C');
        }

        $pdf->Output();
        exit;
    }


    public function barangayTotalVoter()
    {
        $voterFactions = Barangay::select('barangays.name')

            // Count voters and their remarks categories
            ->selectRaw('COUNT(voters.id) as total_voters')
            ->selectRaw('SUM(voters.remarks = "ally") as ally_count')
            ->selectRaw('SUM(voters.remarks = "opponent") as opponent_count')
            ->selectRaw('SUM(voters.remarks = "undecided") as undecided_count')

            // Join with voters and municipalities
            ->leftJoin('voters', 'barangays.id', '=', 'voters.barangay_id')
            ->join('municipalities', 'municipalities.id', '=', 'barangays.municipality_id')

            // Filter by active voters and current user's municipality
            ->where('barangays.municipality_id', auth()->user()->municipality_id)
            ->where(function ($query) {
                $query->where('voters.status', 'Active')
                    ->orWhereNull('voters.id'); // Include barangays with no voters
            })

            // Group and order by barangay name
            ->groupBy('barangays.name')
            ->orderBy('barangays.name', 'asc')
            ->get();

        // Calculate percentages and handle zero voters
        $voterFactions = $voterFactions->map(function ($barangay) {
            $totalVoters = $barangay->total_voters;

            $barangay->ally_percentage = $totalVoters ? round(($barangay->ally_count / $totalVoters) * 100, 2) : 0;
            $barangay->opponent_percentage = $totalVoters ? round(($barangay->opponent_count / $totalVoters) * 100, 2) : 0;
            $barangay->undecided_percentage = $totalVoters ? round(($barangay->undecided_count / $totalVoters) * 100, 2) : 0;

            return $barangay;
        });

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, "Total voters per barangay ", 0, 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(190, 5, "The Total Voters per Barangay report provides a detailed breakdown of the number of registered voters in each barangay. It helps election officials, policymakers, and researchers analyze voter distribution, plan resource allocation, and anticipate turnout trends. This data is crucial for ensuring fair and efficient elections, optimizing polling station placements, and promoting voter engagement for a more inclusive democratic process.", 0, 'L');

        $pdf->ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(173, 216, 230); // RGB for light blue
        $pdf->Cell(10, 10, '#', 1, 0, 'L', true);
        $pdf->Cell(150, 10, 'BARANGAY', 1, 0, 'L', true);
        $pdf->Cell(30, 10, 'TOTAL', 1, 1, 'C', true);

        $i = 1;
        $pdf->SetFont('Arial', 'B', 8);
        foreach ($voterFactions as $voter) {
            $pdf->Cell(10, 10, $i++, 1, 0, 'L');
            $pdf->Cell(150, 10, strtoupper($voter->name), 1, 0, 'L');
            $pdf->Cell(30, 10, number_format($voter->total_voters), 1, 1, 'C');
        }

        $pdf->Output();
        exit;
    }

    public function withoutGuiconsultaTagging()
    {
        $voterDetails = Barangay::select('barangays.name')

            // Count voters and their remarks categories
            ->selectRaw('COUNT(voters.id) as total_voters')
            ->selectRaw('SUM(voters.remarks = "ally") as ally_count')
            ->selectRaw('SUM(voters.remarks = "opponent") as opponent_count')
            ->selectRaw('SUM(voters.remarks = "undecided") as undecided_count')

            // Join with voters and municipalities
            ->join('voters', 'barangays.id', '=', 'voters.barangay_id')
            ->join('municipalities', 'municipalities.id', '=', 'barangays.municipality_id')

            // Filter by active voters and current user's municipality
            ->where('barangays.municipality_id', auth()->user()->municipality_id)
            ->where(function ($query) {
                $query->where('voters.status', 'Active')
                    ->whereNull('voters.is_guiconsulta');
            })

            // Group and order by barangay name
            ->groupBy('barangays.name')
            ->orderBy('barangays.name', 'asc')
            ->get();

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, "Guiconsulta Bayambang Profiled Statistics", 0, 1);

        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);

        $total = 0;
        $totalAlly = 0;
        $totalOpponent = 0;
        $totalUndecided = 0;

        // Table Header (no background color)
        $pdf->Cell(10, 10, '#', 1, 0, 'L');
        $pdf->Cell(50, 10, 'BARANGAY', 1, 0, 'L');
        $pdf->Cell(40, 10, 'TOTAL PROFILED', 1, 0, 'C');
        $pdf->Cell(30, 10, 'ALLY', 1, 0, 'C');
        $pdf->Cell(30, 10, 'OPPONENTS', 1, 0, 'C');
        $pdf->Cell(30, 10, 'UNDECIDED', 1, 1, 'C');

        // Table Data
        $i = 1;
        $pdf->SetFont('Arial', 'B', 8);
        foreach ($voterDetails as $detail) {
            $pdf->Cell(10, 10, $i++, 1, 0, 'L');
            $pdf->Cell(50, 10, $detail->name, 1, 0, 'L');
            $pdf->Cell(40, 10, $detail->total_voters, 1, 0, 'C');
            $pdf->Cell(30, 10, $detail->ally_count, 1, 0, 'C');
            $pdf->Cell(30, 10, $detail->opponent_count, 1, 0, 'C');
            $pdf->Cell(30, 10, $detail->undecided_count, 1, 1, 'C');

            $total += $detail->total_voters;
            $totalAlly += $detail->ally_count;
            $totalOpponent += $detail->opponent_count;
            $totalUndecided += $detail->undecided_count;
        }
        $pdf->Cell(10, 10, '', 1, 0, 'L');
        $pdf->Cell(50, 10, 'Total =', 1, 0, 'L');
        $pdf->Cell(40, 10, number_format($total), 1, 0, 'C');
        $pdf->Cell(30, 10, number_format($totalAlly), 1, 0, 'C');
        $pdf->Cell(30, 10, number_format($totalOpponent), 1, 0, 'C');
        $pdf->Cell(30, 10, number_format($totalUndecided), 1, 1, 'C');

        $pdf->Output();
        exit;
    }

    public function withoutGuiconsultaBayambangProfiledPerBarangay()
    {
        $groupedVoters = Barangay::select(
            'barangays.name as barangay_name',
            'voters.fname',
            'voters.lname',
            'voters.precinct_no',
            'voters.remarks'
        )
            ->join('voters', 'barangays.id', '=', 'voters.barangay_id')
            ->join('municipalities', 'municipalities.id', '=', 'barangays.municipality_id')
            ->where('barangays.municipality_id', auth()->user()->municipality_id)
            ->whereIn('barangays.name', ['Langiran', 'Macayocayo', 'Beleng', 'Balaybuaya', 'Malimpec'])
            ->where(function ($query) {
                $query->where('voters.status', 'Active')
                    ->whereNull('voters.is_guiconsulta');
            })
            ->orderBy('barangays.name')
            ->orderByRaw("FIELD(voters.remarks, 'Opponent', 'Ally', 'Undecided')")
            ->orderBy('voters.lname')
            ->orderBy('voters.fname')
            ->orderBy('voters.precinct_no')

            ->get()
            ->groupBy('barangay_name');

        $pdf = new FPDF();
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, "Guiconsulta Profiled in Bayambang", 0, 1, 'C');
        $pdf->Ln(5);

        foreach ($groupedVoters as $barangay => $voters) {
            // Barangay Header
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, "Barangay: " . $barangay, 0, 1);

            // Table Header
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(10, 8, '#', 1, 0, 'C');
            $pdf->Cell(80, 8, 'Name', 1, 0, 'L');
            $pdf->Cell(40, 8, 'Precinct', 1, 0, 'C');
            $pdf->Cell(40, 8, '', 1, 1, 'C');

            // Table Data
            $pdf->SetFont('Arial', '', 9);
            $i = 1;
            foreach ($voters as $voter) {
                $fullName = $voter->lname . ', ' . $voter->fname;
                $pdf->Cell(10, 8, $i++, 1, 0, 'C');
                $pdf->Cell(80, 8, $fullName, 1, 0, 'L');
                $pdf->Cell(40, 8, $voter->precinct_no, 1, 0, 'C');
                $pdf->Cell(40, 8, $voter->remarks, 1, 1, 'C');
            }

            $pdf->Ln(5);
        }

        $pdf->Output();
        exit;
    }

    public function guiconsultaProfiledAndNotPerBarangay()
    {
        $groupedVoters = Barangay::select(
            'barangays.name as barangay_name',
            DB::raw("SUM(CASE WHEN is_guiconsulta = 1 THEN 1 ELSE 0 END) as total_yes"),
            DB::raw("SUM(CASE WHEN is_guiconsulta = 0 THEN 1 ELSE 0 END) as total_no")
        )
            ->join('voters', 'barangays.id', '=', 'voters.barangay_id')
            ->join('municipalities', 'municipalities.id', '=', 'barangays.municipality_id')

            ->where('voters.status', 'Active')
            ->whereIn('voters.remarks', ['Ally', 'Undecided'])

            ->orderBy('barangays.name')

            ->get()
            ->groupBy('barangay_name');

        $pdf = new FPDF();
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, "Guiconsulta Profiled in Bayambang", 0, 1, 'C');
        $pdf->Ln(5);

        foreach ($groupedVoters as $barangay => $voters) {
            // Barangay Header
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, "Barangay: " . $barangay, 0, 1);

            // Table Header
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(10, 8, '#', 1, 0, 'C');
            $pdf->Cell(80, 8, 'Name', 1, 0, 'L');
            $pdf->Cell(40, 8, 'Precinct', 1, 0, 'C');
            $pdf->Cell(40, 8, '', 1, 1, 'C');

            // Table Data
            $pdf->SetFont('Arial', '', 9);
            $i = 1;
            foreach ($voters as $voter) {
                $fullName = $voter->lname . ', ' . $voter->fname;
                $pdf->Cell(10, 8, $i++, 1, 0, 'C');
                $pdf->Cell(80, 8, $fullName, 1, 0, 'L');
                $pdf->Cell(40, 8, $voter->precinct_no, 1, 0, 'C');
                $pdf->Cell(40, 8, $voter->remarks, 1, 1, 'C');
            }

            $pdf->Ln(5);
        }

        $pdf->Output();
        exit;
    }
}
