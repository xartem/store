<!-- Filter item -->
<div>
    <h5 class="mb-4 text-sm 2xl:text-md font-bold">{{ $filter->title() }}</h5>

    @foreach($filter->values() as $brand_id => $brand_title)
        <div class="form-checkbox">
            <input name="{{ $filter->name($brand_id) }}"
                   type="checkbox"
                   value="{{ $brand_id }}"
                   @checked($filter->requestValue($brand_id))
                   id="{{ $filter->id($brand_id) }}"
            >

            <label for="{{ $filter->id($brand_id) }}" class="form-checkbox-label">
                {{ $brand_title }}
            </label>
        </div>
    @endforeach
</div>
