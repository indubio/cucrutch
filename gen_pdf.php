<?php
//============================================================+
// File name   : gen_pdf.php
// Begin       : 2017-04-10
// Last Update : 2017-04-10
//
// Description : generiert ein PDF nach CUBUS Standard
//
// Author: Steffen Eichhorn
//
// (c) Copyright:
//               Steffen Eichhorn aka indUbio
//               mail@indubio.org
//============================================================+

// Include the main TCPDF library
require_once('tcpdf/tcpdf.php');


function html_txt($txt){
    $linebr = array("<br>", "&#13", "<br/>", "\n");
    return str_replace($linebr, "<br />", $txt);
}


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Klinikum Ernst von Bergmann');
$pdf->SetTitle('Arztbericht');
$pdf->SetSubject('Unfallmeldung');
$pdf->SetKeywords('Artzbericht, Unfall, cubus');

// set default header data
$header_string  = "Name: ".$_POST["vers_name"]."\n";
$header_string .= "Vorname: ".$_POST["vers_vorname"]."\n";
$header_string .= "Geburtsdatum: ".$_POST["vers_gebdatum"]."\n";
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->SetHeaderData('', '', '', $header_string, array(0,0,0), array(0,0,0));
//$pdf->setPrintHeader(false);
$pdf->setFooterData(array(0,0,0), array(0,0,0));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_DATA));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/de.php')) {
	require_once(dirname(__FILE__).'/lang/de.php');
	$pdf->setLanguageArray($l);
}

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 10, '', true);

$posrow1 = 20;
$posrow2 = 35;

$pdf->AddPage();

//UE Unfallereignis
$y = $pdf->getY();
$content = "<b>UE Unfallereignis</b><br>";
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "<u><b>UE</b></u>", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "<u><b>Unfallereignis</b></u>", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//UE1
$y = $pdf->getY();
$content = "Datum/ Uhrzeit: ".$_POST["ue1"];
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "UE 1", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, $content, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//UE2
$y = $pdf->getY();
$content = html_txt($_POST["ue2_txt"]);
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "UE 2", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Unfallursache/-hergang:", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $content, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//UE3
$y = $pdf->getY();
$content = html_txt($_POST["ue3_txt"]);
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "UE 3", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Wer hat diese Angaben gemacht (Name und Anschrift)", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $content, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//UE4
$y = $pdf->getY();
$answer = $_POST["ue4_r"];
$content = html_txt($_POST["ue4_txt"]);
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "UE 4", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Berufsunfall?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
if ($answer == "ja"){
    $pdf->writeHTMLCell(0, 0, $posrow2, '', $content, 0, 1, 0, true, '', true);
}
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//EB Erstbefund
$y = $pdf->getY();
$content = "<b>EB Erstbefund</b><br>";
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "<u><b>EB</b></u>", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "<u><b>Erstbefund</b></u>", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//EB1
$y = $pdf->getY();
$content = $_POST["eb1_txt"];
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "EB 1", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Subjektive Angaben über Schmerzen und Funktionsstörungen:", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $content, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//EB2
$y = $pdf->getY();
$content = $_POST["eb2_txt"];
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "EB 2", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Objektiver Befund der ersten Untersuchung durch Sie:", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $content, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//EB3
$answer = $_POST["eb3_r"];
$content = html_txt($_POST["eb3_txt"]);
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "EB 3", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Lagen zum Zeitpunkt des Unfallereignisses Krankheiten und/ oder Gebrechen vor?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', "(z.B. degenerative Veränderungen bzw. Folgen aus früheren Unfällen)", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
if ($answer == "ja"){
    $pdf->writeHTMLCell(0, 0, $posrow2, '', "Welche? Seit wann?", 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, $posrow2, '', $content, 0, 1, 0, true, '', true);
}
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//EB4
$answer = $_POST["eb4_r"];
$content = html_txt($_POST["eb4_txt"]);
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "EB 4", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Gibt es Anzeichen, das zum Zeitpunkt des Unfallereignisses bereits eine Pflegebedürftigkeit bestanden hat?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
if ($answer == "ja"){
    $pdf->writeHTMLCell(0, 0, $posrow2, '', "Welche?", 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, $posrow2, '', $content, 0, 1, 0, true, '', true);
}
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

