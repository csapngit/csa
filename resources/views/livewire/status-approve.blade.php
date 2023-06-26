<div>
  {{-- The whole world belongs to you. --}}
  <div class="row">
    <div class="col">
      <!-- Select Key -->
      <div class="form-group">
        <label for="">
          Select Key
        </label>
        <span class="text-danger">*</span>
        <select name="key_id" wire:click="selectedKey($event.target.value)" id="key_id"
          class="form-control @error('key_id') is-invalid @enderror">
          <option selected disabled value>Select Key ..</option>
          @foreach ($keys as $key)
          <option value="{{ $key->id }}" {{ old('key_id') == $key->id ? 'selected' : '' }}>{{ $key->name }}</option>
          @endforeach
        </select>

        @error('key_id')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
    </div>

    <div class="col">
      <!-- Status -->
      <div class="form-group">
        <label for="">
          Status Approve
        </label>

        <div class="row">
          <div class="col-sm-3">
            Approve UM
          </div>
          <div class="col-sm">
            : <strong>{{ $approve_um }}</strong>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3">
            Approve RM/FM
          </div>
          <div class="col-sm">
            : <strong>{{ $approve_rm }}</strong>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Attachment -->
  <div class="form-group">
    <label for="">
      Attachment
    </label>
    <span class="text-danger"> * </span>
    <div class="custom-file">
      <input type="file" name="imageFile" class="custom-file-input @error('imageFile') is-invalid @enderror"
        id="customFile" />
      <label class="custom-file-label" for="customFile">Choose file</label>
      @error('imageFile')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
  </div>

  <!-- Approve Um Button -->
  <button type="submit" name="action" value="approve_um" class="btn btn-primary"
    {{ $approve_um == 'OK' ? 'disabled' : '' }}>Approve UM</button>
  <!-- Approve Rm Button -->
  <button type="submit" name="action" value="approve_rm" class="btn btn-primary"
    {{ $approve_rm == 'OK' ? 'disabled' : '' }}>Approve RM</button>
</div>
