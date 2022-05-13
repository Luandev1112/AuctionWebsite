@extends($activeTemplate.'layouts.frontend')
@section('content')
 <section class="blog-section pt-120 pb-120">
    <div class="container">
        <div class="row gy-5">
            <div class="col-lg-12 col-xl-12">
                <div class="row g-4">
                	@foreach($blogs as $blog)
	                    <div class="col-xl-3 col-md-6 col-sm-10">
	                        <div class="post__item">
	                            <div class="post__thumb">
	                                <a href="{{ route('blog.details',[$blog->id,slug($blog->data_values->title)]) }}">
	                                    <img src="{{getImage('assets/images/frontend/blog/'. @$blog->data_values->blog_image, '900x600')}}" alt="@lang('blog')">
	                                </a>
	                            </div>
	                            <div class="post__content">
	                                <h6 class="post__title">
	                                    <a href="{{ route('blog.details',[$blog->id,slug($blog->data_values->title)]) }}">{{__($blog->data_values->title)}}</a>
	                                </h6>
	                                <div class="meta__date">
	                                    <div class="meta__item">
	                                        <i class="las la-calendar"></i>
	                                        {{showDateTime($blog->created_at, 'd M Y')}}
	                                    </div>
	                                    <div class="meta__item">
	                                        <i class="las la-user"></i>
	                                        @lang('Admin')
	                                    </div>
	                                </div>
	                                <a href="{{ route('blog.details',[$blog->id,slug($blog->data_values->title)]) }}" class="post__read">@lang('Read More') <i class="las la-long-arrow-alt-right"></i></a>
	                            </div>
	                        </div>
	                    </div>
	                @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection