<?php

namespace App\Mail;

use App\Models\Recette;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NouveauFavoriRecetteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Recette $recette,
        public string $nomUtilisateur
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre recette a recu un nouveau favori'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.nouveau-favori-recette'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
