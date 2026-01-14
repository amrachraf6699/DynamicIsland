<?php

namespace App\Http\Controllers\Admin;

use App\Mail\NewsletterCampaignMail;
use App\Models\NewsletterSubscription;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends BaseCrudController
{
    protected string $model = NewsletterSubscription::class;
    protected string $resourceName = 'newsletters';
    protected string $viewPath = 'admin.newsletters';
    protected ?string $resourceLabel = 'النشرة البريدية';
    protected array $searchable = ['email'];
    protected array $sortable = ['id', 'email', 'created_at'];
    protected array $filterable = [];
    protected array $createValidationRules = [];
    protected array $updateValidationRules = [];

    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:' . $this->permissionName('update'))->only(['campaignForm', 'campaign']);
    }

    protected function buildIndexQuery(Request $request): Builder
    {
        return parent::buildIndexQuery($request)->latest();
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

    public function campaignForm(): Renderable
    {
        $total = NewsletterSubscription::count();

        return view('admin.newsletters.campaign', compact('total'));
    }

    public function campaign(Request $request)
    {
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $subscribers = NewsletterSubscription::query()->pluck('email');

        if ($subscribers->isEmpty()) {
            return redirect()
                ->back()
                ->with('error', 'لا يوجد مشتركون لإرسال الحملة.');
        }

        foreach ($subscribers as $email) {
            Mail::to($email)->send(new NewsletterCampaignMail(
                $email,
                $data['subject'],
                $data['message']
            ));
        }

        return redirect()
            ->route('admin.newsletters.index')
            ->with('success', 'تم إرسال الحملة البريدية إلى جميع المشتركين.');
    }
}