$answer = $_POST["eb4_ps_r"];
$content = html_txt($_POST["eb4_ps_txt"]);
$pdf->writeHTMLCell(0, 0, $posrow2, '', "War zum Zeitpunkt des Unfalls bereits eine Pflegestufe anerkannt?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
if ($answer == "ja"){
    $pdf->writeHTMLCell(0, 0, $posrow2, '', "Pflegestufe: ".$content, 0, 1, 0, true, '', true);
}
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//EB5
$answer = $_POST["eb5_r"];
$content = html_txt($_POST["eb5_txt"]);
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "EB 5", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Lagen Anzeichen von Alkohol-, Medikamenten- oder Rauschmitteleinfluss vor?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
if ($answer == "ja"){
    $pdf->writeHTMLCell(0, 0, $posrow2, '', "Welche Anzeichen / Ausfallerscheinungen wurden beobachtet?", 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, $posrow2, '', $content, 0, 1, 0, true, '', true);
}
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

$answer = $_POST["eb5_blut_r"];
$content_wert = html_txt($_POST["eb5_blut_wert_txt"]);
$content_mv = html_txt($_POST["eb5_blut_mv_txt"]);
$content_zeit = html_txt($_POST["eb5_blut_zeit_txt"]);
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow2, '', "Wurde eine Blutprobe entnommen?&nbsp;".$answer, 0, 1, 0, true, '', true);
if ($answer == "ja"){
    $pdf->writeHTMLCell(0, 0, $posrow2, '', "Wert (BAK o.ä.):&nbsp;".$content_wert, 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, $posrow2, '', "Messverfahren:&nbsp;".$content_mv, 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, $posrow2, '', "Zeitpunkt der Blutentnahme:&nbsp;".$content_zeit, 0, 1, 0, true, '', true);
}
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//EB6
$answer = $_POST["eb6_r"];
$content = html_txt($_POST["eb6_txt"]);
$content_art = html_txt($_POST["eb6_bewusst_txt"]);
$content_ursache = html_txt($_POST["eb6_ursachen_txt"]);
$answer_krankheit = html_txt($_POST["eb6_krankheit_r"]);
$content_krankheit = html_txt($_POST["eb6_krankheit_txt"]);
$content_behandlung = html_txt($_POST["eb6_behandlung_txt"]);
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "EB 6", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Lagen Anzeichen für eine Bewußtseinsstörung vor?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);
if ($answer == "ja"){
    $pdf->writeHTMLCell(0, 0, $posrow2, '', "Welche Art von Bewußtseinsstörung lag vor?", 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, $posrow2, '', $content_art, 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, $posrow2, '', "Was war die Ursache für die Bewußtseinsstörung?", 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, $posrow2, '', $content_ursache, 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, $posrow2, '', "Lagen Anzeichen für eine Krankheit als Ursache vor?", 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, $posrow2, '', $answer_krankheit, 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);
    if ($answer_krankheit == "ja"){
      $pdf->writeHTMLCell(0, 0, $posrow2, '', "Welche?", 0, 1, 0, true, '', true);
      $pdf->writeHTMLCell(0, 0, $posrow2, '', $content_krankheit, 0, 1, 0, true, '', true);
      $pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);
      $pdf->writeHTMLCell(0, 0, $posrow2, '', "Wann und bei welchem Arzt haben deshalb Behandlungen stattgefunden?", 0, 1, 0, true, '', true);
      $pdf->writeHTMLCell(0, 0, $posrow2, '', $content_behandlung, 0, 1, 0, true, '', true);
      $pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);
    }
}

