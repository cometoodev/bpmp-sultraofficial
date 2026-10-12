@props(['isPreview' => false])

{{-- Forward directly to the unified site navbar --}}
<x-navbar :alwaysScrolled="true" :isPreview="$isPreview" />
