<div class="form-group">
  <!-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi -->

  <label for="{{ $name }}">
    {{ $text }}
    @if ($required)
    <span class="text-danger">*</span>
    @endif
  </label>

{{-- {{ dd($value) }} --}}

{{-- <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="2020-12-23" --}}
<input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}"
    class="form-control @error($name) is-invalid @enderror">

  @error($name)
  <div class="invalid-feedback">
    {{ $message }}
  </div>
  @enderror

</div>
