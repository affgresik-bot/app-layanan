<?php

namespace App\Livewire;

use App\Models\Complaint;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Riwayat Pengajuan Saya — SAPA SOSIAL')]
class RiwayatPengajuan extends Component
{
    public string $filter = 'semua'; // semua, layanan, pengaduan

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
    }

    public function render()
    {
        $userId = Auth::id();

        $serviceRequests = ServiceRequest::with(['serviceType', 'dtsenCertificate', 'pbiReactivation'])
            ->where('submitter_id', $userId)
            ->latest('submitted_at')
            ->get();

        $complaints = Complaint::with(['category'])
            ->where('reporter_id', $userId)
            ->latest('reported_at')
            ->get();

        // Stats calculation
        $totalCount = $serviceRequests->count() + $complaints->count();

        $inProcessCount = $serviceRequests->whereNotIn('status.value', ['completed', 'rejected', 'reactivated'])->count()
            + $complaints->whereNotIn('status.value', ['resolved', 'duplicate', 'invalid'])->count();

        $completedCount = $serviceRequests->whereIn('status.value', ['completed', 'reactivated', 'issued'])->count()
            + $complaints->where('status.value', 'resolved')->count();

        $revisionCount = $serviceRequests->where('status.value', 'revision_requested')->count();

        return view('livewire.riwayat-pengajuan', [
            'serviceRequests' => $serviceRequests,
            'complaints' => $complaints,
            'totalCount' => $totalCount,
            'inProcessCount' => $inProcessCount,
            'completedCount' => $completedCount,
            'revisionCount' => $revisionCount,
        ]);
    }
}
