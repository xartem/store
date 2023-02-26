<select
        name="{{ $sort->name() }}"
        x-on:change="$refs.sortForm.submit()"
        class="form-select w-full h-12 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xxs sm:text-xs shadow-transparent outline-0 transition">

    <option value="" class="text-dark">по умолчанию</option>
    @foreach($sort->values() as $sort_id => $sort_name)
        <option @selected($sort->requestValue() === $sort_id) value="{{ $sort_id }}" class="text-dark">{{ $sort_name }}</option>
    @endforeach
</select>
