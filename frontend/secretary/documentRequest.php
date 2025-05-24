<?php
require __DIR__ . '/../templates/header.php';
require __DIR__ . '/../templates/sidebar.php';
include __DIR__ . '/../templates/nav.php';
?>


<!-- secretaryView.php -->
<table class="table table-hover">
    <thead>
        <tr>
            <th>Resident</th>
            <th>Document</th>
            <th>Purpose</th>
            <th>Status</th>
            <th>Remarks</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="requestsBody"></tbody>
</table>
<!-- Reject Reason Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="rejectForm">
        <div class="modal-header">
          <h5 class="modal-title">Reject Request</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="rejectRequestId">
          <div class="mb-3">
            <label for="rejectReason" class="form-label">Reason for rejection</label>
            <textarea class="form-control" id="rejectReason" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Reject</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
fetch("https://bmsbackend.christjoy.site/api/certificate-request", {
    method: "GET",
    headers: {
        "Authorization": "Bearer " + localStorage.getItem("token"),
        "Accept": "application/json",
    },
})
.then(res => res.json())
.then(data => {
    console.log(data); 

    const tbody = document.getElementById('requestsBody');
    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center">No requests found.</td></tr>';
        return;
    }

    data.forEach(row => {
    let statusBadge = '';
    let remarks = '';

    if (row.status === 'Approved') {
    statusBadge = `<span class="badge bg-success">Approved</span>`;
    
    // Remarks based on claim status
    remarks = row.is_claimed
        ? `<span class="text-success">✅ Claimed</span>`
        : `<span class="text-warning">❌ Not claimed yet</span>`;

    } else if (row.status === 'Rejected') {
        statusBadge = `<span class="badge bg-danger">Rejected</span>`;
        remarks = `<div class="text-muted small mt-1"><strong>Reason:</strong> ${row.reason ?? 'No reason provided'}</div>`;
    } else {
        statusBadge = `<span class="badge bg-warning text-dark">Pending</span>`;
    }
   
    tbody.innerHTML += `
    <tr>
        <td>${row.resident_id}</td>
        <td>${row.document_type}</td>
        <td>${row.purpose}</td>
        <td>${statusBadge}</td> <!-- badge only -->
        <td>${remarks}</td> <!-- messages, buttons, etc. -->
        <td>
            ${row.status === 'Pending' ? `
            <button onclick="updateStatus(${row.id}, 'Approved')" class="btn btn-success btn-sm">Approve</button>
            <button onclick="showRejectModal(${row.id})" class="btn btn-danger btn-sm">Reject</button>
            ` : ''}
        </td>
    </tr>
`;

 });
});


function updateStatus(id, status, reason = null) {
    fetch(`https://bmsbackend.christjoy.site/api/certificate-request/${id}/status`, {
        method: "PUT",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("token"),
            "Accept": "application/json",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ status, reason })
    })
    .then(res => res.json())
    .then(() => {
        location.reload();
    })
    .catch(error => {
        console.error('Failed to update status:', error);
    });
}


// Show reject modal
function showRejectModal(requestId) {
    document.getElementById('rejectRequestId').value = requestId;
    document.getElementById('rejectReason').value = '';
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}

// Submit reject forma
document.getElementById('rejectForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('rejectRequestId').value;
    const reason = document.getElementById('rejectReason').value;

    fetch(`https://bmsbackend.christjoy.site/api/certificate-request/${id}/status`, {
        method: "PUT",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("token"),
            "Accept": "application/json",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ status: 'Rejected', reason })
    })
    .then(res => res.json())
    .then(() => {
        bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();
        location.reload();
    });
});

// function markAsClaimed(id) {
//     fetch(`http://backend.test/api/certificate-request/${id}/claim`, {
//         method: "PUT",
//         headers: {
//             "Authorization": "Bearer " + localStorage.getItem("token"),
//             "Accept": "application/json",
//         }
//     })
//     .then(res => res.json())
//     .then(() => location.reload())
//     .catch(err => console.error('Error marking as claimed:', err));
// }



</script>
<?php require '../templates/footer.php'  ?>