@props(['errors'])

@if (!empty($errors))
    <ul class="text-danger ps-0 mb-0" style="list-style: none">
        @foreach (collect($errors)->dot() as $error)
            <li><small>{{ $error }}</small></li>
        @endforeach
    </ul>
@endif