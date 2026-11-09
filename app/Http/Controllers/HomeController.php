<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Award;
use App\Models\Banner;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\GratificationReport;
use App\Models\Guestbook;
use App\Models\Post;
use App\Models\SocialIntegration;
use App\Models\SpmbReport;
use App\Models\StandarPelayanan;
use App\Models\Survey;
use App\Models\UltRequest;
use App\Services\UltSkmService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama (homepage) portal BPMP Provinsi Sulawesi Tenggara.
     */
    public function index(Request $request, UltSkmService $ultSkmService): View
    {
        $banners = Banner::where('status', true)->orderBy('order', 'asc')->get();
        $announcements = Announcement::where('status', 'published')->latest('published_at')->take(5)->get();

        $featuredPosts = Post::with('category', 'author')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        $sidePosts = Post::with('category', 'author')
            ->where('status', 'published')
            ->latest('published_at')
            ->skip(3)
            ->take(3)
            ->get();

        $settings = DB::table('settings')->where('group', 'general')->pluck('value', 'key');
        $totalGuestbook = Guestbook::count();
        $totalPosts = Post::where('status', 'published')->count();
        $awards = Award::orderBy('order', 'asc')->orderBy('created_at', 'desc')->get();
        $events = Event::orderBy('event_date', 'desc')->take(6)->get();
        $agendas = Agenda::orderBy('agenda_date', 'asc')->orderBy('time_start', 'asc')->get();

        $agendaJsonList = $agendas->map(function ($item) {
            $date = Carbon::parse($item->agenda_date);

            return [
                'id' => $item->id,
                'day' => (int) $date->format('j'),
                'month' => (int) $date->format('n') - 1,
                'year' => (int) $date->format('Y'),
                'title' => $item->title,
                'time' => $item->time_start.' - '.$item->time_end.' WITA',
                'description' => $item->description ?? 'Agenda kegiatan resmi BPMP Sultra.',
                'type' => 'primary',
            ];
        });

        if ($agendaJsonList->isEmpty()) {
            $agendaJsonList = collect([
                [
                    'id' => 0,
                    'day' => (int) date('j'),
                    'month' => (int) date('n') - 1,
                    'year' => (int) date('Y'),
                    'title' => 'Rapat Koordinasi Mingguan BPMP Sultra',
                    'time' => '09.00 - 11.30 WITA',
                    'description' => 'Koordinasi berkala evaluasi capaian program dan layanan BPMP Sultra.',
                    'type' => 'primary',
                ],
            ]);
        }

        $surveys = Survey::orderBy('year', 'desc')->orderBy('period', 'asc')->get();
        $activeSurvey = null;
        if ($request->filled('survey_id')) {
            $activeSurvey = Survey::find($request->input('survey_id'));
        } else {
            $reqYear = $request->input('skm_tahun', $request->input('survey_year'));
            $reqTwNum = $request->input('skm_triwulan');
            $reqPeriod = $reqTwNum ? ('Triwulan '.$reqTwNum) : $request->input('survey_period');

            if ($reqYear && $reqPeriod) {
                $activeSurvey = Survey::where('year', $reqYear)->where('period', $reqPeriod)->first();
            } elseif ($reqYear) {
                $activeSurvey = Survey::where('year', $reqYear)->where('is_active', true)->first()
                    ?? Survey::where('year', $reqYear)->first();
            }
        }
        if (! $activeSurvey) {
            $activeSurvey = Survey::where('is_active', true)->first() ?? $surveys->first();
        }

        // 1. Tangkap Parameter Filter dari URL (Default: Tahun ini, Triwulan 1)
        $tahunSkm = (int) $request->input('skm_tahun', $request->input('survey_year', date('Y')));
        $triwulanSkm = (int) $request->input('skm_triwulan', 1);
        if (! in_array($triwulanSkm, [1, 2, 3, 4], true)) {
            $triwulanSkm = 1;
        }

        // 2. Helper untuk query berdasarkan Triwulan
        $getSurveyByTriwulan = function ($tahun, $triwulan) {
            $query = Guestbook::with('ultSurveyResponse')->whereYear('created_at', $tahun);
            if ($triwulan == 1) {
                $query->whereMonth('created_at', '>=', 1)->whereMonth('created_at', '<=', 3);
            }
            if ($triwulan == 2) {
                $query->whereMonth('created_at', '>=', 4)->whereMonth('created_at', '<=', 6);
            }
            if ($triwulan == 3) {
                $query->whereMonth('created_at', '>=', 7)->whereMonth('created_at', '<=', 9);
            }
            if ($triwulan == 4) {
                $query->whereMonth('created_at', '>=', 10)->whereMonth('created_at', '<=', 12);
            }

            return $query->whereHas('ultSurveyResponse')->get()->pluck('ultSurveyResponse');
        };

        // 4. Hitung juga nilai IKM untuk ke-4 Triwulan (untuk preview angka di tombol tab)
        $skmTabs = [];
        $activeWithData = null;

        for ($i = 1; $i <= 4; $i++) {
            $tabResponses = $getSurveyByTriwulan($tahunSkm, $i);
            $tabCalc = $ultSkmService->calculateSkm($tabResponses);
            $tabScore = $tabCalc['nilai_konversi'];

            if ($tabScore == 0 && isset($surveys)) {
                $matchManualSurvey = $surveys->first(function ($s) use ($tahunSkm, $i) {
                    return (int) $s->year === (int) $tahunSkm && (string) $s->period === ('Triwulan '.$i);
                });
                if ($matchManualSurvey && $matchManualSurvey->ikm_score > 0) {
                    $tabScore = (float) $matchManualSurvey->ikm_score;
                }
            }

            $skmTabs[$i] = $tabScore;
            if ($tabCalc['total_responden'] > 0 && $activeWithData === null) {
                $activeWithData = $i;
            }
        }

        if (! $request->filled('skm_triwulan') && ($skmTabs[$triwulanSkm] ?? 0) == 0 && $activeWithData !== null) {
            $triwulanSkm = $activeWithData;
        }

        // 3. Ambil data utama sesuai filter yang aktif
        $surveyResponses = $getSurveyByTriwulan($tahunSkm, $triwulanSkm);
        $dataSkmUtama = $ultSkmService->calculateSkm($surveyResponses);

        if ($dataSkmUtama['total_responden'] === 0 && $activeSurvey && ! empty($activeSurvey->nrr_elements)) {
            $nrrConverted = [];
            for ($k = 1; $k <= 9; $k++) {
                $uKey = 'u'.$k;
                $qKey = 'q'.$k;
                $val = (float) ($activeSurvey->nrr_elements[$uKey] ?? $activeSurvey->nrr_elements[$qKey] ?? 0);
                $nrrConverted[$qKey] = $val;
                $nrrConverted[$k] = $val;
            }

            $dataSkmUtama = [
                'total_responden' => (int) $activeSurvey->total_respondents,
                'nrr_per_unsur' => $nrrConverted,
                'nilai_ikm' => (float) ($activeSurvey->total_nrt ?? round(($activeSurvey->ikm_score / 25), 3)),
                'nilai_konversi' => (float) $activeSurvey->ikm_score,
                'mutu' => $activeSurvey->ikm_service_quality ?? 'B',
                'kinerja' => $activeSurvey->ikm_performance_category ?? 'Baik',
                'unsur_terbaik' => null,
                'unsur_terendah' => null,
            ];
        }

        // Ambil daftar tahun unik dari buku tamu untuk selector tahun dinamis
        $driver = DB::getDriverName();
        $yearExpr = $driver === 'sqlite' ? "strftime('%Y', created_at) as year" : 'YEAR(created_at) as year';

        $availableSkmYears = Guestbook::selectRaw($yearExpr)
            ->distinct()
            ->pluck('year')
            ->filter()
            ->map(fn ($y) => (int) $y)
            ->toArray();

        if (empty($availableSkmYears)) {
            $availableSkmYears = [(int) date('Y'), (int) date('Y') - 1, (int) date('Y') - 2];
        } elseif (! in_array((int) date('Y'), $availableSkmYears, true)) {
            array_unshift($availableSkmYears, (int) date('Y'));
        }
        rsort($availableSkmYears);

        // =========================================================================
        // 4 VARIABEL STATISTIK KINERJA OTOMATIS (MURNI DARI DATABASE)
        // =========================================================================

        // 1. Total Dokumen / Standar Pelayanan Publik
        $totalDokumenStandar = StandarPelayanan::where('is_active', true)->count();

        // 2. Aspirasi & Pengaduan Selesai / Resolved Rate
        // Perbandingan aduan/pesan berstatus 'selesai' dibanding total keseluruhan aduan (SPMB, Gratifikasi, & Pesan Masuk)
        $totalSpmb = SpmbReport::count();
        $totalGratifikasi = GratificationReport::count();
        $totalContact = ContactMessage::count();
        $totalAspirasi = $totalSpmb + $totalGratifikasi + $totalContact;

        $selesaiSpmb = SpmbReport::whereIn('status', ['completed', 'selesai'])->count();
        $selesaiGratifikasi = GratificationReport::whereIn('status', ['recorded', 'verified', 'selesai'])->count();
        $selesaiAspirasi = $selesaiSpmb + $selesaiGratifikasi;

        $resolvedRate = $totalAspirasi > 0
            ? round(($selesaiAspirasi / $totalAspirasi) * 100, 1)
            : 100;

        // 3. Total Kunjungan Buku Tamu / Layanan ULT
        // Akumulasi total baris data dari tabel guestbooks dan permohonan ULT
        $totalKunjunganUlt = Guestbook::count() + UltRequest::count();

        // 4. Indeks Kepuasan SKM Aktif
        // Rata-rata skor nilai kuesioner dari tabel SKM yang dikonversi ke format persentase %
        $indeksKepuasanSkm = (float) ($dataSkmUtama['nilai_konversi'] > 0
            ? $dataSkmUtama['nilai_konversi']
            : ($activeSurvey->ikm_score ?? 90.65));

        // Integrasi Media Sosial Publik (Urutkan sesuai order, hanya yang aktif)
        $socialIntegrations = SocialIntegration::where('is_active', true)->orderBy('order', 'asc')->get();
        if ($socialIntegrations->isEmpty()) {
            $socialIntegrations = collect([
                new SocialIntegration(['platform' => 'instagram', 'name' => 'Instagram', 'username' => '@bpmpsultra', 'profile_url' => 'https://www.instagram.com/bpmpsultra/', 'is_active' => true, 'order' => 1]),
                new SocialIntegration(['platform' => 'tiktok', 'name' => 'TikTok', 'username' => '@bpmp.sulawesitenggara', 'profile_url' => 'https://www.tiktok.com/@bpmp.sulawesitenggara', 'is_active' => true, 'order' => 2]),
                new SocialIntegration(['platform' => 'youtube', 'name' => 'YouTube', 'username' => '@bpmpsultra', 'profile_url' => 'https://www.youtube.com/@bpmpsultra', 'is_active' => true, 'order' => 3]),
            ]);
        }

        return view('welcome', compact(
            'banners',
            'announcements',
            'featuredPosts',
            'sidePosts',
            'settings',
            'activeSurvey',
            'surveys',
            'tahunSkm',
            'triwulanSkm',
            'dataSkmUtama',
            'skmTabs',
            'availableSkmYears',
            'totalGuestbook',
            'totalPosts',
            'awards',
            'events',
            'agendas',
            'agendaJsonList',
            'totalDokumenStandar',
            'resolvedRate',
            'totalKunjunganUlt',
            'indeksKepuasanSkm',
            'totalAspirasi',
            'selesaiAspirasi',
            'socialIntegrations'
        ));
    }
}
