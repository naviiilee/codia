<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use FPDF;

class CertificateController extends Controller
{
    public function show()
    {
        $username = session('username');

        if (!$username) {
            return redirect()->route('home')->with('error', 'Please login to view your certificates.');
        }

        $user = DB::table('users')
            ->where('username', $username)
            ->first();

        if (!$user) {
            return redirect()->route('home')->with('error', 'User not found.');
        }

        $certificates = DB::table('certificates')
            ->where('user_id', $user->id)
            ->orderByDesc('awarded_at')
            ->get();

        return view('certificate', [
            'certificates' => $certificates,
            'first'        => $user->first,
            'last'         => $user->last,
            'username'     => $user->username,
        ]);
    }

    /**
     * Download a diploma-style certificate PDF
     */
    public function download($certificateId)
    {
        $username = session('username');

        if (!$username) {
            return redirect()->route('home')->with('error', 'Please login to download your certificate.');
        }

        $user = DB::table('users')
            ->where('username', $username)
            ->first();

        if (!$user) {
            return redirect()->route('home')->with('error', 'User not found.');
        }

        $certificate = DB::table('certificates')
            ->where('id', $certificateId)
            ->where('user_id', $user->id)
            ->first();

        if (!$certificate) {
            return redirect()->route('home')->with('error', 'Certificate not found.');
        }

        $pdf = $this->generateCertificatePdf($certificate, $user);

        // Generate PDF filename
        $fullName = trim($user->first . ' ' . $user->last);
        $filename = 'Certificate_' . str_replace(' ', '_', $fullName) . '_' . date('Y-m-d') . '.pdf';

        // Output PDF for download
        $pdf->Output('D', $filename);
    }

    /**
     * Display a diploma-style certificate PDF in browser
     */
    public function displayCertificate($certificateId)
    {
        $username = session('username');

        if (!$username) {
            return redirect()->route('home')->with('error', 'Please login to view your certificate.');
        }

        $user = DB::table('users')
            ->where('username', $username)
            ->first();

        if (!$user) {
            return redirect()->route('home')->with('error', 'User not found.');
        }

        $certificate = DB::table('certificates')
            ->where('id', $certificateId)
            ->where('user_id', $user->id)
            ->first();

        if (!$certificate) {
            return redirect()->route('home')->with('error', 'Certificate not found.');
        }

        $pdf = $this->generateCertificatePdf($certificate, $user);

        // Output PDF for inline display
        $pdf->Output('I');
    }

