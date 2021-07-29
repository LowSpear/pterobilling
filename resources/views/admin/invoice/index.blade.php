@extends('layouts.admin')

@inject('invoice_model', 'App\Models\Invoice')
@inject('server_model', 'App\Models\Server')

@section('title', 'Invoices')

@section('content')
    <div class="row justify-content-center">
        <div class="card col-12">
            <div class="card-header">
                <h3 class="card-title">Unpaid Invoices</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table id="unpaid-invoice-table" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Item</th>
                            <th>Amount</th>
                            <th>Invoice Date</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice_model->where('paid', false)->get() as $invoice)
                            <tr>
                                <td><a href="{{ route('client.invoice.show', ['id' => $invoice->id]) }}">{{ $invoice->id }}</a></td>
                                <td><a href="{{ route('admin.client.show', ['id' => $invoice->client_id]) }}" target="_blank">{{ $client_model->find($invoice->client_id)->email }}</a></td>
                                <td>
                                    @if ($invoice->server_id)
                                        Server #{{ $invoice->server_id }}
                                    @elseif ($invoice->credit_amount)
                                        {!! session('currency')->symbol !!}{{ number_format($invoice->credit_amount * session('currency')->rate) }} {{ session('currency')->name }} Credit
                                    @endif
                                </td>
                                @php
                                    $tax = $tax_model->find($invoice->tax_id);
                                @endphp
                                <td>
                                    {!! session('currency')->symbol !!}
                                    @if ($invoice->server_id)
                                        {{ number_format((($server_model->getTotalCost() + $invoice->late_fee) * ($tax->percent / 100) + $tax->amount) * session('currency')->rate) }} 
                                    @elseif ($invoice->credit_amount)
                                        {{ number_format(($invoice->credit_amount * ($tax->percent / 100) + $tax->amount) * session('currency')->rate) }} 
                                    @endif
                                    {{ session('currency')->name }}
                                </td>
                                <td>{{ $invoice->created_at }}</td>
                                <td>{{ $invoice->due_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Item</th>
                            <th>Amount</th>
                            <th>Invoice Date</th>
                            <th>Due Date</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card col-12">
            <div class="card-header">
                <h3 class="card-title">Paid Invoices</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table id="paid-invoice-table" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Item</th>
                            <th>Amount</th>
                            <th>Invoice Date</th>
                            <th>Paid Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice_model->where('paid', true)->get() as $invoice)
                            <tr>
                                <td><a href="{{ route('client.invoice.show', ['id' => $invoice->id]) }}">{{ $invoice->id }}</a></td>
                                <td><a href="{{ route('admin.client.show', ['id' => $invoice->client_id]) }}" target="_blank">{{ $client_model->find($invoice->client_id)->email }}</a></td>
                                <td>
                                    @if ($invoice->server_id)
                                        Server #{{ $invoice->server_id }}
                                    @elseif ($invoice->credit_amount)
                                        {!! session('currency')->symbol !!}{{ number_format($invoice->credit_amount * session('currency')->rate) }} {{ session('currency')->name }} Credit
                                    @endif
                                </td>
                                @php
                                    $tax = $tax_model->find($invoice->tax_id);
                                @endphp
                                <td>
                                    {!! session('currency')->symbol !!}
                                    @if ($invoice->server_id)
                                        {{ number_format((($server_model->getTotalCost() + $invoice->late_fee) * ($tax->percent / 100) + $tax->amount) * session('currency')->rate) }} 
                                    @elseif ($invoice->credit_amount)
                                        {{ number_format(($invoice->credit_amount * ($tax->percent / 100) + $tax->amount) * session('currency')->rate) }} 
                                    @endif
                                    {{ session('currency')->name }}
                                </td>
                                <td>{{ $invoice->created_at }}</td>
                                <td>{{ $invoice->updated_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Item</th>
                            <th>Amount</th>
                            <th>Invoice Date</th>
                            <th>Paid Date</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('admin_scripts')
    <script> lazyLoadCss('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); </script>

    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(function () {
            $("#unpaid-invoice-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
            $("#paid-invoice-table").DataTable({"responsive": false, "lengthChange": false, "autoWidth": false});
        });
    </script>
@endsection
