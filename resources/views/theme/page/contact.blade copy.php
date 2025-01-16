@php extract($data); @endphp

@extends($templatePath.'.layouts.index')

@section('seo')
@endsection

@section('content')

    <div class="banner-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 p-md-5 pt-3 bg-white contact-page-info">
                    <h3>{!! htmlspecialchars_decode(setting_option('contact-company')) !!}</h3>
                    <p>{!! htmlspecialchars_decode(setting_option('company-address-1')) !!}</p>
                    <p>{!! htmlspecialchars_decode(setting_option('company-address-2')) !!}</p>
                </div>
                <div class="col-lg-6 p-md-5 pt-3 bg-white contact-page-info">
                <!-- <h3 class="fs-3 fw-bold">{{ __('Contact') }}</h3> -->

                    <form method="POST" action="{{ route('contact.submit') }}" enctype="multipart/form-data">
                        @csrf
                        @include($templatePath .'.contact.contact_content')
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{{ __('Send message') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection