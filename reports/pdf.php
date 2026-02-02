<?php
require '../middleware/auth.php';
require '../config/database.php';
if ($_SESSION['user']['role'] !== 'admin') die("Akses ditolak.");

require '../vendor/autoload.php';
use Dompdf\Dompdf;

$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
if ($from==='' || $to==='') die("Periode tidak lengkap.");

$fromSafe = $conn->real_escape_string($from);
$toSafe = $conn->real_escape_string($to);

$data = $conn->query("
  SELECT b.*, r.name AS room_name
  FROM bookings b JOIN rooms r ON b.room_id=r.id
  WHERE b.date BETWEEN '$fromSafe' AND '$toSafe'
  ORDER BY b.date ASC, b.start_time ASC
");

$html = "
<h2 style='text-align:center;margin:0;'>LUMIERE</h2>
<p style='text-align:center;margin:6px 0 18px;'>Laporan Pemesanan Ruangan</p>
<p>Periode: <b>$fromSafe</b> s.d. <b>$toSafe</b></p>
<table width='100%' border='1' cellspacing='0' cellpadding='6'>
  <tr>
    <th>Ruangan</th><th>Tanggal</th><th>Waktu</th><th>Kegiatan</th><th>PJ</th><th>Status</th>
  </tr>
";

while($r = $data->fetch_assoc()){
  $time = $r['start_time']." - ".$r['end_time'];
  $html .= "<tr>
    <td>".htmlspecialchars($r['room_name'])."</td>
    <td>".htmlspecialchars($r['date'])."</td>
    <td>".htmlspecialchars($time)."</td>
    <td>".htmlspecialchars($r['title'])."</td>
    <td>".htmlspecialchars($r['person_in_charge'])."</td>
    <td>".htmlspecialchars($r['status'])."</td>
  </tr>";
}
$html .= "</table>";

$pdf = new Dompdf();
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'landscape');
$pdf->render();
$pdf->stream("lumiere_laporan.pdf");
