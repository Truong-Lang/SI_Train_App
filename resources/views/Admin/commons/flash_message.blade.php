<div class="col-md-12">
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }}">
                    {{ Session::get('alert-' . $msg) }}
                </p>
            @endif
        @endforeach
    </div>
</div>