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
        $net_total = 0;
        $tot_taxable_amount = 0;
        $vat_amount = 0;
        $cash_rendered = 0;
        $totalcost = collect($printbetweendate)->count();
        foreach($printbetweendate as $print)
        $gross_total += $print->gross_amount
        ?>
        <?php
        foreach($printbetweendate as $print)
        $net_total += $print->net_amount
        ?>
        <?php
        foreach($printbetweendate as $print)
        $tot_taxable_amount += $print->tot_taxable_amount
        ?>
        <?php
        foreach($printbetweendate as $print)
        $vat_amount += $print->vat_amount
        ?>
        <?php
        foreach($printbetweendate as $print)
        $cash_rendered += $print->cash_rendered
        ?>

        

        <tr>
            
            <td>Date From: <br>
                Date To:<br>
                Register Time:<br>
                Register #:<br>
                Location #:<br>
                Terminal #:<br>
                Operator:<br>
                <hr><br>
                Beginning SI#: <br>
                Ending SI#:<br>
                <hr>
                Beginning:<br>
                Today:<br>
                Ending:<br>
                <hr>
                GROSS Sales: {{$gross_total}}<br>
                Net Sales: {{$net_total}}<br>
                <hr><br>
                Total Cancel: <br>
                Canceled Sales: <br>
                <hr>
                S.C Discount:<br>
                <hr>
                Vat Sales: <br>
                12 % Vat: <br>
                Vat Exempt Sales: <br>
                Vat Zero Rated: <br>
                <hr><br>
                TOTAL CASH: <br>
                GRAND TOTAL: <br>
                Total Qty Sold: <br>
                Transaction Count: {{$totalcost}}<br>
                <hr>
                No Cash Out
            </td>
        </tr>
    
        {{-- <tr>
            <td>Client Name</td>
            <td><b>Juan Dela Cruz</b></td>
        </tr> --}}
    </thead>
    
    </table>
    <hr>
    
    <table>
		<tr>
			<td >Prepared by : &emsp;&emsp;</td>
            
		</tr>
				
		
	</table>

    {{-- <table>
        <tr>
            <td><b>Item(s)</b></td>
            <td><b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;PHP</b></td>
        </tr>
        <tr><td colspan="2"><hr></td></tr>
        
    </table>
    <hr>

    <table>
        <tr>
            <td>Name : ____________________________</td>
        </tr>
        <tr>
            <td>Address : __________________________</td>
            
        </tr>
        <tr>
            <td><span>TIN : _______________________________</span></td>
        </tr>
        <tr>
            <td><span>Business Style : ____________________</span></td>
        </tr>
    </table>
    <hr> --}}

</div>
</body>
</html>