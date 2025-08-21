@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Product Manager</h2>

    <!-- Product Form -->
    <form id="productForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label>Product Name</label>
            <input type="text" name="product_name" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Product Description</label>
            <textarea name="product_description" class="form-control" rows="4"></textarea>
        </div>

        <div class="form-group mb-3">
            <label>Product Price</label>
            <input type="text" name="product_price" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Product SKU</label>
            <input type="text" name="product_sku" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Product Qty</label>
            <input type="text" name="product_qty" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Product Type</label>
            <input type="text" name="product_type" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Product Vendor</label>
            <input type="text" name="product_vendor" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Product Image</label>
            <input type="file" name="product_image" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Product Tags</label>
            <input type="text" class="form-control" value="(Tags are auto-assigned)" disabled>
        </div>

        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>

    <hr>

    <!-- Product List -->
    <h3>Product List</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Price</th>
                <th>Vendor</th>
                <th>Type</th>
                <th>Tags</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->product_sku }}</td>
                    <td>{{ $product->product_price }}</td>
                    <td>{{ $product->product_vendor }}</td>
                    <td>{{ $product->product_type }}</td>
                    <td>
                        @foreach($product->tags as $tag)
                            <span class="badge bg-info">{{ $tag->tag_name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">No products found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $("#productForm").validate({
        rules: {
            product_name: { required: true, minlength: 3 },
            product_description: { required: true, minlength: 5 },
            product_price: { required: true, number: true, min: 0 },
            product_sku: { required: true, minlength: 3 },
            product_qty: { required: true, digits: true, min: 1 },
            product_type: { required: true },
            product_vendor: { required: true },
            product_image: { required: true, extension: "jpg|jpeg|png|gif" }
        },
        messages: {
            product_name: { required: "Please enter product name", minlength: "At least 3 characters" },
            product_description: { required: "Please enter description", minlength: "At least 5 characters" },
            product_price: { required: "Enter price", number: "Must be a number", min: "Cannot be negative" },
            product_sku: { required: "Enter SKU", minlength: "At least 3 characters" },
            product_qty: { required: "Enter quantity", digits: "Must be integer", min: "At least 1" },
            product_type: { required: "Enter type" },
            product_vendor: { required: "Enter vendor" },
            product_image: { required: "Select an image", extension: "Allowed: jpg, jpeg, png, gif" }
        },
        errorElement: 'span',
        errorClass: 'text-danger',
        highlight: function(element) { $(element).addClass('is-invalid'); },
        unhighlight: function(element) { $(element).removeClass('is-invalid'); }
    });
});
</script>
@endpush
