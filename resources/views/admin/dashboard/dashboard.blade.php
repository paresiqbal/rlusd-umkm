@extends('admin._layout.main')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="overflow-x-hidden flex flex-col w-full">
        @include('admin.dashboard._components.activity')
    </div>
@endsection
