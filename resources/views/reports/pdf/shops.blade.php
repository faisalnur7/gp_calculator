<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1e293b; background: #fff; padding: 30px 36px; }
    .header { padding: 16px 20px 12px; border-bottom: 2px solid #f59e0b; margin-bottom: 16px; }
    .header h1 { font-size: 18px; font-weight: 700; color: #1e293b; }
    .header p { font-size: 11px; color: #64748b; margin-top: 3px; }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: #fef3c7; }
    th { padding: 8px 10px; text-align: left; font-size: 10px; font-weight: 700; color: #92400e; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #fde68a; }
    th.center, td.center { text-align: center; }
    th.right,  td.right  { text-align: right; }
    td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; font-size: 11px; }
    tr:nth-child(even) td { background: #fafafa; }
    tfoot td { padding: 8px 10px; font-weight: 700; background: #fef3c7; border-top: 2px solid #f59e0b; font-size: 11px; }
    .footer { margin-top: 16px; font-size: 9px; color: #94a3b8; text-align: right; }
</style>
</head>
<body>
<div class="header">
    <h1>Shop Report{{ $dateLabel ? ' &nbsp;|&nbsp; ' . $dateLabel : '' }}</h1>
    <p>Generated: {{ now()->format('d M Y, H:i') }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>Shop</th>
            <th>Code</th>
            <th class="center">Items</th>
            <th class="center">Vori</th>
            <th class="center">Ana</th>
            <th class="center">Roti</th>
            <th class="center">Point</th>
            <th class="center">Grams</th>
            <th class="right">Total Value</th>
        </tr>
    </thead>
    <tbody>
        @forelse($rows as $shop)
        <tr>
            <td>{{ $shop->name }}</td>
            <td>{{ $shop->code ?? '—' }}</td>
            <td class="center">{{ $shop->jewellery_items_count }}</td>
            <td class="center">{{ $shop->w_vori }}</td>
            <td class="center">{{ $shop->w_ana }}</td>
            <td class="center">{{ $shop->w_roti }}</td>
            <td class="center">{{ $shop->w_point }}</td>
            <td class="center">{{ number_format($shop->jewellery_items_sum_total_grams ?? 0, 4) }}g</td>
            <td class="right">{{ number_format($shop->jewellery_items_sum_subtotal ?? 0, 2) }}</td>
        </tr>
        @empty
        <tr><td colspan="9" class="center">No data found.</td></tr>
        @endforelse
    </tbody>
    @if($rows->isNotEmpty())
    <tfoot>
        <tr>
            <td colspan="2">Grand Total</td>
            <td class="center">{{ $grand['items'] }}</td>
            <td class="center">{{ $grand['vori'] }}</td>
            <td class="center">{{ $grand['ana'] }}</td>
            <td class="center">{{ $grand['roti'] }}</td>
            <td class="center">{{ $grand['point'] }}</td>
            <td class="center">{{ number_format($grand['grams'], 4) }}g</td>
            <td class="right">{{ number_format($grand['value'], 2) }}</td>
        </tr>
    </tfoot>
    @endif
</table>
<div class="footer">GP Calculator &mdash; Shop Report</div>
</body>
</html>
