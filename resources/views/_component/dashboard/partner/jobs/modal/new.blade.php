<div class="relative z-50 modal hidden " id="partner-jobs-new" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div onclick="closeModal(this)" class="fixed inset-0 transition-opacity bg-black bg-opacity-50 modal-overlay "></div>
        <div class="p-4 mx-auto animate-translate sm:max-w-lg">
            <div class="relative overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl">
                <div class="bg-white">
                    <button onclick="closeModal(this)" type="button" class="absolute top-3 right-2.5 text-gray-400 border-transparent hover:bg-gray-50/50 hover:text-gray-900 rounded-lg text-sm px-2 py-1 ml-auto  inline-flex items-center" data-tw-dismiss="modal">
                        <i class="text-xl text-gray-500 mdi mdi-close"></i>
                    </button>
                    <div class="p-5">
                        <h3 class="mb-4 text-xl font-medium text-gray-700">Tambah Lowongan Baru</h3>
                        <form class="space-y-4" action="#">
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 text-left">Nama Perusahaan</label>
                                <input type="text" name="name" id="name" placeholder="Nama Lowongan" required class="bg-gray-800/5 border border-gray-100 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:ring-0"  />
                            </div>                                                        
                            <div>
                                <label for="desciption" class="block mb-2 text-sm font-medium text-gray-900 text-left">Description</label>
                                <textarea rows="5" name="description" id="description" placeholder="-" required class="bg-gray-800/5 border border-gray-100 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:ring-0"  ></textarea>
                            </div>
                            <div>
                                <label for="category" class="block mb-2 text-sm font-medium text-gray-900 text-left">Kategori Pekerjaan</label>
                                <div class="flex h-10">
                                    <select name="category" class="w-full form-select form-select-md rounded py-0.5 border-gray-100 bg-gray-800/5">
                                        <option value="sektor-1" selected="">Fulltime</option>
                                        <option value="sektor-2" selected="">Part-Time</option>
                                    </select>
                                </div>                         
                            </div>
                            <div>
                                <label for="min_education" class="block mb-2 text-sm font-medium text-gray-900 text-left">Minimal Pendidikan</label>
                                <div class="flex h-10">
                                    <select name="min_education" class="w-full form-select form-select-md rounded py-0.5 border-gray-100 bg-gray-800/5">
                                        @foreach ($educations as $edu)

                                        <option value="{{$edu->education_id}}">{{$edu->education_name}}</option>
                                            
                                        @endforeach
                                    </select>
                                </div>                         
                            </div>
                            <div>
                                <label for="salary" class="block mb-2 text-sm font-medium text-gray-900 text-left">Rentang Gaji</label>
                                <div class="flex gap-2 justify-center items-center">
                                    <div class="grow">
                                        <input name="salary_bottom" id="salary_bottom" placeholder="Rp" required class="bg-gray-800/5 border border-gray-100 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:ring-0"/>
                                    </div>
                                    <div class="grow text-center"> - </div>
                                    <div class="grow">
                                        <input name="salary_top" id="salary_top" placeholder="Rp" required class="bg-gray-800/5 border border-gray-100 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:ring-0"  />
                                    </div>
                                </div>
                            </div>   
                            <div>
                                <label for="job_type" class="block mb-2 text-sm font-medium text-gray-900 text-left">Tipe Pekerjaan</label>
                                <div class="flex h-10">
                                    <select name="job_type" class="w-full form-select form-select-md rounded py-0.5 border-gray-100 bg-gray-800/5">
                                        <option value="sektor-1" selected="">WFH</option>
                                        <option value="sektor-2" selected="">WFO</option>
                                        <option value="sektor-2" selected="">Hybrid</option>
                                    </select>
                                </div>                         
                            </div>   
                            <div>
                                <label for="skill" class="block mb-2 text-sm font-medium text-gray-900 text-left">Skill yang dibutuhkan</label>
                                <div class="flex min-h-10">
                                    <select name="skill[]" id="skill" multiple class="w-full form-select form-select-md rounded py-0.5 border-gray-100 bg-gray-800/5">
                                        {{-- option --}}
                                        <option value="a" selected>wkww</option>
                                        <option value="b" selected>wkwwB</option>
                                    </select>
                                </div>                         
                            </div>
                            <div>
                                <label for="term_and_q" class="block mb-2 text-sm font-medium text-gray-900 text-left">Syarat dan Kualifikasi</label>
                                <textarea rows="5" name="description" id="description" placeholder="-" required class="bg-gray-800/5 border border-gray-100 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:ring-0"  ></textarea>
                            </div>
                            
                            <div class="mt-6 flex justify-end gap-4">
                                <button class="btn-outlined " data-tw-dismiss="modal" onclick="closeModal(this)">Kembali</button>
                                <button type="submit" class="bg-primary-500 hover:bg-primary-600 active:bg-primary-700 btn-primary ">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>