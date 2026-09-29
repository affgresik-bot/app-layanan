<?php

namespace Tests\Feature;

use App\Enums\ServiceRequestStatus;
use App\Livewire\CekStatus;
use App\Livewire\PengaduanSosial;
use App\Livewire\PengajuanDtsen;
use App\Livewire\PengajuanPbi;
use App\Models\ComplaintCategory;
use App\Models\District;
use App\Models\DtsenPurpose;
use App\Models\ServiceRequest;
use App\Models\Village;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PublicPortalSubmissionTest extends TestCase
{
    public function test_submit_dtsen_request_successfully(): void
    {
        Storage::fake('local');

        $purpose = DtsenPurpose::first();
        $district = District::first();
        $village = Village::where('district_id', $district->id)->first();

        $ktpFile = UploadedFile::fake()->create('ktp.jpg', 200, 'image/jpeg');
        $kkFile = UploadedFile::fake()->create('kk.jpg', 200, 'image/jpeg');

        $component = Livewire::test(PengajuanDtsen::class)
            // Step 1
            ->set('dtsen_purpose_id', $purpose->id)
            ->call('nextStep')
            ->assertSet('currentStep', 2)
            // Step 2
            ->set('applicant_name', 'Budi Santoso')
            ->set('applicant_nik', '3505123456780001')
            ->set('family_card_number', '3505123456780002')
            ->set('address', 'Jl. Merdeka No. 10')
            ->set('district_id', $district->id)
            ->set('village_id', $village->id)
            ->set('phone', '081234567890')
            ->set('subject_name', 'Budi Santoso')
            ->set('subject_nik', '3505123456780001')
            ->set('relationship_to_applicant', 'diri_sendiri')
            ->call('nextStep')
            ->assertSet('currentStep', 3)
            // Step 3
            ->set('ktp_file', $ktpFile)
            ->set('kk_file', $kkFile)
            ->call('nextStep')
            ->assertSet('currentStep', 4)
            // Step 4
            ->set('agreement', true)
            ->call('submit');

        $ticket = $component->get('submittedTicket');
        $this->assertNotNull($ticket);
        $this->assertStringStartsWith('DTSEN-', $ticket);

        $this->assertDatabaseHas('service_requests', [
            'request_number' => $ticket,
            'applicant_name' => 'Budi Santoso',
            'applicant_nik' => '3505123456780001',
            'status' => ServiceRequestStatus::Submitted->value,
        ]);
    }

    public function test_submit_pbi_request_successfully(): void
    {
        Storage::fake('local');

        $district = District::first();
        $village = Village::where('district_id', $district->id)->first();

        $ktpFile = UploadedFile::fake()->create('ktp.jpg', 200, 'image/jpeg');
        $kkFile = UploadedFile::fake()->create('kk.jpg', 200, 'image/jpeg');
        $bpjsFile = UploadedFile::fake()->create('bpjs.jpg', 200, 'image/jpeg');
        $faskesFile = UploadedFile::fake()->create('faskes.pdf', 300, 'application/pdf');

        $component = Livewire::test(PengajuanPbi::class)
            // Step 1
            ->set('participant_name', 'Siti Rahayu')
            ->set('participant_nik', '3505987654320003')
            ->set('bpjs_card_number', '0001234567890')
            ->set('deactivated_date', '2026-08-01')
            ->set('district_id', $district->id)
            ->set('village_id', $village->id)
            ->set('address', 'Dusun Krajan RT 01 RW 01')
            ->set('phone', '081298765432')
            ->call('nextStep')
            ->assertSet('currentStep', 2)
            // Step 2
            ->set('reason', 'emergency')
            ->set('health_facility_name', 'RSUD Ngudi Waluyo Wlingi')
            ->set('health_letter_number', '445/88/RSUD/2026')
            ->call('nextStep')
            ->assertSet('currentStep', 3)
            // Step 3
            ->set('ktp_file', $ktpFile)
            ->set('kk_file', $kkFile)
            ->set('bpjs_file', $bpjsFile)
            ->set('health_letter_file', $faskesFile)
            ->call('nextStep')
            ->assertSet('currentStep', 4)
            // Step 4
            ->set('agreement', true)
            ->call('submit');

        $ticket = $component->get('submittedTicket');
        $this->assertNotNull($ticket);
        $this->assertStringStartsWith('PBI-', $ticket);

        $this->assertDatabaseHas('service_requests', [
            'request_number' => $ticket,
            'is_priority' => true,
        ]);

        $this->assertDatabaseHas('pbi_reactivations', [
            'participant_name' => 'Siti Rahayu',
            'health_facility_name' => 'RSUD Ngudi Waluyo Wlingi',
        ]);
    }

    public function test_submit_complaint_successfully(): void
    {
        $category = ComplaintCategory::first();
        $district = District::first();
        $village = Village::where('district_id', $district->id)->first();

        $component = Livewire::test(PengaduanSosial::class)
            ->set('complaint_category_id', $category->id)
            ->set('district_id', $district->id)
            ->set('village_id', $village->id)
            ->set('location_detail', 'Depan balai desa Kanigoro RT 01')
            ->set('description', 'Ada seorang lansia terlantar membutuhkan bantuan sembako dan perawatan.')
            ->set('reporter_name', 'Joko Widodo')
            ->set('reporter_phone', '081234567899')
            ->call('submit');

        $ticket = $component->get('submittedTicket');
        $this->assertNotNull($ticket);
        $this->assertStringStartsWith('ADU-', $ticket);

        $this->assertDatabaseHas('complaints', [
            'complaint_number' => $ticket,
            'reporter_name' => 'Joko Widodo',
        ]);
    }

    public function test_cek_status_verifies_ticket_with_key(): void
    {
        $sr = ServiceRequest::first();
        $last4 = substr($sr->applicant_nik, -4);

        Livewire::test(CekStatus::class, ['ticket' => $sr->request_number])
            ->set('identityKey', $last4)
            ->call('checkTicket')
            ->assertSet('errorMessage', null)
            ->assertSee($sr->request_number);
    }
}
