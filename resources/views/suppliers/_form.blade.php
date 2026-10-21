@csrf
@foreach (['name' => 'Nama', 'phone' => 'Telepon', 'email' => 'Email'] as $field => $label)
<div class="mb-3">
    <label class="form-label">{{ $label }}</label>
    <input name="{{ $field }}" class="form-control @error($field) is-invalid @enderror" value="{{ old($field, $supplier->$field ?? '') }}">
    @error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
@endforeach
<div class="mb-3">
    <label class="form-label">Alamat</label>
    <textarea name="address" class="form-control @error('address') is-invalid @enderror">{{ old('address', $supplier->address ?? '') }}</textarea>
    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<button class="btn btn-primary">Simpan</button>
<a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Batal</a>
