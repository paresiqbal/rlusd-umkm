<div class="flex flex-col grow">
    <p class="text-lg font-bold">
        {{ $experience->job_title }}
    </p>
    <div class="flex items-center gap-2 text-gray-500">
        <span>{{ $experience->company_name }}</span>
        <div class="size-1 bg-gray-500 rounded-full"></div>
        <span class="capitalize">{{ $experience->employment_type }}</span>
        <div class="size-1 bg-gray-500 rounded-full"></div>
        {{ Carbon\Carbon::parse($experience->start_at)->isoFormat('D MMMM Y') }} -
        {{ $experience->end_at ? Carbon\Carbon::parse($experience->end_at)->isoFormat('D MMMM Y') : 'sekarang' }}
    </div>
    <div class="text-justify mt-2">
        {{ $experience->job_desc }}
    </div>
</div>
