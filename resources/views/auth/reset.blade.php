@extends('layouts.auth')

@section('title', 'Сброс пароля')

@section('content')
    <x-forms.base-auth-form :title="'Сброс пароля'" action="{{ route('password.reset.handle') }}" method="POST">
        @csrf
        <x-forms.text-input name="token" type="hidden" value="{{ $token }}"/>
        <x-forms.text-input name="email" type="email" placeholder="E-mail" required :is-error="$errors->has('email')" value="{{ request()->email }}"/>
        @error('email')<x-forms.error>{{ $message }}</x-forms.error>@enderror
        <x-forms.text-input name="password" type="password" placeholder="Пароль" required :is-error="$errors->has('password')" />
        @error('password')<x-forms.error>{{ $message }}</x-forms.error>@enderror
        <x-forms.text-input name="password_confirmation" type="password" placeholder="Повторите пароль" required :is-error="$errors->has('password_confirmation')" />
        @error('password_confirmation')<x-forms.error>{{ $message }}</x-forms.error>@enderror

        <x-forms.primary-button type="submit">Сбросить</x-forms.primary-button>
    </x-forms.base-auth-form>
@endsection