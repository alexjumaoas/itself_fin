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

<div class="modal" id="cancelRequestModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Cancel Request</h5>
            </div>
            <form id="cancelRequestForm" action="{{ route('requests.cancel', ':id') }}" method="POST">
                @csrf
                <input type="hidden" id="cancelJobId" name="id">
                <input type="hidden" id="req_code" name="req_code">
                <div class="modal-body">
                    <label for="cancelRemarks" class="form-label">Remarks:</label>
                    <textarea class="form-control" id="cancelRemarks" name="cancelRemarks" rows="3" placeholder="Enter cancellation reason..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="closeCurrentReq">Close</button>
                    <button type="submit" class="btn btn-secondary" id="confirmCancel">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById("closeCurrentReq").addEventListener("click", function () {
        let modalDialog = document.querySelector("#cancelRequestModal .modal-dialog");

        modalDialog.style.animation = "elasticPopOut 0.3s ease-in forwards";

        setTimeout(() => {
            $('#cancelRequestModal').modal('hide');
            modalDialog.style.animation = "";
        }, 300);
    });
</script>
