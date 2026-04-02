@extends('admin.layouts.app')

@section('meta_description', 'إدارة قائمة المشتركين في النشرة البريدية.')

@section('title', 'المشتركين')

@section('content')
    <div class="max-w-7xl mx-auto pb-20">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3">
                    <div class="p-2.5 bg-indigo-50 text-indigo-500 rounded-xl">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path>
                        </svg>
                    </div>
                    القائمة البريدية
                </h1>
                <p class="text-gray-500 font-bold mt-2 text-sm">قائمة الزوار المشتركين لاستقبال آخر الأخبار
                    والمقالات.</p>
            </div>

            <div class="bg-white px-6 py-3 rounded-2xl shadow-sm border border-gray-50 flex items-center gap-4">
                <div
                    class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center font-black">
                    {{ $subscribers->total() }}
                </div>
                <span class="text-sm font-bold text-gray-500">إجمالي المشتركين</span>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-50 overflow-hidden relative">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-right border-collapse">
                    <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider w-16 text-center">
                            #
                        </th>
                        <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider text-left"
                            dir="ltr">Email Address
                        </th>
                        <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider">تاريخ الاشتراك
                        </th>
                        <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider text-center w-32">
                            الإجراءات
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($subscribers as $subscriber)
                        <tr class="hover:bg-gray-50/30 transition-colors group">
                            <td class="px-6 py-4 text-center font-bold text-gray-500">
                                {{ ($subscribers->currentPage() - 1) * $subscribers->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 text-left" dir="ltr">
                                <a href="mailto:{{ $subscriber->email }}"
                                   class="font-black text-gray-800 hover:text-indigo-600 transition-colors">
                                    {{ $subscriber->email }}
                                </a>
                            </td>

                            <td class="px-6 py-4 font-bold text-gray-500 text-sm">
                                {{ $subscriber->created_at->format('Y-m-d') }}
                                <span
                                    class="block text-xs text-gray-400">{{ $subscriber->created_at->format('h:i A') }}</span>
                            </td>

                            <td class="px-6 py-4">
                                <div
                                    class="flex items-center justify-center opacity-80 group-hover:opacity-100 transition-opacity">
                                    <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}"
                                          method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-colors cursor-pointer"
                                                title="حذف المشترك">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center opacity-50">
                                    <div
                                        class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                    </div>
                                    <span
                                        class="text-lg font-black text-gray-500">لا يوجد مشتركون في القائمة حتى الآن</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($subscribers->hasPages())
                <div class="p-6 border-t border-gray-50 bg-gray-50/30">
                    {{ $subscribers->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
