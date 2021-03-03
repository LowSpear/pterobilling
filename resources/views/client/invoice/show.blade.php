@extends('layouts.client')

@section('content')
    <div class="row" id="invoice_content">
        <div class="col-12">
            <div class="invoice p-3 mb-3">
                <div class="row">
                    <div class="col-12">
                        <h4>
                            <img src="{{ config('app.logo_file_path') }}" height="50px" alt="Logo"> {{ config('app.company_name') }}
                            <span class="float-right">Status: UNPAID</span>
                        </h4>
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        From
                        <address>
                            <strong>{{ config('app.company_name') }}</strong><br>
                            Email: {{ config('mail.from.address') }}
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        To
                        <address>
                            <strong>User Name</strong><br>
                            Email: user@example.com
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <b>Invoice #1</b><br>
                        <b>Invoice Date:</b> Jan 1, 2021 13:00 (UTC)<br>
                        <b>Due Date:</b> Jan 1, 2021 13:00 (UTC)<br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width:85%">Product</th>
                                    <th style="width:15%">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Category 1 - Plan 1</td>
                                    <td>$5.00 USD</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-5">
                        <p class="lead">Payment Methods</p>
    
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:35%">Primary</th>
                                    <td>PayPal</td>
                                </tr>
                                <tr>
                                    <th>Backup</th>
                                    <td>Account Credit</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-5 offset-1">
                        <p class="lead">Amount Due</p>
    
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:60%">Subtotal</th>
                                    <td>$5.00</td>
                                </tr>
                                <tr>
                                    <th>Tax (3%)</th>
                                    <td>+ $0.15</td>
                                </tr>
                                <tr>
                                    <th>Account Credit</th>
                                    <td>- $2.00</td>
                                </tr>
                                <tr>
                                    <th>Total Due</th>
                                    <td>$3.15</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row no-print">
                    <div class="col-12">
                        <button onclick="print_invoice()" target="_blank" class="btn btn-default">
                            <i class="fas fa-print"></i> Print / Save
                        </button>
                        <button type="submit" name="pay" value="pay" form="payForm" class="btn btn-success float-right">
                            <i class="far fa-credit-card"></i> Pay Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="" method="POST" id="payForm"></form>
@endsection

@section('scripts')
    <script>
        function print_invoice()
        {
            var printWindow = window.open('{{ route('client.invoice.print', ['id' => 1]) }}');
            printWindow.focus();
            printWindow.print();
        }
    </script>
@endsection