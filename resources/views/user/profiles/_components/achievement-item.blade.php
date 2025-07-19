<div class="flex flex-col grow">
    <div class="flex items-center gap-2 text-lg">
        <p class="font-bold">
            {{ $achievement->achievement_title }}
        </p>
    </div>
    <div class="flex items-center gap-2 text-gray-500">
        {{ $achievement->achievement_year }}
    </div>
    <div class="text-justify mt-2">
        {{ $achievement->additional_information }}
    </div>
</div>
