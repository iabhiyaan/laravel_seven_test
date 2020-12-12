<x-admin-layout title="category lists">

    <x-slot name="styles">
        <link href="/admin/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    </x-slot>

    <div class="container-fluid">
        @if (session('message'))
            <x-alert type="success" message="{{ session('message') }}"></x-alert>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                    <div class="d-flex justify-content-end my-2">
                        <a href="{{ route('category.create') }}"
                            class="btn btn-primary waves-effect width-md waves-light">
                            Add category
                        </a>
                    </div>
                    <table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Title</th>
                                <th>Slug</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if ($details->isNotEmpty())
                                @foreach ($details as $key => $data)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $data->title }}</td>
                                        <td>{{ $data->slug }}</td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8">
                                        You do not have any data yet.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end row -->
    </div>

    <x-slot name="scripts">
        <script src="/admin/libs/datatables/jquery.dataTables.min.js"></script>
        <script src="/admin/libs/datatables/dataTables.bootstrap4.js"></script>
        <!-- third party js ends -->

        <!-- Datatables init -->
        <script>
            $("#responsive-datatable").DataTable();

        </script>
    </x-slot>

</x-admin-layout>
