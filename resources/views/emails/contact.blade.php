<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Baru dari Website</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 24px; color: #1e293b;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        <div style="background: #1e3a8a; padding: 24px 32px; color: #ffffff;">
            <p style="margin: 0; font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; color: #93c5fd; font-weight: 700;">BPMP Provinsi Sulawesi Tenggara</p>
            <h1 style="margin: 8px 0 0 0; font-size: 20px; font-weight: 800; color: #ffffff;">Pesan Baru dari Formulir Kontak</h1>
        </div>
        
        <div style="padding: 32px;">
            <div style="background-color: #f1f5f9; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px;">
                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <tr>
                        <td style="padding: 6px 0; color: #64748b; width: 100px; font-weight: 600;">Pengirim</td>
                        <td style="padding: 6px 0; color: #0f172a; font-weight: 700;">: {{ $contactData['name'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Email</td>
                        <td style="padding: 6px 0; color: #0f172a;">: <a href="mailto:{{ $contactData['email'] ?? '' }}" style="color: #2563eb; text-decoration: none; font-weight: 600;">{{ $contactData['email'] ?? '-' }}</a></td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Subjek</td>
                        <td style="padding: 6px 0; color: #0f172a; font-weight: 700;">: {{ $contactData['subject'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Waktu</td>
                        <td style="padding: 6px 0; color: #0f172a;">: {{ now()->translatedFormat('d F Y, H:i') }} WITA</td>
                    </tr>
                </table>
            </div>

            <h3 style="font-size: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #475569; margin: 0 0 10px 0;">Isi Pesan:</h3>
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; font-size: 14px; line-height: 1.7; color: #334155; white-space: pre-wrap;">{{ $contactData['message'] ?? '' }}</div>

            <div style="margin-top: 32px; padding-top: 20px; border-top: 1px solid #f1f5f9; font-size: 12px; color: #94a3b8; text-align: center;">
                Pesan ini dikirimkan secara otomatis melalui Formulir Hubungi Kami di situs resmi BPMP Provinsi Sulawesi Tenggara.
            </div>
        </div>
    </div>
</body>
</html>

