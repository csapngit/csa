<div class="form-group">
  <!-- Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci -->

  <label for="">
    {{ $text }}
    @if ($required)
    <span class="text-danger">*</span>
    @endif
  </label>

  <select name="{{ $name }}" id="{{ $name }}" class="form-control select2_hide_search @error($name) is-invalid @enderror"
    style="width: 100%;" {{ $readonly ? 'readonly' : '' }}>

    <option selected disabled value=""> {{ $placeholder }} </option>

    @foreach ($items as $item)
    <option value="{{ $item->id }}" {{ $isSelected($item->id) }}>
      {{ $item->name }}
    </option>
    @endforeach

  </select>

  @error($name)
  <div class="invalid-feedback">
    {{ $message }}
  </div>
  @enderror

</div>
