<!DOCTYPE html>
<html>
<head>
    <title>Laravel Datatables Filter with Dropdown</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="text-center">
            <h1>Laravel Datatables Filter with Dropdown</h1>
    </div>
    <!-- <div class="card">
        <div class="card-body"> -->
            <div class="form-group">
                 <label><strong>Status :</strong></label> 
                <select id='status' class="form-control" style="width: 150px">
                    <option value="">Select Status</option>
                    <option value="1">Active</option>
                    <option value="0">Deactive</option>
                </select>
            </div>
        <!-- </div>
    </div> -->
    <br>
  <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Product Name</th>
                <th>Product Sku</th>
                <th>Product Price</th>
                <th>Product Details</th>
                <th>Product status</th>
                <th>Product category</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>   
<script type="text/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('filter.index') }}",
          data: function (d) {
                d.status = $('#status').val(),
                d.search = $('input[type="search"]').val()
            }
        },
        columns: [
{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, visible: true},
{data: 'name', name: 'name', orderable: false, searchable: true, visible: true},
{data: 'sku', name: 'sku', orderable: false, searchable: true, visible: true},
{data: 'price', name: 'price', orderable: false, searchable: true, visible: true},
{data: 'detail', name: 'detail', orderable: false, searchable: true, visible: true},
{data: 'status', name: 'status', orderable: false, searchable: false, visible: true},
{data: 'category',name: 'category',orderable: false, searchable: true, visible: true},
]
    });
    $('#status').change(function(){
        table.draw();
    });
  });
</script>

</body>  
</html>
