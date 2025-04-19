<?php
require 'templates/header.php';
require 'templates/sidebar.php';
include 'templates/nav.php';
?>

<!-- Main Content -->
<div class="table-content p-4">    
    <div class="container-fluid mt-4">

        <!-- Upload Form -->
        <form id="uploadForm" action="#" method="POST" enctype="multipart/form-data" onsubmit="return false;">
            <div class="mb-3">
                <label for="document" class="form-label">Upload Document (PDF, DOC, DOCX)</label>
                 <input type="file" id="document" name="document" class="dropify"
                 data-allowed-file-extensions="pdf doc docx"
                 data-max-file-size="10M" />
             </div>
            <button type="submit" class="btn btn-success">Upload</button>
</form>

<hr>
<div id="uploadResponse" class="mt-3"></div>
<h5>Uploaded Documents </h1>
<ul class="list-group" id="fileList">
    <!-- Files will be loaded here dynamically -->
</ul>
<button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>


       

    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete <strong id="fileName"></strong>?
        <input type="hidden" name="delete_file" id="deleteFileInput">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger">Delete</button>
      </div>
    </form>
  </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/dropify/0.2.2/js/dropify.min.js"></script>

<!-- Script to initialize Dropify and handle modal -->
<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
});

document.addEventListener('DOMContentLoaded', () => {
    const uploadForm = document.getElementById('uploadForm');
    const fileList = document.getElementById('fileList');
    const deleteFileInput = document.getElementById('deleteFileInput');
    const fileNameDisplay = document.getElementById('fileName');

    $('.dropify').dropify();

    function loadFiles() {
        fetch('http://backend.test/api/list-documents', {
            headers: {
                "Authorization": "Bearer " + localStorage.getItem("token")
            }
        })
        .then(res => res.json())
        .then(data => {
            fileList.innerHTML = '';
            if (data.length === 0) {
                fileList.innerHTML = '<li class="list-group-item">No documents uploaded yet.</li>';
            } else {
                data.forEach(file => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-center';
                    li.innerHTML = `
                        <a href="http://backend.test/storage/${file.path}" target="_blank">${file.original_name}</a>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="${file.id}" data-name="${file.original_name}">Delete</button>
                    `;
                    fileList.appendChild(li);
                });
            }
        });
    }

    uploadForm.addEventListener('submit', e => {
        e.preventDefault();
        const formData = new FormData(uploadForm);

        fetch('http://backend.test/api/upload-document', {
            method: 'POST',
            headers: {
                "Authorization": "Bearer " + localStorage.getItem("token")
                // ❌ Don't set 'Content-Type' manually with FormData
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            Toast.fire({
                icon: 'success',
                title: data.message
            });
            uploadForm.reset();
            $('.dropify-clear').click(); // Clear dropify
            loadFiles();
        })
        .catch(() => {
            Toast.fire({
                icon: 'error',
                title: 'Failed to upload.'
            });
        });
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.matches('[data-bs-target="#deleteModal"]')) {
            const id = e.target.getAttribute('data-id');
            const name = e.target.getAttribute('data-name');
            fileNameDisplay.textContent = name;
            deleteFileInput.value = id;
        }
    });

    document.querySelector('#deleteModal form').addEventListener('submit', function(e) {
        e.preventDefault();

        const fileId = deleteFileInput.value;

        fetch('http://backend.test/api/delete-document', {
            method: 'POST',
            headers: {
                "Authorization": "Bearer " + localStorage.getItem("token"),
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ id: fileId })
        })
        .then(res => res.json())
        .then(data => {
            bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();

            Toast.fire({
                icon: 'success',
                title: 'Document deleted successfully.'
            });

            loadFiles();
        })
        .catch(() => {
            Toast.fire({
                icon: 'error',
                title: 'Failed to delete document.'
            });
        });
    });

    loadFiles();
});
</script>
