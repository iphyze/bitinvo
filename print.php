<?php
require('fpdf/pdf_js.php');
include_once('includes/connection.php');

//if(!isset($_SESSION['username']) || $_SESSION['username'] == ''){
       // header('location:login.php');
//}

if(isset($_GET['invoice']) && $_GET['invoice'] != ""){
    $invoice_id = $_GET['invoice'];
}else{
    header('location:invoice.php');
}



class PDF_AutoPrint extends PDF_JavaScript
{
    function AutoPrint($printer='')
    {
        // Open the print dialog
        if($printer)
        {
            $printer = str_replace('\\', '\\\\', $printer);
            $script = "var pp = getPrintParams();";
            $script .= "pp.interactive = pp.constants.interactionLevel.full;";
            $script .= "pp.printerName = '$printer'";
            $script .= "print(pp);";
        }
        else
            $script = 'print(true);';
        $this->IncludeJS($script);
    }
    
// Page header
function Header()
{
    
    $this->AddFont('Montserrat-Regular','','Montserrat-Regular.php'); //Regular

    $this->AddFont('Montserrat-Bold','','Montserrat-Bold.php'); //Bold
    
    $this->SetFont('Montserrat-Bold','',15);
    
    $this->SetY (15);


    //Set Font to Calribi, Bold, 14pt
    $this -> SetFont('Montserrat-Bold', '', '14');

    //Cell (Width, Height, Text, Border, End Line, Align)
    $this -> Cell(130, 7, 'CHIDON GLOBAL - TECH ENTERPRISES ', 0, 0);

    global $db;
    global $invoice_id;

    $choose = mysqli_query($db, "SELECT * FROM invoice_table WHERE invoice_number = '$invoice_id'");
    $chosen = mysqli_fetch_assoc($choose);

    $inv_name = $chosen['customer_name'];
    $inv_project = $chosen['project'];
    $inv_po_number = $chosen['po_number'];
    $inv_date = date('d M, Y | h:i a', strtotime($chosen['created_at']));
    $inv_created_by = $chosen['created_by'];

    //Set Font to Calribi, Bold, 14pt
    $this -> SetFont('Montserrat-Regular', '', '8');
    $this -> Cell(59, 7, 'Date: '. $inv_date, 0, 1, 'R'); //end of line

    //Set Font to Calribi, Bold, 8pt
    $this -> SetFont('Montserrat-Regular', '', '8');
    $this -> Cell(130, 7, 'Office: 42, Idoluwo Street, Lagos Island | Email: uzomaemmanuel29@yahoo.com', 0, 0);

    //Set Font to Calribi, Bold, 14pt
    $this->SetTextColor(52, 223, 136);
    $this -> SetFont('Montserrat-Bold', '', '10');
    $this -> Cell(59, 7, 'SALES INVOICE # : '. $invoice_id, 0, 1, 'R'); //end of line

    //Set Font to Calribi, Bold, 14pt
    $this-> SetTextColor(60, 60, 60);
    $this -> SetFont('Montserrat-Regular', '', '8');
    $this -> Cell(130, 7, 'Tel: .234 8023 001 097, +234 8098 380 672', 0, 0);

    //Set Font to Calribi, Bold, 14pt
    $this -> SetFont('Montserrat-Regular', '', '10');
    $this -> Cell(59, 7, 'P.O. #: ' . $inv_po_number, 0, 1, 'R'); //end of line

    $this->SetY (35);


    //Set Font to Calribi, Bold, 14pt
    $this -> SetFont('Montserrat-Bold', '', '10');
    $this->  SetTextColor(60, 60, 60);
    $this -> Cell(59, 7, 'Billed To', 0, 0, 'L'); //end of line

    $this->SetTextColor(60, 60, 60);
    $this -> SetFont('Montserrat-Bold', '', '7');
    $this -> Cell(70, 7, '', 0, 0, 'L'); //end of line
    $this -> Cell(59, 7, "Page " . $this->PageNo(), 0, 1, 'R'); //end of line

    //Set Font to Calribi, Bold, 14pt
    $this -> SetFont('Montserrat-Bold', '', '9');
    $this -> Cell(59, 7, $inv_name, 0, 1, 'L'); //end of line

    $this -> Cell(59, 7, $inv_project, 0, 1, 'L'); //end of line

    $this->SetY (58);
}

// Page footer
function Footer()
{
    $this->SetXY (5,-25);
    $this -> SetFont('Montserrat-Regular', '', '6');
    $this->Cell(0, 3, "Page " . $this->PageNo(), 0, 1, 'R');
}
}


