<div>
  <!-- Select Area -->
  <div class="form-group">
    <label for="area">
      {{ __('app.programs.area') }}
    </label>
    <span class="text-danger"> * </span>

    <select name="area" wire:click="selectedArea($event.target.value)" id="area" class="form-control @error('area') is-invalid @enderror">
      <option selected disabled value=""> {{ __('app.programs.placeholder.area') }} </option>
      @foreach ($areas as $area)
      <option value="{{ $area }}" {{ old('area') == $area ? 'selected' : '' }}>
        {{ $area }}
      </option>
      @endforeach
    </select>

    @error('area')
    <div class="text-danger">
      {{ $message }}
    </div>
    @enderror
  </div>

  <!-- Select Program -->
  <div class="form-group">
    <label for="">
      {{ __('app.generates.program_id') }}
    </label>
    <span class="text-danger"> * </span>

    <select name="program_id" class="form-control @error('program_id') is-invalid @enderror">
      @foreach ($programs as $program)
      <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
        {{ $program->name }}
      </option>
      @endforeach
    </select>

    @error('program_id')
    <div class="invalid-feedback">
      {{ $message }}
    </div>
    @enderror
  </div>

</div>
