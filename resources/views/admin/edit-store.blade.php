<div class="row">
    <div class="col-sm-12">
        <div class="white-box">

            <h3 class="box-title m-b-0">Edit Store-Branch </h3>
            <hr>
            <form class="form-horizontal" autocomplete="off" method="POST"
                action="{{route('admin_edit_branch_action')}}">
                {{ csrf_field() }}
                <div class="form-group col-12">
                    <label style="margin-left: 15px;">Store Branch</label>
                    <div class="col-md-12">
                        <select name="branch" id="branchSelect" class="form-control" required>
                            <option value="">Select a Branch</option>
                            @foreach ($data['branches'] as $branch)
                            <option data-items="{{$branch->itemMax}}" value="{{$branch->id}}">{{$branch->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="form-group col-12 ">
                    <label style="margin-left: 15px;">Maximum Items Allowed </label>
                    <div class="col-md-12">
                        <input type="number" required id="itemMax" name="itemMax" min="0" step="1" class="form-control"
                            placeholder="Admin First-Name">
                    </div>
                </div>


                <button style="margin-left: 15px;" class="btn btn-success btn-md ml-2" type="submit"
                    id="submit">Submit</button>
            </form>
        </div>
    </div>
</div>

@section('other_scripts')
<script type="text/javascript">
    const selectField = document.getElementById("branchSelect")
    selectField.addEventListener('change', (e) => {
        var x = selectField.selectedIndex;
        var y = selectField.options;
        let currentMax = y[x].dataset.items ? y[x].dataset.items : 0
        document.getElementById("itemMax").value = currentMax

    })
</script>
@endsection