$pdf = new FPDF('P', 'mm', 'A4');

$pdf = new PDF_AutoPrint();

$pdf->  AliasNbPages();

$pdf -> AddPage();

$pdf->AddFont('Montserrat-Regular','','Montserrat-Regular.php'); //Regular

$pdf->AddFont('Montserrat-Bold','','Montserrat-Bold.php'); //Bold



//Set Font to Calribi, Bold, 14pt
$pdf -> SetFont('Montserrat-Bold', '', '8');
$pdf->SetFillColor(52, 223, 136);
$pdf->SetTextColor(60, 60, 60);
$pdf -> Cell(30, 8, 'CODE', 0, 0, 'L', true);

$pdf->SetFillColor(52, 223, 136);
$pdf -> Cell(75, 8, 'DESCRIPTION OF GOODS', 0, 0, 'L', true);

$pdf->SetFillColor(52, 223, 136);
$pdf -> Cell(15, 8, 'QTY', 0, 0, 'C', true);

$pdf->SetFillColor(52, 223, 136);
$pdf -> Cell(20, 8, 'RATE', 0, 0, 'L', true);

$pdf->SetFillColor(52, 223, 136);
$pdf -> Cell(10, 8, 'VAT', 0, 0, 'L', true);

$pdf->SetFillColor(52, 223, 136);
$pdf -> Cell(10, 8, 'DISC', 0, 0, 'L', true);

$pdf->SetFillColor(52, 223, 136);
$pdf -> Cell(30, 8, 'AMOUNT', 0, 0, 'R', true);

$pdf->SetY (65);

$get_new_inv_table = mysqli_query($db, "SELECT * FROM new_invoice_table WHERE invoice_number = '$invoice_id'");
$gotten_new_inv_table = mysqli_fetch_array($get_new_inv_table);
$inv_details = $gotten_new_inv_table;
$sub_total = 0;
$net_total = 0;
$inv_vat = 0;
$discount_total = 0;
$total = 0;
$inv_other_charges = 0;
$inv_vat_total = 0;

foreach($get_new_inv_table as $inv_details){
$inv_code_small = $inv_details['product_code'];
$inv_code = substr($inv_code_small, 0, 21);
$inv_description_small = $inv_details['product_description'];
$inv_description = substr($inv_description_small, 0, 65) . ' ...';
$inv_qty = $inv_details['product_quantity'];
$inv_price = number_format($inv_details['product_price'], 2);
$inv_discount = $inv_details['discount'] . '%';
$inv_vat = ($inv_details['vat']) . '%';
$inv_created_by = $inv_details['created_by'];
$total = $inv_details['product_quantity'] * $inv_details['product_price'];

$discount_total = $discount_total + ($total * $inv_details['discount']/100);

$inv_vat_total = $inv_vat_total + ($total - ($inv_details['discount_figure'])) * ($inv_details['vat']/100);

if($inv_details['vat'] == 0){
    $inv_other_charges = $inv_other_charges + ($inv_details['product_quantity'] * $inv_details['product_price']);
}else{
    $sub_total = $sub_total + ($inv_details['product_quantity'] * $inv_details['product_price']);
}

$inv_total = number_format($inv_details['total'], 2);

$net_total = ($sub_total - $discount_total) + $inv_other_charges + $inv_vat_total;

$pdf -> SetFont('Montserrat-Regular', '', '6');
$pdf->  SetTextColor(8, 8, 8);
$pdf -> Cell(30, 8, $inv_code, 0, 0);
$pdf -> Cell(75, 8, $inv_description, 0, 0);
$pdf -> Cell(15, 8, $inv_qty, 0, 0, 'C');
$pdf -> Cell(20, 8, $inv_price, 0, 0);
$pdf -> Cell(10, 8, $inv_vat, 0, 0);
$pdf -> Cell(10, 8, $inv_discount, 0, 0);
$pdf -> Cell(30, 8, $inv_total, 0, 1, 'R');
}

$pdf->Ln();

