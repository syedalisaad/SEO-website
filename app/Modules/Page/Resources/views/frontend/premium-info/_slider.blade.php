@php $extra = is_object($hospital->hospital_info) ? $hospital->hospital_info->extras : [];
@endphp
@if($hospital->hospital_info && !empty($hospital->hospital_info->image_url_right) && isset($subscribe_order))

    <div class="pre-slider">

        @php

            $user_id = is_object($hospital->hospital_info) ? $hospital->hospital_info->user_id : 0;
                $order           = get_current_subscription($user_id);
               if($order){
                  $video         = $order->hasOneOrderItem->product->extras;
               }
        @endphp

        {{--    vidoe slider start--}}
        @if(isset($extra['video_one_status']) )

            @if(isset($video) && $video && $extra['video_one_status']==0 && $video['video']>=1)
                @if(  $hospital->hospital_info->video_one)
                    <div class="video_play_frame">
                        <div class="pre-slide play_button_img">
                            {{--                        <a data-fancybox="gallery" href="{{$hospital->hospital_info->url_video_one}}">--}}
                            <video
                                width="100%"
                                controls
                                loop
                                muted
                                preload="metadata"
                                id="video_{{$video['video']}}">
                                <source src="{{$hospital->hospital_info->url_video_one}}">
                            </video>
                            {{--                        </a>--}}
                        </div>
                    </div>
                @endif
            @endif

            @if($extra['video_one_status']==1 && isset($extra['video_one_youtube']))
                @php
                    $youtubeId = getYoutubeId($extra['video_one_youtube']);
                    $yt_link = 'https://www.youtube.com/embed/'.$youtubeId;
                @endphp
                <div class="video_play_frame">
                    <div class="pre-slide ">
                        <iframe
                            height="100%"
                            width="100%"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            frameborder="0"
                            allowfullscreen
                            src="{{$yt_link}}?">
                        </iframe>
                    </div>
                </div>
            @endif

        @endif
        @if(isset($extra['video_two_status']))


            @if(isset($video) && $video && $extra['video_two_status']==0 && $video['video']>=2)
                @if($hospital->hospital_info->video_two)
                    <div class="video_play_frame">
                        <div class="pre-slide play_button_img">
                            {{--                        <a data-fancybox="gallery" class="img" href="{{$extra['video_two_status']}}">--}}
                            <video
                                width="100%"
                                controls
                                loop
                                muted
                                preload="metadata"
                                id="video_{{$video['video']}}">
                                <source src="{{$hospital->hospital_info->url_video_two}}">
                            </video>
                            {{--                        </a>--}}
                        </div>
                    </div>
                @endif
            @endif

            @if($extra['video_two_status']==1 && isset($extra['video_two_youtube']))
                @php
                    $youtubeId2 = getYoutubeId($extra['video_two_youtube']);
                    $yt_link2 = 'https://www.youtube.com/embed/'.$youtubeId2;
                @endphp
                <div class="video_play_frame">
                    <div class="pre-slide ">
                        <iframe
                            height="100%"
                            width="100%"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            frameborder="0"
                            allowfullscreen
                                src="{{$yt_link2}}">
                        </iframe>

                    </div>
                </div>
            @endif

        @endif
        @if( isset($extra['video_three_status'])  )


            @if(isset($video) && $video && $extra['video_three_status']==0 && $video['video']>=3)
                @if($hospital->hospital_info->video_three)
                    <div class="video_play_frame">
                        <div class="pre-slide play_button_img">
                            {{--                        <a data-fancybox="gallery" href="{{$hospital->hospital_info->url_video_three}}">--}}
                            <video width="100%"
                                   controls
                                   loop
                                   muted
                                   preload="metadata"
                                   id="video_{{$video['video']}}">
                                <source src="{{$hospital->hospital_info->url_video_three}}">
                            </video>
                            {{--                        </a>--}}

                        </div>
                    </div>
                @endif
            @endif

            @if($extra['video_three_status']==1 && isset($extra['video_three_youtube']))
                @php
                    $youtubeId3 = getYoutubeId($extra['video_three_youtube']);
                    $yt_link3 = 'https://www.youtube.com/embed/'.$youtubeId3;
                @endphp
                <div class="video_play_frame">
                    <div class="pre-slide ">
                        <iframe
                            height="100%"
                            width="100%"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            frameborder="0"
                            allowfullscreen
                            src="{{$yt_link3}}">
                        </iframe>
                    </div>
                </div>
            @endif

        @endif

        <div class="pre-slide ">
            {{--            <a data-fancybox="gallery" href="{{$hospital->hospital_info->image_url_right}}">--}}
            <img src="{{$hospital->hospital_info->image_url_right}}">
            {{--            </a>--}}
        </div>

        {{--    vidoe slider end--}}
    </div>
@endif
