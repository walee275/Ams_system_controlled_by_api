@extends('layouts.main')

@section('title', 'Admin | Students Leave Requests')

@section('contents')
    <main>
        <div class="container-fluid px-4">
            <div class="card mt-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="">Students Leave Request</h3>
                        </div>
                        <div class="col-6 text-end">
                            {{-- <a href="{{ route('admin.student.create') }}" class="btn btn-outline-primary">Add Student</a> --}}
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    @include('partials.alerts')

                    @if (count($leave_requests) > 0)

                        <div class="table-responsive">
                            <table class="table table-bordered  table-hover" id="table-1">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Student Name</th>
                                        <th>Email</th>
                                        <th>Leave Reason</th>
                                        <th>Leave Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($leave_requests as $leave_request)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $leave_request['student']['user']['name'] }}</td>
                                            <td>{{ $leave_request['student']['user']['email'] }}</td>
                                            <td>{{ $leave_request['reason'] }}</td>
                                            <td>{{ date("d-M-Y", strtotime($leave_request['date'])) }}</td>
                                            <td>
                                                @if ($leave_request['status'] == 0)
                                                    <span class="badge bg-primary">Pending</span>
                                                @elseif($leave_request['status'] == 1)
                                                    <span class="badge bg-success">Approved</span>
                                                @else
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td><a href="requests/{{ $leave_request['id'] }}/approve" class="btn btn-success" >Approve
                                                </a>
                                                <a href="requests/{{ $leave_request['id'] }}/reject" class="btn btn-danger" id="reject-btn">Reject</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                    @else
                        <div class="alert alert-danger" role="alert">
                            No record found!
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </main>
    <script>

        const form = document.getElementById('form');

        form.addEventListener('submit', function(e){
            e.preventDefault();

            const statusElement = document.getElementById('status');
            let statusValue = status.value;

            if(statusValue == '' || status === undefined){
                statusElement.calssList.add('i-invalid');
            }else{
                const data = {
                    status:statusValue
                }
                fetch('{{ route('students.leave.requests') }}', {
                    method:'POST',
                    body: JSON.stringify(data),
                    headers:{
                        'Content-Type': 'application/json'
                    }
                }).then(function(response){
                    return response.json()
                }).then(function(result){

                })
            }
        })



    </script>
                    {{-- <form action="" method="POST" id="form">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-sm-6">
                                <select name="status" class="form-select">
                                    <option value="" selected>Search Specific Requests</option>
                                    <option value="0">Pending</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </div>
                            <input type="submit" class="col-sm-2 mb-3 btn btn-outline-primary">
                        </div>
                        <p id="error" class="text-danger"></p>
                    </form> --}}
@endsection
