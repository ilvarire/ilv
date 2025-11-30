@component('mail::message')
# Low Stock Alert

The following products in your inventory have reached a low stock level.

---

## Products
@component('mail::table')
| Product | Category | Current Stock | Threshold |
| -------------- | ------ | ------------- | --------- |
@foreach ($lowStockProducts as $product)
    | {{ $product->name }} | {{ $product->category->name ?? 'N/A' }} | {{ $product->quantity }} | 10 |

@endforeach
@endcomponent

---

@component('mail::panel')
Product(s) has fallen below the minimum stock threshold and may require restocking soon.
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent