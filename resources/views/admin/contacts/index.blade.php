@extends('admin.layouts.app')

@section('meta_description', 'صندوق الوارد ورسائل الزوار.')

@section('title', 'صندوق الوارد')

@section('content')
    <div x-data="contactsInbox()" class="max-w-7xl mx-auto pb-20">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3">
                    <div class="p-2.5 bg-blue-50 text-blue-500 rounded-xl">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    صندوق الوارد
                </h1>
                <p class="text-gray-500 font-bold mt-2 text-sm">متابعة رسائل واستفسارات الزوار الواردة من الموقع.</p>
            </div>
        </div>
        <div class="mb-8 bg-white p-6 rounded-[2rem] shadow-sm border border-gray-50 flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-2 bg-blue-50 text-blue-500 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                </div>
                <span class="text-sm font-black text-gray-700">تصفية حسب:</span>
            </div>

            <form action="{{ route('admin.contacts.index') }}" method="GET" class="flex-1 max-w-xs relative group">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-400 group-hover:text-primary transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>

                <select name="type_id" onchange="this.form.submit()"
                        class="appearance-none w-full pl-10 pr-6 py-3.5 bg-gray-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/10 font-black text-gray-700 text-sm cursor-pointer transition-all shadow-inner">
                    <option value="">كل أنواع الرسائل</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name['ar'] }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-50 overflow-hidden relative">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-right border-collapse">
                    <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider w-16 text-center">#</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider">المرسل</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider">التصنيف</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider">التاريخ</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider text-center">الحالة</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider text-center">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($contacts as $contact)
                        <tr class="transition-colors group {{ $contact->is_read ? 'hover:bg-gray-50/30' : 'bg-blue-50/30 hover:bg-blue-50/50' }}">
                            <td class="px-6 py-4 text-center font-bold text-gray-500">
                                {{ ($contacts->currentPage() - 1) * $contacts->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-black text-gray-800 {{ !$contact->is_read ? 'text-blue-900' : '' }}">{{ $contact->name }}</span>
                                    <span class="text-xs font-bold text-gray-400 mt-1" dir="ltr">{{ $contact->email }}</span>
                                    <span class="text-xs font-bold text-gray-400" dir="ltr">{{ $contact->phone }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                    <span class="px-3 py-1.5 bg-gray-100 text-gray-600 rounded-lg text-xs font-black">
                                        {{ $contact->type->name['ar'] ?? 'غير محدد' }}
                                    </span>
                            </td>

                            <td class="px-6 py-4 font-bold text-gray-500 text-sm">
                                {{ $contact->created_at->format('Y-m-d') }}
                                <span class="block text-xs text-gray-400">{{ $contact->created_at->format('h:i A') }}</span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($contact->is_read)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 text-gray-500 border border-gray-200 rounded-xl text-xs font-black">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            مقروءة
                                        </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 border border-blue-200 rounded-xl text-xs font-black animate-pulse">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            جديدة
                                        </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2 opacity-80 group-hover:opacity-100 transition-opacity">

                                    <button @click="viewMessage({{ json_encode([
                                                    'id' => $contact->id,
                                                    'name' => $contact->name,
                                                    'email' => $contact->email,
                                                    'phone' => $contact->phone,
                                                    'type' => $contact->type->name['ar'] ?? 'غير محدد',
                                                    'message' => $contact->message,
                                                    'attachment' => $contact->attachment ? asset($contact->attachment) : null,
                                                    'date' => $contact->created_at->format('Y-m-d h:i A')
                                                ]) }})"
                                            class="p-2.5 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-xl transition-colors cursor-pointer" title="عرض التفاصيل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>

                                    <form action="{{ route('admin.contacts.toggle-read', $contact->id) }}" method="POST" x-data="{ isToggling: false }" @submit="isToggling = true">
                                        @csrf
                                        <button type="submit" :disabled="isToggling" class="p-2.5 bg-gray-100 text-gray-600 hover:bg-gray-600 hover:text-white rounded-xl transition-colors cursor-pointer disabled:opacity-50" title="{{ $contact->is_read ? 'تحديد كغير مقروء' : 'تحديد كمقروء' }}">
                                            <svg x-show="!isToggling" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($contact->is_read)
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path>
                                                @endif
                                            </svg>
                                            <svg x-show="isToggling" style="display: none;" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-colors cursor-pointer" title="حذف">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center opacity-50">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-lg font-black text-gray-500">لا توجد رسائل واردة حتى الآن</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($contacts->hasPages())
                <div class="p-6 border-t border-gray-50 bg-gray-50/30">
                    {{ $contacts->links() }}
                </div>
            @endif
        </div>

        <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center">

            <div x-show="isModalOpen" x-transition.opacity.duration.300ms class="absolute inset-0 bg-secondary/60 backdrop-blur-sm" @click="closeModal()"></div>

            <div x-show="isModalOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                 class="relative w-full max-w-2xl bg-white rounded-[2.5rem] shadow-2xl overflow-hidden m-4 flex flex-col max-h-[90vh]">

                <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/50 shrink-0">
                    <h3 class="text-xl font-black text-gray-900 flex items-center gap-3">
                        <span class="w-2 h-6 bg-primary rounded-full"></span>
                        تفاصيل الرسالة
                    </h3>
                    <button @click="closeModal()" type="button" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-colors cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <template x-if="msg">
                    <div class="p-8 overflow-y-auto custom-scrollbar space-y-8">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-3xl border border-gray-100">
                            <div>
                                <span class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1">المرسل</span>
                                <span class="text-lg font-bold text-gray-900" x-text="msg.name"></span>
                            </div>
                            <div>
                                <span class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1">البريد الإلكتروني</span>
                                <a :href="'mailto:' + msg.email" class="text-base font-bold text-primary hover:underline" dir="ltr" x-text="msg.email"></a>
                            </div>
                            <div>
                                <span class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1">رقم الهاتف</span>
                                <a :href="'tel:' + msg.phone" class="text-base font-bold text-gray-800 hover:text-primary transition-colors" dir="ltr" x-text="msg.phone"></a>
                            </div>
                            <div>
                                <span class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1">تاريخ الإرسال</span>
                                <span class="text-base font-bold text-gray-800" x-text="msg.date" dir="ltr"></span>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="block text-sm font-black text-gray-800">محتوى الرسالة:</span>
                                <span class="px-3 py-1 bg-primary/10 text-primary rounded-lg text-xs font-black" x-text="msg.type"></span>
                            </div>
                            <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 text-gray-700 font-semibold leading-relaxed whitespace-pre-line" x-text="msg.message"></div>
                        </div>

                        <div x-show="msg.attachment">
                            <span class="block text-sm font-black text-gray-800 mb-3">المرفقات:</span>
                            <a :href="msg.attachment" target="_blank" class="inline-flex items-center gap-3 px-6 py-4 bg-gray-900 text-white hover:bg-black rounded-2xl font-black text-sm shadow-xl shadow-gray-900/20 transition-all hover:-translate-y-1">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                تحميل المرفق
                            </a>
                        </div>

                    </div>
                </template>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        function contactsInbox() {
            return {
                isModalOpen: false,
                msg: null,
                viewMessage(data) {
                    this.msg = data;
                    this.isModalOpen = true;
                },
                closeModal() {
                    this.isModalOpen = false;
                    setTimeout(() => {
                        this.msg = null;
                    }, 300);
                }
            }
        }
    </script>
@endsection
