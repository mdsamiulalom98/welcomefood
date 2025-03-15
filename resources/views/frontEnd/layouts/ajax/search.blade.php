@if ($foods && count($foods) > 0)
    <div class="search_product">
        <ul>
            @foreach ($foods as $value)
                <a class="quick_view" data-id="{{ $value->id }}" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                    <li>
                        <div class="search_img">
                            <img src="{{ asset($value->image ? $value->image->image : '') }}" alt="{{ $value->name }}">
                        </div>
                        <div class="search_content">
                            <p class="name">{{ $value->name }}</p>
                            @if ($value->variables_count > 1)
                                <p class="price">
                                    ৳ {{ $value->start_price->new_price }} - ৳ {{ $value->end_price->new_price }}
                                </p>
                            @else
                                <p class="price">
                                    ৳ {{ $value->start_price->new_price }}
                                </p>
                            @endif
                        </div>
                    </li>
                </a>
            @endforeach
        </ul>
    </div>
@endif
