<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body{
        font-family: "Rubik", sans-serif;
    }
    td{
        padding: 5px 5px;
        width: 25%;
        font-size: 13px;
    }
    .inner-table-amount{
        width: 100%;
        border-collapse: collapse;
    }
    .inner-table-amount td{
        width: 50%;
        width: 100%;
        border: 1px dashed black;
    }
    .invoice-name{
        font-size: 22px;
        font-weight: bold;
    }
    .main-bold-txt{
        font-weight: 700;
    }
    span{
        font-weight: normal;
    }
    .amount-box{
        border: 1px solid black;
        padding: 5px 5px;
        min-width: 90px;
        display: inline-block;
    }
    .small-area{
        display: inline-block;
        width: 120px;
        padding-left: 5px;
        border-bottom: 1px solid black;
        margin: 0px;
    }
    .large-area{
        display: inline-block;
        width: 400px;
        padding-left: 5px;
        border-bottom: 1px solid black;
        margin: 0px;
    }
</style>
<body>
    <table style="border: 1px solid black; width: 100%;">
        <tr>
            <td colspan="4" class="invoice-name">
              
            </td>
        </tr>
        <tr>
            <td colspan="2" style="height: 25px;"></td>
            <td>
                <span>Date:</span>  &emsp;
                {{$invoice->date}}
                <!-- <span>_________________</span> -->
            </td>
            <td>
                <span>No:</span>  &emsp;
                <span class="small-area">{{$invoice->invoice_no}}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="main-bold-txt">Amount:</span>  &emsp;
                <span class="amount-box">Rs {{$invoice->account_amt}}</span>
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 10%;"></td>
                        <td style="width: 90%;">
                            <span>Amount:</span>  &emsp;
                            {{$invoice->amount_in_word}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 10%;"></td>
                        <td style="width: 25%;">
                            <span>from:</span>  &emsp;
                            {{$invoice->from_date}}
                           
                        </td>
                        <td style="width: 25%;">
                            <span>to:</span>  &emsp;
                            <span class="small-area">{{$invoice->to_date}}</span>
                        </td>
                        <td style="width: 40%;">
                            <span>Paid by:</span>  &emsp;
                            <span class="small-area" style="width: 160px;">{{$invoice->paid_by}}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span class="main-bold-txt">Received by:</span>  &emsp;
                <span>____________________________________</span>
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 20%;"></td>
                        <td style="width: 80%;">
                            <span>Name :</span> 
                            &emsp;
                            {{$invoice->stud_id}}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%;"></td>
                        <td style="width: 80%;">
                            <span>Address :</span>  &emsp;
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%;"></td>
                        <td style="width: 80%;">
                            <span>Phone :</span>
                            {{$invoice->phone}}  &emsp;
                        </td>
                    </tr>
                </table>
            </td>
            <td colspan="2">
                <table class="inner-table-amount">
                    <tr>
                        <td style="width: 50%;">
                            <span>Account Amt</span>
                        </td>
                        <td style="width: 50%;">
                        {{$invoice->account_amt}}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">
                            <span>Paid Amt</span>
                        </td>
                        <td style="width: 50%;">
                        {{$invoice->paid_amount}}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">
                            <span>Balance Amt</span>
                        </td>
                        <td style="width: 50%;">
                            <span>Rs {{$invoice->balance_amount}}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</body>
</html>