//FB Behandlungsmaßnahmen / Heilverfahren / Letzter Befund
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "<u><b>FB</b></u>", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "<u><b>Behandlungsmaßnahmen / Heilverfahren / Letzter Befund</b></u>", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//FB1
$answer = $_POST["fb1"];
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "FB 1", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Behandlungsbeginn bei Ihnen", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//FB2
$answer = $_POST["fb2_txt"];
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "FB 2", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Behandlungsmaßnahmen / Heilverfahren", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//FB3
$answer = $_POST["fb3_txt"];
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "FB 3", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Derzeitige subjektive Beschwerden der versicherten Person", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//FB4
$answer = $_POST["fb4_txt"];
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "FB 4", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Letzter objektiver Befund", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//FB5
$answer = $_POST["fb5"];
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "FB 5", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Wann ist dieser Befund erhoben worden?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//FB6
$answer = $_POST["fb6_txt"];
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "FB 6", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Ist die Behandlung abgeschlossen, ggf. wann oder wann vorraussichtlich?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//FB7
$answer = $_POST["fb7_txt"];
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "FB 7", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Vor- oder Weiterbehandlung? Durch wen?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//DI Diagnose
$answer = $_POST["di_txt"];
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "<u><b>DI</b></u>", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "<u><b>Wie lautet Ihre Diagnose?</b></u>", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//KM Kausalität und Mitwirkung</legend>
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "<u><b>KM</b></u>", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "<u><b>Kausalität und Mitwirkung</b></u>", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//KM1
$answer = $_POST["km1_txt"];
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "KM 1", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Sind diese Gesundheitsschäden ausschließlich durch das geschilderte Ereignis verursacht worden?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//KM2
$answer = $_POST["km2_txt"];
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "KM 2", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Lagen zum Zeitpunkt des Unfalllereignisses Krankheiten und/ oder Gebrechen bzw. Folgen aus früheren Unfällen vor?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', "Welche? Seit wann?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//KM3
$answer = $_POST["km3"];
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "KM 3", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Bitte bemessen Sie den unfallunabhängigen Anteil an der Gesundheitsschädigung oder deren Folgen in Prozent", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//HB Hirnbeteilung
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "<u><b>HB</b></u>", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "<u><b>Hirnbeteiligung</b></u>", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

$answer = $_POST["hb_r"];
$content_art = html_txt($_POST["hb_art_txt"]);
$content_anzeichen = html_txt($_POST["hb_anzeichen_txt"]);
$content_ursache = html_txt($_POST["hb_ursachen_txt"]);
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow2, '', "Lagen Zeichen einer Hirnbeteiligung (Kontusion, Blutung) vor?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);
if ($answer == "ja"){
    $pdf->writeHTMLCell(0, 0, $posrow2, '', "Welche Art der Hirnbeteiligung?", 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, $posrow2, '', $content_art, 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, $posrow2, '', "Welche Anzeichen?", 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, $posrow2, '', $content_anzeichen, 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, $posrow2, '', "Auf welche Ursachen ist die Hirnblutung ganz oder überwiegend zurückzuführen?", 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, $posrow2, '', $content_ursache, 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);
}

//PR Prognose
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "<u><b>PR</b></u>", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "<u><b>Prognose</b></u>", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//PR1
$answer = $_POST["pr1_r"];
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "PR 1", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Wird der Unfall vorraussichtlich zu einer dauernden Beeinträchtigung der körperlichen oder geistigen Leistungsfähigkeit führen?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//PR2
$answer = $_POST["pr2_txt"];
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "PR 2", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Welche Beeinträchtigungen sind zu erwarten?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//PR2
$answer = $_POST["pr3"];
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "PR 3", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Wann kann der Invaliditätsgrad bemessen werden?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);


//SB Abschluss des Berichts
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "<u><b>SB</b></u>", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "<u><b>Abschluss des Berichts</b></u>", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//SB1
$answer = $_POST["sb1_r"];
$content = html_txt($_POST["sb1_txt"]);
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "SB 1", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Haben Sie einer anderen weiteren privaten oder gesetzlichen Unfallversicherung, Krankenversicherung oder anderen Versicherungsgesellschaften Auskunft über diesen Unfall gegeben?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
if ($answer == "ja"){
    $pdf->writeHTMLCell(0, 0, $posrow2, '', "Namen, Aktenzeichen, Anschrift:", 0, 1, 0, true, '', true);
    $pdf->writeHTMLCell(0, 0, $posrow2, '', $content, 0, 1, 0, true, '', true);
}
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//SB2
$answer = $_POST["sb2_r"];
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "SB 2", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Stehen der Aushändigung dieses Berichts an die verletzte Person medizinische Gründe entgegen?", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//SB3
$answer = $_POST["sb3_txt"];
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "SB 3", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Fügen Sie bitte ggf. Arztbriefe, Entlassungsberichte bei:", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, '', $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

//SB4
$answer = $_POST["sb4_txt"];
$y = $pdf->getY();
$pdf->writeHTMLCell(0, 0, $posrow1, $y, "SB 4", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, "Bemerkungen:", 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, $posrow2, $y, $answer, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, '', '', "<br />", 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('cubus_meldung.pdf', 'I');
