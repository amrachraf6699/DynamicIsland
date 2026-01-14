<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\ContactReplyMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends BaseCrudController
{
    protected string $model = Contact::class;
    protected string $resourceName = 'contacts';
    protected string $viewPath = 'admin.contacts';
    protected ?string $resourceLabel = 'الرسائل';

    protected array $searchable = ['id', 'name', 'email', 'subject', 'message'];

    protected array $filterable = [
        'is_read' => [
            'label' => 'مقروء',
            'type' => 'boolean',
            'options' => ['1' => 'نعم', '0' => 'لا'],
        ],
    ];

    protected array $sortable = ['id', 'created_at', 'replied_at'];
    protected array $createValidationRules = [];
    protected array $updateValidationRules = [];

    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:' . $this->permissionName('update'))->only(['replyForm', 'reply']);
    }

    protected function getIndexColumns(): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'الاسم'],
            ['key' => 'email', 'label' => 'البريد الإلكتروني'],
            ['key' => 'subject', 'label' => 'الموضوع'],
            ['key' => 'created_at', 'label' => 'تاريخ الإرسال', 'type' => 'datetime'],
            ['key' => 'replied_at', 'label' => 'تاريخ الرد', 'type' => 'datetime'],
        ];
    }

    protected function buildIndexQuery(Request $request): Builder
    {
        $query = parent::buildIndexQuery($request);
        // By default latest first
        return $query->orderBy('created_at', 'desc');
    }

    public function create(): Renderable
    {
        abort(404);
    }

    public function store(Request $request)
    {
        abort(404);
    }

    public function edit($id): Renderable
    {
        abort(404);
    }

    public function update(Request $request, $id)
    {
        abort(404);
    }

    public function replyForm($id): Renderable
    {
        $contact = $this->findModel($id);
        return view('admin.contacts.reply', compact('contact'));
    }

    public function reply(Request $request, $id)
    {
        $contact = $this->findModel($id);

        $data = $request->validate([
            'reply_message' => ['required', 'string', 'max:5000'],
        ]);

        $contact->reply_message = $data['reply_message'];
        $contact->replied_at = now();
        $contact->reply_user_id = Auth::id();
        $contact->is_read = true;
        $contact->save();

        Mail::to($contact->email)
        ->send(new ContactReplyMail($contact, $data['reply_message']));

        return redirect()->route('admin.contacts.index')
            ->with('success', 'تم إرسال الرد وحفظه بنجاح');
    }
}
