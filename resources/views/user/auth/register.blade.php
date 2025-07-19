@extends('common.auth.register')

@section('fieldLabelName')
    Nama
@endsection

@section('urlRegisterPost', route('users.auth.register.post'))
@section('urlRedirectLogin', route('users.auth.login.index'))
@section('urlRedirectGoogle', route('users.auth.google.redirect', ['method' => 'register']))
