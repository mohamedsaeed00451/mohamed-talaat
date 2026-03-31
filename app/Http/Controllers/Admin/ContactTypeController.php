<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactTypeController extends Controller
{
    public function index(): View
    {
        $types = ContactType::latest()->paginate(10);
        return view('admin.contact_types.index', compact('types'));
    }

    public function create(): View
    {
        return view('admin.contact_types.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name.ar' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
        ]);

        ContactType::create([
            'name' => [
                'ar' => $request->input('name.ar'),
                'en' => $request->input('name.en'),
            ]
        ]);

        return redirect()->route('admin.contact-types.index')->with('success', 'تم إضافة النوع بنجاح');
    }

    public function edit(ContactType $contactType): View
    {
        return view('admin.contact_types.edit', compact('contactType'));
    }

    public function update(Request $request, ContactType $contactType): RedirectResponse
    {
        $request->validate([
            'name.ar' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
        ]);

        $contactType->update([
            'name' => [
                'ar' => $request->input('name.ar'),
                'en' => $request->input('name.en'),
            ]
        ]);

        return redirect()->route('admin.contact-types.index')->with('success', 'تم التعديل بنجاح');
    }

    public function destroy(ContactType $contactType): RedirectResponse
    {
        $contactType->delete();
        return back()->with('success', 'تم الحذف بنجاح');
    }
}
