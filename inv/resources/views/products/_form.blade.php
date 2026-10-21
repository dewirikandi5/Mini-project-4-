@csrf
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">SKU</label>
        <input name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku ?? '') }}">
        @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Nama</label>
        <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name ?? '') }}">
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
            <option value="">-- pilih --</option>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id ?? '') == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Harga</label>
        <input name="price" type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price ?? '') }}">
        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    @unless (isset($product))
    <div class="col-md-6 mb-3">
        <label class="form-label">Stok Awal</label>
        <input name="stock" type="number" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', 0) }}">
        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    @endunless
    <div class="col-md-6 mb-3">
        <label class="form-label">Stok Minimum</label>
        <input name="minimum_stock" type="number" class="form-control @error('minimum_stock') is-invalid @enderror" value="{{ old('minimum_stock', $product->minimum_stock ?? 0) }}">
        @error('minimum_stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<div class="mb-3">
    <label class="form-label d-block">Supplier</label>
    @php $selected = old('supplier_ids', isset($product) ? $product->suppliers->pluck('id')->all() : []); @endphp
    @foreach ($suppliers as $s)
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="supplier_ids[]" value="{{ $s->id }}" id="s{{ $s->id }}" @checked(in_array($s->id, $selected))>
            <label class="form-check-label" for="s{{ $s->id }}">{{ $s->name }}</label>
        </div>
    @endforeach
    @error('supplier_ids.*')<div class="text-danger small">{{ $message }}</div>@enderror
</div>
<button class="btn btn-primary">Simpan</button>
<a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
