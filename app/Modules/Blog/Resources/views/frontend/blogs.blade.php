@extends( front_layout('master') )
@section('title', 'Blogs')
@section('content')

{{--    <section class="section bg-secondary " {!! $data->page_header_url?'style="background:url('.$data->page_header_url.') !important"':null !!}>--}}
{{--        <div class="container">--}}
{{--            --}}
{{--        </div>--}}
{{--    </section>--}}

    <section class="blogpage">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Blogs</h2>
                    @if( $data->page_header_sub_title )
                        <h5>{{ $data->page_header_sub_title }}</h5>
                    @endif
                </div>
            </div>
            <div class="row masonry-container">
                @if( $blogs->count() )
                    @foreach($blogs as $blog)
                        <div class="col-lg-4 col-sm-6 mb-5">
                            <article>
                                <div class="img">
                                    <a href="{{ $blog->post_url }}">
                                        <img class="img-fluid mb-4" src="{{ $blog->image_url }}" alt="{{ $blog->name }}">
                                    </a>
                                </div>
                                <h4>
                                    <a href="{{ $blog->post_url }}">{{ $blog->name }}</a>
                                </h4>
                                <p>{{ $blog->short_desc }}</p>
                                <a href="{{ $blog->post_url   }}" class="btn btn-transparent">read more <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                            </article>
                        </div>
                    @endforeach

                    <div class="pagination-lg">
                        <ul>
                            {{ $blogs->links() }}
                        </ul>
                    </div>
                @else
                    No blogs available
                @endif
            </div>
        </div>
    </section>

@endsection
