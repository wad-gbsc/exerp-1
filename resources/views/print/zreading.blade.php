<!DOCTYPE html>
<html lang="ar">
<!-- <html lang="ar"> for arabic only -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>EXERP</title>
    <style>
        @media print {
            @page {
                margin: 0 auto; /* imprtant to logo margin */
                sheet-size: 300px 250mm; /* imprtant to set paper size */
            }
            html {
                direction: rtl;
            }
            html,body{margin:0;padding:0}
            #printContainer {
                width: 250px;
                margin: auto;
                /*padding: 10px;*/
                /*border: 2px dotted #000;*/
                text-align: justify;
            }

           .text-center{text-align: center;}
        }
    </style>
</head>
<body>
<div id='printContainer'>
    <br>
    <br>
   
    <table>
        <thead>
        <tr>
           	
			<td colspan="4" class="header report_header" style="font-size: 24pt; font-family: Times new roman;">
				<h6><center>ButterWorld Bakeshop</center></h6>
               <h6 style="font-size:10px;"><center>Tarlac City</center></h6>
            </td>
           
        </tr>
        <tr>
            <td> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;MIN:&nbsp;0000000 <br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;SN#:&nbsp;0000000</td>
        </tr>
        <hr>
        <br>
        <?php 
        $gross_total = 0; 
        $net_amount = 0;
        $tot_taxable_amount = 0;
        $vat_amount = 0;
        $cash_rendered = 0;
        $disc_amount = 0;
        $totalcost = collect($printbetweendate)->count();
        foreach($printbetweendate as $print)
        $gross_total += $print->gross_amount
        ?>
        <?php
        foreach($printbetweendate as $print)
        $tot_taxable_amount += $print->tot_taxable_amount
        ?>
        <?php
        foreach($printbetweendate as $print)
        $net_amount += $print->net_amount
        ?>
        <?php
        foreach($printbetweendate as $print)
        $vat_amount += $print->vat_amount
        ?>
        <?php
        foreach($printbetweendate as $print)
        $disc_amount += $print->disc_amount
        ?>
        <tr>
            <td>Date From: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{$date_from}} <br>
                Date To: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;{{$date_to}}<br>
                Register Date/Time:&emsp;&nbsp; <?= date("d/m/Y H:i:s", time()); ?><br>
                Register #:<span>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;000000101</span><br>
                Location #:<span>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;Tarlac City</span><br>
                Terminal #: <span>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;All</span><br>
                Operator: <span>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;All</span><br>
                <hr><br>
                Beginning SI#: <br>
                Ending SI#:<br>
                <hr>
                Beginning:<br>
                Today: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;{{number_format($net_amount,2)}}<br>
                Ending:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{number_format($net_amount,2)}}<br>
                <hr>
                GROSS Sales: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{number_format($gross_total,2)}}<br>
                Net Sales :&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;{{number_format($net_amount,2)}}<br>
                <hr><br>
                Total Cancel:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;{{number_format(0.00,2)}} <br>
                Canceled Sales: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;{{number_format(0.00,2)}}<br>
                <hr>
                S.C Discount:  &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;{{number_format($disc_amount,2)}}<br>
                <hr>
                Vat Sales: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{number_format($net_amount,2)}} <br>
                12 % Vat: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;{{number_format($vat_amount,2)}}<br>
                Vat Exempt Sales:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{number_format(0.00,2)}} <br>
                Vat Zero Rated:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;{{number_format(0.00,2)}}<br>
                <hr><br>
                TOTAL CASH: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;{{number_format($net_amount,2)}}<br>
                GRAND TOTAL: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{number_format($net_amount,2)}}<br>
                Total Qty Sold: <br>
                Transaction Count:&emsp;&emsp;&emsp;&emsp;&emsp; {{number_format($totalcost)}}<br>
                <hr>
                No Cash Out
            </td>
        </tr>
    </thead>
    
    </table>
    <hr>
    
    <table>
		<tr>
			<td >Prepared by :</td>
		</tr>
	</table>

</div>
</body>
</html>