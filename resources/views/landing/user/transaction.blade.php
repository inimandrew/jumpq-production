@extends('landing.includes.master')

@section('content')
<div class="w-full bg-white flex items-center justify-center">
    <div class="mx-auto w-11/12 md:w-3/5 py-4 my-20">
        <h3 class=" font-bold text-lg tracking-wide capitalize my-2">Transactions</h3>

        <div class="overflow-x-auto w-full">
            <table class="table table-auto w-full">
                <thead>
                    <tr>
                        <th class="border border-black p-2 text-sm">#</th>
                        <th class="border border-black p-2 text-sm">DATE OF TRANSACTION</th>
                        <th class="border border-black p-2 text-sm">STORE NAME</th>
                        <th class="border border-black p-2 text-sm">TRANSACTION ID</th>
                        <th class="border border-black p-2 text-sm">STATUS</th>
                        <th class="border border-black p-2 text-sm">CART</th>
                        <th class="border border-black p-2 text-sm">SUB-TOTAL AMOUNT</th>
                        <th class="border border-black p-2 text-sm">SERVICE CHARGE</th>
                        <th class="border border-black p-2 text-sm">TOTAL AMOUNT</th>
                    </tr>
                </thead>
                <tbody id="transactions">

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{url('assets/users/js/transactions.js')}}"></script>
@endsection