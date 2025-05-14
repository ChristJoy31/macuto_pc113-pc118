<?php
require __DIR__ . '/../templates/header.php';
require __DIR__ . '/../templates/sidebar.php';
include __DIR__ . '/../templates/nav.php';
?>


<h1>dashboard secretary ni lalay</h1>

<!-- <script>
fetch('http://backend.test/api/certificate-request')
    .then(res => res.json())
    .then(data => {
        const tbody = document.getElementById('requestsBody');
        data.forEach(row => {
            tbody.innerHTML += `
                <tr>
                    <td>${row.resident_id}</td>
                    <td>${row.document_type}</td>
                    <td>${row.purpose}</td>
                    <td><span class="badge bg-${row.status === 'Pending' ? 'warning' : row.status === 'Approved' ? 'success' : 'danger'}">${row.status}</span></td>
                    <td>
                        ${row.status === 'Pending' ? `
                        <button onclick="updateStatus(${row.id}, 'Approved')" class="btn btn-success btn-sm">Approve</button>
                        <button onclick="updateStatus(${row.id}, 'Rejected')" class="btn btn-danger btn-sm">Reject</button>
                        ` : ''}
                    </td>
                </tr>
            `;
        });
    });

function updateStatus(id, status) {
    fetch(`http://localhost:8000/api/document-request/${id}/status`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ status })
    }).then(res => res.json())
      .then(() => location.reload());
}
</script> -->


<?php require '../templates/footer.php'; ?>