@extends('partner._layout.main')

@section('title', 'Mitra Dashboard')

@section('content')
    <div class="overflow-x-hidden flex flex-col w-full ">


        @include('partner.dashboard._components.activity', [
            'jobCount' => $jobCount,
            'totalApplicants' => $totalApplicants,
        ])
    </div>
@endsection
