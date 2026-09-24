<?php

namespace Database\Seeders;

use App\Enums\ApprovalDecision;
use App\Enums\ComplaintStatus;
use App\Enums\DocumentVerificationStatus;
use App\Enums\HandlingType;
use App\Enums\MinistryDecision;
use App\Enums\PbiReason;
use App\Enums\ReferralStatus;
use App\Enums\RehabilitationCaseStatus;
use App\Enums\ServiceRequestStatus;
use App\Models\Approval;
use App\Models\Assessment;
use App\Models\Client;
use App\Models\ClientCategory;
use App\Models\Complaint;
use App\Models\ComplaintAttachment;
use App\Models\ComplaintCategory;
use App\Models\DtsenCertificate;
use App\Models\DtsenPurpose;
use App\Models\NumberSequence;
use App\Models\PbiReactivation;
use App\Models\Referral;
use App\Models\ReferralInstitution;
use App\Models\RehabilitationCase;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestDocument;
use App\Models\ServiceType;
use App\Models\StatusHistory;
use App\Models\User;
use App\Models\Village;
use App\Models\WorkUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $submitter = User::where('email', 'warga@gmail.com')->first();
        $officerLayanan = User::where('email', 'petugas.layanan@dinsos.blitarkab.go.id')->first();
        $officerRehsos = User::where('email', 'petugas.rehsos@dinsos.blitarkab.go.id')->first();
        $kabid = User::where('email', 'kabid.linjamsos@dinsos.blitarkab.go.id')->first();
        $kadis = User::where('email', 'kadis@dinsos.blitarkab.go.id')->first();

        $kanigoroVillage = Village::where('name', 'Kanigoro')->first();
        $satreyanVillage = Village::where('name', 'Satreyan')->first();

        $linjamsos = WorkUnit::where('name', 'like', '%Linjamsos%')->first();
        $rehsos = WorkUnit::where('name', 'like', '%Rehabilitasi%')->first();

        $dtsenType = ServiceType::where('code', 'DTSEN')->first();
        $pbiType = ServiceType::where('code', 'PBI')->first();
        $dtsenPurpose = DtsenPurpose::where('code', 'spmb')->first();

        // 1. SAMPLE LAYANAN 1: SK DTSEN (Status: Selesai / Issued)
        $req1 = ServiceRequest::where('applicant_nik', '3505071208960007')
            ->where('service_type_id', $dtsenType?->id)
            ->first();

        if (! $req1 && $dtsenType && $kanigoroVillage) {
            $dtsenReqNumber = NumberSequence::next('DTSEN');
            $req1 = ServiceRequest::create([
                'request_number' => $dtsenReqNumber,
                'service_type_id' => $dtsenType->id,
                'submitter_id' => $submitter?->id,
                'applicant_name' => 'Budi Santoso',
                'applicant_nik' => '3505071208960007',
                'family_card_number' => '3505071208960001',
                'address' => 'RT 02 RW 01 Kelurahan Kanigoro',
                'village_id' => $kanigoroVillage->id,
                'phone' => '085700001122',
                'submitted_at' => Carbon::now()->subDays(2),
                'officer_id' => $officerLayanan?->id,
                'work_unit_id' => $linjamsos?->id,
                'status' => ServiceRequestStatus::Completed,
                'is_priority' => false,
                'verification_result' => 'Data sesuai dengan SIKS-NG Pusat. Pemohon terdaftar pada Desil 2.',
                'officer_notes' => 'Memenuhi persyaratan SPMB Afirmasi.',
                'service_result' => 'Surat Keterangan DTSEN Nomor 400.9/101/409.105/2026 telah diterbitkan.',
                'completed_at' => Carbon::now()->subDay(),
            ]);

            // Dokumen pengajuan 1
            foreach ($dtsenType->requirements as $req) {
                ServiceRequestDocument::create([
                    'service_request_id' => $req1->id,
                    'service_requirement_id' => $req->id,
                    'file_path' => 'documents/samples/sample_ktp.pdf',
                    'original_name' => $req->name.'.pdf',
                    'verification_status' => DocumentVerificationStatus::Valid,
                    'notes' => 'Dokumen asli terbaca jelas.',
                ]);
            }

            // Detail SK DTSEN
            $certNumber = '400.9/101/409.105/'.Carbon::now()->year;
            if (! DtsenCertificate::where('certificate_number', $certNumber)->exists()) {
                $verificationCode = strtoupper(Str::random(12));
                $cert = DtsenCertificate::create([
                    'service_request_id' => $req1->id,
                    'dtsen_purpose_id' => $dtsenPurpose->id,
                    'purpose_description' => 'Pendaftaran SPMB Jalur Afirmasi SMAN 1 Talun',
                    'subject_name' => 'Ahmad Fauzi (Anak)',
                    'subject_nik' => '3505072005080008',
                    'relationship_to_applicant' => 'Anak Kandung',
                    'is_registered' => true,
                    'decile' => 2,
                    'checked_at' => Carbon::now()->subDays(2),
                    'checker_id' => $officerLayanan?->id,
                    'certificate_number' => $certNumber,
                    'issued_at' => Carbon::now()->subDay(),
                    'valid_until' => Carbon::now()->addDays(90),
                    'signer_id' => $kadis?->id,
                    'file_path' => 'certificates/sk_dtsen_'.$req1->id.'.pdf',
                    'verification_code' => $verificationCode,
                ]);

                // Persetujuan Berjenjang SK DTSEN
                if ($kabid) {
                    Approval::create([
                        'approvable_type' => DtsenCertificate::class,
                        'approvable_id' => $cert->id,
                        'step' => 1,
                        'approver_id' => $kabid->id,
                        'decision' => ApprovalDecision::Approved,
                        'notes' => 'Paraf disetujui, berkas dan desil sesuai ketentuan.',
                        'decided_at' => Carbon::now()->subDays(1)->subHours(3),
                    ]);
                }

                if ($kadis) {
                    Approval::create([
                        'approvable_type' => DtsenCertificate::class,
                        'approvable_id' => $cert->id,
                        'step' => 2,
                        'approver_id' => $kadis->id,
                        'decision' => ApprovalDecision::Approved,
                        'notes' => 'Tanda tangan disetujui via sistem.',
                        'decided_at' => Carbon::now()->subDay(),
                    ]);
                }
            }

            StatusHistory::create([
                'statusable_type' => ServiceRequest::class,
                'statusable_id' => $req1->id,
                'from_status' => ServiceRequestStatus::Submitted->value,
                'to_status' => ServiceRequestStatus::Completed->value,
                'notes' => 'Surat Keterangan telah selesai dan diterbitkan.',
                'user_id' => $officerLayanan?->id,
                'created_at' => Carbon::now()->subDay(),
            ]);
        }

        // 2. SAMPLE LAYANAN 2: REAKTIVASI KIS / PBI-JK (Status: Diusulkan ke Kemensos / Darurat Medis)
        $req2 = ServiceRequest::where('applicant_nik', '3505074506880009')
            ->where('service_type_id', $pbiType?->id)
            ->first();

        if (! $req2 && $pbiType && $satreyanVillage) {
            $pbiReqNumber = NumberSequence::next('PBI');
            $req2 = ServiceRequest::create([
                'request_number' => $pbiReqNumber,
                'service_type_id' => $pbiType->id,
                'submitter_id' => $submitter?->id,
                'applicant_name' => 'Siti Aminah',
                'applicant_nik' => '3505074506880009',
                'family_card_number' => '3505074506880001',
                'address' => 'Dusun Tlogo, Desa Tlogo, Kanigoro',
                'village_id' => $satreyanVillage->id,
                'phone' => '081399887766',
                'submitted_at' => Carbon::now()->subHours(12),
                'officer_id' => $officerLayanan?->id,
                'work_unit_id' => $linjamsos?->id,
                'status' => ServiceRequestStatus::ProposedToMinistry,
                'is_priority' => true,
                'verification_result' => 'Pasien rawat inap darurat di RSUD Ngudi Waluyo Wlingi dengan diagnosa katastropik.',
                'officer_notes' => 'Prioritas penanganan darurat medis.',
                'service_result' => null,
                'completed_at' => null,
            ]);

            $recomNumber = '440/202/409.105/'.Carbon::now()->year;
            if (! PbiReactivation::where('recommendation_number', $recomNumber)->exists()) {
                PbiReactivation::create([
                    'service_request_id' => $req2->id,
                    'participant_name' => 'Siti Aminah',
                    'participant_nik' => '3505074506880009',
                    'bpjs_card_number' => '0001456789123',
                    'deactivated_date' => Carbon::now()->subMonths(2),
                    'reason' => PbiReason::Emergency,
                    'health_facility_name' => 'RSUD Ngudi Waluyo Wlingi',
                    'health_letter_number' => '445/892/RSUD/2026',
                    'decile' => 1,
                    'eligibility_notes' => 'Peserta memenuhi syarat reaktivasi kriteria darurat medis.',
                    'recommendation_number' => $recomNumber,
                    'recommendation_issued_at' => Carbon::now()->subHours(6),
                    'signer_id' => $kadis?->id,
                    'proposed_to_ministry_at' => Carbon::now()->subHours(4),
                    'ministry_decision' => MinistryDecision::Pending,
                ]);
            }
        }

        // 3. SAMPLE LAYANAN 3: REHABILITASI SOSIAL & KLIEN
        $clientCat = ClientCategory::where('name', 'like', '%Lanjut Usia%')->first();
        $client = Client::where('nik', '3505070101420002')->first();

        if (! $client && $clientCat && $satreyanVillage) {
            $client = Client::create([
                'name' => 'Mbah Marto Utomo',
                'client_category_id' => $clientCat->id,
                'nik' => '3505070101420002',
                'birth_date' => '1942-05-10',
                'gender' => 'Laki-laki',
                'address' => 'RT 01 RW 03 Kelurahan Satreyan, Kec. Kanigoro',
                'village_id' => $satreyanVillage->id,
                'phone' => null,
            ]);

            $caseNumber = NumberSequence::next('RHS');
            $rehabCase = RehabilitationCase::create([
                'case_number' => $caseNumber,
                'client_id' => $client->id,
                'officer_id' => $officerRehsos?->id,
                'handling_type' => HandlingType::Referral,
                'status' => RehabilitationCaseStatus::InService,
                'handling_result' => 'Klien telah di-assessment dan dirujuk ke UPT PSTW Blitar.',
                'received_at' => Carbon::now()->subDays(5),
            ]);

            $assessment = Assessment::create([
                'rehabilitation_case_id' => $rehabCase->id,
                'officer_id' => $officerRehsos?->id,
                'assessment_date' => Carbon::now()->subDays(4),
                'result' => 'Lansia berusia 84 tahun, hidup sebatang kara, tidak memiliki keluarga yang menafkahi dan kondisi fisik rentan.',
                'service_needs' => 'Perawatan panti jompo, permakanan rutin, dan pemeriksaan kesehatan berkala.',
                'recommendation' => 'Rujukan ke UPT Pelayanan Sosial Tresna Werdha (PSTW) Blitar.',
                'needs_referral' => true,
            ]);

            $pstw = ReferralInstitution::where('type', 'panti')->first();
            if ($pstw) {
                $refNumber = NumberSequence::next('RJK');
                Referral::create([
                    'referral_number' => $refNumber,
                    'rehabilitation_case_id' => $rehabCase->id,
                    'assessment_id' => $assessment->id,
                    'referral_institution_id' => $pstw->id,
                    'officer_id' => $officerRehsos?->id,
                    'referral_date' => Carbon::now()->subDays(3),
                    'status' => ReferralStatus::Accepted,
                    'service_result' => 'Klien telah diterima dengan baik di Wisma Mawar PSTW Blitar.',
                    'completed_at' => null,
                ]);
            }
        }

        // 4. SAMPLE LAYANAN 5: PENGADUAN SOSIAL
        $complaintCat = ComplaintCategory::where('name', 'like', '%ODGJ%')->first();
        $existingComplaint = Complaint::where('description', 'like', '%ODGJ tanpa busana%')->first();

        if (! $existingComplaint && $complaintCat && $kanigoroVillage) {
            $compNumber = NumberSequence::next('ADU');
            $complaint = Complaint::create([
                'complaint_number' => $compNumber,
                'complaint_category_id' => $complaintCat->id,
                'reporter_id' => $submitter?->id,
                'reporter_name' => 'Budi Santoso',
                'reporter_phone' => '085700001122',
                'location_detail' => 'Dekat Pasar Kanigoro, trotoar jalan utama arah Garum',
                'village_id' => $kanigoroVillage->id,
                'description' => 'Terdapat seorang ODGJ tanpa busana dan sering melempar kerikil ke arah pengguna jalan, mohon bantuan penanganan.',
                'reported_at' => Carbon::now()->subHours(8),
                'officer_id' => $officerRehsos?->id,
                'status' => ComplaintStatus::InHandling,
                'verification_result' => 'Laporan valid, petugas TRC Dinsos telah berkoordinasi dengan Satpol PP untuk penjangkauan lapangan.',
                'action_taken' => 'Penjangkauan lokasi bersama tim Satpol PP dan evakuasi sementara ke RSUD.',
            ]);

            ComplaintAttachment::create([
                'complaint_id' => $complaint->id,
                'file_path' => 'attachments/laporan_odgj.jpg',
                'type' => 'photo',
            ]);
        }
    }
}
