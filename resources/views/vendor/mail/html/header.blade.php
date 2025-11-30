@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img src="{{ config('app.url') . '/images/logo.png' }}" width="150px" class="logo"
                alt="{{ config('app.name') }}">
        </a>
    </td>
</tr>