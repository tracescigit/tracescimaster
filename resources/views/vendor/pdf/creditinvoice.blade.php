<html>
<head>
  <style>
    @font-face{
        font-family: 'Raleway';
        src: url("{{asset('dist/fonts/Raleway/Raleway-Regular.ttf')}}") format('truetype');
        }
        * {
          font-size: 13px;
      }
      body{
          margin: 0 5%;
          font-family: 'Raleway', sans-serif;
      }
      .header-div {
          display: flex;
          justify-content: space-between;
      }
      .logo-div {
          margin: auto;
          width: 120px;
      }
      img {
          width: 150px;
      }
      .header-paragragh {
          font-size: 23px;
      }
      .table-bill-details{
          margin-top: 50px;
      }
      .bill-details .bill-header,.summary-details .summary-header {
          text-transform: uppercase;
          font-weight: bold;
      }
      .bill-details{
          width: 50%;
      }
      .summary-details{
        margin-left: auto;
        width: 50%;
    }
    .service-period {
      text-transform: capitalize;
      font-weight: bold;
  }
  table {
      width: 100%;
      text-align: left;
  }
  .payment-summary thead {
      background-color: #aaa;
  }
  .payment-summary th,
  .payment-summary td {
      border: none;
      border-bottom: 1px solid black;
      padding: 5px 10px;
  }
  .alingRight {
      text-align: right;
  }
  .payment-summary {
      margin-top: 40px;
  }
  .payment-summary h2 {
      text-align: center;
      font-size: 18px;
  }
  .bill-footer {
      margin-top: 10rem;
      text-align: center;
  }
  .total-bill {
      text-align: right;
      margin-right: 10px;
  }
  .total-bill table {
      width: 200px;
  }
  .total-bill-title {
      font-weight: bold;
      margin-right: 30px;
  }
  .text-right{
    text-align: right !important;
}
.text-center{
    text-align: center !important;
}
</style>
</head>
<body>
    <table style="width: 100%;">
        <tr>
            <td style="font-size: 20px;">
             <strong>Hey !<br />
                It’s your<br />
                <span>INVOICE</span>
            </strong>
        </td>
        <td class="text-right">
            <img style="float:right;" src="{{public_path('dist/images/logo_color.png')}}" alt="" />
        </td>
    </tr>
</table>
<table class="table-bill-details" style="width:100%;">
    <tr>
        <td class="bill-details">
            <p class="bill-header">BILL TO</p>
            <p>
                {{$credit->getuser->getCompany->name}}<br />
                {{$credit->getuser->getCompany->address}}<br />
                {{$credit->getuser->getCompany->city}}<br />
                {{$credit->getuser->getCompany->zip}}<br />
                {{$credit->getuser->getCompany->country}}<br />
                {{$credit->getuser->email}}<br />
                Mob. +{{$credit->getuser->phone_code}}{{$credit->getuser->phone}}<br />
            </p>
            <p>GST / Tax Identification No. {{$credit->getuser->getCompany->gst??'-'}}</p>
        </td>
        <td class="summary-details text-right">
            <p class="summary-header">INVOICE SUMMARY</p>
            <p>
                Invoice Date: {{date('M d, Y',strtotime($credit->created_at))}}<br />
                Invoice No: {{prepareInvoiceId($credit->getInvoice->id)}}
            </p>
            <p>
                Client Code: {{$credit->getuser->id}}
            </p>
        </td>
    </tr>
</table>

<div class="payment-summary">
    <h2>CHARGE SUMMARY</h2>
    <table>
        <thead>
            <tr>
                <th>Charge Name</th>
                <th>Description/Credits</th>
                <th class="alingRight">Amount</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td class="text-center">
                    {{$credit->plan_name??''}}
                </td>
                <td class="text-center">
                    {{$credit->credits??'-'}}
                </td>
                <td class="text-right">
                    {{env('CURRENCY','INR')}} {{number_format((float)$credit->amount,2,'.','')??''}}
                </td>
            </tr>
            
        </tbody>
    </table>
</div>

<br/>


<div class="total-bill">
    @php
    $taxable = $credit->discounted_amount??$credit->amount;
    @endphp

    @if($credit->getOffer)
    <div>
        <span class="total-bill-title">Offer Applied : </span>
        <span class="alingRight">{{$credit->getOffer->code}}</span>
    </div>

    <div>
        <span class="total-bill-title">Discount : </span>
        <span class="alingRight">{{env('CURRENCY','INR')}} {{$credit->amount-$credit->discounted_amount}}</span>
    </div>
    @endif

    <div>
        <span class="total-bill-title">Subtotal : </span>
        <span class="alingRight">{{env('CURRENCY','INR')}} {{number_format((float)$taxable,2,'.','')}}</span>
    </div>
    
    @if ($credit->igst && $credit->igst>0)
    <div>
        <span class="total-bill-title">IGST({{$credit->igst}}%) :</span> <span class="alingRight">
            {{env('CURRENCY','INR')}} {{number_format((float)($credit->payable - $taxable),2,'.','')}}
        </span>
    </div>
    @else
    <div>
        <span class="total-bill-title">CGST({{$credit->cgst}}%) :</span> <span class="alingRight">
            {{env('CURRENCY','INR')}} {{number_format((float)($credit->payable - $taxable)/2,2,'.','')}}
        </span>
    </div>
    <div>
        <span class="total-bill-title">SGST({{$credit->sgst}}%) :</span> <span class="alingRight">
            {{env('CURRENCY','INR')}} {{number_format((float)($credit->payable - $taxable)/2,2,'.','')}}
        </span>
    </div>
    @endif  

    <hr/>
    <div>
        <span class="total-bill-title">Total</span>
        <span class="alingRight">{{env('CURRENCY','INR')}} {{number_format((float)$credit->payable,2,'.','')}}</span>
    </div>
</div>


<div class="payment-summary">
    <h2>PAYMENT SUMMARY</h2>
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Date</th>
                <th>Transaction ID</th>
                <th>Method</th>
                <th class="alingRight">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">Electronic</td>
                <td class="text-center">{{date('M d, Y',strtotime($credit->updated_at))}}</td>
                <td class="text-center">{{$credit->payment_id}}</td>
                <td class="text-center">RazorPay</td>
                <td class="alingRight">{{env('CURRENCY','INR')}} {{number_format((float)$credit->payable,2,'.','')}}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="bill-footer">
    <p>
        <b>Tracesci Global Private Limited</b><br />
        8B 'Chaitanya Exotica', 24 Venkatnarayana Road, T. Nagar, Chennai - 600
        017, Tamilnadu, India<br />
        Phone : 1 800 102 4567<br />
        GST / Tax No. 33AAJCT2962L1ZZ
    </p>
</div>
</body></html>
