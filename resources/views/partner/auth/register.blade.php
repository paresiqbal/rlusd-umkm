@extends('common.auth.register')

@section('fieldLabelName')
    Nama Mitra
@endsection

@section('urlRegisterPost', route('partners.auth.register.post'))
@section('urlRedirectLogin', route('partners.auth.login.index'))
@section('urlRedirectGoogle', route('partners.auth.google.redirect', ['method' => 'register']))
