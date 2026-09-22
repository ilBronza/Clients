@if($image)
	<img src="{{ $image }}" alt="{{ $modelInstance->getName() }} Logo">
@else
	<img src="{{ $modelInstance->getMissingLogoUrl() }}" alt="{{ $modelInstance->getName() }} Logo">
@endif

<a
	class="uk-button uk-button-small uk-button-primary"
	data-type="iframe"
	href="{{ $modelInstance->getUploadLogoFormUrl() }}?iframed=true"
>
	@lang('crud::buttons.uploadNewImage')
</a>
