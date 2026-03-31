<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactType;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $types = ContactType::all();

        $contacts = Contact::with('type')
            ->when(request('type_id'), function ($query) {
                return $query->where('contact_type_id', request('type_id'));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.contacts.index', compact('contacts', 'types'));
    }

    public function toggleRead(Contact $contact): RedirectResponse
    {
        $contact->update(['is_read' => !$contact->is_read]);
        return back()->with('success', 'تم تغيير حالة الرسالة بنجاح.');
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        if ($contact->attachment) {
            delete_file($contact->attachment);
        }
        $contact->delete();
        return back()->with('success', 'تم حذف الرسالة بنجاح.');
    }
}
