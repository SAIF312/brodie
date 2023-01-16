<!DOCTYPE html>
<html>

<head>
    <title>Brodie</title>
    <style>
        body {
            /*margin: 10 0 10 0;*/
        }

        table {
            width: 98%;
            margin: 0px 20px;
        }

        table tr th {
            text-align: left;
            width: 40%;
            vertical-align: top;
            padding: 5px 0rem;

        }

        table td {
            vertical-align: top;
            padding: 5px 0rem;
        }

        table tr td,
        table tr th {
            border-bottom: 1px solid grey;
        }

        tbody tr:last-child td,
        tbody tr:last-child th {
            border-bottom: unset !important;
            padding-bottom: 5px;
        }

        td span {
            padding: 4px, 8px, 4px, 8px;
            border: 1px solid orange;
            border-radius: 3px;
        }
    </style>
</head>


<body>
    <div class="head-title" style="margin-bottom:1rem; background-color: #D3BC8C; padding: 20px; height:55px;">
        <h1 class="text-center" style="margin: 1em, 0em, 0em, 1em; display:inline;">Order Details</h1>
        <img style="float:right; margin-right: 5rem;" src="{{ asset('admin/brodie/logo/logo.png') }}" width="100">
    </div>


    <table>
        <tbody>
            <tr>
                <th>Businesss Name</th>
                <td>{{ $pdf_data['business_name'] }}</td>

            </tr>
            <tr>
                <th>Number of items</th>
                <td>{{ $pdf_data['No_of_items'] }}</td>
            </tr>
            <tr>
                <th>Customer Name</th>
                <td>{{ $pdf_data['customer_name'] }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $pdf_data['customer_email'] }}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{ date('m-d-Y', strtotime($pdf_data['customer_date'])) }}</td>
            </tr>
        </tbody>
    </table>
    <div style="margin:1rem 0rem; background-color: #D3BC8C;">
        <h3>
            Item Details:
        </h3>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width:10%;">Count</th>
                <th style="width:30%;">Item</th>
                <th style="width:60%;">Notes</th>
            </tr>
        </thead>
        <tbody>


            @foreach ($item_details as $key => $item)
                <tr>
                    <td style="width:10%;"><span>{{ $item['count'] }}</span></td>
                    <td style="width:30%;">{{ $item['item'] }}</td>
                    <td style="width:60%;">{{ $item['notes'] ? $item['notes'] : 'Null' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table style="margin-top:2rem;">
        </tbody>
        <tr>
            <th>Installer Name</th>
            <td>{{ $pdf_data['installer_name'] }}</td>
        </tr>
        <tr>
            <th>Notes</th>
            <td>{{ $pdf_data['installer_note'] ? $pdf_data['installer_note'] : 'Null' }}</td>
        </tr>
        <tr>
            <th>Customer Signature</th>
            <td><img style="margin:auto;" src="{{ $pdf_data['sign'] }}" height="150" width="150"></td>
        </tr>
        </tbody>
    </table>
</body>

</html>
