@if ($products)
    <div class="search_product">
        <ul>
            @foreach ($products as $value)
                <a href="{{ route('product', $value->slug) }}">
                    <li>
                        <div class="search_img">
                            <img src="{{ asset($value->image ? $value->image->image : '') }}" alt="{{ $value->name }}">
                        </div>
                        <div class="search_content">
                            <p class="name">{{ $value->name }}</p>
                            @if ($value->variable_count > 0 && $value->type == 0)
                                <p class="price">৳{{ $value->variable->new_price }} @if ($value->variable->old_price)
                                        <del>{{ $value->variable->old_price }} Tk</del>
                                    @endif
                                </p>
                            @else
                                <p class="price">{{ $value->new_price }} Tk
                                  @if ($value->old_price)
                                        <del>{{ $value->old_price }} Tk</del>
                                    @endif
                                </p>
                            @endif

                        </div>
                    </li>
                </a>
            @endforeach
        </ul>
    </div>
@endif
