@extends('layouts.backend')

@section('title', __('Product'))

@section('content')
<!-- main Section -->
<div class="main-body">
	<div class="container-fluid">
		@php $vipc = vipc(); @endphp
		@if($vipc['bkey'] == 0)
		@include('backend.partials.vipc')
		@else
		<div class="row mt-25">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-lg-6">
								{{ __('Product') }}
							</div>
							<div class="col-lg-6">
								<div class="float-right">
									<a href="{{ route('backend.products') }}" class="btn warning-btn"><i class="fa fa-reply"></i> {{ __('Back to List') }}</a>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body tabs-area p-0">
						@include('backend.partials.product_tabs_nav')
						<div class="tabs-body">
							<!--Data Entry Form-->
							<form novalidate="" data-validate="parsley" id="DataEntry_formId">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="lan">{{ __('Language') }}<span class="red">*</span></label>
											<select name="lan" id="lan" class="chosen-select form-control">
											@foreach($languageslist as $row)
												<option {{ $row->language_code == $datalist['lan'] ? "selected=selected" : '' }} value="{{ $row->language_code }}">
													{{ $row->language_name }}
												</option>
											@endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-6"></div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="product_name">{{ __('Product Name') }}<span class="red">*</span></label>
											<input value="{{ $datalist['title'] }}" type="text" name="title" id="product_name" class="form-control parsley-validated" data-required="true">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="slug">{{ __('Slug') }}<span class="red">*</span></label>
											<input value="{{ $datalist['slug'] }}" type="text" name="slug" id="slug" class="form-control parsley-validated" data-required="true">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="short_desc">{{ __('Short Description') }}</label>
											<textarea name="short_desc" id="short_desc" class="form-control" rows="2">{{ $datalist['short_desc'] }}</textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group tpeditor">
											<label for="description">{{ __('Product Content') }}</label>
											<textarea name="description" id="description" class="form-control" rows="4">{{ $datalist['description'] }}</textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="brand_id">{{ __('Brand') }}<span class="red">*</span></label>
											<select name="brand_id" id="brand_id" class="chosen-select form-control">
											<option value="0">No Brand</option>
											@foreach($brandlist as $row)
												<option {{ $row->id == $datalist['brand_id'] ? "selected=selected" : '' }} value="{{ $row->id }}">
													{{ $row->name }}
												</option>
											@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="cat_id">{{ __('Category') }}<span class="red">*</span></label>
											<select name="cat_id" id="cat_id" class="chosen-select form-control">
											<option value="" selected="selected">{{ __('Select Category') }}</option>
											@foreach($categorylist as $row)
												<option {{ $row->id == $datalist['cat_id'] ? "selected=selected" : '' }} value="{{ $row->id }}">
													{{ $row->name }}
												</option>
											@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="collection_id">{{ __('Collection') }}</label>
											<select name="collection_id" id="collection_id" class="chosen-select form-control">
											<option value="0">No Collection</option>
											@foreach($collectionlist as $row)
												<option {{ $row->id == $datalist['collection_id'] ? "selected=selected" : '' }} value="{{ $row->id }}">
													{{ $row->name }}
												</option>
											@endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="label_id">{{ __('Label') }}</label>
											<select name="label_id" id="label_id" class="chosen-select form-control">
											<option value="0">No Label</option>
											@foreach($labellist as $row)
												<option {{ $row->id == $datalist['label_id'] ? "selected=selected" : '' }} value="{{ $row->id }}">
													{{ $row->title }}
												</option>
											@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="tax_id">{{ __('Tax') }}</label>
											<select name="tax_id" id="tax_id" class="chosen-select form-control">
											@foreach($taxlist as $row)
												<option {{ $row->id == $datalist['tax_id'] ? "selected=selected" : '' }} value="{{ $row->id }}">
													{{ $row->title }}
												</option>
											@endforeach
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="is_featured">{{ __('Featured') }}</label>
											<select name="is_featured" id="is_featured" class="chosen-select form-control">
												<option {{ 1 == $datalist['is_featured'] ? "selected=selected" : '' }} value="1">{{ __('YES') }}</option>
												<option {{ 0 == $datalist['is_featured'] ? "selected=selected" : '' }} value="0">{{ __('NO') }}</option>
											</select>
										</div>
									</div>
                                    {{-- for Availability options values are On Transit, In China and In Stock --}}
                                    <div class="col-lg-6">
										<div class="form-group">
											<label for="availability">{{ __('Availability') }}</label>
											<select name="availability" id="availability" class="chosen-select form-control">
												<option {{ 'On Transit' == $datalist['availability'] ? "selected=selected" : '' }} value="On Transit">{{ __('On Transit') }}</option>
												<option {{ 'Over Sea' == $datalist['availability'] ? "selected=selected" : '' }} value="Over Sea">{{ __('Over Sea') }}</option>
												<option {{ 'In Stock' == $datalist['availability'] ? "selected=selected" : '' }} value="In Stock">{{ __('In Stock') }}</option>
												<option {{ 'Sold Out' == $datalist['availability'] ? "selected=selected" : '' }} value="Sold Out">{{ __('Sold Out') }}</option>
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="is_publish">{{ __('Status') }}<span class="red">*</span></label>
											<select name="is_publish" id="is_publish" class="chosen-select form-control">
											@foreach($statuslist as $row)
												<option {{ $row->id == $datalist['is_publish'] ? "selected=selected" : '' }} value="{{ $row->id }}">
													{{ $row->status }}
												</option>
											@endforeach
											</select>
										</div>
									</div>
                                    {{-- Now input for battery --}}
                                    <div class="col-lg-3">
										<div class="form-group">
											<label for="battery">{{ __('Battery') }}</label>
											<input type="number" step="0.01" name="battery" id="battery" class="form-control" value="{{ $datalist['battery'] }}">
										</div>
									</div>
                                    {{-- Now input for range --}}
                                    <div class="col-lg-3">
										<div class="form-group">
											<label for="range">{{ __('Range') }}</label>
											<input type="number" step="0.01" name="range" id="range" class="form-control" value="{{ $datalist['range'] }}">
										</div>
									</div>
                                    {{-- Now input for charging --}}
                                    <div class="col-lg-3">
										<div class="form-group">
											<label for="charging">{{ __('Charging') }}</label>
											<input type="number" step="0.01" name="charging" id="charging" class="form-control" value="{{ $datalist['charging'] }}">
										</div>
									</div>
                                    {{-- Now input for Mileage --}}
                                    <div class="col-lg-3">
										<div class="form-group">
											<label for="mileage">{{ __('Mileage') }}</label>
											<input type="number" step="0.01" name="mileage" id="mileage" class="form-control" value="{{ $datalist['mileage'] }}">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="f_thumbnail_thumbnail">{{ __('Featured image') }}<span class="red">*</span></label>
											<div class="tp-upload-field">
												<input value="{{ $datalist['f_thumbnail'] }}" type="text" name="f_thumbnail" id="f_thumbnail_thumbnail" class="form-control" readonly>
												<a onClick="onGlobalMediaModalView()" href="javascript:void(0);" class="tp-upload-btn"><i class="fa fa-window-restore"></i>{{ __('Browse') }}</a>
											</div>
											<em>Recommended image size width: 600px and height: 600px.</em>
											<div id="remove_f_thumbnail" class="select-image dnone">
												<div class="inner-image" id="view_thumbnail_image"></div>
												<a onClick="onMediaImageRemove('f_thumbnail_thumbnail')" class="media-image-remove" href="javascript:void(0);"><i class="fa fa-remove"></i></a>
											</div>
										</div>
									</div>
									<div class="col-lg-6"></div>
								</div>

								<input value="{{ $datalist['id'] }}" type="text" name="RecordId" id="RecordId" class="dnone">
								<div class="row tabs-footer mt-15">
									<div class="col-lg-12">
										<a id="submit-form" href="javascript:void(0);" class="btn blue-btn">{{ __('Save') }}</a>
									</div>
								</div>
							</form>
							<!--/Data Entry Form/-->
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
</div>
<!-- /main Section -->

<!--Global Media-->
@include('backend.partials.global_media')
<!--/Global Media/-->

@endsection

@push('scripts')
<!-- css/js -->
<script type="text/javascript">
var media_type = 'Product_Thumbnail';
var strIds = "{{ $datalist['category_ids'] }}";
if(strIds !=''){
	var idsArr = strIds.split(",");
	$("#category_ids").val(idsArr).trigger("chosen:updated");
}
var f_thumbnail = "{{ $datalist['f_thumbnail'] }}";
if(f_thumbnail == ''){
	$("#remove_f_thumbnail").hide();
	$("#f_thumbnail_thumbnail").html('');
}
if(f_thumbnail != ''){
	$("#remove_f_thumbnail").show();
	$("#view_thumbnail_image").html('<img src="'+public_path+'/media/'+f_thumbnail+'">');
}
var TEXT = [];
	TEXT['Select Category'] = "{{ __('Select Category') }}";

</script>
<link href="{{asset('backend/editor/summernote-lite.min.css')}}" rel="stylesheet">
<script src="{{asset('backend/editor/summernote-lite.min.js')}}"></script>
<script src="{{asset('backend/pages/product.js')}}"></script>
<script src="{{asset('backend/pages/global-media.js')}}"></script>
@endpush
