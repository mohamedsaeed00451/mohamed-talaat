@extends('admin.layouts.app')

@section('title', 'الصفحات المخصصة')

@section('content')
    <div class="max-w-7xl mx-auto pb-20">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3">
                    <div class="p-2.5 bg-purple-50 text-purple-500 rounded-xl">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    الصفحات المخصصة
                </h1>
                <p class="text-gray-500 font-bold mt-2 text-sm">إدارة صفحات سياسة الخصوصية، الشروط والأحكام، وغيرها.</p>
            </div>

            <a href="{{ route('admin.pages.create') }}" class="group flex items-center gap-2 px-6 py-3.5 bg-primary text-white rounded-2xl font-black text-sm shadow-xl shadow-primary/30 hover:-translate-y-1 transition-all duration-300">
                <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                إنشاء صفحة جديدة
            </a>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-50 overflow-hidden relative">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-right border-collapse">
                    <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider text-center w-16">#</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider">العنوان</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider text-left" dir="ltr">Slug</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider text-center w-32">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($pages as $page)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-5 text-center font-bold text-gray-500 align-middle">
                                {{ ($pages->currentPage() - 1) * $pages->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-6 py-5 align-middle">
                                <p class="font-black text-gray-800 text-sm">{{ $page->title['ar'] ?? '' }}</p>
                                <p class="font-bold text-gray-400 text-xs mt-1">{{ $page->title['en'] ?? '' }}</p>
                            </td>

                            <td class="px-6 py-5 font-bold text-blue-500 text-sm text-left align-middle" dir="ltr">
                                /{{ $page->slug }}
                            </td>

                            <td class="px-6 py-5 align-middle">
                                <div class="flex items-center justify-center gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.pages.edit', $page->id) }}" class="p-2.5 bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white rounded-xl transition-colors" title="تعديل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="delete-form m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-colors" title="حذف">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center opacity-50">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <span class="text-lg font-black text-gray-500">لا توجد صفحات حتى الآن</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($pages->hasPages())
                <div class="p-6 border-t border-gray-50 bg-gray-50/30">{{ $pages->links() }}</div>
            @endif
        </div>
    </div>
@endsection
