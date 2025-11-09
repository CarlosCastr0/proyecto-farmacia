@csrf

<div class="space"></div>
<label for="nombre">Nombre</label>
<input id="nombre" type="text" name="nombre" value="{{ old('nombre', $product->nombre ?? '') }}" required>
@error('nombre')<div class="error">{{ $message }}</div>@enderror

<div class="space"></div>
<label for="descripcion">Descripción</label>
<textarea id="descripcion" name="descripcion" rows="4" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;">{{ old('descripcion', $product->descripcion ?? '') }}</textarea>
@error('descripcion')<div class="error">{{ $message }}</div>@enderror

<div class="space"></div>
<div class="row" style="gap:16px;">
  <div style="flex:1;">
    <label for="precio">Precio</label>
    <input id="precio" type="number" step="0.01" min="0" name="precio" value="{{ old('precio', $product->precio ?? '') }}" required>
    @error('precio')<div class="error">{{ $message }}</div>@enderror
  </div>
  <div style="flex:1;">
    <label for="stock">Stock</label>
    <input id="stock" type="number" min="0" name="stock" value="{{ old('stock', $product->stock ?? '') }}" required>
    @error('stock')<div class="error">{{ $message }}</div>@enderror
  </div>
</div>

<div class="space"></div>
<label for="imagen">Imagen</label>
<input id="imagen" type="file" name="imagen" accept="image/*">
@error('imagen')<div class="error">{{ $message }}</div>@enderror

@if(!empty($product?->imagen))
  <div class="space"></div>
  <div style="height:120px; background:#f3f4f6; display:flex; align-items:center; justify-content:center; border-radius:6px;">
    <img src="{{ asset('storage/'.$product->imagen) }}" alt="{{ $product->nombre }}" style="max-height:100%; max-width:100%;">
  </div>
@endif

<div class="space"></div>
<button type="submit" class="btn">Guardar</button>

