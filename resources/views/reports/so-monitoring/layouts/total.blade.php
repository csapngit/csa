<div class="card mt-5">
	<div class="card-body">
		{{-- <div class="row"> --}}
			<div style="display: flex; justify-content: flex-start">
				{{-- <div class="col-sm"> --}}
					<div class="d-flex align-items-center" style="margin-right: 15%">
						<!--begin::Symbol-->
						<div class="symbol symbol-45 symbol-light-info mr-4 flex-shrink-0">
							<div class="symbol-label">
								<span class="svg-icon svg-icon-lg svg-icon-info">
									<!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Cart3.svg-->
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
										height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<path
												d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z"
												fill="#000000" fill-rule="nonzero" opacity="0.3" />
											<path
												d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z"
												fill="#000000" />
										</g>
									</svg>
									<!--end::Svg Icon-->
								</span>
							</div>
						</div>
						<!--end::Symbol-->
						<!--begin::Title-->
						<div>
							<div class="font-size-h4 text-dark-75 font-weight-bolder">{{ number_format($totalOrder) }}</div>
							<div class="font-size-sm text-muted font-weight-bold mt-1">
								{{ __('app.reports.so-monitorings.total_so') }}</div>
						</div>
						<!--end::Title-->
					</div>
				{{-- </div> --}}
				{{-- <div class="col-sm"> --}}
					<div class="d-flex align-items-center" style="margin-right: 15%">
						<!--begin::Symbol-->
						<div class="symbol symbol-45 symbol-light-info mr-4 flex-shrink-0">
							<div class="symbol-label">
								<span class="svg-icon svg-icon-lg svg-icon-info">
									<!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Cart3.svg-->
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
										height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<path
												d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z"
												fill="#000000" fill-rule="nonzero" opacity="0.3" />
											<path
												d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z"
												fill="#000000" />
										</g>
									</svg>
									<!--end::Svg Icon-->
								</span>
							</div>
						</div>
						<!--end::Symbol-->
						<!--begin::Title-->
						<div>
							<div class="font-size-h4 text-dark-75 font-weight-bolder">{{ number_format($totalMerch) }}</div>
							<div class="font-size-sm text-muted font-weight-bold mt-1">
								{{ __('app.reports.so-monitorings.totmerch') }}
							</div>
						</div>
						<!--end::Title-->
					</div>
				{{-- </div> --}}
				{{-- <div class="col-sm"> --}}
					<div class="d-flex align-items-center" style="margin-right: 15%">
						<!--begin::Symbol-->
						<div class="symbol symbol-45 symbol-light-info mr-4 flex-shrink-0">
							<div class="symbol-label">
								<span class="svg-icon svg-icon-lg svg-icon-info">
									<!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Cart3.svg-->
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
										height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<path
												d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z"
												fill="#000000" fill-rule="nonzero" opacity="0.3" />
											<path
												d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z"
												fill="#000000" />
										</g>
									</svg>
									<!--end::Svg Icon-->
								</span>
							</div>
						</div>
						<!--end::Symbol-->
						<!--begin::Title-->
						<div>
							<div class="font-size-h4 text-dark-75 font-weight-bolder">
								{{ round($totalIndex, 1) }}{{ __('app.operators.percentage') }}</div>
							<div class="font-size-sm text-muted font-weight-bold mt-1">
								{{ __('app.reports.so-monitorings.total_average') }}
							</div>
						</div>
						<!--end::Title-->
					</div>
				{{-- </div> --}}
			</div>
		{{-- </div> --}}
	</div>
</div>