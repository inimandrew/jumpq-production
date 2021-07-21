<style>
    .emptyCategory{
        text-align: center;
        padding: 20px;
        font-weight: bold;
        color: black;
    }
    td{
        color:black;
        text-align:center;
    }
</style>
<div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title m-b-0">Create New Categories</h3>
<hr>
                <form class="form-horizontal" autocomplete="off" id="create-category">
                    {{ csrf_field() }}

                    <div class="form-group col-lg-12">
                        <label class="col-md-12">Category Name</label>
                        <div class="col-md-12">
                            <input type="text" name="category_name" class="form-control">
                         </div>
                    </div>


                        <button class="btn btn-success btn-md" type="submit" id="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title m-b-0">Available Categories</h3>
<hr>
                <table class="table table-bordered">
                    <thead>
                        <tr style="color:black;font-weight:900;text-align:center;">
                            <td>#</td>
                            <td>Category Name</td>
                            <td>Products In this Category</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody id="category-data">

                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title delete-title"></h4> </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light final_delete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel1">Edit Category</h4> </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Category Name:</label>
                            <input type="text" class="form-control" id="category_name"> </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary final_edit_submit">Update Changes</button>
                </div>
            </div>
        </div>
    </div>
@section('other_scripts')
<script src="{{url('assets/administrator/js/staff/category.js')}}"></script>
@endsection
