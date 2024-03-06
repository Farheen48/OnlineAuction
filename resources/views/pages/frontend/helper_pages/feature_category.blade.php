
@php
$category_list= App\Models\Category::where('status','=','active')->get();
@endphp
<div class="browse-slider-section mt--140">
    <div class="container">
        <div class="section-header-2 cl-white mb-4">
            <div class="left">
                <h6 class="title pl-0 w-100">Browse the highlights</h6>
            </div>
            <div class="slider-nav">
                <a href="#0" class="bro-prev"> <- </a>
                <a href="#0" class="bro-next active"> -> </a>
            </div>
        </div>
        <div class="m--15">
            <div class="browse-slider owl-theme owl-carousel">
                @forelse($category_list as $ct)
                <a href="#" class="browse-item">
                    <img src="{{ asset($ct->image) }}" alt="No found">
                    <span class="info">{{ $ct->category }}</span>
                </a>
                @empty
                <a href="#" class="browse-item">
                    <img src="{{ asset('/public/assets/images/icons/note_found.jpg') }}" alt="No found">
                    <span class="info">No Category</span>
                </a>
                @endforelse
            </div>
        </div>
    </div>
</div>
