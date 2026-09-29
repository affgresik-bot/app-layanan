<?php

namespace App\Livewire;

use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use App\Models\ComplaintAttachment;
use App\Models\ComplaintCategory;
use App\Models\District;
use App\Models\NumberSequence;
use App\Models\StatusHistory;
use App\Models\Village;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Pengaduan & Laporan Sosial — SAPA SOSIAL')]
class PengaduanSosial extends Component
{
    use WithFileUploads;

    public ?int $complaint_category_id = null;

    public ?int $district_id = null;

    public ?int $village_id = null;

    public string $location_detail = '';

    public string $description = '';

    public string $reporter_name = '';

    public string $reporter_phone = '';

    public array $attachments = [];

    public ?string $submittedTicket = null;

    public function mount(): void
    {
        $firstCat = ComplaintCategory::where('is_active', true)->first();
        if ($firstCat) {
            $this->complaint_category_id = $firstCat->id;
        }

        if (auth()->check()) {
            $user = auth()->user();
            $this->reporter_name = $user->name ?? '';
            $this->reporter_phone = $user->phone ?? '';
            $this->district_id = $user->district_id ?? null;
            $this->village_id = $user->village_id ?? null;
        }
    }

    public function updatedDistrictId(): void
    {
        $this->village_id = null;
    }

    public function selectCategory(int $id): void
    {
        $this->complaint_category_id = $id;
    }

    public function submit(): void
    {
        $this->validate([
            'complaint_category_id' => 'required|exists:complaint_categories,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'location_detail' => 'required|string|max:500',
            'description' => 'required|string|min:20',
            'reporter_name' => 'required|string|max:255',
            'reporter_phone' => 'required|string|min:9|max:16',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'complaint_category_id.required' => 'Pilih kategori pengaduan.',
            'district_id.required' => 'Kecamatan kejadian wajib dipilih.',
            'village_id.required' => 'Desa/Kelurahan kejadian wajib dipilih.',
            'location_detail.required' => 'Detail patokan lokasi kejadian wajib diisi.',
            'description.required' => 'Uraian pengaduan wajib diisi.',
            'description.min' => 'Uraian pengaduan minimal 20 karakter.',
            'reporter_name.required' => 'Nama pelapor wajib diisi.',
            'reporter_phone.required' => 'Nomor WhatsApp / HP pelapor wajib diisi.',
        ]);

        $ticket = DB::transaction(function () {
            $reportNumber = NumberSequence::next('ADU');

            $complaint = Complaint::create([
                'complaint_number' => $reportNumber,
                'complaint_category_id' => $this->complaint_category_id,
                'reporter_id' => auth()->id(),
                'reporter_name' => $this->reporter_name,
                'reporter_phone' => $this->reporter_phone,
                'location_detail' => $this->location_detail,
                'village_id' => $this->village_id,
                'description' => $this->description,
                'reported_at' => now(),
                'status' => ComplaintStatus::Received,
            ]);

            // Save attachments
            if (! empty($this->attachments)) {
                foreach ($this->attachments as $file) {
                    $path = $file->store('documents/complaints', 'local');
                    $isPhoto = str_starts_with($file->getMimeType(), 'image/');

                    ComplaintAttachment::create([
                        'complaint_id' => $complaint->id,
                        'file_path' => $path,
                        'type' => $isPhoto ? 'photo' : 'document',
                    ]);
                }
            }

            StatusHistory::create([
                'statusable_type' => Complaint::class,
                'statusable_id' => $complaint->id,
                'from_status' => null,
                'to_status' => ComplaintStatus::Received->value,
                'notes' => 'Laporan pengaduan disampaikan masyarakat via portal SAPA SOSIAL.',
                'user_id' => auth()->id(),
            ]);

            return $reportNumber;
        });

        $this->submittedTicket = $ticket;
    }

    public function render()
    {
        $categories = ComplaintCategory::where('is_active', true)->get();
        $districts = District::orderBy('name')->get();
        $villages = $this->district_id
            ? Village::where('district_id', $this->district_id)->orderBy('name')->get()
            : collect();

        return view('livewire.pengaduan-sosial', [
            'categories' => $categories,
            'districts' => $districts,
            'villages' => $villages,
        ]);
    }
}
