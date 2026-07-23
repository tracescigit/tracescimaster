@extends('admin.layout.' . $layout)

@section('subhead')
<title>{{__('demo.demo')}} - TRACESCI</title>
@endsection



@section('subcontent')
<style>
    :root {
        --bg: #f6f6f7;
        --card: #ffffff;
        --black: #16161a;
        --gray: #767680;
        --gray-light: #9a9aa2;
        --border: #e7e7ea;
        --accent: #7a0d7d;
        --accent-soft: rgba(122, 13, 125, .07);
        --shadow: 0 2px 10px rgba(20, 20, 25, .04);
    }

    body {
        background: var(--bg);
    }

    .demo-dashboard {
        max-width: 980px;
        margin: auto;
        font-size: 14px;
        color: var(--black);
    }

    .demo-dashboard *:focus-visible {
        outline: 2px solid var(--accent);
        outline-offset: 2px;
    }

    .demo-dashboard .sheet {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 10px;
        box-shadow: var(--shadow);
    }

    /* ==========================
   HEADER BAR
========================== */

    .demo-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 22px 28px;
        margin-bottom: 20px;
        border-top: 3px solid var(--accent);
    }

    .demo-header .eyebrow {
        font-size: 10.5px;
        text-transform: uppercase;
        letter-spacing: 1.6px;
        color: var(--gray-light);
        margin-bottom: 6px;
        font-weight: 600;
    }

    .demo-header h1 {
        font-size: 20px;
        font-weight: 600;
        margin: 0;
        color: var(--black);
        line-height: 1.3;
    }

    .demo-header .sub {
        font-size: 13px;
        color: var(--gray);
        margin-top: 2px;
    }

    /* ==========================
 STATUS
========================== */

    .status-pill {
        padding: 6px 14px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-pill i {
        font-size: 13px;
    }

    .status-pill.scheduled {
        background: var(--accent-soft);
        color: var(--accent);
        border: 1px solid var(--accent);
    }

    .status-pill.completed {
        background: var(--black);
        color: #fff;
        border: 1px solid var(--black);
    }

    /* ==========================
 DETAILS SHEET
========================== */

    .details-sheet {
        padding: 4px 28px;
        margin-bottom: 20px;
    }

    .sheet-title {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: var(--gray-light);
        font-weight: 600;
        padding: 16px 0 10px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 4px;
    }

    .detail-row {
        display: grid;
        grid-template-columns: 170px 1fr;
        gap: 12px;
        padding: 11px 0;
        border-bottom: 1px dotted var(--border);
        align-items: baseline;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-row .d-label {
        font-size: 12px;
        color: var(--gray);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-row .d-label i {
        font-size: 13px;
        color: var(--gray-light);
        width: 14px;
        text-align: center;
    }

    .detail-row .d-value {
        font-size: 13.5px;
        font-weight: 500;
        color: var(--black);
        word-break: break-word;
    }

    /* ==========================
 MESSAGE (inline row)
========================== */

    .message-row {
        padding: 14px 0 18px;
    }

    .message-row .d-label {
        font-size: 12px;
        color: var(--gray);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
    }

    .message-row .d-label i {
        font-size: 13px;
        color: var(--gray-light);
    }

    .message-body {
        background: var(--bg);
        border-left: 3px solid var(--accent);
        padding: 14px 16px;
        border-radius: 6px;
        line-height: 1.7;
        font-size: 13.5px;
        color: #3a3a40;
        font-style: italic;
    }

    /* ==========================
TIMELINE
========================== */

    .timeline-sheet {
        padding: 4px 28px 18px;
        margin-bottom: 20px;
    }

    .timeline {
        margin-top: 2px;
    }

    .timeline-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 0;
        position: relative;
    }

    .timeline-item:not(:last-child):after {
        content: "";
        position: absolute;
        left: 4px;
        top: 24px;
        width: 1px;
        height: 100%;
        background: var(--border);
    }

    .dot {
        width: 9px;
        height: 9px;
        background: #fff;
        border: 2px solid var(--gray-light);
        border-radius: 50%;
        margin-top: 4px;
        flex-shrink: 0;
    }

    .timeline-item:first-child .dot {
        background: var(--accent);
        border-color: var(--accent);
    }

    .timeline-item strong {
        display: block;
        font-size: 12.5px;
        font-weight: 600;
        margin-bottom: 2px;
        color: var(--black);
    }

    .timeline-item span {
        font-size: 12.5px;
        color: var(--gray);
    }

    /* ==========================
ACTION
========================== */

    .action-bar {
        display: flex;
        justify-content: flex-end;
        padding: 16px 28px;
    }

    .complete-btn {
        background: var(--black);
        color: #fff;
        border: 1px solid var(--black);
        border-radius: 8px;
        padding: 10px 20px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 9px;
        transition: .2s ease;
    }

    .complete-btn i {
        font-size: 14px;
    }

    .complete-btn:hover {
        background: var(--accent);
        border-color: var(--accent);
    }

    .complete-btn:disabled {
        opacity: .55;
        cursor: not-allowed;
    }

    /* ==========================
RESPONSIVE
========================== */

    @media(max-width:640px) {
        .demo-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .detail-row {
            grid-template-columns: 1fr;
            gap: 4px;
        }

        .action-bar {
            justify-content: stretch;
        }

        .complete-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="demo-dashboard mt-5">

    <!-- Header -->
    <div class="demo-header sheet">
        <div>
            <div class="eyebrow">Demo Schedule</div>
            <h1>{{ $demo->full_name ?? 'Unknown User' }}</h1>
            <div class="sub">{{ $demo->company_name ?? 'No Company Provided' }}</div>
        </div>

        <div id="statusBadgeWrapper">
            @if($demo->status == 1)
            <div class="status-pill completed">
                <i class="bi bi-check-circle-fill"></i>
                Completed
            </div>
            @else
            <div class="status-pill scheduled">
                <i class="bi bi-clock-history"></i>
                Scheduled
            </div>
            @endif
        </div>
    </div>

    <!-- Details -->
    <div class="details-sheet sheet">

        <div class="sheet-title"><span style=color:#7a0d7d>Contact &amp; Schedule</span></div>

        <div class="detail-row">
            <div class="d-label"><i class="bi bi-person"></i>Full Name</div>
            <div class="d-value">{{ $demo->full_name ?? 'N/A' }}</div>
        </div>

        <div class="detail-row">
            <div class="d-label"><i class="bi bi-envelope"></i>Email</div>
            <div class="d-value">{{ $demo->email ?? 'N/A' }}</div>
        </div>

        <div class="detail-row">
            <div class="d-label"><i class="bi bi-telephone"></i>Phone</div>
            <div class="d-value">{{ $demo->phone ?? 'N/A' }}</div>
        </div>

        <div class="detail-row">
            <div class="d-label"><i class="bi bi-building"></i>Company</div>
            <div class="d-value">{{ $demo->company_name ?? 'N/A' }}</div>
        </div>

        <div class="detail-row">
            <div class="d-label"><i class="bi bi-envelope-paper"></i>Company Email</div>
            <div class="d-value">{{ $demo->company_email ?? 'N/A' }}</div>
        </div>

        <div class="detail-row">
            <div class="d-label"><i class="bi bi-calendar-event"></i>Demo Date</div>
            <div class="d-value">{{ $demo->demo_date ? date('M d, Y', strtotime($demo->demo_date)) : 'N/A' }}</div>
        </div>

        <div class="detail-row">
            <div class="d-label"><i class="bi bi-clock"></i>Demo Time</div>
            <div class="d-value">{{ $demo->demo_time ?? 'N/A' }}</div>
        </div>

        @if($demo->message)
        <div class="message-row">
            <div class="d-label"><i class="bi bi-chat-left-quote"></i>Message</div>
            <div class="message-body">"{{ $demo->message }}"</div>
        </div>
        @endif

    </div>

    <!-- Timeline -->
    <div class="timeline-sheet sheet">

        <div class="sheet-title">Activity</div>

        <div class="timeline">
            <div class="timeline-item">
                <div class="dot"></div>
                <div>
                    <strong>Created</strong>
                    <span>{{ $demo->created_at ? $demo->created_at->format('M d, Y') : 'N/A' }}</span>
                </div>
            </div>

            <div class="timeline-item">
                <div class="dot"></div>
                <div>
                    <strong>Last Updated</strong>
                    <span>{{ $demo->updated_at ? $demo->updated_at->format('M d, Y') : 'N/A' }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Action -->
    <div id="markDoneWrapper"
        class="action-bar sheet"
        @if($demo->status==1)
        style="display:none"
        @endif>

        <button
            class="complete-btn"
            id="markDoneBtn"
            data-id="{{$demo->id}}">
            <i class="bi bi-check-circle-fill"></i>
            Mark Demo as Completed
        </button>
    </div>

</div>

@endsection

@section('script')
<script>
    "use strict";

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('#markDoneBtn');
        if (!btn) return;

        e.preventDefault();
        if (!confirm('Are you sure you want to mark this demo as done?')) return;

        const demoId = btn.dataset.id;
        btn.disabled = true;

        fetch("{{route('admin-demo-schedule-mark-done', ':id')}}".replace(':id', demoId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                body: 'status=1'
            })
            .then(res => res.json())
            .then(response => {
                if (response.status) {
                    document.getElementById('statusBadgeWrapper').innerHTML =
                        '<div class="status-pill completed"><i class="bi bi-check-circle-fill"></i> Completed</div>';
                    document.getElementById('markDoneWrapper').style.display = 'none';

                    setTimeout(function() {
                        window.location.href = "{{route('admin-demo-schedule')}}";
                    }, 1200);
                } else {
                    alert(response.message || 'Something went wrong!');
                    btn.disabled = false;
                }
            })
            .catch(() => {
                alert('Something went wrong! Please try again');
                btn.disabled = false;
            });
    });
</script>
@endsection