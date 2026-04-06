@extends('admin.layouts.app')
@section('title', 'المقالات والأعمدة')

@section('content')
    <div class="max-w-7xl mx-auto pb-20">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3">
                    <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    </div>
                    إدارة المقالات والأعمدة
                </h1>
            </div>
            <a href="{{ route('admin.posts.create') }}" class="cursor-pointer group flex items-center gap-2 px-6 py-3.5 bg-primary text-white rounded-2xl font-black text-sm shadow-xl shadow-primary/30 hover:-translate-y-1 transition-all duration-300">
                <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                إضافة مقال جديد
            </a>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-50 overflow-hidden relative">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-right border-collapse table-fixed min-w-[800px]">
                    <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase w-16">#</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase w-20">الصورة</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase w-1/3">العنوان</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase text-center">التصنيف</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase text-center w-36 sticky left-0 bg-gray-50 z-20 shadow-[-10px_0_15px_-3px_rgba(0,0,0,0.05)] border-r border-gray-100">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($posts as $post)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-5 text-center font-bold text-gray-500 align-middle">{{ $loop->iteration }}</td>

                            <td class="px-6 py-5 align-middle">
                                @if($post->image)
                                    <img src="{{ asset($post->image) }}" class="w-12 h-12 rounded-xl object-cover shadow-sm border border-gray-100">
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-5 align-middle">
                                <p class="font-black text-gray-800 text-sm">{{ $post->title['ar'] ?? '' }}</p>
                                <p class="font-bold text-gray-400 text-xs mt-1" dir="ltr">{{ $post->title['en'] ?? '' }}</p>
                            </td>

                            <td class="px-6 py-5 text-center align-middle">
                                <span class="px-3 py-1 bg-blue-50 text-blue-700 border border-blue-100 rounded-lg text-xs font-black">{{ $post->category->name['ar'] ?? 'غير محدد' }}</span>
                            </td>

                            <td class="px-6 py-5 align-middle sticky left-0 bg-white group-hover:bg-gray-50 z-10 shadow-[-10px_0_15px_-3px_rgba(0,0,0,0.03)] border-r border-gray-50 transition-colors">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.posts.edit', $post->id) }}"
                                       class="p-2.5 bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white rounded-xl transition-all hover:shadow-lg hover:shadow-blue-500/30 hover:-translate-y-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="delete-form m-0">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="cursor-pointer p-2.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all hover:shadow-lg hover:shadow-red-500/30 hover:-translate-y-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-20 text-center text-gray-400 font-bold text-lg">لا توجد مقالات مسجلة</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($posts->hasPages())
                <div class="p-6 border-t border-gray-50 bg-gray-50/30">{{ $posts->links() }}</div>
            @endif
        </div>
    </div>
@endsection
