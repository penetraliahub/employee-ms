@extends('layouts.gen-layout')

@section('content')
 <div class="right_col" role="main">
      <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Leave <small>view</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                  @if($leave_types->count() > 0)
                    @if(auth()->user()->can('add_leave'))
                        <a href="{{ route('leave-type.create')}}" class="btn btn-primary btn-sm my-2">
                        <span class="fa fa-plus-circle mr-2"></span>
                        Profile new leave
                        </a>
                     @endif
                 @endif

                 @if($leave_types->count() >  0)
                  <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                      
                      <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Days</th>
                            <th>Eligibility</th>
                            <th>Status</th>
                            <th>Leave Compulsion</th>
                            @if(auth()->user()->hasAnyPermission(['read_leave','edit_leave','delete_leave']))
                            <th class="text-center">Action</th>
                            @endif
                        </tr>
                      </thead>

                      <tbody>
                         @foreach($leave_types as $leave_type)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $leave_type->leave_name }}</td>
                                <td>
                                    @if($leave_type->number_of_days > 0)
                                        {{ $leave_type->number_of_days }} day{{ $leave_type->number_of_days > 0 ? 's' : '' }}
                                    @else
                                        Leave days not pre-defined
                                    @endif
                                </td>
                                <td>
                                    @if($leave_type->eligibility == 'All')
                                        All Staffs
                                    @elseif($leave_type->eligibility == 'Male')
                                        Male Staffs Only
                                    @elseif($leave_type->eligibility == 'Female')
                                        Female Staffs Only
                                    @endif
                                </td>
                                <td>
                                    <span class='label label-{{ $leave_type->is_active === 'Active' ? 'success' : 'warning' }} label-sm'>
                                        {{$leave_type->is_active }}
                                    </span>
                                </td>
                                <td>
                                    @if($leave_type->compulsory == 'Yes')
                                        Compulsory
                                    @elseif($leave_type->compulsory == 'No')
                                        Not Compulsory
                                    @endif
                                </td>
                                @if(auth()->user()->hasAnyPermission(['read_leave','edit_leave','delete_leave']))
                                <td class="text-center">
                                <div class ="btn-group">
                                    @if(auth()->user()->can('read_leave'))
                                    <a class="edit-btn btn btn-info btn-sm glyphicon glyphicon-eye-open" href="{{ route('leave-type.show', $leave_type->id) }}" role="button" >
                                    </a>
                                    @endif

                                    @if(auth()->user()->can('edit_leave'))
                                    <a class="edit-btn btn btn-info btn-sm glyphicon glyphicon-edit" href="{{ route('leave-type.edit', $leave_type->id) }}" role="button">
                                    </a>
                                    @endif

                                    @if(auth()->user()->can('delete_leave'))
                                    <a class="delete-btn btn btn-danger btn-sm glyphicon glyphicon-trash" data-toggle="modal" data-target="#deleteModal" href="#" role="button" data-policy="{{ $leave_type->id }}"></a>
                                    @endif
                                    </div>
                                </td> 
                                @endif
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                    </div>
                  @else
                        <div class="empty-state text-center my-3">
                            @include('icons.empty')
                            <p class="text-muted my-3">
                                No profiled leave yet!
                            </p>
                            @if(auth()->user()->can('add_leave'))
                            <a href="{{ route("leave-type.create") }}">
                                Profile new leave
                            </a> 
                            @endif
                      </div>
                @endif
              </div>
              
              </div>
              
      </div>
</div>
  <!--Delete modal start -->
  <div class="modal fade " id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center" id="exampleModalLabel">Delete Comfirmation</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="delete-form" method="post">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="workDay" name="_method" value="DELETE" >
                    </div>

                    <h4 class="text-center">Are you sure you want to delete this data? </h4>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning px-5" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-success px-5">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Delete modal end -->
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();

            $('#deleteModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var policy = button.data('policy') // Extract info from data-* attributes
                console.log(policy);
                var modal = $(this)
                $('#delete-form').attr('action', "leave-type/"+policy);
            })
        });
    </script>
@endsection