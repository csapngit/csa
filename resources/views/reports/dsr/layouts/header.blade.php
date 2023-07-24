<div class="row" style="font-weight: 600">
    <div class="col">
        <!-- Date -->
        <div class="row">
            <label for="" class="col-md-3 col-form-label">
                {{ __('app.reports.dsr.date') }}
            </label>
            <label class="col col-form-label">
                : {{ $dates['date'] }}
            </label>
        </div>

        <!-- Timegone % -->
        <div class="row">
            <label for="" class="col-md-3 col-form-label">
                {{ __('app.reports.dsr.timegone_index') }}
            </label>
            <label class="col col-form-label">
                : {{ round($dates['timegone_index'], 2) }}{{ __('app.operators.percentage') }}
            </label>
        </div>

        <!-- Hari Kerja -->
        <div class="row">
            <label for="" class="col-md-3 col-form-label">
                {{ __('app.reports.dsr.working_days') }}
            </label>
            <label class="col col-form-label">
                : {{ $dates['workday'] }}
            </label>
        </div>

        <!-- Timegone -->
        <div class="row">
            <label for="" class="col-md-3 col-form-label">
                {{ __('app.reports.dsr.timegone') }}
            </label>
            <label class="col col-form-label">
                : {{ $dates['timegone'] }}
            </label>
        </div>

        <!-- Sisa hari kerja -->
        <div class="row">
            <label for="" class="col-md-3 col-form-label">
                {{ __('app.reports.dsr.the_rest_of_working_days') }}
            </label>
            <label class="col col-form-label">
                : {{ $dates['rest_of_workdays'] }}
            </label>
        </div>
    </div>

    <!-- Target -->
    <div class="col">
        <div class="row">
            <label for="" class="col-md-3 col-form-label">
                {{ __('app.reports.dsr.target') }}
            </label>
            <label class="col col-form-label">
                : {{ __('app.operators.rupiah') }}{{ number_format($channel_DSRs['TOTAL']['monthly_target']) }}
            </label>
        </div>

        <!-- So open -->
        <div class="row">
            <label for="" class="col-md-3 col-form-label">
                {{ __('app.reports.dsr.so_open') }}
            </label>
            <label class="col col-form-label">
                : {{ __('app.operators.rupiah') }}{{ number_format($channel_DSRs['TOTAL']['so_open']) }}
            </label>
        </div>

        <!-- DO -->
        <div class="row">
            <label for="" class="col-md-3 col-form-label">
                {{ __('app.reports.dsr.delivery_order') }}
            </label>
            <label class="col col-form-label">
                : {{ __('app.operators.rupiah') }}{{ number_format($channel_DSRs['TOTAL']['delivery_order']) }}
            </label>
        </div>

        <!-- AR -->
        <div class="row">
            <label for="" class="col-md-3 col-form-label">
                {{ __('app.reports.dsr.ar_invoice') }}
            </label>
            <label class="col col-form-label">
                : {{ __('app.operators.rupiah') }}{{ number_format($channel_DSRs['TOTAL']['ar_invoice']) }}
            </label>
        </div>

        <!-- Best Estimate -->
        <div class="row">
            <label for="" class="col-md-3 col-form-label">
                {{ __('app.reports.dsr.best_estimate') }}
            </label>
            <label class="col col-form-label">
                : {{ __('app.operators.rupiah') }}{{ number_format($channel_DSRs['TOTAL']['best_estimate']) }}
            </label>
        </div>

        <!-- Acvh vs Target -->
        <div class="row">
            <label for="" class="col-md-3 col-form-label">
                {{ __('app.reports.dsr.acvh_vs_target') }}
            </label>
            <label class="col col-form-label">
                : {{ round($channel_DSRs['TOTAL']['achv_vs_target'], 2) }}{{ __('app.operators.percentage') }}
            </label>
        </div>

        <!-- Achv vs Timegone -->
        <div class="row">
            <label for="" class="col-md-3 col-form-label">
                {{ __('app.reports.dsr.acvh_vs_timegone') }}
            </label>
            <label class="col col-form-label">
                : {{ round($channel_DSRs['TOTAL']['achv_vs_timegone'], 2) }}{{ __('app.operators.percentage') }}
            </label>
        </div>
    </div>
</div>
