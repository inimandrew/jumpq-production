<link href="{{url('assets/administrator/plugins/bower_components/select2-4.0.13/dist/css/select2.min.css')}}"
    rel="stylesheet" />

<link href="{{url('assets/administrator/plugins/bower_components/custom-select/custom-select.css')}}" rel="stylesheet"
    type="text/css" />
<link rel="stylesheet" href="{{url('assets/main/dist/css/dropify.min.css')}}">
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">

            <h3 class="box-title m-b-0">Add New Product</h3>
            <hr>
            <form class="form" autocomplete="off" id="add-product" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="form-group col-lg-6">
                    <label class="col-md-12">Category</label>
                    <div class="col-md-12">
                        <select name="category_id" id="categories" class="form-control select2" required>
                            <option></option>
                        </select>
                    </div>
                </div>

                <div class="form-group col-lg-6">
                    <label class="col-md-12">Product Type</label>
                    <div class="col-md-12">
                        <select type="text" name="product_type" class="form-control" required>
                            <option value="0">Products with RFID & Barcode Tags</option>
                            <option value="1">Products With only Barcode Tags</option>
                        </select>
                    </div>
                </div>

                <div class="form-group col-lg-4">
                    <label class="col-md-12">Product Name</label>
                    <div class="col-md-12">
                        <input type="text" name="product_name" class="form-control" required>
                    </div>
                </div>


                <div class="form-group col-lg-4">
                    <label class="col-md-12">Selling Price</label>
                    <div class="col-md-12">
                        <input type="number" step='0.01' min="1" name="price" class="form-control" required>
                    </div>
                </div>

                <div class="form-group col-lg-4">
                    <label class="col-md-12">Cost Price</label>
                    <div class="col-md-12">
                        <input type="number" step='0.01' min="1" name="cost_price" class="form-control" required>
                    </div>
                </div>

                <div class="form-group col-lg-12">
                    <label class="col-md-12">Product Description (Optional)</label>
                    <div class="col-md-12">
                        <textarea type="text" rows="7" id="description" name="description" class="form-control" required
                            placeholder="Type Product Description here"></textarea>
                    </div>
                </div>

                <div class="form-group col-lg-6">
                    <label class="col-md-12">Product Thumbnail <span class="label label-info">Thumbnail should have a
                            dimension of 100 x 100 </span></label>
                    <div class="col-md-12">
                        <input type="file" multiple id="thumbnail" name="thumbnail"
                            data-allowed-file-extensions="jpg png jpeg" data-max-file-size="1M"
                            class="form-control dropify form-control-line">
                    </div>
                </div>

                <div class="form-group col-lg-6">
                    <label class="col-md-12">Product Medium-sized Image <span class="label label-info">Medium Product
                            Image should have a dimension of 300 x 450</span></label>
                    <div class="col-md-12">
                        <input type="file" multiple id="medium" name="medium"
                            data-allowed-file-extensions="jpg png jpeg" data-max-file-size="2M"
                            class="form-control dropify form-control-line">
                    </div>
                </div>

                <div class="form-group col-lg-12">
                    <label class="col-md-12">Product Images <span class="label label-info">You can select a maximum of
                            10 Images with dimensions of 800 x 1200</span></label>
                    <div class="col-md-12">
                        <input type="file" multiple id="images" name="images[]"
                            data-allowed-file-extensions="jpg png jpeg" data-max-file-size="2M"
                            class="form-control dropify form-control-line">
                    </div>
                </div>

                <div class="form-group col-lg-12" style="padding: 0 30px;">
                    <div class="input-group">
                        <input type="text" name="barcode" class="form-control" required autofocus
                            placeholder="Scan Product Barcode"> <span class="input-group-btn">
                            <button type="button" id="rescan"
                                class="btn waves-effect waves-light btn-info">Scan</button>
                        </span>
                    </div>
                </div>


                <button style="margin-left: 30px;" class="btn btn-success btn-md" type="submit"
                    id="submit">Submit</button>
            </form>
        </div>
    </div>
</div>

<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">A product already has the same Barcode, do you want to continue</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" id="finalSubmit">Continue</button>
            </div>
        </div>
    </div>
</div>

@section('other_scripts')
<script src="{{url('assets/administrator/js/staff/product.js')}}"></script>
<script src="{{url('assets/administrator/plugins/bower_components/select2-4.0.13/dist/js/select2.min.js')}}"
    type="text/javascript"></script>
<script src="{{url('assets/administrator/plugins/bower_components/custom-select/custom-select.min.js')}}"></script>
<script src="{{url('assets/main/dist/js/dropify.min.js')}}"></script>
<script>
    $(document).ready(function () {
        // Basic
        $('.dropify').dropify();

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function (event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function (event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function (event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function (e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
</script>


@endsection