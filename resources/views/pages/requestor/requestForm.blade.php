    @extends('layouts.appClient')
    @section('content')

    <div class="row" style="justify-content: center;">
        <div class="col-md-6">
            <h3 class="fw-bold mb-3">REQUEST FORM</h3>
            <div class="card">
                <div class="card-header" style="background-color: #5867dd;">
                    <div class="card-title" style="color: white;">IT Services</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('saveRequest') }}" method="POST">
                        @csrf
                        <div class="row">
                            <label class="mt-3 mb-3" style="font-weight: 600;">Requesting To:</label>
                            <div class="col-md-6" style="margin-left: 10px;">
                                <div class="form-check" style="padding: 1px;">
                                    <input class="form-check-input" type="checkbox" name="check_comp" value="Check Computer Desktop / Laptop" id="checkValue1">
                                    <label class="form-check-label" for="checkValue1">
                                        Check Computer Desktop / Laptop
                                    </label>
                                </div>
                                <div class="form-check" style="padding: 1px;">
                                    <input class="form-check-input" type="checkbox" name="check_intern" value="Check Internet Connection" id="checkValue2">
                                    <label class="form-check-label" for="checkValue2">
                                        Check Internet Connection
                                    </label>
                                </div>
                                <div class="form-check" style="padding: 1px;">
                                    <input class="form-check-input" type="checkbox" name="check_Mon" value="Check Monitor" id="checkValue3">
                                    <label class="form-check-label" for="checkValue3">
                                        Check Monitor
                                    </label>
                                </div>
                                <div class="form-check" style="padding: 1px;">
                                    <input class="form-check-input" type="checkbox" name="check_mouse" value="Check Mouse / Keyboard" id="checkValue4">
                                    <label class="form-check-label" for="checkValue4">
                                        Check Mouse / Keyboard
                                    </label>
                                </div>
                                <div class="form-check" style="padding: 1px;">
                                    <input class="form-check-input" type="checkbox" name="check_others" value="Others" id="checkValue9">
                                    <label class="form-check-label" for="checkValue9">
                                        Others: Please Specify
                                    </label>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" id="otherRequest" name="others_input" rows="5" style="resize: both; overflow-y: auto; display: none;"></textarea>
                                </div>

                            </div>

                            <div class="col-md-5" style="margin-left: 5px;">
                                <div class="form-check" style="padding: 1px;">
                                    <input class="form-check-input" type="checkbox" name="install_print" value="Install Printer" id="checkValue5">
                                    <label class="form-check-label" for="checkValue5">
                                        Install Printer
                                    </label>
                                </div>
                                <div class="form-check" style="padding: 1px;">
                                    <input class="form-check-input" type="checkbox" name="install_soft" value="Install Software Application" id="checkValue6">
                                    <label class="form-check-label" for="checkValue6">
                                        Install Software Application
                                    </label>
                                </div>
                                <div class="form-check" style="padding: 1px;">
                                    <input class="form-check-input" type="checkbox" name="bio_reg" value="Biometrics Registration" id="checkValue7">
                                    <label class="form-check-label" for="checkValue7">
                                        Biometrics Registration
                                    </label>
                                </div>
                                <div class="form-check" style="padding: 1px;">
                                    <input class="form-check-input" type="checkbox" name="system_tech" value="System Technical Asistance" id="checkValue8">
                                    <label class="form-check-label" for="checkValue8">
                                        System Technical Asistance
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3" style="margin-left: 10px;">Apply Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                swal({
                    title: "Success!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    button: "OK", // OK button
                }).then(function() {
                    window.location = "{{ route('currentRequest') }}"; // Redirect to currentRequest after OK
                });
            });
        </script>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const checkbox = document.getElementById("checkValue9");
            const textarea = document.getElementById("otherRequest");

            // Function to toggle textarea visibility
            function toggleTextarea() {
                if (checkbox.checked) {
                    textarea.style.display = "block"; // Show textarea
                    textarea.focus(); // Focus on it when shown
                } else {
                    textarea.style.display = "none"; // Hide textarea
                    textarea.value = ""; // Clear input when unchecked (optional)
                }
            }
            // Attach event listener to checkbox
            checkbox.addEventListener("change", toggleTextarea);
        });
    </script>


    @endsection
