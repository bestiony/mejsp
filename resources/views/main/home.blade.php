@extends('main.layouts.master') @section('title', 'مؤسسة الشرق الأوسط للنشر العلمي') @section('content') <header id="home-header"
    class="mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 mb-4 text-center">
                <div class="title">
                    <h1 class="w-100 text-center"> مؤسسة الشرق الأوسط للنشر العلمي </h1>
                </div><button class="btn-search text-white">هل تبحث عن شيء ؟ <span class=" text font-weight-bold">ابحث
                        الآن</span></button>
            </div>
        </div>
    </div>
    <div class="overlay"></div>
</header>
<section id="journals">
    <div class="container">
        <div id="carousel-sections">
            <h2 class="section-title mb-5"><a href="{{ url('journals') }}">المجلات</a></h2>
            <div class="journals-owl-carousel owl-carousel owl-theme">
                @foreach ($journals as $jour)
                    <div class="item"> <a href="{{ url('journal/' . $jour->slug) }}">
                            @if (checkFile('assets/uploads/journals/' . $jour->cover))
                                <img src="{{ asset('assets/uploads/journals/' . $jour->cover) }}"
                                    alt="{{ $jour->name }}" title="{{ $jour->name }}">
                            @else
                                <img src="{{ asset('assets/images/notfound.png') }}" alt="{{ $jour->name }}"
                                    title="{{ $jour->name }}">
                            @endif
                            <div class="info mt-4 ">
                                <h2 class="journal-title">{{ $jour->name, 40 }}</h2>
                                <p class=" text-secondary">{{ Str::limit($jour->meta_desc, 95) }}</p>
                            </div>
                        </a> </div>
                    @endforeach
            </div>
        </div>
    </div>
</section>
<section id="blog">
    <div class="container">
        <div id="carousel-sections">
            <h2 class="section-title mb-5"><a href="{{ url('blog') }}">المدونة</a></h2>
            <div class="journals-owl-carousel owl-carousel owl-theme">
                @foreach ($articles as $art)
                    <article class="item"> <a
                            href="@if ($art->version == 'old') {{ url('blog-single.php?lang=ar&id=' . $art->id . '&name=' . $art->title) }}@else{{ url("article/$art->slug") }} @endif">
                            @if (checkFile('assets/uploads/thumbnails/articles-ar/' . $art->image))
                                <img src="{{ asset('assets/uploads/thumbnails/articles-ar/' . $art->image) }}"
                                    alt="{{ $art->title }}" title="{{ $art->title }}">
                            @else
                                <img src="{{ asset('assets/images/notfound.png') }}" alt="{{ $art->title }}"
                                    title="{{ $art->title }}">
                            @endif
                            <div class="info mt-4">
                                <h2 class="journal-title">{{ $art->title, 40 }}</h2>
                                <p class=" text-secondary">{{ Str::limit($art->meta_desc, 95) }}</p>
                            </div>
                        </a> </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
@if (Session::has('message'))
    @section('js')
        <script>
            toastr.options.timeOut = 2000;
            toastr.options.progressBar = true;
            toastr.success("{{Session::get('message')}}")
        </script>
    @endsection
@endif
@endsection
