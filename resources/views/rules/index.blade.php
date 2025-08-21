@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Rule Manager</h2>

    <!-- Rule Form -->
    <form id="ruleForm" action="{{ route('rules.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label>Rule Name <span class="text-danger">*</span></label>
            <input type="text" name="rule_name" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Conditions<span class="text-danger">*</span></label>
            <div id="conditions-wrapper">
                <div class="row mb-2 condition-row">
                    <div class="col-md-4">
                        <select name="conditions[0][product_field]" class="form-control" required>
                            <option value="type">Type</option>
                            <option value="sku">SKU</option>
                            <option value="vendor">Vendor</option>
                            <option value="price">Price</option>
                            <option value="qty">Qty</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="conditions[0][operator]" class="form-control" required>
                            <option value="==">==</option>
                            <option value=">">></option>
                            <option value="<"><</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="conditions[0][value]" class="form-control" required>
                    </div>
                </div>
            </div>
            <button type="button" id="add-condition" class="btn btn-secondary btn-sm mt-2">+ Add Condition</button>
        </div>

        <div class="form-group mb-3">
            <label>Apply Tags <span class="text-danger">*</span></label>
            <input type="text" name="apply_tags" class="form-control" placeholder="comma,separated,tags" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Rule</button>
    </form>

    <hr>

    <!-- Rules List -->
    <h3>Rule List</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Rule Name</th>
                <th>Conditions</th>
                <th>Apply Tags</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rules as $rule)
                <tr>
                    <td>{{ $rule->rule_name }}</td>
                    <td>
                        @if($rule->conditions->isNotEmpty())
                            <ul class="mb-0">
                                @foreach($rule->conditions as $condition)
                                    <li>
                                        <strong>{{ ucfirst($condition->product_field) }}</strong>
                                        {{ $condition->operator }}
                                        <em>{{ $condition->value }}</em>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">No conditions</span>
                        @endif
                    </td>
                    <td>{{ $rule->apply_tags }}</td>
                    <td>
                        <form action="{{ route('rules.apply', $rule->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Apply Rule</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">No rules found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>
<script>
    let conditionIndex = 1;

    // Dynamically add new condition rows
    $('#add-condition').click(function() {
        let wrapper = $('#conditions-wrapper');
        let newRow = $(`
            <div class="row mb-2 condition-row">
                <div class="col-md-4">
                    <select name="conditions[${conditionIndex}][product_field]" class="form-control" required>
                        <option value="type">Type</option>
                        <option value="sku">SKU</option>
                        <option value="vendor">Vendor</option>
                        <option value="price">Price</option>
                        <option value="qty">Qty</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="conditions[${conditionIndex}][operator]" class="form-control" required>
                        <option value="==">==</option>
                        <option value=">">></option>
                        <option value="<"><</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="conditions[${conditionIndex}][value]" class="form-control" required>
                </div>
            </div>
        `);
        wrapper.append(newRow);
        conditionIndex++;
    });

    // jQuery Validation
    $(document).ready(function() {
        $('#ruleForm').validate({
            rules: {
                rule_name: { required: true },
                apply_tags: { required: true }
            },
            messages: {
                rule_name: { required: "Please enter a rule name" },
                apply_tags: { required: "Please enter tags to apply" }
            },
            errorClass: 'text-danger',
            errorElement: 'small',
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endsection
