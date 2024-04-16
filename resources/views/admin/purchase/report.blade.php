@extends('admin.layout.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Purchase Report')
@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>Purchase</h5>
                {{-- <a href="{{ route('manage-purchase.index') }}" class="btn bg-gradient-dark btn-sm float-end mb-0">Add Purchase</a> --}}
            </div>
            <div class="card-body px-4 pt-0 pb-2">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="from" class="col-md-2 col-form-label form-control-label">Date</label>
                            <div class="col-md-9">
                                <input class="form-control" type="date" value="{{ date('Y-m-d') }}" id="from">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="to" class="col-md-3 col-form-label form-control-label">To Date</label>
                            <div class="col-md-8">
                                <input class="form-control" type="date" value="{{ date('Y-m-d') }}" id="to">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-danger" id="downloadPDF">PDF Download</button>
                    </div>
                </div>


                <div class="table-responsive p-0 mt-5">
                    <table class="table align-items-center mb-0 table-flush dataTable" id="purchaseTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>Purchase Code</th>
                                <th>Supplier Name</th>
                                <th>Amount</th>
                                <th>Due</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.12/jspdf.plugin.autotable.min.js"></script>


<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });
    $(function() {
        var table = $('#purchaseTable').DataTable({
            processing: false,
            "responsive": true
                , language: {
                    paginate: {
                        next: '&#8594;', // or '→'
                        previous: '&#8592;' // or '←'
                    }
                }
            , serverSide: true
            , ajax: {
                url: "{{ route('purchase.report') }}"
                , type: "POST"
                , data: function(d) {
                    d.from = $('#from').val();
                    d.to = $('#to').val();
                }

            }
            , columns: [{
                    data: 'id'
                    , name: 'id'
                    , render: function(data, type, row, meta) {
                        return meta.settings._iDisplayStart + meta.row + 1; // Global sequential number
                    }
                }, {
                    data: 'purchase_code'
                    , name: 'purchase_code'
                }
                , {
                    data: 'supplier_id'
                    , name: 'supplier_id'
                }
                , {
                    data: 'amount'
                    , name: 'amount'
                }
                , {
                    data: 'due'
                    , name: 'due'
                }
                , {
                    data: 'date'
                    , name: 'date'
                }
            , ]
        });

        $('#from, #to').change(function() {
            // Reload the DataTable when either date changes
            table.ajax.reload();
        });

    });

    var doc = new jsPDF();
    var specialElementHandlers = {
        '#editor': function(element, renderer) {
            return true;
        }
    };

    $('#downloadPDF').click(function() {
    // Get the DataTable instance
    var table = $('#purchaseTable').DataTable();
    
    // Get the table data
    var data = table.data().toArray();
    
    // Create an array to hold table headers
    var headers = ['Id', 'Purchase Code', 'Supplier Name', 'Amount', 'Due', 'Date'];
    
    // Prepare table content for PDF
    var content = [headers];
    data.forEach(function(row) {
        var rowData = [];
        Object.values(row).forEach(function(value) {
            rowData.push(value);
        });
        content.push(rowData);
    });
    
    // Generate PDF
    var doc = new jsPDF();
    doc.autoTable({
        head: [content[0]],
        body: content.slice(1)
    });
    
    // Save the PDF
    doc.save('purchase_report.pdf');
});

</script>
@endsection
