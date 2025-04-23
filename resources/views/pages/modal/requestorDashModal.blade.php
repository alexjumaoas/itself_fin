<style>
   /* Elastic Pop In Animation */
    @keyframes elasticPopIn {
        0% {
            transform: scale(0.5);
            opacity: 0;
        }
        60% {
            transform: scale(1.2);
            opacity: 1;
        }
        100% {
            transform: scale(1);
        }
    }

    /* Elastic Pop Out Animation */
    @keyframes elasticPopOut {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        100% {
            transform: scale(0.5);
            opacity: 0;
        }
    }

    /* Apply the animations */
    .modal.show .modal-dialog {
        animation: elasticPopIn 0.5s ease-out;
    }

    .modal.fade .modal-dialog {
        animation: elasticPopOut 0.3s ease-in;
    }
</style>

<!-- Modal -->
<div class="modal modal-xl" id="dashModal" role="dialog" aria-labelledby="dashModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="dashModalLabel">Requests History</h5>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <div class="table-responsive">
                    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="dashTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Descriptions</th>
                                            <th>Technician / Remarks</th>
                                            <th>Done / Cancelled</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activity_finish as $finish)

                                        @php

                                        $user = App\Models\Dtruser::where(function ($query) use ($finish) {
                                            if (!empty($finish->tech_from)) {
                                                $query->where('username', $finish->tech_from);
                                            }

                                            if (!empty($finish->tech_to)) {
                                                $query->orWhere('username', $finish->tech_to);
                                            }
                                        })->first();

                                        @endphp
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($finish->job_req->request_date)->format('F d, Y h:i A') }}</td>
                                                <td>{{$finish->job_req->description}}</td>
                                                <td>{{$user ? $user->fname. ' ' . $user->mname. ' ' . $user->lname : 'N/A'}}</td>
                                                <td>{{ \Carbon\Carbon::parse($finish->created_at)->format('F d, Y h:i A') }}</td>
                                                <td>Completed</td>
                                            </tr>
                                        @endforeach
                                        @foreach($activity_cancelled as $cancelled)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($cancelled->job_req->request_date)->format('F d, Y h:i A') }}</td>
                                                <td>{{$cancelled->job_req->description}}</td>
                                                <td>{{ $cancelled->remarks}}</td>
                                                <td>{{ \Carbon\Carbon::parse($cancelled->created_at)->format('F d, Y h:i A')}}</td>
                                                <td style="color: red;">Cancelled</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- <div class="row">
                            <div class="col-sm-12">
                                <table id="dashTable" class="table table-hover">
                                    <tbody>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" id="closeModalButtonFooter">Close</button>
        </div>
        </div>
    </div>
</div>

<script>

    document.getElementById("closeModalButtonFooter").addEventListener("click", function () {
        let modalDialog = document.querySelector("#dashModal .modal-dialog");

        modalDialog.style.animation = "elasticPopOut 0.3s ease-in forwards";

        setTimeout(() => {
            $('#dashModal').modal('hide');
            modalDialog.style.animation = "";
        }, 300);
    });

//   $(document).ready(function() {
//       let table = $('#dashTable').DataTable({
//           "paging": true,         // Enable pagination
//           "lengthMenu": [5, 10, 25, 50], // Rows per page
//           "searching": true,      // Enable search
//           "ordering": true,       // Enable sorting
//           "info": true,           // Show info (e.g., "Showing 1 to 10 of 50 entries")
//           "autoWidth": false,     // Prevent table width issues
//           "responsive": true      // Enable responsive design
//       });
//   });

</script>
