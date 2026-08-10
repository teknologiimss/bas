<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Email;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Log;

class SyncEmails extends Command
{
    /**
     * Nama perintah artisan yang akan dijalankan.
     */
    protected $signature = 'email:sync';

    /**
     * Deskripsi perintah.
     */
    protected $description = 'Sinkronisasi otomatis email dari departemenmro@gmail.com';

    public function handle()
    {
        $this->info('Memulai sinkronisasi email...');

        try {
            $client = Client::account('default');
            $client->connect();

            // Mengambil folder INBOX
            $folder = $client->getFolder('INBOX');

            // Ambil 30 email terbaru
            $messages = $folder->query()->all()->limit(30)->get();

            $countNew = 0;

            foreach ($messages as $message) {
                $messageId = $message->getMessageId()->get()[0] ?? microtime();

                // Tangani format tanggal
                $rawDate = $message->getDate();
                $dateReceived = null;
                if ($rawDate) {
                    $dateReceived = is_iterable($rawDate) ? $rawDate->first() : $rawDate;
                }

                // Simpan jika belum ada di database
                if (!Email::where('message_id', $messageId)->exists()) {
                    Email::create([
                        'message_id'    => $messageId,
                        'subject'       => $message->getSubject()->get()[0] ?? '(Tanpa Subjek)',
                        'from_email'    => $message->getFrom()[0]->mail ?? '-',
                        'from_name'     => $message->getFrom()[0]->personal ?? '-',
                        'body_html'     => $message->getHTMLBody() ?: $message->getTextBody(),
                        'body_text'     => $message->getTextBody(),
                        'date_received' => $dateReceived ?? now(),
                        'is_read'       => false,
                    ]);
                    $countNew++;
                }
            }

            $this->info("Berhasil! {$countNew} email baru ditambahkan.");
            Log::info("Auto Sync Email: {$countNew} email baru berhasil masuk.");

        } catch (\Exception $e) {
            $this->error('Gagal sinkronisasi: ' . $e->getMessage());
            Log::error('Auto Sync Email Error: ' . $e->getMessage());
        }
    }
}