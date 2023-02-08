@extends('layouts.auth')

@section('title', 'Восстановить')

@section('content')
    <x-forms.base-auth-form :title="'Восстановить пароль'" action="{{ route('forgot.handle') }}" method="POST">
        @csrf
        <x-forms.text-input name="email" type="email" placeholder="E-mail" required :is-error="$errors->has('email')"/>
        @error('email')<x-forms.error>{{ $message }}</x-forms.error>@enderror

        <x-forms.primary-button type="submit">Восстановить</x-forms.primary-button>

        <x-slot:buttons>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs"><a href="{{ route('login') }}" class="text-white hover:text-white/70 font-bold">Войти</a></div>
                <div class="text-xxs md:text-xs"><a href="{{ route('register') }}" class="text-white hover:text-white/70 font-bold">Зарегистрироваться</a></div>
            </div>
        </x-slot:buttons>
    </x-forms.base-auth-form>
@endsection