@extends('layouts.master')
@section('page-header')
    Sent Card Detail
@endsection
@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"></h3>
            <div class="box-tools pull-right">
                <a href="/sentcards" class="btn bg-navy btn-xs">Back</a>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <table id="sentcards" class="table responsive nowrap" width="100%">
                <thead>
                    <tr>
                        <th>Card Image</th>
                        <th>Delivery</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src="{{ asset('storage/img/ecards/' . $sentCardDetail->ecard->filename . '.jpg') }}"
                                alt="Placeholder Image" class="thumbnail" width="100" id="image_small_display"></td>
                        <td>{!! $delivery !!}</td>
                        <td>{!! $message !!}</td>
                    </tr>
                </tbody>
            </table>

            <h3>Recipients</h3>

            <table id="dynamic-table" class="table responsive nowrap sentcards" width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Count View</th>
                        <th>Delivery Status</th>
                        <th>Pickup Status</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($recipients as $recipient)
                        <tr>
                            <td>{{ $recipient->name }}</td>
                            <td>{{ $recipient->email }}</td>
                            <td>{{ $recipient->count_view }}</td>
                            <td>{{ $sentCardDetail->deliveryStatus() }}</td>
                            <td>
                                @if ($recipient->pickup_date == null)
                                    Not Viewed
                                @else
                                    Viewed
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div><!-- /.box-body -->
    </div>
@endsection

@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        $(".sentcards").DataTable(
            {
                "pageLength": 25,
                "lengthMenu": [25, 50, 100, 200],
            }
        );
    });
</script>
@endpush
