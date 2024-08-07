@props(['vacancy', 'big' => false])

<div @class(['fs-3' => $big])>
    {{ $vacancy->position_title }}
    @if ($vacancy->status == 'Open')
        {{-- <span class="badge bg-success">open</span> --}}
        <span class="text-success">
            (Open)
        </span>
    @elseif ($vacancy->status == 'Closed')
        {{-- <span class="badge bg-secondary">closed</span> --}}
        <span class="text-secondary">
            (Closed)
        </span>
    @elseif ($vacancy->status == 'Shortlisted')
        {{-- <span class="badge bg-primary">shortlisted</span> --}}
        <span class="text-primary">
            (Shortlisted)
        </span>
    @endif
</div>
