<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class InvoiceTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::create('invoice_templates', function (Blueprint $table) {
      $table->id();
      $table->string('name', 100);
      $table->text('variables')->nullable();
      $table->text('html');
      $table->timestamps();
    });

     DB::table('invoice_templates')->insert(
      array(
        'name'          => 'payment_slip',
        'variables'     => 'buyer_name,address,email,admin_address,admin_mail,invoice_no,date_of_issue,
        payment_id,price,total,currency,plan_name',
        'html'          => '<html>
        <style type="text/css">
        body {
          text-align: start;
          padding: 10px;
        }
        th {
          padding-right: 10px;
          text-align: start;
        }
        hr {
          border: 1px solid #aaa;
          outline: 0;
        }
        .header_title {
          float: right;
          margin-left: auto; 
          width: 60%;
          text-align: right;
        }
        .header {
          width: 100%;
          display: flex;
        }

        .header_logo img{
          width: 150px;
          height: 150px;
        }
        .header_logo {
          width: 40%;
          text-align: left;
          padding:0;
        }

        .bill_div th,
        .bill_div tr {
          font-size: 14px;
        }
        .bill_div {
          position: relative;
          height: 100%;
          width: 100%;
          background-color: #fff;
        }

        .bill_detail {
          width: 100%;
          display: flex;
        }
        .bill_p {
          line-height: 8px;
          font-size: 14px;
          color: #333;
        }
        /*.bill_p span {
          font-weight: bold;
          }*/
          .bill_cost {
            margin-top: 2em;
            width: 50%;
          }
          .bill_from {
            margin-top: -30px;
            float: right;
            margin-left: auto; 
            width: 50%;
            text-align: right;      
          }

          .bill_info_from {
            float: right;
            margin-left: auto; 
            width: 50%;   
            text-align: right;
          }

          .bill_price_table {
            margin-top: 30px;
            width: 100%;
          }
          .bill_price_table th {
            padding: 10px 0;
            border-bottom: 1px solid #000;
          }
          .total_price_div {
            width: 100%;
          }
          .total_price_table{
            float: right;
            margin-left: auto;
          }
          .total_price_div th {
            font-size: 15px;
          }

          .hr {
            border-bottom: 1px solid #333;
          }
          .bill_price_table td {
            font-size: 14px;
            line-height: 10px;
            padding: 5px 0;
          }
          .bill_tnk {
            width: 100%;
            text-align: center;
          }
          </style>
          <body>
          <div class="bill_div">
          <div style="position: relative">
          <div class="header" style="margin-bottom: 30px;">
          <div class="header_logo">
          <h1>TRACESCI</h1>
          </div>
          <div class="header_title">
          <h1>e-INVOICE / TAX INVOICE</h1>
          </div>
          </div>
          </div>

          <div class="bill_detail">
          <div class="bill_cost">
          <p class="bill_p"><span>{{buyer_name}}: </span></p>
          <p class="bill_p">{{address}}</p>
          <p class="bill_p">{{email}}</p>
          </div>
          <div class="bill_from">
          <p class="bill_p"><span>From:</span></p>
          <p class="bill_p">TRACESCI</p>
          <p class="bill_p">{{admin_address}}</p>
          <p class="bill_p">{{admin_mail}}</p>
          <p class="bill_p" style="margin-top: 30px;">
          <strong>Invoice No:</strong>
          <span>{{invoice_no}}</span>
          </p>
          <p class="bill_p">          
          <strong>Date of Issue:</strong>
          <span>{{date_of_issue}}</span>
          </p>
          <p class="bill_p">          
          <strong>Currency:</strong>
          <span>{{currency}}</span>
          </p>
          </div>
          </div>
          <table class="bill_price_table" style="margin-top: 100px;">
          <thead>
          <tr>
          <th>Plan Name</th>
          <th style="text-align: right;">Payment Id</th>
          <th style="text-align: right;"> Price</th>
          <th style="text-align: right;"> Total</th>
          </tr>
          </thead>
          <tbody>
          <tr>
          <td>{{plan_name}}</td>
          <td style="text-align: right;">{{payment_id}}</td>
          <td style="text-align: right;"> {{price}}</td>
          <td style="text-align: right;">  {{total}}</td>
          </tr>
          </tbody>
          </table>
          <div class="bill_detail">
          <div class="bill_cost">
          <p class="bill_p"><span>Payment Details:</span></p>
          <p class="bill_p">Transaction Date: {{date_of_issue}}</p>
          <p class="bill_p">Payment Id.: {{payment_id}}</p>
          </div>
          </div>

          <div class="bill_tnk" style="margin-top: 50px;">
          <p class="bill_p">Thanks for your order</p>
          <hr />
          <p class="bill_p">This invoice was auto generated</p>
          </div>
          <div class="bill_tnk">
          </div>
          </div>
          </body>
          </html>
          ',
          'created_at'    => Carbon::now()
        )
);
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('invoice_templates');
    }
  }
