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
        $net_amount = 0;
        $tot_taxable_amount = 0;
        $vat_amount = 0;
        $cash_rendered = 0;
        $disc_amount = 0;
        $total = 0;
        $beg_total_sum = 0;
        $totalcost = collect($printbetweendate)->count();
        ?>
        <?php foreach($printbetweendate as $print):
        $gross_total += $print->gross_amount;
        $tot_taxable_amount += $print->tot_taxable_amount;
        $net_amount += $print->net_amount;
        $vat_amount += $print->vat_amount;
        $disc_amount += $print->disc_amount;
        $beg_total_sum += $print->net_amount;
        ?>
        <?php endforeach; ?> 

        <?php
        foreach($qty as $total_qty)
        $total += $total_qty->sale_qty
        ?>

        <table style="font-family: Times new roman;">
        <tbody>
        <tr>
            <td colspan="9">
                Date From:<br>
                Date To:<br>
                Register<br>Date/Time:<br>
                Register #:<br>
                Location #:<br>
                Terminal #:<br>
                Operator:<br>
            </td>
            <td colspan="3" >
                {{$date_from}}<br>
                {{$date_to}}<br>
                <?= date("d-m-Y H:i:s", time()); ?><br>
                000000101<br>
                Tarlac City<br>
                All<br>
                All<br>
            </td>
        </tr>
        <tr>
			<td colspan="12" class="top"></td>
		</tr>
        <tr>
            <td colspan="8" style="font-family: Monospaced sans-serif;">
                Beginning SI#: <br>
                Ending SI#:<br>
            </td>
            <td colspan="4" >
                {{$beginning}}<br>
                {{$ending}}<br>
            </td>
        </tr>
        <tr>
			<td colspan="12" class="top"></td>
		</tr>
        <tr>
            <td colspan="9">
                Beginning:<br>
                Today: <br>
                Ending:<br>
            </td>
            <td colspan="3" >
                
                {{number_format($beg_total_sum,2)}}<br>
                {{number_format($net_amount,2)}}<br>
                {{number_format($net_amount + $beg_total_sum,2)}}<br>
            </td>
        </tr>
        <tr>
			<td colspan="12" class="top"></td>
		</tr>
        <tr>
            <td colspan="9">
                GROSS Sales: <br>
                Net Sales :<br>
            </td>
            <td colspan="3" >
                {{number_format($gross_total,2)}}<br>
                {{number_format($net_amount,2)}}<br>
            </td>
        </tr>
        <tr>
			<td colspan="12" class="top"></td>
		</tr>
        <tr>
            <td colspan="9">
                Total Cancel: <br>
                Canceled Sales: <br>
            </td>
            <td colspan="3" >
                {{number_format(0.00,2)}}<br>
                {{number_format(0.00,2)}}<br>
            </td>
        </tr>
        <tr>
			<td colspan="12" class="top"></td>
		</tr>
        <tr>
            <td colspan="9">
                S.C Discount: <br>
            </td>
            <td colspan="3" >
                {{number_format($disc_amount,2)}}<br>
            </td>
        </tr>
        <tr>
			<td colspan="12" class="top"></td>
		</tr>
        <tr>
            <td colspan="9">
                Vat Sales:<br>
                12 % Vat: <br>
                Vat Exempt Sales:<br>
                Vat Zero Rated: <br>
            </td>
            <td colspan="3" >
                {{number_format($net_amount,2)}}<br>
                {{number_format($vat_amount,2)}}<br>
                {{number_format(0.00,2)}}<br>
                {{number_format(0.00,2)}}<br>
            </td>
        </tr>
        <tr>
			<td colspan="12" class="top"></td>
		</tr>
        <tr>
            <td colspan="9">
                TOTAL CASH: <br>
                GRAND TOTAL: <br>
                Total Qty Sold: <br>
                Transaction Count: <br>
            </td>
            <td colspan="3" >
                {{number_format($net_amount,2)}}<br>
                {{number_format($net_amount,2)}}<br>
                {{number_format($total)}}<br>
                {{number_format($totalcost)}}<br>
            </td>
        </tr>
        <tr>
			<td colspan="12" class="top"></td>
		</tr>
        <tr>
            <td colspan="12">
                No Cash Out<br>
            </td>
        </tr>
        <tr>
			<td colspan="12" class="top"></td>
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