<!-- People find pleasure in different ways. I find it in keeping my mind clear. - Marcus Aurelius -->
<div class="form-group" id2="{{ $form_id }}">
  <label for="{{ $name }}">
    {{ $text }}
    @if ($required)
    <span class="text-danger">*</span>
    @endif
  </label>

  <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}" placeholder="{{ $placeholder }}" {{ $readonly ? 'readonly' : '' }}
    class="form-control @error($name) is-invalid @enderror">

  @error($name)
  <div class="invalid-feedback">
    {{ $message }}
  </div>
  @enderror
</div>
