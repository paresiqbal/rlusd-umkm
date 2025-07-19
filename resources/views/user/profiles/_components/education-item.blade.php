<div class="flex flex-col grow">
    <div class="flex items-center gap-2 text-lg">
        <p class="font-bold">
            {{ $education->major }}
        </p>
        <div class="bg-gray-600 rounded-full size-1"></div>
        <p class="text-sm">
            {{ $education->school_name }}
        </p>
    </div>
    <div class="flex items-center gap-2 text-gray-500">
        <p>Tahun Lulus</p>
        <div class="flex items-center gap-2">
            <p>{{ $education->graduate_year }}</p>
        </div>
    </div>
    <div class="text-justify mt-2">
        {{ $education->education_desc }}
    </div>
</div>
