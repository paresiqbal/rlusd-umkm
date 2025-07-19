<div id="applyJobModal" class="hidden">
    <div class="modal fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4 sm:w-2/3 md:w-1/2">
            <h2 class="text-xl font-semibold mb-4">Lamar Sebagai <span>{{ $job->role }}</span></h2>
            <p class="mb-4">Apakah anda yakin melamar dipekerjaan ini?</p>
            <form id="applyJobForm" method="POST" action="{{ route('users.jobs.apply', ['id' => $job->post_job_id]) }}">
                @csrf
                <div class="mb-4">
                    <label for="note" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                    <textarea id="note" name="note" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                </div>
                <div class="flex flex-col sm:flex-row justify-between gap-4">
                    <button type="submit" class="btn-primary w-full">Lamar</button>
                    <button type="button" id="cancel-apply" class="btn-outlined w-full">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
