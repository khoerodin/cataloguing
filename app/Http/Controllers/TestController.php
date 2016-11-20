<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function String2Hex($string)
    {
	    $hex='';
	    for ($i=0; $i < strlen($string); $i++){
	        $hex .= dechex(ord($string[$i]));
	    }
	    return $hex;
	} 
 
	private function Hex2String($hex)
	{
	    $string='';
	    for ($i=0; $i < strlen($hex)-1; $i+=2){
	        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
	    }
	    return $string;
	}

	public function index()
	{
		$html = '<style>
body {
	font-family: arial;	
	text-transform: uppercase;
	font-size: 12px;
}
h1 {
	font-size: 18px; 
	font-weight: bold;
	line-height: 0.5em;
}
h2 {
	font-size: 14px; 
	font-weight: bold;
	line-height: 0.5em;
}
table {
    border: 1px solid black;
    font-size: 13px;
    border-collapse: collapse; 
}
table, tr, td, th {
	border: 1px solid black; 
}
tr.no-border td {
	border: 0;
	color: transparent;
}
.bg-grey {
	background-color: #e6e6e6;
}
table th {
	font-size: 14px;
	text-align: left;
}
.pre {
    /*white-space: pre;*/
    /*font-family: monospace;*/
}
</style>

<body>
	<!-- <img src="'.public_path('images/client_logo.jpg').'" height="60px" style="float:left;">
	<img src="'.public_path('images/client2_logo.png').'" height="60px" style="float:right;">

	<h2><center>LAPORAN HARIAN</center></h2> //-->
	<h2><center>HASIL PEKERJAAN CLEAN UP SPARE PART CATALOGUING</center></h2>
	<h1><center>PT. PETROKIMIA GRESIK INDONESIA</center></h1>
	<br>
	<table cellpadding="3" cellspacing="0" width="49.5%" style="float: left; margin-bottom: 15px;">
		<tr>
			<th class="bg-grey" colspan="2">DATA AWAL</th>
		</tr>
	</table>

	<table cellpadding="3" cellspacing="0" width="49.5%" style="float: right; margin-bottom: 15px;">
		<tr>
			<th class="bg-grey" colspan="2">HASIL PEKERJAAN</th>
		</tr>
	</table>

	<table cellpadding="3" cellspacing="0" width="49.5%" style="float: left; margin-bottom: 15px;">
		<tr>
			<td width="35%">STOCK NUMBER</td>
			<td>100001</td>
		</tr>
		<tr>
			<td>INC</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>ITEM NAME</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>GROUP CLASS</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>UNIT OF ISSUE</td>
			<td>37840</td>
		</tr>
	<table>

	<table cellpadding="3" cellspacing="0" width="49.5%" style="float: right; margin-bottom: 15px;">
		<tr>
			<td width="35%">STOCK NUMBER</td>
			<td>100001</td>
		</tr>
		<tr>
			<td>INC</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>ITEM NAME</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>GROUP CLASS</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>UNIT OF ISSUE</td>
			<td>37840</td>
		</tr>
	<table>

	<table cellpadding="3" cellspacing="0" width="49.5%" style="float: left; margin-bottom: 15px;">
		<tr>
			<td width="35%">SHORT DESCRIPTION</td>
			<td>KJHKJGKJGKJHGKJH</td>
		</tr>
	</table>

	<table cellpadding="3" cellspacing="0" width="49.5%" style="float: right; margin-bottom: 15px;">
		<tr>
			<td width="35%">SHORT DESCRIPTION</td>
			<td>KJHKJGKJGKJHGKJH</td>
		</tr>
	</table>

	<table cellpadding="3" cellspacing="0" width="49.5%" style="float: left; margin-bottom: 15px;">
		<tr>
			<th colspan="2">SOURCE DATA</th>
		</tr>
		<tr>
			<td height="302px" valign="top">'.nl2br('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum molestiae fugit, soluta sed commodi omnis perspiciatis quaerat qui ut suscipit hic possimus, vero beatae. Laudantium, perspiciatis dolorum. Praesentium, similique, harum!').'</td>
		</tr>
	<table>

	<table cellpadding="1" cellspacing="0" width="49.5%" style="float: right; margin-bottom: 15px;">
		<tr>
			<th colspan="2">CHARACTERISTICS</th>
		</tr>
		<tr>
			<td width="35%">STOCK NUMBER</td>
			<td>100001</td>
		</tr>
		<tr>
			<td>ITEM NAME</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>GROUP CLASS</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>UNIT OF ISSUE</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>ITEM NAME</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>GROUP CLASS</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>UNIT OF ISSUE</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>ITEM NAME</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>GROUP CLASS</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>UNIT OF ISSUE</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>ITEM NAME</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>GROUP CLASS</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>UNIT OF ISSUE</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>ITEM NAME</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>GROUP CLASS</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>ITEM NAME</td>
			<td>37840</td>
		</tr>
		<tr>
			<td>GROUP CLASS</td>
			<td>37840</td>
		</tr>
	<table>

	<table cellpadding="3" cellspacing="0" width="49.5%" style="float: left; margin-bottom: 15px;">
		<tr>
			<th width="33%">MAN CODE</th>
			<th width="33%">MANUFACTURER</th>
			<th width="33%">PART NUMBER</th>
		</tr>
		<tr>
			<td>MAN CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
		<tr>
			<td>MAN CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
		<tr>
			<td>MAN CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
	</table>
	<table cellpadding="3" cellspacing="0" width="49.5%" style="float: right; margin-bottom: 15px;">
		<tr>
			<th width="33%">MAN CODE</th>
			<th width="33%">MANUFACTURER</th>
			<th width="33%">PART NUMBER</th>
		</tr>
		<tr>
			<td>MAN CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
		<tr>
			<td>MAN CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
		<tr>
			<td>MAN CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
		<tr>
			<td>MAN CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
		<tr>
			<td>MAN CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
	</table>

	<table cellpadding="3" cellspacing="0" width="49.5%" style="float: left; margin-bottom: 10px;">
		<tr>
			<th width="33%">EQUIPMENT CODE</th>
			<th width="33%">MANUFACTURER</th>
			<th width="33%">PART NUMBER</th>
		</tr>
		<tr>
			<td>EQUIPMENT CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
		<tr>
			<td>EQUIPMENT CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
		<tr>
			<td>EQUIPMENT CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
		<tr>
			<td>EQUIPMENT CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
		<tr>
			<td>EQUIPMENT CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
		<tr>
			<td>EQUIPMENT CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
		<tr>
			<td>EQUIPMENT CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
	</table>
	<table cellpadding="3" cellspacing="0" width="49.5%" style="float: right; margin-bottom: 10px;">
		<tr>
			<th width="33%">EQUIPMENT CODE</th>
			<th width="33%">MANUFACTURER</th>
			<th width="33%">PART NUMBER</th>
		</tr>
		<tr>
			<td>EQUIPMENT CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
		<tr>
			<td>EQUIPMENT CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
		<tr>
			<td>EQUIPMENT CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
		<tr>
			<td>EQUIPMENT CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
		<tr>
			<td>EQUIPMENT CODE HERE</td>
			<td>MANUFACTURER NAME</td>
			<td>7H15 15 P4R7 NUMB3R</td>
		</tr>
	</table>
	
	
		<div style="font-size: 13px; text-transform: initial; font-style: italic; position: fixed; bottom: 0; left: 0;">
			Karena terbatasnya tempat, berikut data yang tidak ditampilkan secara legkap dalam lembar laporan ini: 
			<ol>
				<li>MAN CODE pada DATA AWAL</li>
				<li>EQUIPMENT CODE pada DATA AWAL</li>
				<li>MAN CODE pada HASIL PEKERJAAN</li>
				<li>EQUIPMENT CODE pada HASIL PEKERJAAN</li>
			</ol>
		</div>
		
		<div style="position: fixed; bottom: 0; right: 0;">

			<div>
			<strong>TELAH DIPERIKSA</strong>
			</div>
			<div>
			PADA TANGGAL : .....................................
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			PADA TANGGAL : .....................................
			</div>

			<div style="margin-bottom: 61px;">
			Counter Part Catalog
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Kordinator Counter Part Catalog
			</div>

			<div>
			(.......................................................................)
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			(.......................................................................)
			</div>

		</div>
</body>';
		
		$pdf = \PDF::loadHTML($html)
			->setPaper('a3')
			->setOrientation('landscape')
			->setOption('margin-top', 8)
			->setOption('margin-right', 10)
			->setOption('margin-bottom', 10)
			->setOption('margin-left', 10);
		return $pdf->inline();
	}
 
}
