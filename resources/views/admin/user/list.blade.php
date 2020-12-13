<x-admin-layout title="User lists">

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
                        <a href="{{ route('user.create') }}" class="btn btn-primary waves-effect width-md waves-light">
                            Add user
                        </a>
                    </div>
                    <table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Permissions</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if ($details->isNotEmpty())
                                @foreach ($details as $key => $data)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->email }}</td>
                                        <td>{{ $data->access_level }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $data->is_published == 1 ? 'success' : 'danger' }}">
                                                {{ $data->is_published == 1 ? 'Published' : 'Unpublished' }}
                                            </span>
                                        </td>
                                        <td class="d-flex">
                                            <a href="{{ route('user.edit', $data->id) }}"
                                                class="btn btn-icon waves-effect waves-light btn-purple"><i
                                                    class="fa fa-edit"></i></a>

                                            <form class="ml-2" action="{{ route('user.destroy', $data->id) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-icon waves-effect waves-light btn-danger"
                                                    type="submit" name="button"
                                                    onclick="return confirm('Are you sure you want to delete this user?')"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
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
