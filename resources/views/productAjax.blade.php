<!DOCTYPE html>
<html>
<head>
<title>Crud</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- css link -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<!-- datatables link -->
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- javascript link -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
<div class="container">
<center>
<a class="btn btn-link" href="javascript:void(0)" id="createNewProduct">Create New Product</a>
</center>
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
<th width="100px">Action</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
</div>
<div class="modal fade" id="ajaxModel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="modelHeading"></h4>
</div>
<div class="modal-body">
<form id="productForm" name="productForm" class="form-horizontal">
<input type="hidden" name="product_id" id="product_id">
<div class="form-group">
<label for="name" class="col-sm-2 control-label">Name</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" maxlength="50" required="" autocomplete="off">
</div>
</div>
<div class="form-group">
<label for="sku" class="col-sm-2 control-label">Sku</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="sku" name="sku" placeholder="Enter Sku" maxlength="50" required="" autocomplete="off">
</div>
</div> 
<div class="form-group">
<label for="price" class="col-sm-2 control-label">Price</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" required="" autocomplete="off">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Category:</label>
<div class="col-sm-12">
<select class="form-control" name="category"id="category">
 <option value="" selected disabled>Select Category</option>
 @foreach($categories as $key => $category)
 <option value="{{$category->name}}"> {{$category->name}}</option>
 @endforeach
 </select>
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Status:</label>
<div class="col-sm-12">
<select class="form-control" name="status" id="status">
<option value="" selected disabled>Select Status</option>
<option value="1" >Active</option>
<option value="0" >Inactive</option>
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Details</label>
<div class="col-sm-12">
<textarea id="detail" name="detail" required="" placeholder="Enter Details" class="form-control" 
autocomplete="off"></textarea>
</div>
</div>


<div class="col-sm-offset-2 col-sm-10">
<button type="submit" class="btn btn-link" id="saveBtn" value="create">Save Changes</button>
</div>
</form>
</div>
</div>
</div>
</div>
</body>
<script type="text/javascript">
$(function () {

$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

var table = $('.data-table').DataTable({
processing: true,
serverSide: true,
ajax: "{{ route('ajaxproducts.index') }}",
columns: [
{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, visible: true},
{data: 'name', name: 'name', orderable: false, searchable: true, visible: true},
{data: 'sku', name: 'sku', orderable: false, searchable: true, visible: true},
{data: 'price', name: 'price', orderable: false, searchable: true, visible: true},
{data: 'detail', name: 'detail', orderable: false, searchable: true, visible: true},
{data: 'status', name: 'status', orderable: false, searchable: false, visible: true},
{data: 'category',name: 'category',orderable: false, searchable: true, visible: true},
{data: 'action', name: 'action', orderable: false, searchable: false, visible: true},
]
});

$('#createNewProduct').click(function () 
{
	$('#saveBtn').val("create-product");
	$('#product_id').val('');
	$('#productForm').trigger("reset");
	$('#modelHeading').html("Create New Product");
	$('#ajaxModel').modal('show');
});
$('body').on('click', '.editProduct', function () 
{
	var product_id = $(this).data('id');
	$.get("{{ route('ajaxproducts.index') }}" +'/' + product_id +'/edit', function (data) 
	{
		$('#modelHeading').html("Edit Product");
		$('#saveBtn').val("edit-user");
		$('#ajaxModel').modal('show');
		$('#product_id').val(data.id);
		$('#name').val(data.name);
		$('#sku').val(data.sku);
		$('#price').val(data.price)
		$('#status').val(data.status);
		$('#detail').val(data.detail);
		$('#category').val(data.category);
	})
});
$('#saveBtn').click(function (e) 
{
	e.preventDefault();
	$(this).html('Save Changes');
	$.ajax({

		data: $('#productForm').serialize(),
		url: "{{ route('ajaxproducts.store') }}",
		type: "POST",
		dataType: 'json',
		success: function (data) 
		{
			$('#productForm').trigger("reset");
			$('#ajaxModel').modal('hide');
			table.draw();
		},
		error: function (data) 
		{
			console.log('Error:', data);
			$('#saveBtn').html('Save Changes');
		}
	});
});
$('body').on('click', '.deleteProduct', function (){
	var product_id = $(this).data("id");
	alert("Are You sure want to delete !");
	$.ajax({
		type: "DELETE",
		url: "{{ route('ajaxproducts.store') }}"+'/'+product_id,
		success: function (data) 
		{
			table.draw();
		},
		error: function (data) 
		{
			console.log('Error:', data);
		}
	});
});
});
</script>
</html>