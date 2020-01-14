
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: SourceSansPro;
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #f3f3f3;
            text-decoration: none;
        }

        body {
            position: relative;
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #555555;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-family: SourceSansPro;
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }

        #logo {
            float: left;
            margin-top: 8px;
        }

        #logo img {
            height: 70px;
        }

        #company {
            float: right;
            text-align: right;
        }


        #details {
            margin-bottom: 50px;
        }

        #client {
            padding-right: 6px;
            padding-left: 6px;
            border-left: 6px solid #65a1e9;
            float: left;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
        }

        #invoice {
            float: right;
            text-align: right;
        }

        #invoice h1 {
            color: #65a1e9;
            font-size: 2.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0  0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 20px;
            background: #EEEEEE;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
        }

        table td {
            text-align: right;
        }

        table td h3{
            color: #65a1e9;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            background: #65a1e9;
        }

        table .desc {
            text-align: left;
        }

        table .unit {
            background: #DDDDDD;
        }

        table .qty {
        }

        table .total {
            background: #65a1e9;
            color: #FFFFFF;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table tbody tr:last-child td {
            border: none;
        }

        table tfoot td {
            padding: 10px 20px;
            background: #FFFFFF;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap;
            border-top: 1px solid #AAAAAA;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr:last-child td {
            color: #65a1e9;
            font-size: 1.4em;
            border-top: 1px solid #65a1e9;

        }

        table tfoot tr td:first-child {
            border: none;
        }

        #thanks{
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices{
            padding-left: 6px;
            border-left: 6px solid #65a1e9;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #AAAAAA;
            padding: 8px 0;
            text-align: center;
        }
        .bg-moladin {
            padding: 10px;
            color: #f3f3f3;
            background-color: #65a1e9;
        }

    </style>
</head>
<body>
<header class="clearfix bg-moladin">
    <div id="logo">
        <img src="data:image/png;base64,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">
    </div>
    <div id="company" style="padding-right: 24%">
        <h2 class="name">PT. Moladin Digital Indonesia</h2>
        <div>Jl. Ciledug Raya,Petukangan Utara, Ciledug Raya, Kota Jakarta Selatan</div>
        <div>+62 21 22738046</div>
        <div><a href="mailto:company@example.com">hello@moladin.com</a></div>
    </div>
    </div>
</header>
<main>
    <div id="details" style="padding-right: 39%" class="clearfix">
        <div id="client">
            <div class="to">INVOICE TO:</div>
            <h2 class="name">Martua Nasution</h2>
            <div class="address">Jl. Ciledug Raya,Petukangan Utara, Ciledug Raya</div>
            <div class="email"><a href="mailto:john@example.com">martuanst@moladin.com</a></div>
        </div>
        <div id="client">
            <div class="to">INVOICE TO:</div>
            <h2 class="name">Martua Nasution</h2>
            <div class="address">Jl. Ciledug Raya,Petukangan Utara, Ciledug Raya</div>
            <div class="email"><a href="mailto:john@example.com">martuanst@moladin.com</a></div>
        </div>
        <div id="invoice">
            <h1>INVOICE-{{  $data->id_penarikan }}</h1>
            <div class="date">Date of Invoice: {{$data->created_at->format('d-m-Y')}}</div>
            <div class="date">Due Date: {{$data->created_at->addDays('14')->format('d-m-Y')}}</div>
        </div>
    </div>
    <table border="0" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th class="no">#</th>
            <th class="desc">DESCRIPTION</th>
            <th class="unit">UNIT PRICE</th>
            <th class="qty">QUANTITY</th>
            <th class="total">TOTAL</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="no">01</td>
            <td class="desc"><h3>Permintaan Pencairan</h3>Permintaan pencairan penghasilan Affliasi Program</td>
            <td class="unit">Rp. {{  number_format($data->penarikan)  }}</td>
            <td class="qty">1</td>
            <td class="total">Rp. {{  number_format($data->penarikan)  }}</td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2"></td>
            <td colspan="2">SUBTOTAL</td>
            <td>Rp. {{  number_format($data->penarikan)  }}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2">TAX 0%</td>
            <td>Rp. 0</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2">GRAND TOTAL</td>
            <td>Rp. {{  number_format($data->penarikan)  }}</td>
        </tr>
        </tfoot>
    </table>
</main>
</body>
</html>
