@include('layout.header')
@yield('headerLink')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
</head>
<body>
	@guest
		@yield('loginform')
	@endguest
@auth
    @include('layout.sidenavbar') 
    @include('layout.topnavbar')
    @yield('content')
    @endauth
	@include('layout.footer')
	<div class="modal fade" id="largemodel">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body largemodelbody">
                    Loading......
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="batchmodel">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body batchmodel">
                    Loading......
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
			<div class="modal-header">
				
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
		</div>
			<div class="modal-body newmodel">
			Loading......
			</div>
			
			</div>
		</div>
	</div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
			<div class="modal-header">
				
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
		</div>
			<div class="modal-body editModal">
			Loading......
			</div>
			
			</div>
		</div>
	</div>
    <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete Box</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i style="font-size: 80px; padding: 30px 30px;" class="fas fa-trash-alt text-danger"></i>
               
                    <h4 class="text-dager tx-semibold">Are you sure want to delete?</h4>
             
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger" id="conf_true">Delete</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

	<div class="modal fade" id="permissionmodal" tabindex="-1" role="dialog" aria-labelledby="permissionmodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
            <div class="card">
                <div class="card-header">
                <h5 class="modal-title" id="permissionmodal">Staff Permission</h5>
                </div>
                <div class="card-body">
                    <form action="{{ url('/managestaffpermission') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $permission->id ?? '' }}">
                        <div class="form-group col-9 col-md-9 col-lg-12">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $permission->name ?? '' }}" name="permission_name">
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Submit</button>
                            <button class="btn btn-secondary" type="reset">Reset</button>
                        </div>
                    </form>
                </div> 
            </div>
            <div class="modal fade right" id="addEditModal" tabindex="-1" role="dialog" aria-labelledby="addEditModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal content goes here -->
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
        function show_large_model() {
            $(".largemodelbody").html('Loading......');
            
            $.get("{{ route('studentdetails') }}")  
                .done(function(data) {
                    $(".largemodelbody").html(data);
                    $("#largemodel").modal("show");
                })
                
        }
    function show_large_models(id, page) {
        //    alert(id);
			$(".newmodel").html('Loading......');
			$.get("{{url('/')}}/" + page + "/" + id)
			.done(function(data) {
				$(".newmodel").html(data);
			});

			$("#form1").submit(function(event) {
				event.preventDefault();

				$('#newmodel1').modal('hide');
				$('#cancel1').click();
				$('#newmodel2').modal('show');

				
			});
		}
        function delete_confirm(path) {
            // alert(fullurl);
	        var url = "{{url('')}}";
	        var fullurl = url+path;
	        $("#conf_true").attr("href", fullurl);    
	    }
        function showLargePermissionModal() {
            alert("xcdc");
    $('#permissionmodal').modal('show');
  }
   function addEditModal(){
    alert("helo");
    $('#editModal').modal('show');

   }
    </script>

    </body>
        @yield('contentjs')
        </html>
       