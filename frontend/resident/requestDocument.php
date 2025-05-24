<?php
require '../templates/header.php';
require '../templates/sidebar.php';
include '../templates/nav.php';
?>

<div class="table-content p-4">

    <h4 class="mb-4">Request Barangay Document</h4>
    <form id="requestForm" class="border p-4 bg-light rounded shadow-sm">
        <div class="mb-3">
            <label for="document_type" class="form-label">Document Type</label>
            <select class="form-select" name="document_type" required>
                <option value="">-- Select Document --</option>
                <option value="Barangay Clearance">Barangay Clearance</option>
                <option value="Certificate of Residency">Certificate of Residency</option>
                <option value="Indigency Certificate">Indigency Certificate</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="purpose" class="form-label">Purpose</label>
            <textarea class="form-control" name="purpose" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-success w-100">Submit Request</button>
    </form>
    <hr class="my-4">
<h5>Your Requested Documents</h5>
<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Document</th>
            <th>Purpose</th>
            <th>Status</th>
            <th>Notes</th>
            <th>Remarks</th>
            <th>Date Requested</th>
            <th>Date Claimed</th>
        </tr>
    </thead>
    <tbody id="residentRequestsTable">
        <tr><td colspan="4" class="text-center">Loading...</td></tr>
    </tbody>
</table>

</div>

<script>
document.getElementById('requestForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = new FormData(this);

    fetch("https://bmsbackend.christjoy.site/api/certificate-request", {
        method: "POST",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("token"),
            "Accept": "application/json",
            
        },
        body: form 
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            Swal.fire('Success!', 'Request submitted to the Secretary.', 'success');
            this.reset();
        } else {
            Swal.fire('Error!', 'Something went wrong.', 'error');
        }
    })
    .catch(err => {
        console.error(err);
        Swal.fire('Oops!', 'Request failed.', 'error');
    });
});
function loadResidentRequests() {
    fetch("https://bmsbackend.christjoy.site/api/my-certificate-requests", {
        method: "GET",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("token"),
            "Accept": "application/json"
        }
    })
    .then(res => res.json())
    .then(data => {
        const table = document.getElementById('residentRequestsTable');
        table.innerHTML = '';

        if (data.length === 0) {
            table.innerHTML = `<tr><td colspan="4" class="text-center">No requests yet.</td></tr>`;
            return;
        }
        data.forEach(row => {
            // console.log(`ID: ${row.id} | is_claimed: ${row.is_claimed}`);
    let statusBadge = '';
    let notes = '';
    let remarks = '';

    if (row.status === 'Pending') {
        statusBadge = `<span class="badge bg-warning text-dark">Pending</span>`;
    } else if (row.status === 'Rejected') {
        statusBadge = `<span class="badge bg-danger">Rejected</span>`;
        notes = row.reason ? `<small class="text-danger">Rason: ${row.reason}</small>` : '';
    } else if (row.status === 'Approved') {
        statusBadge = `<span class="badge bg-success">Approved</span>`;
        
        if (row.is_claimed == 1 || row.is_claimed == "1") {
            notes = `<span class="text-muted">Document claimed.</span>`;
            remarks = ''; 
        } else {
            notes = `<span class="text-success">Please claim your document..</span>`;
            remarks = `<button onclick="markAsClaimed(${row.id})" class="btn btn-outline-primary btn-sm">Mark as Claimed</button>`;
        }


    }
 
    table.innerHTML += `
        <tr>
            <td>${row.document_type}</td>
            <td>${row.purpose}</td>
            <td>${statusBadge}</td>
            <td>${notes}</td>
            <td>${remarks}</td>
            <td>${new Date(row.created_at).toLocaleDateString()}</td>
             <td>${row.claimed_at ? new Date(row.claimed_at).toLocaleDateString() : ''}</td>
        </tr>
    `;
});


    })
    .catch(err => {
        console.error(err);
        document.getElementById('residentRequestsTable').innerHTML = `<tr><td colspan="4" class="text-center text-danger">Failed to load requests.</td></tr>`;
    });
}

function markAsClaimed(id) {
    fetch(`https://bmsbackend.christjoy.site/api/certificate-request/${id}/claim`, {
        method: "PUT",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("token"),
            "Accept": "application/json",
        }
    })
    .then(res => res.json())
    .then(res => {
    if (res.success) {
        Swal.fire('Marked as Claimed!', 'You have successfully claimed your document.', 'success');
        setTimeout(() => {
            loadResidentRequests(); // reload after delay
        }, 500); // 0.5 second delay
    } else {
        Swal.fire('Error', res.message || 'Update failed.', 'error');
    }
});


}


loadResidentRequests();
</script>

 

<?php require '../templates/footer.php'; ?>
