<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labeling</title>
</head>
<style>
    body {
        display: grid;
        align-items: center;
        justify-items: center;
    }

    * {
        box-sizing: border-box;
    }

    .overflow-hidden {
        overflow: hidden;
    }

    .qrcode-font {
        font-size: 9px;
        margin-top: 3px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }

    html,
    body {
        margin: 0;
        padding: 0;
    }

    .label-border {
        border: 1px dashed white;
    }

    .label-elemenet {
        display: inline-block;
    }

    .block {
        display: block;
    }

    .code-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

</style>
<body>
    @foreach($labelings as $index=>$item)
		@php
			$quantity = $item->qty ?: $item->quantity ;
			$quantity = is_numeric($quantity) ? $quantity : 1;
  			$previousQuantity = $item->getPreviousRowsQuantities();
			
			$quantityStartFrom = $item->quantityStartFrom() ;
			$qIndex = $quantityStartFrom + $previousQuantity  + 1 ;
			$fromToString = $item->getCode($index+1,true);

			 
			
			
		@endphp
		
		@for($i = 0 ; $i< $quantity ; $i++ )
    <div style="width:{{ $width }}cm;height:{{ $height }}cm;padding-top:{{ $paddingTop }}cm;padding-bottom:{{ $paddingTop }}cm;padding-right:{{ $paddingLeft }}cm;padding-left:{{ $paddingLeft }}cm;margin-bottom:{{ $marginBottom }}cm;" class="label-elemenet label-border overflow-hidden">
        <div class="code-item">
            <img style="width:{{ 0.5*$height }}cm;height:{{ 0.5*$height }}cm;@if(!$company->labeling_use_client_logo)margin:auto;@endif" src="data:image/png;base64,{!! DNS2D::getBarcodePNG(str_replace($fromToString , $qIndex+ $i,qrcodeSpacing($item->getCode($index+1))), 'QRCODE') !!}" alt="barcode" />
            @if($company->labeling_use_client_logo)
            <img style="max-height:{{ 0.5*$height }}cm" src="{{ $company->labeling_use_client_logo ? asset('storage/'.$company->labeling_client_logo) : null }}">
            @endif
        </div>
        <span class="block qrcode-font"> {{ $item->getCode($index+1) }} </span>
    </div>
    <div></div>
	@endfor 
    @endforeach

</body>
</html>
