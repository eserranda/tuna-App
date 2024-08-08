<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title">Tambah Data Users</h5>

                <button type="button" class="btn-close" onclick="closeModalAdd()">

                </button>
            </div>

            <form id="addForm">
                <div class="modal-body">
                    <div class="col-xxl-3 col-md-12 mb-3">
                        <div>
                            <label class="form-label" for="name">Role</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="role">
                            <div class="invalid-feedback"> </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-3 col-md-12">
                        <div>
                            <label class="form-label" for="description">Deskripsi</label>
                            <textarea class="form-control" placeholder="deskripsi" rows="3" name="description" id="description"></textarea>
                            <div class="invalid-feedback"> </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" onclick="closeModalAdd()">
                            Close
                        </button>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function closeModalAdd() {
        const invalidInputs = document.querySelectorAll('.is-invalid');
        invalidInputs.forEach(invalidInput => {
            invalidInput.value = '';
            invalidInput.classList.remove('is-invalid');
            const errorNextSibling = invalidInput.nextElementSibling;
            if (errorNextSibling && errorNextSibling.classList.contains(
                    'invalid-feedback')) {
                errorNextSibling.textContent = '';
            }
        });

        const form = document.getElementById('addForm');
        form.reset();
        $('#addModal').modal('hide');
    }
    document.getElementById('addForm').addEventListener('submit', async (event) => {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        try {
            const response = await fetch('/roles/store', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData,
            });

            const data = await response.json();
            console.log(data);
            if (!data.success) {
                Object.keys(data.messages).forEach(fieldName => {
                    const inputField = document.getElementById(fieldName);
                    if (inputField) {
                        inputField.classList.add('is-invalid');
                        if (inputField.nextElementSibling) {
                            inputField.nextElementSibling.textContent = data.messages[
                                fieldName][0];
                        }
                    }
                });

                // hapus error message jika form sudah di isi
                const validFields = document.querySelectorAll('.is-invalid');
                validFields.forEach(validField => {
                    const fieldName = validField.id;
                    if (!data.messages[fieldName]) {
                        validField.classList.remove('is-invalid');
                        if (validField.nextElementSibling) {
                            validField.nextElementSibling.textContent = '';
                        }
                    }
                });

            } else {
                const invalidInputs = document.querySelectorAll('.is-invalid');
                invalidInputs.forEach(invalidInput => {
                    invalidInput.value = '';
                    invalidInput.classList.remove('is-invalid');
                    const errorNextSibling = invalidInput.nextElementSibling;
                    if (errorNextSibling && errorNextSibling.classList.contains(
                            'invalid-feedback')) {
                        errorNextSibling.textContent = '';
                    }
                });

                // $('#datatable').DataTable().ajax.reload();
                $('#addModal').modal('hide');
                location.reload();
            }


        } catch (error) {
            console.error(error);
        }
    });
</script>
