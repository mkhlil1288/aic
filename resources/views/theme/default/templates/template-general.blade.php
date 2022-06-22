@extends('theme.default.layout')
@section('content')

<!-- Hero-area -->
<div class="hero-area section">

	<!-- Backgound Image -->
	<div class="bg-image bg-parallax overlay" style="background-image:url({{ theme_asset_url('img/page-background.jpg') }})"></div>
	<!-- /Backgound Image -->

	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1 text-center">
				<ul class="hero-area-tree">
					<li><a href="{{ url('/') }}">{{ _lang('Home') }}</a></li>
					<li>{{ $page->content[0]->page_title }}</li>
				</ul>
				<h1 class="white-text">{{ $page->content[0]->page_title }}</h1>
				<ul class="blog-post-meta">
					<li class="blog-meta-author">{{ _lang('By') }} : <a href="#">{{ $page->author->name }}</a></li>
					<li>{{ date('d M, Y',strtotime($page->created_at)) }}</li>
				</ul>
			</div>
		</div>
	</div>

</div>
<!-- /Hero-area -->

<!-- Blog -->
<div id="blog" class="section">

	<!-- container -->
	<div class="container">

		<!-- row -->
		<div class="row">

			<!-- main blog -->
			<div id="main" class="col-md-9">

				<!-- blog page -->
				<div class="blog-page">
				{!! $page->content[0]->page_content !!}
				</div>
				<!-- /blog page -->

			</div>
			<!-- /main blog -->

			<!-- aside blog -->
			<div id="aside" class="col-md-3">

				<!-- search widget -->
				<div class="widget search-widget">
					<form>
						<input class="input" type="text" name="search">
						<button><i class="fa fa-search"></i></button>
					</form>
				</div>
				<!-- /search widget -->

				<!-- category widget -->
				<div class="widget category-widget">
					<h3>{{ _lang('Categories') }}</h3>
					{!! categoryTree(get_table('post_categories'), 0, '') !!}	
				</div>
				<!-- /category widget -->

				<!-- posts widget -->
				<div class="widget posts-widget">
					<h3>{{ _lang('Recents Posts') }}</h3>

					@foreach(get_posts(3) as $post)
					<!-- single posts -->
					<div class="single-post">
						<a class="single-post-img" href="{{ post_parmalink($post) }}">
							<img src="{{ $post->featured_image != "" ? asset('uploads/media/'.$post->featured_image) : asset('uploads/no_image.jpg') }}" alt="">
						</a>
						<a href="{{ post_parmalink($post) }}">{{ $post->content[0]->post_title }}</a>
						<p><small>{{ _lang('By') }} : {{ $post->author->name }} .{{ date('d M, Y',strtotime($post->created_at)) }}</small></p>
					</div>
					<!-- /single posts -->
                    @endforeach
				</div>
				<!-- /posts widget -->
			</div>
			<!-- /aside blog -->

		</div>
		<!-- row -->

	</div>
	<!-- container -->

</div>
<!-- /Blog -->

@endsection