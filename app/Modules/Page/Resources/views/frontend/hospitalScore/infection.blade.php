@extends( front_layout('master') )
@section('title', $page_title)
@section('meta_tags')
    @if( isset($seo_metadata['meta_keywords']) && $seo_metadata['meta_keywords'] )
        <meta name="keywords" content="{{ $seo_metadata['meta_keywords'] }}"/>
    @endif

    <meta property="url" content="{{ route(front_route('page.hospital.infection'), $hospital->slug) }}"/>
    <meta property="type" content="article"/>
    <meta property="title" content="{{ $page_title }}"/>
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="description" content="{{ $seo_metadata['meta_description'] }}"/>
    @else
        <meta property="description" content="{{ $hospital->short_desc ?: $hospital->hospital_ownership ?: '' }}"/>
    @endif

    <meta property="og:url" content="{{ route(front_route('page.unpaid'), $hospital->slug) }}"/>
    <meta property="og:title" content="{{ $page_title }}"/>
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="og:description" content="{{ $seo_metadata['meta_description'] }}"/>
    @else
        <meta property="og:description" content="{{ $hospital->short_desc ?: $hospital->hospital_ownership ?: '' }}"/>
    @endif
    @if(isset($hospital->hospital_info->share_image) && !empty($hospital->hospital_info->share_image) && $hospital->hospital_info->share_image!=null)
        <meta property="image" content="{{$hospital->hospital_info->image_url_share}}"/>
        <meta property="og:image" content="{{$hospital->hospital_info->image_url_share}}"/>
        <meta property="og:image:url" content="{{$hospital->hospital_info->image_url_share}}"/>
        <meta property="og:image:width" content="400"/>
        <meta property="og:image:height" content="300"/>
        <meta name=”twitter:title” content="{{ $page_title }}"/>
        <meta name="twitter:image:src" content="{{$hospital->hospital_info->image_url_share}}"/>
        <meta name="twitter:image" content="{{$hospital->hospital_info->image_url_share}}"/>

    @else
        @php $site_settings = get_site_settings(); @endphp
        @if( isset($hospital->hospital_info->image_url_logo) )
            <meta property="image" content="{{$hospital->hospital_info->image_url_logo}}"/>
            <meta property="og:image" content="{{$hospital->hospital_info->image_url_logo}}"/>
            <meta property="og:image:url" content="{{$hospital->hospital_info->image_url_logo}}"/>
            <meta property="og:image:width" content="400"/>
            <meta property="og:image:height" content="300"/>
            <meta name=”twitter:title” content="{{ $page_title }}"/>
            <meta name="twitter:image:src" content="{{$hospital->hospital_info->image_url_logo}}"/>
            <meta name="twitter:image" content="{{$hospital->hospital_info->image_url_logo}}"/>
        @else
            <meta property="image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
            <meta property="og:image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
            <meta property="og:image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
            <meta property="og:image:url" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
            <meta property="og:image:width" content="400"/>
            <meta property="og:image:height" content="300"/>
            <meta name="twitter:image:src" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
            <meta name="twitter:image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
        @endif
    @endif

@endsection
@section('content')

    <div class="unsubscribe infection">
        <div class="custom-container">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <a class="bacnbtn" href="{{route(front_route('page.unpaid'),$hospital->slug)}}"><i class="fas fa-angle-double-left"></i> Back</a>
                </div>
                <div class="col-md-10">
                    @include( frontend_module_view('hospitalScore.stars', 'Page') , ['item' => $hospital])
                </div>
            </div>

            <div class="row sub-detial d-flex align-items-center">
                <div class="col-md-5">

                    <div class="shelby d-flex flex-column align-items-start">
                        @include(frontend_module_view('premium-info._logo', 'Page'), ['hospital' => $hospital,'subscribe_order' => $subscribe_order])
                        <div class="share">
                            <a href="javascript:void(0)"><i class="fas fa-share-square"></i> Share this Hospital</a>
                        </div>
                    </div>
                    <h2 class="catheading">
                        @include(frontend_module_view('premium-info._name', 'Page'), ['hospital' => $hospital,'subscribe_order' => $subscribe_order])
                    </h2>
                    <div class="info">
                        @include(frontend_module_view('premium-info._left_info', 'Page'), ['hospital' => $hospital,'subscribe_order' => $subscribe_order])
                    </div>
                </div>
                <div class="col-md-7">
                    @include(frontend_module_view('premium-info._slider', 'Page'), ['hospital' => $hospital,'subscribe_order' => $subscribe_order])
                    <div class="row d-flex justify-content-end mt-5">
                        <div class="benchmark">
                            <h6>Over All CMS Score:</h6>
                            <ul class="rates">
                                <li><a class="btn red">Worse</a></li>
                                <li><a class="btn yellow">Good</a></li>
                                <li><a class="btn green">Best</a></li>
                                <li><a class="btn silver">Not Available</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row listings">
                <div class="col-md-9">
                    <h2>Infections <br><span style="font-size: 14.5px; display: block;">National Benchmark: {{number_format(\App\Models\PatientInfection::where('type_of','NATIONAL')->orderBy('score','ASC')->first()->score,3)}}</span></h2><br>

                    <div class="img">
                        <img src="{{asset(front_asset('images/single-infection.webp'))}}" alt="single-infection">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="share">
                        <a href="#"><i class="fas fa-share-square"></i> Share this Hospital's score</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <ul>
                        @if( $hospital->infection_patients->count() )
                            @foreach($hospital->infection_patients as $patient_infection)
                                <li class="white">
                                    <h4>{{$patient_infection->measure_name}}</h4>
                                    <div class="boxes">
                                        <div class="inner-box">
                                            <h5>Score:</h5>
                                            @if($patient_infection->compared_to_national=='No Different than National Benchmark' && $patient_infection->score==0  )
                                                <p class="btn {{ $patient_infection->score_class }}">Best Possible Score</p>

                                            @else
                                                <p class="btn {{ $patient_infection->score_class }}">{{$patient_infection->score}}</p>

                                            @endif
                                        </div>
                                        <div class="inner-box">
                                            <h5>Footnote:</h5>
                                            <p>{!! $patient_infection->footnote_score_not_available?:'-' !!}</p>
                                        </div>
                                        <div class="inner-box">
                                            <h5>Start Date:</h5>
                                            <p>{{$patient_infection->start_date?:'-'}}</p>
                                        </div>
                                        <div class="inner-box">
                                            <h5>End Date:</h5>
                                            <p>{{$patient_infection->end_date?:'-'}}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li class="white">Not available</li>
                        @endif
                    </ul>
                </div>
            </div>

            @include( frontend_module_view('hospitalScore.more-info-hospital', 'Page'))

        </div>
    </div>

@endsection
@push('modals')
    <div class="modal fade" id="share-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Share</h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <ul class="p-0">
                                <li>
                                    <a href="javascript:void(0);" class="shareModalLinks const-share-hospital" data-channel="facebook">
                                        <i class="fa fa-facebook" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="shareModalLinks const-share-hospital" data-channel="twitter">
                                        <i class="fa fa-twitter" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="shareModalLinks const-share-hospital" data-channel="linkedin">
                                        <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="shareModalLinks" data-channel="copy">
                                        <i class="fas fa-copy" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush
