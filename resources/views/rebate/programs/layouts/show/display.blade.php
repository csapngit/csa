<div class="form-group">
  <!-- Add Tier Button -->
  <a href="{{ route('tiers.create', $program->id) }}" class="btn btn-primary">{{ __('app.tiers.pages.create') }}</a>

  <!-- Back Button -->
  <x-buttons.back routeName="programs.index" />
</div>

<table id="example" class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>{{ __('app.tables.number') }}</th>
      <th>{{ __('app.tables.name') }}</th>
      <th>{{ __('app.tiers.display') }}</th>
      <th>{{ __('app.tiers.monthly_display') }}</th>
      <th>{{ __('app.tiers.monthly_volume') }}</th>
      <th>{{ __('app.tables.action') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($program->programTiers as $tier)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $tier->name }}</td>
      <td>{{ $tier->display }}</td>
      <td>{{ $tier->formatted_monthly_display }}</td>
      <td>{{ $tier->monthly_volume, 2 }}{{ __('app.operators.percentage') }} </td>
      <td>

        <!-- Edit Button -->
        <x-buttons.edit routeName="tiers" :id="$tier->id" />

        <!-- Delete Button -->
        <x-buttons.delete routeName="tiers" :id="$tier->id" />

      </td>
    </tr>
    @endforeach
  </tbody>
</table>
