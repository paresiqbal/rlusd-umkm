<div class="relative z-50 modal hidden" id="partner-profiles-details" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-50 modal-overlay "></div>
        <div class="p-4 mx-auto animate-translate sm:max-w-lg">
            <div class="relative overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl">
                <div class="bg-white">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 border-transparent hover:bg-gray-50/50 hover:text-gray-900 rounded-lg text-sm px-2 py-1 ml-auto inline-flex items-center" data-tw-dismiss="modal">
                        <i class="text-xl text-gray-500 mdi mdi-close"></i>
                    </button>
                    <div class="p-5">
                        <h3 class="mb-4 text-xl font-medium text-gray-700">Ubah Detail Perusahaan</h3>
                        <form class="space-y-4" action="#">
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 text-left">Nama Perusahaan</label>
                                <input type="text" name="name" id="name" placeholder="Nama Perusaahaan" required class="bg-gray-800/5 border border-gray-100 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:ring-0"  />
                            </div>                            
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 text-left">Email</label>
                                <input type="email" name="email" id="email" placeholder="Email" disabled class="bg-gray-800/5 border border-gray-100 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:ring-0"  />
                            </div>                            
                            <div>
                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 text-left">Nomor Telepon</label>
                                <input name="phone" id="phone" placeholder="Nomor Telepon" required class="bg-gray-800/5 border border-gray-100 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:ring-0"  />
                            </div>   
                            <div>
                                <label for="address" class="block mb-2 text-sm font-medium text-gray-900 text-left">Nomor Telepon</label>
                                <textarea name="address" id="address" placeholder="Alamat Perusahaan" required class="bg-gray-800/5 border border-gray-100 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:ring-0"  ></textarea>
                            </div>   
                            <div>
                                <label for="sector" class="block mb-2 text-sm font-medium text-gray-900 text-left">Sektor Usaha</label>
                                <div class="flex h-10">
                                    <select name="sector" class="w-full form-select form-select-md rounded py-0.5 border-gray-100 bg-gray-800/5">
                                        <option value="sektor-1" selected="">Sektor 1</option>
                                        <option value="sektor-2" selected="">Sektor 2</option>
                                        <option value="sektor-3" selected="">Sektor 3</option>
                                    </select>
                                </div>                         
                            </div>
                            <div>
                                <label for="class" class="block mb-2 text-sm font-medium text-gray-900 text-left">Sektor Usaha</label>
                                <div class="flex h-10">
                                    <select name="class" class="w-full form-select form-select-md rounded py-0.5 border-gray-100 bg-gray-800/5">
                                        <option value="Kelas-1" selected="">Kelas 1</option>
                                        <option value="Kelas-2" selected="">Kelas 2</option>
                                        <option value="Kelas-3" selected="">Kelas 3</option>
                                    </select>
                                </div>                         
                            </div>
                            <div class="mt-6 flex justify-end gap-4">
                                <button class="btn-outlined " data-tw-dismiss="modal">Kembali</button>
                                <button type="submit" class="bg-primary-500 hover:bg-primary-600 active:bg-primary-700 btn-primary ">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>