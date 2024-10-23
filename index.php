<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./libs/bootstrap.min.css">
  <link href="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.css" rel="stylesheet">
  <title>Document</title>
</head>

<body>
  <div class="container">
    <h1 id="table-loading">Loading...</h1>
    <h2 id="no-data" class="d-none">No data</h2>
    <div class="table-responsive d-none" id="users-table-wrapper">
      <table id="users-table" class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created at</th>
            <th>Post</th>
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

  <script src="./libs/jquery-3.7.1.js"></script>
  <script src="./libs/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.js"></script>
  <script>
    $(document).ready(function() {
      new DataTable('#users-table', {
        ajax: 'action.php?action=fetchUsers',
        processing: true,
        serverSide: true,
        columnDefs: [{
            orderable: false,
            targets: -1
          } // Disable sorting for the last column
        ],
        drawCallback: function(settings) {
          var api = this.api();
          var rows = api.rows({
            visible: true
          }).nodes();

          if (rows.length === 0) {
            $('#no-data').show()
          } else {
            $('#users-table-wrapper').removeClass('d-none')
          }
          $('#table-loading').addClass('d-none')
        }
      });
    });
  </script>
</body>

</html>