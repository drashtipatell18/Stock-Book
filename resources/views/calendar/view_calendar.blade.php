@extends('layouts.main')
@section('content')
    <style>
        .fc-time {
            display: none !important;
        }
    </style>
    <div class="row">
        <div class="col">
            <div class="au-card">
                <div id="calendar"></div>
            </div>
        </div><!-- .col -->
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            var leaves = @json($leaves); // This now includes birthday and leave events

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listWeek'
                },
                defaultView: 'month',
                events: leaves,
                eventRender: function(event, element) {
                    // Optionally customize the display more, such as adding icons or different formats
                }
            });
        });
    </script>
@endpush
