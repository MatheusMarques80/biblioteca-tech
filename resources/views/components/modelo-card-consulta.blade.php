<div class="card">
  <div class="card-header">
    {{ $titulo }}
  </div>
  <div class="card-body">
    <div class="d-flex align-items-center justify-content-center">
        <span class="card-title mb-0">{{ $subTitulo }}</span>
        <a href="{{ $rotaBotao }}" class=" btn btn-sm ms-auto {{$corBotao}}">
            {{ $nomeAcaoBtn }}
        </a>
    </div>
    <div class="card-text mt-3">
        {{ $slot }}
    </div>
  </div>
</div>