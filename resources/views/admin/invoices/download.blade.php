<html>
<head>
  <style>
    @font-face{
        font-family: 'Raleway';
        src: url("{{asset('dist/fonts/Raleway/Raleway-Regular.ttf')}}") format('truetype');
        }

        *{
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
      .bill-details .bill-header,
      .summary-details .summary-header {
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
                    {{$invoice->getuser->getCompany->name}}<br />
                    {{$invoice->getuser->getCompany->address}}<br />
                    {{$invoice->getuser->getCompany->city}}<br />
                    {{$invoice->getuser->getCompany->zip}}<br />
                    {{$invoice->getuser->getCompany->country}}<br />
                    {{$invoice->getuser->email}}<br />
                    Mob. +{{$invoice->getuser->phone_code}}{{$invoice->getuser->phone}}<br />
                </p>
                <p>GST / Tax Identification No. {{$invoice->getuser->getCompany->gst??'-'}}</p>
            </td>
            <td class="summary-details text-right">
                <p class="summary-header">INVOICE SUMMARY</p>
                <p>
                    Invoice Date: {{date('M d, Y',strtotime($invoice->created_at))}}<br />
                    Invoice No: {{prepareInvoiceId($invoice->id)}}
                </p>
                <p>
                    Client Code: {{$invoice->getuser->id}}<br/>
                    @if($invoice->type=='0')
                    Payment Terms: Due Upon Receipt
                    @endif
                </p>

                @if($invoice->type=='0')
                <p class="service-period">Service Period</p>
                <p>{{Carbon\Carbon::create(date('Y-m-d',strtotime($invoice->created_at)))->firstOfMonth()->format('d M Y')}} - {{Carbon\Carbon::create(date('Y-m-d',strtotime($invoice->created_at)))->lastOfMonth()->format('d M Y')}}</p>
                @endif

            </td>
        </tr>
    </table>
    @if($invoice->type!='2')
    <div class="payment-summary">
        <h2>CHARGE SUMMARY</h2>
        <table>
            <thead>
                <tr>
                    <th>Charge Name</th>
                    <th>Description</th>
                    <th class="alingRight">Total</th>
                </tr>
            </thead>
            <tbody>

                @php
                $subtotal = 0;
                @endphp              

                @foreach ($description as $key=>$data)
                <tr>
                    <td>
                        {{$data['plan']??''}}
                    </td>
                    <td>
                        -
                    </td>
                    <td class="text-right">
                        {{env('CURRENCY','INR')}} {{number_format((float)$data['price_inr'],2,'.','')??''}}

                        @php
                        $subtotal = $subtotal+number_format((float)$data['price_inr'],2,'.','');
                        @endphp
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="payment-summary">
        <h2>CHARGE SUMMARY</h2>
        <table>
            <thead>
                <tr>
                    <th>Label Size</th>
                    <th>Material Type</th>
                    <th>Price/Label</th>
                    <th>Quantity</th>
                    <th>SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>

                @php
                $subtotal = 0;
                @endphp              

                @php
                $description = json_decode($invoice->description,true);
                @endphp
                @if (!empty($description))
                @php
                $subtotal = $description['subtotal'];
                @endphp              

                <tr>
                    <td>
                        {{$description['width']}} <sup>"</sup> x {{$description['height']}} <sup>"</sup> 
                    </td>
                    <td>
                        {{$description['material_type_name']}}
                    </td>
                    <td>
                        {{number_format((float)$description['rate'],2,'.','')??''}}
                    </td>
                    <td>
                        {{number_format((float)$description['quantity'],2,'.','')??''}}
                    </td>
                    <td>
                        {{number_format((float)$description['subtotal'],2,'.','')??''}}
                    </td>
                </tr>

                @endif

            </tbody>
        </table>
    </div>
    @endif    

    <br/>

    <div class="total-bill">
        <div>
            <span class="total-bill-title">Subtotal : </span>
            <span class="alingRight">{{env('CURRENCY','INR')}} {{number_format((float)$subtotal,2,'.','')}}</span>
        </div>
        
        @if ($invoice->igst && $invoice->igst>0)
        <div>
            <span class="total-bill-title">IGST({{$invoice->igst}}%) :</span> <span class="alingRight">
                {{env('CURRENCY','INR')}} {{number_format((float)($invoice->amount_inr-$subtotal),2,'.','')}}
            </span>
        </div>
        @else
        <div>
            <span class="total-bill-title">CGST({{$invoice->cgst}}%) :</span> <span class="alingRight">
                {{env('CURRENCY','INR')}} {{number_format((float)($invoice->amount_inr-$subtotal)/2,2,'.','')}}
            </span>
        </div>
        <div>
            <span class="total-bill-title">SGST({{$invoice->sgst}}%) :</span> <span class="alingRight">
                {{env('CURRENCY','INR')}} {{number_format((float)($invoice->amount_inr-$subtotal)/2,2,'.','')}}
            </span>
        </div>
        @endif  

        <hr/>
        <div>
            <span class="total-bill-title">Total</span>
            <span class="alingRight">{{env('CURRENCY','INR')}} {{number_format((float)$invoice->amount_inr,2,'.','')}}</span>
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
                    <td class="text-center">{{date('M d, Y',strtotime($invoice->updated_at))}}</td>
                    <td class="text-center">{{$invoice->payment_id}}</td>
                    <td class="text-center">RazorPay</td>
                    <td class="alingRight">{{env('CURRENCY','INR')}} {{number_format((float)$invoice->amount_inr,2,'.','')}}</td>
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
