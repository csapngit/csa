<div>
  {{-- Nothing in the world is as soft and yielding as water. --}}

  <!-- Select Area -->
  <div class="row">
    <div class="col-md">
      <div class="form-group">
        <select name="area" wire:model="selectedArea" class="form-control">
          <option selected disable value="">{{ __('app.programs.placeholder.area') }}</option>
          @foreach ($areas as $area)
          <option value="{{ $area }}">{{ $area }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-md">
      <button type="button" wire:click="getdataTable"
        class="btn btn-primary mb-3">{{ __('app.button.refresh') }}</button>
    </div>
  </div>

  <!-- Table -->
  <table id="" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th style="width: 5%">
          <input type="checkbox" class="checked_all">
        </th>
        <th>{{ __('app.customers.customer_id') }}</th>
        <th>{{ __('app.tables.name') }}</th>
        <th>{{ __('app.customers.target') }}</th>
        <th>{{ __('app.customers.offtakes') }}</th>
        <th>Can Publish</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($generates as $generate)
      @php
      $generate = is_array($generate) ? (object) $generate : $generate;
      @endphp
      <tr>
        <td>
          <input type="checkbox" name="customer_id[{{ $generate->customer_id }}]" class="check_customer_id" {{ !$generate->can_publish ? 'disabled' : '' }}>
        </td>
        <td>{{ $generate->customer_id }}</td>
        <td>{{ $generate->name }}</td>
        <td>{{ $generate->target }}</td>
        <td>{{ $generate->offtakes }}</td>
        <td>{{ $generate->can_publish }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
