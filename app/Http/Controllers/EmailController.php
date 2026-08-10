<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;

class EmailController extends Controller
{
    public function index()
    {
        // Ambil data email tersimpan dari database
        $emails = Email::orderBy('date_received', 'desc')->paginate(15);

        return view('email.index', compact('emails'));
    }

    public function sync()
    {
        try {
            $client = Client::account('default');
            $client->connect();

            $folder = $client->getFolder('INBOX');

            // Ambil 20 email terbaru
            $messages = $folder->query()->all()->limit(20)->get();

            foreach ($messages as $message) {
                $messageId = $message->getMessageId()->get()[0] ?? microtime();

                // Ubah penanganan tanggal agar kompatibel dengan Carbon
                $rawDate = $message->getDate();
                $dateReceived = null;

                if ($rawDate) {
                    // Jika $rawDate berupa Collection/Array, ambil item pertamanya
                    if (is_iterable($rawDate)) {
                        $dateReceived = $rawDate->first();
                    } else {
                        $dateReceived = $rawDate;
                    }
                }

                // Simpan ke Database
                if (!Email::where('message_id', $messageId)->exists()) {
                    Email::create([
                        'message_id' => $messageId,
                        'subject' => $message->getSubject()->get()[0] ?? '(Tanpa Subjek)',
                        'from_email' => $message->getFrom()[0]->mail ?? '-',
                        'from_name' => $message->getFrom()[0]->personal ?? '-',
                        'body_html' => $message->getHTMLBody() ?: $message->getTextBody(),
                        'body_text' => $message->getTextBody(),
                        'date_received' => $dateReceived ?? now(),
                        'is_read' => false,
                    ]);
                }
            }

            return redirect()->route('email.index')->with('success', 'Email berhasil disinkronisasi!');
        } catch (\Exception $e) {
            return redirect()->route('email.index')->with('error', 'Gagal mengambil email: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $email = Email::findOrFail($id);

        if (!$email->is_read) {
            $email->update(['is_read' => true]);
        }

        return view('email.show', compact('email'));
    }
}
