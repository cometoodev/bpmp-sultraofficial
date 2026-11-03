<?php

namespace Tests\Unit;

use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use Tests\TestCase;

class ContactMessageModelTest extends TestCase
{
    public function test_contact_message_fillable_attributes(): void
    {
        $message = new ContactMessage([
            'name' => 'Siti Rahma',
            'email' => 'siti@example.com',
            'subject' => 'Pertanyaan Kerjasama Pelatihan',
            'message' => 'Halo BPMP Sultra, kami ingin menanyakan jadwal pelatihan terbaru.',
        ]);

        $this->assertEquals('Siti Rahma', $message->name);
        $this->assertEquals('siti@example.com', $message->email);
        $this->assertEquals('Pertanyaan Kerjasama Pelatihan', $message->subject);
        $this->assertEquals('Halo BPMP Sultra, kami ingin menanyakan jadwal pelatihan terbaru.', $message->message);
    }

    public function test_contact_message_mailable_content(): void
    {
        $data = [
            'name' => 'Siti Rahma',
            'email' => 'siti@example.com',
            'subject' => 'Pertanyaan Kerjasama',
            'message' => 'Detail pesan kontak.',
        ];

        $mailable = new ContactMessageMail($data);

        $envelope = $mailable->envelope();
        $this->assertStringContainsString('Pertanyaan Kerjasama', $envelope->subject);
        $this->assertCount(1, $envelope->replyTo);
        $this->assertEquals('siti@example.com', $envelope->replyTo[0]->address);
        $this->assertEquals('Siti Rahma', $envelope->replyTo[0]->name);

        $content = $mailable->content();
        $this->assertEquals('emails.contact', $content->view);
        $this->assertEquals($data, $content->with['contactData']);
    }
}
