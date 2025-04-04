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
                                        <tr>
                                            <td>April 03, 2025 11:58 AM</td>
                                            <td>Install Software Application</td>
                                            <td>Juan Dela Cruz</td>
                                            <td>April 03, 2025 12:35 PM</td>
                                            <td>Completed</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <table id="dashTable" class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td>April 03, 2025 11:58 AM</td>
                                            <td>Check Monitor</td>
                                            <td>Na ok rag iyaha</td>
                                            <td>April 03, 2025 12:35 PM</td>
                                            <td style="color: red;">Cancelled</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
