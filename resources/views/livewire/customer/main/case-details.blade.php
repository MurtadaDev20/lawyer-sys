<div>
    <!-- Main Content -->
    <main class="md:mr-72 p-4 md:p-8">
        <!-- Lawyers Grid -->

                <div class="p-8 rounded-2xl shadow-lg border border-gray-800 mb-8 bg-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-800">
                                    <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 text-gray-200' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 17v-2a4 4 0 014-4h3m4 4v6a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6' /></svg>
                                </span>
                                <h2 class="text-lg font-bold text-white">تفاصيل القضية</h2>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 text-gray-200 text-sm">
                                <div class="flex justify-between border-b border-gray-700 pb-2"><span>عنوان القضية:</span><span>{{ $case->title }}</span></div>
                                <div class="flex justify-between border-b border-gray-700 pb-2"><span>رقم القضية:</span><span>{{ $case->case_number }}</span></div>
                                <div class="flex justify-between border-b border-gray-700 pb-2"><span>النوع:</span><span>{{ $case->caseType->name }}</span></div>
                                <div class="flex justify-between border-b border-gray-700 pb-2"><span>الحالة:</span><span>{{ $case->caseStatus->name }}</span></div>
                                <div class="flex justify-between border-b border-gray-700 pb-2"><span>تاريخ البدء :</span><span>{{ $case->start_date }}</span></div>
                                <div class="flex justify-between border-b border-gray-700 pb-2"><span>تاريخ الانتهاء:</span><span>{{ $case->closed_date }}</span></div>
                                <div class="flex justify-between border-b border-gray-700 pb-2"><span>تاريخ الإنشاء:</span><span>{{ $case->created_at->format('Y-m-d') }}</span></div>
                                <div class="flex justify-between border-b border-gray-700 pb-2"><span>اسم المحكمة:</span><span>{{ $case->court_name }}</span></div>
                                <div class="flex justify-between"><span>الموقع:</span><span>{{ $case->location }}</span></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-800">
                                    <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 text-gray-200' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z' /></svg>
                                </span>
                                <h2 class="text-lg font-bold text-white">المحامي المسؤول</h2>
                            </div>
                            <div class="space-y-2 text-gray-200 text-sm">
                                <div class="flex items-center gap-2"><span class="font-medium">الاسم:</span><span>{{ $case->lawyer->name }}</span></div>
                                <div class="flex items-center gap-2"><svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 text-gray-400' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 5a2 2 0 012-2h3.28a2 2 0 011.7 1l1.38 2.76a2 2 0 001.7 1H19a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5z' /></svg><span class="font-medium">الهاتف:</span><span>{{ $case->lawyer->phone }}</span></div>
                                <div class="flex items-center gap-2"><svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 text-gray-400' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0zm0 0v1a4 4 0 01-4 4H8a4 4 0 01-4-4v-1' /></svg><span class="font-medium">البريد الإلكتروني:</span><span>{{ $case->lawyer->email }}</span></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-800">
                                    <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 text-gray-200' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 10h.01M12 10h.01M16 10h.01M9 16h6m2 4H7a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v11a2 2 0 01-2 2z' /></svg>
                                </span>
                                <h2 class="text-lg font-bold text-white">الوصف</h2>
                            </div>
                            <div class="text-gray-200 text-sm leading-relaxed border border-gray-800 rounded-lg p-4 bg-gray-800">{{ $case->description }}</div>
                        </div>
                    </div>
                </div>
        <!-- End of Lawyers Grid -->

        <div class="mt-10">
            <div class="flex items-center gap-3 mb-4">
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-800">
                    <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 text-gray-400' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 5a2 2 0 012-2h3.28a2 2 0 011.7 1l1.38 2.76a2 2 0 001.7 1H19a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5z' /></svg>
                </span>
                <h2 class="text-lg font-bold text-white">المستندات الخاصة بالقضية</h2>
            </div>
            <ul class="space-y-3">
                @if($files->isEmpty())
                <li class="text-gray-400">لا توجد مستندات مرفقة لهذه القضية.</li>
                @endif
                @foreach ($files as $file)
                <li class="flex items-center gap-4 bg-gray-900 rounded-xl px-6 py-3 border border-gray-700 shadow-sm hover:bg-gray-800 transition">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a2 2 0 011.7 1l1.38 2.76a2 2 0 001.7 1H19a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                        </svg>
                        <a href="{{ route('file.previewCustomer', $file->id) }}"  class="text-primary-300 hover:underline font-semibold text-base">
                            {{ $file->name }}
                        </a>
                    </div>
                    <span class="text-gray-400 text-xs ml-4">{{ $file->created_at->format('Y-m-d') }}</span>
                    <div class="flex gap-2 ml-auto">
                        
                    </div>
                </li>
                @endforeach
                <div class="mt-4">
                {{ $files->links() }}
            </div>
            </ul>
            
        </div>
    </main>

    <!-- End of Main Content -->

    


</div>
