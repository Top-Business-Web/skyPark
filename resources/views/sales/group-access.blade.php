@extends('sales.layouts.master')
@section('page_title')
    {{$setting->title}} | Group Access
@endsection
@section('content')
    <div class="card p-3 py-4 w-100 w-sm-80 m-auto ">

    <h2 class="MainTiltle mb-5 ms-4"> Group Access </h2>
        <label class="form-label fs-4"> <i class="fas fa-ticket-alt me-2"></i>Ticket OR phone</label>
        <div class="d-flex">
            <input type="text" class="form-control" id="searchValue" placeholder="Type here...">
            <button type="button" id="searchButton" class="input-group-text ms-2 bg-gradient-primary px-4 text-body"><i
                    class="fas fa-search text-white"></i></button>
        </div>
    </div>

    <form class="card p-2 py-4 mt-3 ">
        <!-- table -->
        <table class=" customDataTable table table-bordered nowrap">
            <thead>
            <tr>
                <th>Sale Number</th>
                <th>Type</th>
                <th>Bracelet Number </th>
                <th>Name</th>
                <th>Birthday</th>
                <th>Gender</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

{{--        <div class=" p-4">--}}
{{--            <label class="form-label fs-5"><i class="fas fa-feather-alt me-1"></i> Note</label>--}}
{{--            <textarea name="" id="" class="form-control" rows="6" placeholder="Add Note..."></textarea>--}}
{{--        </div>--}}

{{--        <div class="text-center w-80 w-sm-20 m-auto">--}}
{{--            <button type="button" data-bs-toggle="modal" data-bs-target="#modal-print"--}}
{{--                    class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Print</button>--}}
{{--        </div>--}}


{{--        <div class="modal fade" id="modal-print" tabindex="-1" role="dialog" aria-labelledby="modal-print"--}}
{{--             aria-hidden="true">--}}
{{--            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">--}}
{{--                <div class="modal-content">--}}
{{--                    <div class="modal-header">--}}
{{--                        <h6 class="modal-title" id="modal-title-print">Print Ticket</h6>--}}
{{--                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">--}}
{{--                            <i class="fal fa-times text-dark fs-4"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                    <div class="modal-body">--}}
{{--                        <div class="py-3 text-center">--}}
{{--                            <i class="fad fa-print fa-4x"></i>--}}
{{--                            <h5 class="text-gradient text-dark mt-4">Is receipt printed correctly ?</h5>--}}
{{--                            <!-- <p>Is receipt printed correctly ?</p> -->--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="modal-footer">--}}
{{--                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Yes</button>--}}
{{--                        <button type="button" class="btn btn-link text-dark ml-auto">No</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}



    </form>
@endsection
@section('js')
    <script>

        $('#main-group').addClass('active')
        $('.groupAccess').addClass('active')
        $('#groupSale').addClass('show')

        ////////////////////////////////////////////
        // choice Js
        ////////////////////////////////////////////
        $(".controlIcons .icon").click(function () {
            $(this).addClass('checked')
        });


    </script>

    {{--================= custom js ==================--}}
    @include('sales.layouts.customJs.groupAccess')
@endsection
