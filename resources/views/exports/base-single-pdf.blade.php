<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Document' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .document-info {
            display: flex;
            margin-bottom: 30px;
        }
        .document-details {
            flex: 1;
        }
        .info-section {
            margin-bottom: 25px;
        }
        .info-section h3 {
            background-color: #f2f2f2;
            padding: 8px 12px;
            margin-bottom: 10px;
            border-left: 4px solid #EBA687;
        }
        .info-row {
            display: flex;
            margin-bottom: 8px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            /* width: 150px; */
            color: #555;
        }
        .info-value {
            flex: 1;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th, .data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .data-section {
            /* background-color: #f9f9f9; */
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .question-item {
            margin-bottom: 15px;
            padding: 10px;
            /* background-color: #f9f9f9; */
            border-radius: 5px;
        }
        .question-label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .signature {
            margin-top: 40px;
            text-align: right;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 300px;
            margin-left: auto;
            margin-top: 5px;
        }
    </style>
    @yield('style')
</head>
<body>
    <div class="header">
        <div style="text-align: center; margin-bottom: 20px;">
            @if(file_exists($logoPath))
                <img src="{{ $logoPath }}" alt="Company Logo" style="max-height: 60px;">
            @endif
        </div>
        <h2>{{ $title ?? 'Document' }}</h2>
        <p>Generated on: {{ date('d M, Y H:i:s') }}</p>
    </div>
    
    <div class="document-info">
        <div class="document-details">
            @yield('content')
        </div>
    </div>
    
    <div class="footer">
        <p>This is a computer-generated document and does not require a signature.</p>
    </div>
</body>
</html>