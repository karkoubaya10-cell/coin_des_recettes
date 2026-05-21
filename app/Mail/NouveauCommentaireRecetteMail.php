<?php

namespace App\Mail;

use App\Models\Commentaire;
use App\Models\Recette;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NouveauCommentaireRecetteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(//avec new NouveauCommentaireRecetteMail(...)
        public Recette $recette,
        public Commentaire $commentaire,
        public string $nomCommentateur
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouveau commentaire sur votre recette'
        );
    }

    public function content(): Content
    {
        return new Content(//view affiché 
            view: 'emails.nouveau-commentaire-recette'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
