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
        .top{
			border-top: 1px solid black;
            margin-top: 10%;
            margin-bottom: 10%;
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
			<td colspan="12" class="header report_header" style="font-family: Times new roman;">
				<h2><center>ButterWorld Bakeshop</center></h2>
            </td>
        </tr>
        <tr>
            <td colspan="12"><h6><center>Tarlac City</center></h6></td>
        </tr>
        <tr>
            <td colspan="12"><h6><center>MIN:&nbsp;0000000</center></h6></td>
        </tr>
        <tr>
            <td colspan="12"><h6><center>SN#:&nbsp;0000000</center></h6></td>
        </tr>
        <tr>
			<td colspan="12" class="top"></td>
		</tr>
        </thead>
    </table>
        <br>
        <?php 
        $gross_total = 0; 
        // $net_amount = 0;
        // $tot_taxable_amount = 0;
        // $vat_amount = 0;
        // $cash_rendered = 0;
        // $disc_amount = 0;
        // $totalcost = collect($printbetweendate)->count();
        ?>
        <?php foreach($date as $d):
        // $gross_total += $print->gross_amount;
        // $tot_taxable_amount += $print->tot_taxable_amount;
        // $net_amount += $print->net_amount;
        // $vat_amount += $print->vat_amount;
        // $disc_amount += $print->disc_amount;
        ?>
        <?php endforeach; ?> 

        <table>
        <tbody>
        <tr>
            <td colspan="9">
                Total Debit<br>
                &emsp;Cash<br>
                Total Cash<br>
                Grand Total<br>
            </td>
            <td colspan="3" >
                0.00<br>
                0.00<br>
                0.00<br>
                0.00<br>
            </td>
        </tr>
        <tr>
			<td colspan="12" class="top"></td>
		</tr>
        <tr>
            <td colspan="9" style="font-family: Monospaced sans-serif;">
                Beginning OR#: <br>
                Ending OR#<br>
                Beginning<br>
                Todays <br>
                Ending<br>
            </td>
            <td colspan="3" >
                {{$beginningOR}}<br>
                {{$endingOR}}<br>
                {{number_format($beginning,2)}}<br>
                {{number_format($today,2)}}<br>
                {{number_format($beginning + $today,2)}}<br>
            </td>
        </tr>
        <tr>
			<td colspan="12" class="top"></td>
		</tr>
        <tr>
            <td colspan="9">
                Total Cancel<br>
                Canceled Sales<br>
            </td>
            <td colspan="3" >
                {{number_format(0.00,2)}}<br>
                {{number_format(0.00,2)}}<br>
            </td>
        </tr>
    </tbody>
    </table>
    <br>
    <table>
        <tbody>
		<tr>
            <td colspan="9">Prepared by :</td>
            <td colspan="3">Name</td>
        </tr>
        </tbody>
	</table>

</div>
</body>
</html>