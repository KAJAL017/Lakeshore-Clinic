@extends('layouts.doctor')

@section('title', 'My Meetings - Lakeshore Clinic')
@section('page-title', 'My Meetings')

@section('content')
<div class="space-y-6">
    <p class="text-sm text-gray-400">View and join your telemedicine meetings</p>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Meeting ID</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Patient</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Date & Time</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($meetings as $meeting)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-4">
                                <p class="text-sm font-medium text-gray-900 font-mono">{{ $meeting->meeting_id ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex-shrink-0 flex items-center justify-center" style="background: linear-gradient(135deg, #fdf4ff, #fae8ff);">
                                        <span class="text-xs font-bold text-purple-600">{{ strtoupper(substr($meeting->appointment->patient?->first_name ?? 'P', 0, 1) . substr($meeting->appointment->patient?->last_name ?? '', 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $meeting->appointment->patient_name ?? ($meeting->appointment->patient?->first_name . ' ' . $meeting->appointment->patient?->last_name ?? '-') }}</p>
                                        <p class="text-xs text-gray-400">{{ $meeting->appointment->specialization?->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-sm text-gray-900">{{ $meeting->appointment->appointment_date->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($meeting->appointment->appointment_time)->format('h:i A') }}</p>
                            </td>
                            <td class="px-5 py-4">
                                @php $statusVariant = match($meeting->status) { 'pending' => 'bg-amber-50 text-amber-700', 'created' => 'bg-blue-50 text-blue-700', 'active' => 'bg-green-50 text-green-700', 'completed' => 'bg-green-50 text-green-700', 'cancelled' => 'bg-red-50 text-red-700', default => 'bg-gray-50 text-gray-700' }; @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium {{ $statusVariant }}">{{ $meeting->status_label }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <button onclick="viewMeeting({{ $meeting->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View"><svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4"><svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg></div>
                                    <p class="text-sm font-medium text-gray-900">No meetings</p>
                                    <p class="text-xs text-gray-400 mt-1">No meetings assigned yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($meetings->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">{{ $meetings->links() }}</div>
        @endif
    </div>
</div>

<x-modal id="view-meeting" title="Meeting Details" size="lg">
    <div id="meeting-content" class="space-y-4"></div>
</x-modal>

@push('scripts')
<script>
async function viewMeeting(id) {
    try {
        const response = await fetch(`/doctor/meetings/${id}`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await response.json();
        if (data.success) {
            const m = data.meeting;
            const a = m.appointment;
            const statusColors = { pending: 'bg-amber-50 text-amber-700', created: 'bg-blue-50 text-blue-700', active: 'bg-green-50 text-green-700', completed: 'bg-gray-50 text-gray-700', cancelled: 'bg-red-50 text-red-700' };
            document.getElementById('meeting-content').innerHTML = `
                <div class="space-y-4 text-sm">
                    <div><span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium ${statusColors[m.status] || 'bg-gray-50 text-gray-700'}">${m.status_label}</span></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><p class="text-gray-400 mb-1">Meeting ID</p><p class="text-gray-900 font-medium font-mono">${m.meeting_id || 'Not generated'}</p></div>
                        <div><p class="text-gray-400 mb-1">Meeting URL</p><p class="text-gray-900 font-medium break-all">${m.meeting_url || 'Not generated'}</p></div>
                        <div><p class="text-gray-400 mb-1">Patient</p><p class="text-gray-900">${a?.patient_name || (a?.patient ? a.patient.first_name + ' ' + a.patient.last_name : '-')}</p></div>
                        <div><p class="text-gray-400 mb-1">Date & Time</p><p class="text-gray-900">${a?.appointment_date ? new Date(a.appointment_date).toLocaleDateString() : '-'} ${a?.appointment_time || ''}</p></div>
                    </div>
                    ${m.meeting_url ? `<div><a href="${m.meeting_url}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors text-sm font-semibold"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-1M14 4h6m0 0v6m0-6L10 14"/></svg> Join Meeting</a></div>` : ''}
                </div>
            `;
            openModal('modal-view-meeting');
        }
    } catch (error) { showToast('Failed to load meeting details.', 'error'); }
}
</script>
@endpush
@endsection
