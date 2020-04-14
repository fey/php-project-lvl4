@php
/**
 * @var string linkTo
 * @var string $linkText
 */
@endphp
<li class="nav-item {{ Route::currentRouteName() === $routeName ? 'active' : '' }}">
    <a class="nav-link"
       href="{{ route($routeName) }}">
        @lang($linkText)
    </a>
</li>
