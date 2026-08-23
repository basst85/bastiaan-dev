<?php

namespace App\Livewire;

use App\Jobs\SendContactMessage;
use App\Models\ContactMessage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Schema\BreadcrumbListSchema;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class SendMessage extends Component
{
    #[Validate('required')]
    public $name;

    #[Validate('required|min:10|email')]
    public $email;

    #[Validate('required|min:5')]
    public $subject;

    #[Validate('required|min:10')]
    public $message;

    public function send()
    {
        $this->validate();

        $contactMessage = new ContactMessage(
            name: $this->name,
            email: $this->email,
            subject: $this->subject,
            message: $this->message
        );

        SendContactMessage::dispatch($contactMessage);

        session()->flash('success', "Thanks for your message. I'll get back to you as soon as possible.");

        $this->reset();
    }

    public function render()
    {
        // Set SEO meta tags + JSON-LD structured data
        seo(new SEOData(
            title: 'Contact me - '.config('app.name'),
            description: 'Contact Bastiaan Steinmeier',
            author: 'Bastiaan Steinmeier',
            schema: SchemaCollection::initialize()
                ->add(fn (SEOData $SEOData) => [
                    '@context' => 'https://schema.org',
                    '@type' => 'ContactPage',
                    'name' => $SEOData->title,
                    'url' => $SEOData->url,
                ])
                ->addBreadcrumbs(fn (BreadcrumbListSchema $breadcrumbs): BreadcrumbListSchema => $breadcrumbs->prependBreadcrumbs([
                    'Home' => url('/'),
                ])),
        ));

        return view('livewire.contact');
    }
}