//Subtotal
$pdf -> SetFont('Montserrat-Bold', '', '7');
$pdf -> Cell(105, 7, 'KINDLY MAKE YOUR PAYMENTS INTO: ', 0, 0);

$pdf -> SetFont('Montserrat-Bold', '', '7');
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$pdf -> Cell(55, 7, 'SUB-TOTAL', 0, 0, 'R', true);

$pdf->SetTextColor(60, 60, 60);
$pdf->SetFillColor(127, 253, 162);
$pdf -> SetFont('Montserrat-Bold', '', '7');
$pdf -> Cell(30, 7, number_format($sub_total, 2), 0, 1, 'R', true);



//Discount
$pdf -> SetFont('Montserrat-Regular', '', '7');
$pdf->SetTextColor(0, 0, 0);
$pdf -> Cell(105, 7, 'ACCOUNT NAME: CHIDON GLOBAL - TECH ENTERPRISES', 0, 0);

$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$pdf -> SetFont('Montserrat-Bold', '', '7');
$pdf -> Cell(55, 7, 'DISCOUNT (-)', 0, 0, 'R', true);

$pdf->SetFillColor(127, 253, 162);
$pdf->SetTextColor(60, 60, 60);
$pdf -> SetFont('Montserrat-Regular', '', '7');
$pdf -> Cell(30, 7, '('. number_format($discount_total, 2). ')', 0, 1, 'R', true);



//Other Charges
$pdf -> SetFont('Montserrat-Regular', '', '7');
$pdf->SetTextColor(0, 0, 0);
$pdf -> Cell(105, 7, 'ACCOUNT NUMBER: 011145XXXX', 0, 0);

$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$pdf -> SetFont('Montserrat-Bold', '', '7');
$pdf -> Cell(55, 7, 'OTHER CHARGES (+)', 0, 0, 'R', true);

$pdf->SetFillColor(127, 253, 162);
$pdf->SetTextColor(60, 60, 60);
$pdf -> SetFont('Montserrat-Regular', '', '7');
$pdf -> Cell(30, 7, number_format($inv_other_charges, 2), 0, 1, 'R', true);



//Vat
$pdf -> SetFont('Montserrat-Regular', '', '7');
$pdf->SetTextColor(0, 0, 0);
$pdf -> Cell(105, 7, 'BANK NAME: Guaranty Trust Bank ', 0, 0);


$pdf -> SetFont('Montserrat-Bold', '', '7');
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$pdf -> Cell(55, 7, 'VAT (7.5%)', 0, 0, 'R', true);

$pdf -> SetFont('Montserrat-Regular', '', '7');
$pdf->SetFillColor(127, 253, 162);
$pdf->SetTextColor(60, 60, 60);
$pdf -> Cell(30, 7, number_format($inv_vat_total, 2), 0, 1, 'R', true);

$pdf->Ln();
//Total
$pdf -> SetFont('Montserrat-Regular', '', '7');
$pdf -> Cell(105, 7, ' ', 0, 0);

$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$pdf -> SetFont('Montserrat-Bold', '', '7');
$pdf -> Cell(55, 7, 'TOTAL (NGN)', 0, 0, 'R', true);

$pdf->SetFillColor(127, 253, 162);
$pdf->SetTextColor(0, 0, 0);
$pdf -> SetFont('Montserrat-Bold', '', '8');
$pdf -> Cell(30, 7, number_format($net_total, 2), 0, 1, 'R', true);


$pdf -> SetFont('Montserrat-Regular', '', '7');
$pdf -> Cell(130, 7, ' ', 0, 1);


$pdf->Ln();


$pdf->SetTextColor(0, 0, 0);
$pdf -> SetFont('Montserrat-Regular', '', '7');
$pdf -> Cell(95, 30, 'Created By: '. $inv_created_by, 0, 0, 'L');
$pdf -> Cell(95, 30, 'Approved By: __________________________________________', 0, 1, 'R');

$pdf -> Cell(95, 7, 'Received By: ___________________________________________', 0, 0, 'L');

$pdf->Ln();

$pdf->Cell(0, 10, 'Thanks you for doing business with us!', 0, 1, 'L');


$pdf->AutoPrint(); 

//Output the document
$pdf->Output('Invoice ' . $invoice_id . '.pdf','I'); 


?>