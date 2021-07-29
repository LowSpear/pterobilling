@php $header_route = "admin.addon.index"; @endphp

@extends('layouts.admin')

@inject('addon_cycle_model', 'App\Models\AddonCycle')
@inject('category_model', 'App\Models\Category')

@section('title', $addon->name)
@section('header', 'Plan Add-ons')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('api.admin.addon.update', ['id' => $id]) }}" method="PUT" data-callback="updateForm" id="updateForm">
                    @csrf

                    <div class="card-body row">
                        <div class="form-group col-lg-4">
                            <label for="nameInput">Add-on Name</label>
                            <input type="text" name="name" value="{{ $addon->name }}" class="form-control" id="nameInput" placeholder="Add-on Name" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="descriptionInput">Short Description (Optional)</label>
                            <textarea name="description" class="form-control" id="descriptionInput" placeholder="Around 10 words recommended">{{ $addon->description }}</textarea>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="orderInput">Order (The smaller, the higher display priority)</label>
                            <input type="text" name="order" value="{{ $addon->order }}" value="1000" class="form-control" id="orderInput" placeholder="Order" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Categories</label>
                            @foreach ($category_model->all() as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category->id }}" @if (in_array($category->id, json_decode($addon->categories, true))) checked @endif>
                                    <p class="form-check-label">{{ $category->name }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Resource</label>
                            <select class="form-control" name="resource">
                                <option value="ram" @if ($addon->resource === 'ram') selected @endif>RAM</option>
                                <option value="cpu" @if ($addon->resource === 'cpu') selected @endif>CPU</option>
                                <option value="disk" @if ($addon->resource === 'disk') selected @endif>Disk</option>
                                <option value="database" @if ($addon->resource === 'database') selected @endif>Database</option>
                                <option value="backup" @if ($addon->resource === 'backup') selected @endif>Backup</option>
                                <option value="extra_port" @if ($addon->resource === 'extra_port') selected @endif>Extra Port</option>
                                <option value="dedicated_ip" @if ($addon->resource === 'dedicated_ip') selected @endif>Dedicated IP</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="amountInput">Amount of additional resource</label>
                            <input type="number" name="amount" value="{{ $addon->amount }}" min="0" class="form-control" id="amountInput" placeholder="Dedicated IP: enter allocation ID">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="globalLimitInput">Global Limit (max. servers using this add-on) (Optional)</label>
                            <input type="number" name="global_limit" value="{{ $addon->global_limit }}" min="0" class="form-control" id="globalLimitInput" placeholder="0 = No servers can use this add-on">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="perClientInput">Per Client Limit (max. servers per client using this add-on) (Optional)</label>
                            <input type="number" name="per_client_limit" value="{{ $addon->per_client_limit }}" min="0" class="form-control" id="perClientInput" placeholder="0 = No servers can use this add-on">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="perServerInput">Per Server Limit (max. quantity per server) (Optional)</label>
                            <input type="number" name="per_server_limit" value="{{ $addon->per_server_limit }}" min="0" class="form-control" id="perServerInput" placeholder="Dedicated IP: limit = 1">
                        </div>
                        @php $addon_cycles = $addon_cycle_model->where('addon_id', $id)->get() @endphp
                        <div class="form-group col-lg-12">
                            <hr>
                            <h5>Default Billing Cycle</h5>
                        </div>
                        <div class="form-group col-lg-3">
                            <label>Cycle Length</label>
                            <input type="number" name="cycle[0][cycle_length]" value="{{ $addon_cycles[0]->cycle_length }}" class="form-control" placeholder="e.g. Quarterly: enter '3', choose 'Monthly'" required>
                        </div>
                        <div class="form-group col-lg-3">
                            <label>Cycle Type</label>
                            <select class="form-control" name="cycle[0][cycle_type]">
                                <option value="0" @if ($addon_cycles[0]->cycle_type === 0) selected @endif>One-time</option>
                                <option value="1" @if ($addon_cycles[0]->cycle_type === 1) selected @endif>Hourly</option>
                                <option value="2" @if ($addon_cycles[0]->cycle_type === 2) selected @endif>Daily</option>
                                <option value="3" @if ($addon_cycles[0]->cycle_type === 3) selected @endif>Monthly</option>
                                <option value="4" @if ($addon_cycles[0]->cycle_type === 4) selected @endif>Yearly</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label>Initial Price</label>
                            <input type="text" name="cycle[0][init_price]" value="{{ $addon_cycles[0]->init_price }}" class="form-control" placeholder="Use default currency" required>
                        </div>
                        <div class="form-group col-lg-3">
                            <label>Renew Price</label>
                            <input type="text" name="cycle[0][renew_price]" value="{{ $addon_cycles[0]->renew_price }}" class="form-control" placeholder="Use default currency" required>
                        </div>
                        <div class="form-group col-lg-3">
                            <label>Setup fee</label>
                            <input type="text" name="cycle[0][setup_fee]" value="{{ $addon_cycles[0]->setup_fee }}" class="form-control" placeholder="Use default currency" required>
                        </div>
                        <div class="form-group col-lg-12">
                            <hr>
                            <h5>Additional Billing Cycles (Optional)</h5>
                        </div>
                        @for ($i = 1; $i <= 8; $i++)
                            <div class="form-group col-lg-3">
                                <label>Cycle Length</label>
                                <input type="number" name="cycle[{{$i}}][cycle_length]" @if ($addon_cycles->count() >= $i + 1) value="{{ $addon_cycles[$i]->cycle_length }}" @endif class="form-control" placeholder="e.g. Quarterly: enter '3', choose 'Monthly'">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Cycle Type</label>
                                <select class="form-control" name="cycle[{{$i}}][cycle_type]">
                                    <option value="0" @if ($addon_cycles->count() >= $i + 1) @if ($addon_cycles[$i]->cycle_type === 0) selected @endif @endif>One-time</option>
                                    <option value="1" @if ($addon_cycles->count() >= $i + 1) @if ($addon_cycles[$i]->cycle_type === 1) selected @endif @endif>Hourly</option>
                                    <option value="2" @if ($addon_cycles->count() >= $i + 1) @if ($addon_cycles[$i]->cycle_type === 2) selected @endif @endif>Daily</option>
                                    <option value="3" @if ($addon_cycles->count() >= $i + 1) @if ($addon_cycles[$i]->cycle_type === 3) selected @endif @endif>Monthly</option>
                                    <option value="4" @if ($addon_cycles->count() >= $i + 1) @if ($addon_cycles[$i]->cycle_type === 4) selected @endif @endif>Yearly</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Initial Price</label>
                                <input type="text" name="cycle[{{$i}}][init_price]" @if ($addon_cycles->count() >= $i + 1) value="{{ $addon_cycles[$i]->init_price }}" @endif class="form-control" placeholder="Use default currency">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Renew Price</label>
                                <input type="text" name="cycle[{{$i}}][renew_price]" @if ($addon_cycles->count() >= $i + 1) value="{{ $addon_cycles[$i]->renew_price }}" @endif class="form-control" placeholder="Use default currency">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Setup fee</label>
                                <input type="text" name="cycle[{{$i}}][setup_fee]" @if ($addon_cycles->count() >= $i + 1) value="{{ $addon_cycles[$i]->setup_fee }}" @endif class="form-control" placeholder="Use default currency">
                            </div>
                            <div class="form-group col-lg-12">
                                <hr>
                            </div>
                        @endfor
                    </div>
                </form>
                <form action="{{ route('api.admin.addon.delete', ['id' => $id]) }}" method="DELETE" data-callback="deleteForm" id="deleteForm"></form>
                <div class="card-footer col-lg-12 row justify-content-center">
                    <button type="submit" form="updateForm" class="btn btn-success btn-sm col-lg-2 col-md-4">Save</button>
                    <button type="submit" form="deleteForm" class="btn btn-danger btn-sm col-lg-2 col-md-4 offset-lg-1 offset-md-2 ">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin_scripts')
    <script>
        function updateForm(data) {
            if (data.success) {
                toastr.success(data.success)

                if (data.delete_failed) {
                    toastr.warning('Some billing cycles cannot be modified/deleted because some servers are still using it!')
                }
            } else if (data.error) {
                toastr.error(data.error)
            } else if (data.errors) {
                data.errors.forEach(error => { toastr.error(error) });
            } else {
                wentWrong()
            }
        }
        
        function deleteForm(data) {
            if (data.success) {
                toastr.success(data.success)
                waitRedirect('{{ route('admin.addon.index') }}')
            } else if (data.error) {
                toastr.error(data.error)
            } else if (data.errors) {
                data.errors.forEach(error => { toastr.error(error) });
            } else {
                wentWrong()
            }
        }
    </script>
@endsection
