@props(['vacancy', 'big' => false])

<div @class(['fs-3' => $big])>
    {{ $vacancy->position_title }}
    @if ($vacancy->status == 'Open')
        <span class="badge bg-success">open</span>
    @elseif ($vacancy->status == 'Closed')
        <span class="badge bg-secondary">closed</span>
    @elseif ($vacancy->status == 'Shortlisted')
        <span class="badge bg-primary">shortlisted</span>
    @endif
</div>
