@component('mail::message')
# Out of Stock Alert

The following products in your inventory are out of stock.


---

## Products
@component('mail::table')
| Product | Category | Current Stock | Threshold |
| -------------- | ------ | ------------- | --------- |
@foreach ($outOfStockProducts as $product)
    | {{ $product->name }} | {{ $product->category->name ?? 'N/A' }} | 0 | 0 |

@endforeach
@endcomponent

---

@component('mail::panel')
These products are out of stock and needs to be restocked immediately to avoid customer order issues.
@endcomponent

@component('mail::button', ['url' => route('admin.products'), 'color' => 'danger'])
View Products
@endcomponent



Thanks,<br>
{{ config('app.name') }}
@endcomponent