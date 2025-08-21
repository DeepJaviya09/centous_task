@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Product</h2>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf 
        @method('PUT')

        <div class="form-group mb-3">
            <label>Product Name</label>
            <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Product Description</label>
            <textarea name="product_description" class="form-control" rows="4">{{ old('product_description', $product->product_description) }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label>Product Price</label>
            <input type="text" name="product_price" value="{{ old('product_price', $product->product_price) }}" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Product SKU</label>
            <input type="text" name="product_sku" value="{{ old('product_sku', $product->product_sku) }}" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Product Qty</label>
            <input type="text" name="product_qty" value="{{ old('product_qty', $product->product_qty) }}" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Product Type</label>
            <input type="text" name="product_type" value="{{ old('product_type', $product->product_type) }}" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Product Vendor</label>
            <input type="text" name="product_vendor" value="{{ old('product_vendor', $product->product_vendor) }}" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Product Image</label>
            <input type="file" name="product_image" class="form-control">
            @if($product->product_image)
                <img src="{{ asset('storage/'.$product->product_image) }}" width="100" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>
@endsection
