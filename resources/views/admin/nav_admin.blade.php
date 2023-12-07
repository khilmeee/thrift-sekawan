<!-- Create Product Form -->
<form action="{{ route('products.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" required></textarea>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" class="form-control" id="price" name="price" required>
    </div>
    <div class="mb-3">
        <label for="brand_id" class="form-label">Brand</label>
        <select class="form-select" id="brand_id" name="brand_id" required>
        </select>
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select class="form-select" id="category_id" name="category_id" required>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Create Product</button>
</form>

<!-- Update Product Form -->
<form action="{{ route('products.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" required>{{ $product->description }}</textarea>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" class="form-control" id="price" name="price" value="{{ $product->regular_price }}" required>
    </div>
    <div class="mb-3">
        <label for="brand_id" class="form-label">Brand</label>
        <select class="form-select" id="brand_id" name="brand_id" required>
        </select>
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select class="form-select" id="category_id" name="category_id" required>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update Product</button>
</form>


<!-- Delete Product Form (Delete Button) -->
<form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete Product</button>
</form>