    /**
     * Generate a diploma-style certificate PDF
     */
    private function generateCertificatePdf($certificate, $user)
    {
        // Generate PDF
        $pdf = new FPDF('L', 'mm', 'A4'); // Landscape orientation
        $pdf->AddPage();

        // Add background color (cream/diploma color)
        $pdf->SetFillColor(245, 245, 235); // Light cream
        $pdf->Rect(0, 0, 297, 210, 'F');

        // Decorative border - Outer frame
        $pdf->SetLineWidth(3);
        $pdf->SetDrawColor(184, 134, 11); // Dark goldenrod
        $pdf->Rect(10, 10, 277, 190);

        // Inner decorative border
        $pdf->SetLineWidth(1);
        $pdf->SetDrawColor(184, 134, 11);
        $pdf->Rect(15, 15, 267, 180);

        // ===== TOP SECTION: C0DiA LOGO =====
        $pdf->SetFont('Times', 'BI', 42);
        $pdf->SetTextColor(184, 134, 11); // Gold color
        $pdf->SetY(16);
        $pdf->Cell(297, 12, 'C0DiA', 0, 1, 'C');

        // Top decorative line
        $pdf->SetLineWidth(2);
        $pdf->SetDrawColor(184, 134, 11);
        $pdf->Line(80, 32, 217, 32);

        // ===== CERTIFICATE TITLE =====
        $pdf->SetFont('Times', 'B', 32);
        $pdf->SetTextColor(50, 50, 50);
        $pdf->SetY(36);
        $pdf->Cell(297, 7, 'WEB DEVELOPMENT', 0, 1, 'C');

        $pdf->SetFont('Times', 'B', 32);
        $pdf->SetY(43);
        $pdf->Cell(297, 7, 'CERTIFICATE OF COMPLETION', 0, 1, 'C');

        // Decorative line below title
        $pdf->SetLineWidth(1);
        $pdf->SetDrawColor(184, 134, 11);
        $pdf->Line(50, 52, 247, 52);

        // ===== MIDDLE SECTION: USER CONGRATULATION =====
        $pdf->SetFont('Times', 'I', 14);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetY(58);
        $pdf->Cell(297, 4, 'Congratulations!', 0, 1, 'C');

        // ===== USER NAME - CURSIVE STYLE =====
        $fullName = trim($user->first . ' ' . $user->last);
        $pdf->SetFont('Times', 'BI', 48);
        $pdf->SetTextColor(184, 134, 11);
        $pdf->SetY(65);
        $pdf->Cell(297, 15, $fullName, 0, 1, 'C');

        // ===== COMPLETION MESSAGE =====
        $pdf->SetFont('Times', '', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetY(82);
        $awardedDate = $certificate->awarded_at ? date('F d, Y', strtotime($certificate->awarded_at)) : date('F d, Y');
        $completionText = 'For successfully completing the ' . $certificate->course_name . ' course on ' . $awardedDate;
        $pdf->SetX(25);
        $pdf->MultiCell(247, 5, $completionText, 0, 'C');

        // ===== MOTIVATION MESSAGE =====
        $pdf->SetFont('Times', 'I', 11);
        $pdf->SetTextColor(80, 80, 80);
        $pdf->SetY(100);
        $motivationText = 'Keep growing, keep learning, and continue to achieve great things. Your dedication and hard work are inspiring!';
        $pdf->SetX(25);
        $pdf->MultiCell(247, 5, $motivationText, 0, 'C');

        // Bottom decorative line
        $pdf->SetLineWidth(2);
        $pdf->SetDrawColor(184, 134, 11);
        $pdf->Line(20, 116, 277, 116);

        // ===== SIGNATURE SECTION =====
        $pdf->SetY(125);
        $pdf->SetFont('Times', '', 10);
        $pdf->SetTextColor(100, 100, 100);

        // Signature areas
        $pdf->SetLineWidth(1);
        $pdf->SetDrawColor(0, 0, 0);

        // Left signature
        $pdf->SetY(128);
        $pdf->SetX(40);
        $pdf->Line(40, 150, 110, 150);
        $pdf->SetFont('Times', '', 9);
        $pdf->SetY(151);
        $pdf->SetX(40);
        $pdf->Cell(70, 4, 'Authorized Signature', 0, 0, 'C');

        // Right signature
        $pdf->SetX(187);
        $pdf->SetY(128);
        $pdf->Line(187, 150, 257, 150);
        $pdf->SetY(151);
        $pdf->SetX(187);
        $pdf->Cell(70, 4, 'Director', 0, 0, 'C');

        // Seal/Badge effect - circle
        $pdf->SetDrawColor(184, 134, 11);
        $pdf->SetLineWidth(2);
        $this->drawCircle($pdf, 260, 135, 12);

        // Decorative corners
        $this->addCornerDecorations($pdf);

        return $pdf;
    }

    /**
     * Draw a circle on the PDF
     */
    private function drawCircle(&$pdf, $x, $y, $radius)
    {
        // Draw circle using multiple line segments (arc approximation)
        $steps = 60;
        $angle = 0;
        $points = [];

        for ($i = 0; $i <= $steps; $i++) {
            $angle = ($i / $steps) * 2 * M_PI;
            $xPoint = $x + $radius * cos($angle);
            $yPoint = $y + $radius * sin($angle);
            $points[] = ['x' => $xPoint, 'y' => $yPoint];
        }

        // Draw lines between points to form circle
        for ($i = 0; $i < count($points) - 1; $i++) {
            $pdf->Line($points[$i]['x'], $points[$i]['y'], $points[$i + 1]['x'], $points[$i + 1]['y']);
        }
    }

    /**
     * Add decorative corner elements to the PDF
     */
    private function addCornerDecorations(&$pdf)
    {
        $pdf->SetDrawColor(184, 134, 11);
        $pdf->SetLineWidth(1.5);

        // Top-left corner
        $pdf->Line(10, 10, 25, 10);
        $pdf->Line(10, 10, 10, 25);

        // Top-right corner
        $pdf->Line(287, 10, 272, 10);
        $pdf->Line(287, 10, 287, 25);

        // Bottom-left corner
        $pdf->Line(10, 200, 25, 200);
        $pdf->Line(10, 200, 10, 185);

        // Bottom-right corner
        $pdf->Line(287, 200, 272, 200);
        $pdf->Line(287, 200, 287, 185);
    }
}
